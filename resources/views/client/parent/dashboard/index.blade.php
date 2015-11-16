<div ng-if="user.role == futureed.PARENT" class="dashboard-content" ng-cloak>
    <p>
        To get started on using Future Lesson, you need to add a student, click
        <a href="{!! route('client.parent.student.index') !!}"> student</a>.
    </p>

    <p>If you already added a Student, you can
        <a href="{!! route('client.parent.payment.index') !!}"> buy a subject</a> for the your student</p>

    <p>You can also
        <a href="{!! route('client.parent.module.index') !!}"> review</a> the lessons and practice questions.</p>
</div>





