<div class="thumbnail">
    <a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUMMARY_PROGRESS)">
        {!! trans('messages.graph_link_message') !!}
    </a>
    <svg class="chart-spent-monthly" width="370" height="250" ng-init="reports.getStudentMonthlySpentHours()"></svg>
</div>