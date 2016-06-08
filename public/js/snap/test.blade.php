<!DOCTYPE html>
<html>
<head>
    <title>FutureEd Online Education Platform | Programming</title>
    <link media="all" type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/css/futureed-student.css">
    <link rel="stylesheet" href="/css/jquery.modal.css" type="text/css" media="screen" />
    <link href="/css/social_sharing.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" media="screen" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://beta.futurelesson.com/js/jquery.js"></script>
    <link rel="stylesheet" media="all" href="/assets/application-227801d60f4ab9abe27dc72f04f49259178eb251996c59d9bf7f1232d8e50a42.css" data-turbolinks-track="true" />
    <script src="/assets/application-3b8ff35c3b858379f67a2ecbde522cc1be58baa7439c2b2fd0d6444073900921.js" data-turbolinks-track="true"></script>
    <meta name="csrf-param" content="authenticity_token" />
    <meta name="csrf-token" content="i/pLd9bObIEDYJ94HYLvCzDPHTC84bpbYP/F7FHSg46lr9YxDq63sYbitHBETg06UULASK6OTb0YSR1qHtU8eg==" />
    <script src="/js/jquery.modal.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-default">
        <div class="navcon">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#"><img src="https://beta.futurelesson.com/images/logo-sm.png"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-label">Cash Points</li>
                    <li class="nav-points-rewards">
                        <img src="https://beta.futurelesson.com/images/icons/icon-cash-points.png" class="nav-icon-holder" alt="">
                        <span id="cash_points">0</span>
                    </li>
                    <li class="nav-label">Reward Points</li>
                    <li class="nav-points-rewards">
                        <img src="https://beta.futurelesson.com/images/icons/icon-reward.png" class="nav-icon-holder" alt="">
                        <span id="reward_points">0</span>
                    </li>
                    <li class="nav-points-rewards">
                        <img src="https://beta.futurelesson.com/images/icons/icon-badges.png" class="nav-icon-holder" alt="">
                        <span id="badge_points">0</span>
                    </li>

                    <li class="nav-label"></li>
                    <li class="nav-label"></li>
                    <li class="nav-label"></li>

                    <li><img class="nav-image-holder" src="https://beta.futurelesson.com/images/thumbnail/engineer-male/engineer_male_9_main.png"></li>
                    <li class="nav-label">Welcome, User</li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<div class="container">
    <div class="panel panel-info world_panel">
        <div class="panel-heading">
            <h3 class="panel-title">Test Exercise</h3>
        </div>
        <div class="panel-body">
            <div id="world_container">
                <canvas tabindex="1" id="world"/>
            </div>
        </div>
        <div class="panel-footer">
            <button onclick="runCode()" class="btn btn-large btn-primary">Test my program!</button>
            <button onclick="viewCode()" class="btn btn-large btn-success">View my Code!</button>
        </div>
    </div>

    <div id="successful" class="modal" style="display:none;">
        <h1 class="text-success">
            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
            Successful
        </h1>
        <p>
            Congratulations! You've successfully written your first program.
        </p>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">This is the JavaScript code that represents your program:</h2>
            </div>
            <div class="panel-body">
                <div>
                    <pre class="cur_code"></pre>
                </div>
                <div>
                    Share this with your friends:<br>
                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url=https://futureed.herokuapp.com/exercises/1&text=I&#39;ve just written my first program. Write yours!" title="Share on Twitter" target="_blank" class="btn btn-twitter" popup="true"><i class="fa fa-twitter"></i> Twitter</a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://futureed.herokuapp.com/exercises/1" title="Share on Facebook" target="_blank" class="btn btn-facebook" popup="true"><i class="fa fa-facebook"></i> Facebook</a>
                    <!-- Google+ -->
                    <a href="https://plus.google.com/share?url=https://futureed.herokuapp.com/exercises/1" title="Share on Google+" target="_blank" class="btn btn-googleplus" popup="true"><i class="fa fa-google-plus"></i> Google+</a>

                </div>
            </div>
        </div>
    </div>


    <div id="unsuccessful" class="modal" style="display:none;">
        <h1 class="text-danger">
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            Unsuccessful
        </h1>
        <p>
            Sorry, your program didn't work correctly. You can try again.
        </p>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">This is the JavaScript code that represents your program:</h2>
            </div>
            <div class="panel-body">
                <div>
                    <pre class="cur_code"></pre>
                </div>
                <div>
                    Let your friends try:<br>
                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url=https://futureed.herokuapp.com/exercises/1&text=I&#39;m trying to write my first program. Try it!" title="Share on Twitter" target="_blank" class="btn btn-twitter" popup="true"><i class="fa fa-twitter"></i> Twitter</a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://futureed.herokuapp.com/exercises/1" title="Share on Facebook" target="_blank" class="btn btn-facebook" popup="true"><i class="fa fa-facebook"></i> Facebook</a>
                    <!-- Google+ -->
                    <a href="https://plus.google.com/share?url=https://futureed.herokuapp.com/exercises/1" title="Share on Google+" target="_blank" class="btn btn-googleplus" popup="true"><i class="fa fa-google-plus"></i> Google+</a>


                </div>
            </div>
        </div>
    </div>

    <div id="cur_code" class="modal" style="display:none;">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">This is the JavaScript code that represents your program:</h2>
            </div>
            <div class="panel-body">
                <pre class="cur_code"></pre>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Settings.
        var promptBeforeExit = false;
        /*
         var availableCategories = [
         'motion',
         'control',
         'looks',
         'sensing',
         'sound',
         'operators',
         'pen',
         'variables',
         'lists',
         'other'
         ];
         */
        var availableCategories = ['motion'];
    </script>
    <script type="text/javascript" src="/snap/morphic.js"></script>
    <script type="text/javascript" src="/snap/widgets.js"></script>
    <script type="text/javascript" src="/snap/blocks.js"></script>
    <script type="text/javascript" src="/snap/threads.js"></script>
    <script type="text/javascript" src="/snap/objects.js"></script>
    <script type="text/javascript" src="/snap/gui.js"></script>
    <script type="text/javascript" src="/snap/paint.js"></script>
    <script type="text/javascript" src="/snap/lists.js"></script>
    <script type="text/javascript" src="/snap/byob.js"></script>
    <script type="text/javascript" src="/snap/xml.js"></script>
    <script type="text/javascript" src="/snap/store.js"></script>
    <script type="text/javascript" src="/snap/locale.js"></script>
    <script type="text/javascript" src="/snap/cloud.js"></script>
    <script type="text/javascript" src="/snap/sha512.js"></script>
    <script type="text/javascript" src="/snap/FileSaver.min.js"></script>
    <script type="text/javascript">
        function sleepFor( sleepDuration ){
            var now = new Date().getTime();
            while(new Date().getTime() < now + sleepDuration){ /* do nothing */ }
        }
        var world;
        var futureMorph;
        var scripts;
        var target_script;
        var cur_code;
        window.onload = function () {
            world = new WorldMorph(document.getElementById('world'), false);
            world.worldCanvas.focus();
            futureMorph = new IDE_Morph();
            futureMorph.openIn(world);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                document.xxx = xhttp;
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    futureMorph.rawOpenProjectString(xhttp.responseText);
                    futureMorph.selectSprite(futureMorph.sprites.contents[1]);
                    scripts = futureMorph.sprites.contents[1].scripts.children;
                    hideUnwantedScripts();
                    futureMorph.stage.fireGreenFlagEvent();
                }
            };
            xhttp.open("GET", "/snap/test.xml", true);
            xhttp.send();
            element = document.getElementById("world_container");
            world.resize(element.clientWidth-18,560);
            //world.resizeChildren();
            setInterval(loop, 1);
        };
        function hideUnwantedScripts() {
            var len = scripts.length;
            for (var i = 0; i < len; i++) {
                if (scripts[i].selector != "evaluateCustomBlock") {
                    scripts[i].hide()
                } else {
                    target_script = scripts[i];
                    scripts[i].isDraggable = false
                    var ring = scripts[i].children[scripts[i].children.length-1]
                    ring.isDraggable = false;
                    ring.children[ring.children.length-1].hide();
                    ring.fixLayout();
                }
            }
        }
        function loop() {
            world.doOneCycle();
        }

        function update_code() {
            target_script.mouseClickLeft(true);
        }

        function viewCode() {
            update_code();
            futureMorph.stage.doCustomBroadcastEvent("show_code");
        }

        function runCode() {
            update_code();
            futureMorph.stage.doCustomBroadcastEvent("run_code");
        }

        function showCode() {
            displayCode();
            $("#cur_code").modal();
        }

        function displayCode() {
            $(".cur_code").text(cur_code);
        }

        function successful() {
            displayCode();
            $("#cash_points").text("5");
            $("#reward_points").text("1");
            $("#badge_points").text("1");
            $("#successful").modal();
        }

        function unsuccessful() {
            displayCode();
            $("#unsuccessful").modal();
        }

        $( window ).resize(function() {
            element = document.getElementById("world_container");
            world.resize(element.clientWidth-18,560);
        });

        $('a[popup]').on('click', function(event) {
            event.preventDefault();
            return PopupCenter(this.href, 'popup', '500', '500');
        });

    </script>

</div>



</body>
</html>