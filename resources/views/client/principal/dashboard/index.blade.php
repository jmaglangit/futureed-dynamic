<div ng-if="user.role == futureed.PRINCIPAL" class="dashboard-content" ng-cloak>
    <p>To get started on using Future Lesson, you need to invite a
        <a href="{!! route('client.principal.teacher.index') !!}"> teacher</a> first to manage your classes.</p>

    <p>If you have already invited a Teacher, you need to go to the
        <a href="{!! route('client.principal.payment.index') !!}"> payment</a> to buy seats for your classes.</p>
</div>


