<div class="question-analysis" ng-if="reports.active_question_analysis">
    <div class="form-search magenta">
        {!! Form::open(
				[
					'id' => 'search_form',
					'class' => 'form-horizontal'
					, 'ng-submit' => 'reports.searchFnc($event)'
				]
		) !!}
        <div class="form-group">
                <label class="col-xs-2 question-analysis-filter">{!! trans('messages.subject') !!}</label>
                <div class="col-xs-2">
                    <select class="form-control">
                        <option value="">{!! trans('messages.select_subject') !!}</option>
                    </select>
                </div>
            <label class="col-xs-2 question-analysis-filter">Subject</label>
            <div class="col-xs-2">
                <select class="form-control">
                    <option value="">Select Subject</option>
                </select>
            </div>
            <label class="col-xs-2 question-analysis-filter">Subject</label>
            <div class="col-xs-2">
                <select class="form-control">
                    <option value="">Select Subject</option>
                </select>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="list-container" ng-cloak>
        <table id="tip-list" class="table table-striped table-bordered">

        </table>
    </div>


</div>