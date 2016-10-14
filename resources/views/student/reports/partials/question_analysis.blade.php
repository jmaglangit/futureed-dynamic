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
            <div class="col-xs-4">
                <span>Subject</span>
                <select
                        class="form-control">
                    <option value="">Select Subject</option>
                </select>
            </div>
            <div class="col-xs-4">
                <span>Subject</span>
                <select
                        class="form-control">
                    <option value="">Select Subject</option>
                </select>
            </div>
            <div class="col-xs-4">
                <span>Subject</span>
                <select
                        class="form-control">
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