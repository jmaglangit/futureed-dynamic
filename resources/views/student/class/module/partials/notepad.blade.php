<div id="slide-panel">
    <a href="#" class="btn" id="opener"><img class="notepad-opener" ng-src="/images/notepad.png"/></a>
    <canvas id="notepad_sketch" width="820" height="450"></canvas>
    <div id="notepad-info" class="alert alert-info">
        <strong>{!! trans('messages.note') !!}:</strong><br/>
        <br/>{!! trans('messages.notepad_marker_tooltip') !!}<br/>
        <br/>{!! trans('messages.notepad_clear_tooltip') !!}
    </div>
    <div class="col-md-12 tools">
        <div class="col-md-6 color_sketch">
            <a class="btn" href="#notepad_sketch" data-color="#f00" style="background: #f00;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#ff0" style="background: #ff0;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#0f0" style="background: #0f0;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#0ff" style="background: #0ff;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#00f" style="background: #00f;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#f0f" style="background: #f0f;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#000" style="background: #000;"></a>
            <a class="btn" href="#notepad_sketch" data-color="#fff" style="background: #fff;"></a>
        </div>
        <div class="col-md-3 size_sketch">
            <a class="btn" href="#notepad_sketch" data-size="3" style="background: #fff; ">
                <i class="fa fa-pencil" aria-hidden="true" style="color:black;margin-top:4px;"></i></a>
            <a class="btn" href="#notepad_sketch" data-size="5" style="background: #fff">
                <i class="fa fa-pencil fa-2x" aria-hidden="true" style="color:black;margin-top:-2px;margin-left:-5px;"></i></a>
            <a class="btn" href="#notepad_sketch" data-size="10" style="background: #fff">
                <i class="fa fa-pencil fa-3x" aria-hidden="true" style="color:black;font-size: 2.7em;margin-top:-4px;margin-left:-8px;"></i></a>
            <a class="btn" href="#notepad_sketch" data-size="15" style="background: #fff">
                <i class="fa fa-pencil fa-4x" aria-hidden="true" style="color:black;font-size:3.25em;margin-top:-5px;margin-left:-11px;"></i></a>
        </div>
        <div class="col-md-2 marker-sketch"><a href="#notepad_sketch" data-tool="marker" class="btn btn-blue"
                                               data-toggle="tooltip" data-placement="bottom" title="{!! trans('messages.notepad_marker_tooltip') !!}">
                {!! trans('messages.notepad_marker') !!}</a></div>
        <div class="col-md-2 erase-sketch"><a href="#notepad_sketch" data-tool="eraser" class="btn btn-blue"
                                              data-toggle="tooltip" data-placement="bottom" title="{!! trans('messages.notepad_clear_tooltip') !!}">
                {!! trans('messages.notepad_clear') !!}</a></div>
        <div class="col-md-2 help-sketch"><a href="#notepad_sketch" data-tool="help" class="btn btn-blue">{!! trans('messages.help') !!}</a></div>
    </div>
</div>
{!! Html::script('/js/common/notepad.js')!!}