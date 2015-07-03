<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
<div ng-controller="ManageTeacherTipsController as tips" ng-init="tips.setActive('list')" ng-cloak>
	<div class="content-title">
		<div class="title-main-content">
			<span><i class="fa fa-gear"></i> Tips & Help Requests</span>
		</div>
	</div>
	<div class="form-content col-xs-12">
		<ul class="nav nav-tabs">
		    <li class="active">
		    	<a href=""><span><i class="fa fa-lightbulb-o"></i>Tips</span></a>
		    </li>
		    <li>
		    	<a href="{!! route('admin.manage.help.index') !!}"><span><i class="fa fa-question-circle"></i>Help Requests</span></a>
		    </li>
		    <li>
		    	<a href="{!! route('admin.manage.answer.index') !!}"><span><i class="fa fa-exclamation-circle"></i>Help Request Answers</span></a>
		    </li>
		</ul>
	</div>
		
	<div class="tab-content" ng-init="tips.setActive()">
	  	<div id="home" class="tab-pane fade in active">
			<div template-directive template-url="{!! route('client.teacher.tips.partials.list_tips_form') !!}"></div>

			<div template-directive template-url="{!! route('admin.manage.tips.partials.detail') !!}"></div>

			<div template-directive template-url="{!! route('admin.manage.tips.partials.delete') !!}"></div>
		</div>
  	</div>
</div>