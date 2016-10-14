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
            <label class="col-xs-2 question-analysis-filter">{!! trans('messages.school_level') !!}</label>
            <div class="col-xs-2">
                <select class="form-control">
                    <option value="">{!! trans('messages.select_level') !!}</option>
                </select>
            </div>
            <label class="col-xs-2 question-analysis-filter">{!! trans('messages.module') !!}</label>
            <div class="col-xs-2">
                <select class="form-control">
                    <option value="">{!! trans('messages.select_module') !!}</option>
                </select>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="list-container" ng-cloak>
        <table id="tip-list" class="table table-striped">
            <thead>
            <tr class="odd">
                <th>{!! trans('messages.question') !!}</th>
                <th>{!! trans('messages.answer') !!}</th>
                <th>{!! trans('messages.tips') !!}</th>
            </tr>
            </thead>
            <tbody>
                <tr class="odd">
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                </tr>
                <tr class="odd">
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                </tr>
                <tr class="odd">
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                    <td valign="top" colspan="7">
                        lol here...
                    </td>
                </tr>
            </tbody>

        </table>
    </div>


</div>