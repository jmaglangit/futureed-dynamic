<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
<div ng-controller="ManageTeacherTipsController as tips" ng-init="tips.setTipsActive('list')" ng-cloak>
	<div class="content-title">
		<div class="title-main-content">
			<span><i class="fa fa-gear"></i> Tips & Help Requests</span>
		</div>
	</div>
	<div class="form-content col-xs-12">
		<ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active">
		    	<a ng-click="class.setTabActive('tip')" href="#home" aria-controls="home" role="tab" data-toggle="tab"><span><i class="fa fa-lightbulb-o"></i>Tips</span></a>
		    </li>
		    <li role="presentation">
		    	<a ng-click="class.setTabActive('help')" href="#help" aria-controls="help" role="tab" data-toggle="tab"><span><i class="fa fa-question-circle"></i>Help Requests</span></a>
		    </li>
		    <li>
		    	<a href="#"><span><i class="fa fa-exclamation-circle"></i>Help Request Answers</span></a>
		    </li>
		</ul>
	</div>
		
	<div class="tab-content">
	  	<div role="tabpanel" class="tab-pane fade in" ng-class="{'active': class.tip_tab_active}" id="home">
			<div template-directive template-url="{!! route('client.teacher.tips.partials.list_tips_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.tips.partials.view_tips_form') !!}"></div>

			<div template-directive template-url="{!! route('client.teacher.tips.partials.edit_tips_form') !!}"></div>
		</div>
		<div role="tabpanel" class="tab-pane fade" ng-class="{'in': class.help_tab_active, 'active': class.help_tab_active}" id="help" ng-init="tips.setHelpActive('list')">
			<div template-directive template-url="{!! route('client.teacher.help.partials.list_help_form') !!}"></div>
			<div template-directive template-url="{!! route('client.teacher.help.partials.view_help_form') !!}"></div>
		</div>
  	</div>
</div>