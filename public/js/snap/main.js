angular.module('futureed.controllers')
    .controller('SnapModuleController', SnapModuleController);

SnapModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function SnapModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService)
{
    var self = this;
    var world;
    var FutureEd_IDE;
    var target_script;
    var isAnswering = Constants.FALSE;
    var canvas;
    var canvas_parent_div;
    var canvas_offset;
    var x_offset;

    self.loading = Constants.TRUE;

    self.set_IDE = function()
    {

        canvas = document.getElementById('world');
        canvas_parent_div = document.getElementById('snap_container');

        canvas.setAttribute('width', ($('#snap_container').width() - 10).toString());
        canvas.setAttribute('height', ($('#snap_main_div_container').height() - 80).toString());

        world = new WorldMorph(canvas, false);

        FutureEd_IDE = new IDE_Morph();
        FutureEd_IDE.openIn(world);

        hideIDE();

        self.retrieveModule('forward',
            function(resp)
            {

                FutureEd_IDE.rawOpenProjectString(resp);
                FutureEd_IDE.selectSprite(FutureEd_IDE.children[1].children[0]);//select sprites e.i images in the stage

                FutureEd_IDE.corral.hide();
                FutureEd_IDE.corralBar.hide();

                FutureEd_IDE.children[4].bounds = new Rectangle(0,0,0,0);
                FutureEd_IDE.children[4].hide();
                FutureEd_IDE.children[4].drawNew();

                FutureEd_IDE.children[0].bounds = new Rectangle(0,0,0,0);
                FutureEd_IDE.children[0].hide();

                //Left most pane
                FutureEd_IDE.children[2].bounds =
                    new Rectangle(
                        0, //origin x
                        getActualHeightByPercent(0.009),//origin y
                        getActualWidthByPercent(0.18348),//corner x
                        getActualHeightByPercent(0.99107)//corner y
                    );
                FutureEd_IDE.children[2].children[1].bounds =
                    new Rectangle(
                        0,
                        getActualHeightByPercent(0.96964),
                        getActualWidthByPercent(0.17247),
                        getActualHeightByPercent(0.99107)
                    );
                FutureEd_IDE.children[2].children[1].children[0].bounds =
                    new Rectangle(
                        getActualWidthByPercent(0.19174),
                        getActualHeightByPercent(0.97321),
                        getActualWidthByPercent(0.15045),
                        getActualHeightByPercent(0.98928)
                    );
                FutureEd_IDE.children[2].children[2].bounds = new Rectangle(0,0,0,0);
                FutureEd_IDE.children[2].children[2].hide();
                FutureEd_IDE.children[2].drawNew();

                //Center Pane
                FutureEd_IDE.children[3].bounds =
                    new Rectangle(
                        getActualWidthByPercent(0.18807),
                        getActualHeightByPercent(0.009),
                        getActualWidthByPercent(0.55504),
                        getActualHeightByPercent(0.99107)
                    );

                // Center Pane horizontal slider line
                FutureEd_IDE.children[3].children[1].bounds =
                    new Rectangle(
                        getActualWidthByPercent(0.18807),
                        getActualHeightByPercent(0.96964),
                        getActualWidthByPercent(0.54403),
                        getActualHeightByPercent(0.99107)
                    );
                // Center Pane horizontal slider
                FutureEd_IDE.children[3].children[1].children[0].bounds =
                    new Rectangle(
                        getActualWidthByPercent(0.19174),
                        getActualHeightByPercent(0.97321),
                        getActualWidthByPercent(0.50733),
                        getActualHeightByPercent(0.98928)
                    );

                FutureEd_IDE.children[3].children[2].bounds = new Rectangle(0,0,0,0);
                FutureEd_IDE.children[3].children[2].hide();
                FutureEd_IDE.children[3].drawNew();

                var ref_height = FutureEd_IDE.children[3].bounds.corner.y;
                var scale = Math.abs((ref_height) / FutureEd_IDE.children[1].bounds.corner.y);
                var old_stage_width_x = FutureEd_IDE.children[1].bounds.origin.x;

                // Stage location x-axis
                FutureEd_IDE.children[1].bounds.origin.y = getActualHeightByPercent(0.00901);
                FutureEd_IDE.children[1].bounds.origin.x = getActualWidthByPercent(0.55963);

                var gap = Math.abs(FutureEd_IDE.children[3].bounds.corner.x - FutureEd_IDE.children[1].bounds.origin.x);
                var new_stage_width_x = FutureEd_IDE.children[1].bounds.origin.x;

                // Scale stage to fit
                FutureEd_IDE.children[1].setScale(scale);

                // To be used in stageElemsOffset
                x_offset = ((new_stage_width_x  - old_stage_width_x) + gap) / 2;

                // Remove unused px lengthwise due to stage scaling
                canvas_offset = ($(canvas).width() - FutureEd_IDE.children[1].bounds.corner.x);
                canvas.width -= canvas_offset;

                // offset all elements inside stage
                stageElemsOffset(FutureEd_IDE.children[1]);

                // find target script with name "sprite" to be used in fireGreenFlagEvent()
                findTargetScript();
                FutureEd_IDE.stage.fireGreenFlagEvent();

                self.loading = Constants.FALSE;
            }
        );

        loop();
    }

    self.retrieveModule = function(filename, callback)
    {
        StudentModuleService.getSnapModule(filename).success(
            function(response)
            {
                if(callback)
                {
                    callback(response);
                }
                $scope.ui_unblock();
            }
        ).
        error(
            function(response)
            {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            }
        );
    }

    self.runCode = function()
    {
        if(!isAnswering)
        {
            $('.btn-code-run').text('Reset');
            updateCode();
            FutureEd_IDE.stage.doCustomBroadcastEvent("run_code");
            isAnswering = !isAnswering;
        }
        else
        {
            isAnswering = !isAnswering;
            $('.btn-code-run').text('Run');
            FutureEd_IDE.stage.fireGreenFlagEvent();
        }
    }

    function hideIDE()
    {
        FutureEd_IDE.corral.hide();
        FutureEd_IDE.corralBar.hide();
        FutureEd_IDE.children[4].bounds = new Rectangle(0,0,0,0);
        FutureEd_IDE.children[4].hide();
        FutureEd_IDE.children[0].bounds = new Rectangle(0,0,0,0);
        FutureEd_IDE.children[0].hide();
        FutureEd_IDE.children[1].hide();
        FutureEd_IDE.children[2].hide();

    }

    function stageElemsOffset(stage)
    {
        if(stage.children.length)
        {
            for(var i = 0; i < stage.children.length; i++)
            {
                stageElemsOffset(stage.children[i]);
            }
        }
        else
        {
            stage.bounds.origin.x += x_offset;
            stage.bounds.corner.x += x_offset;
        }
    }

    function getActualHeightByPercent(percent)
    {
        var h = $(canvas).height();
        return Math.ceil(h * percent);
    }

    function getActualWidthByPercent(percent)
    {
        var w = $(canvas).width();
        return Math.ceil(w * percent);
    }

    function updateCode()
    {
        target_script.mouseClickLeft(true);
    }

    function loop() {
        requestAnimationFrame(loop);
        world.doOneCycle();
    }

    function findTargetScript()
    {
        var len = FutureEd_IDE.sprites.contents.length;
        for(var i = 0; i < len; i++)
        {
            if(FutureEd_IDE.sprites.contents[i].name == "Sprite")
            {
                target_script =  FutureEd_IDE.sprites.contents[i].scripts.children[FutureEd_IDE.sprites.contents[i].scripts.children.length-1];
                target_script.isDraggable = false;
                target_script.fixLayout();
            }
        }
    }

}