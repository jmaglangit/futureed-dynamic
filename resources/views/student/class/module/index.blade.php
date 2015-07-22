@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="col-xs-12" ng-init="backgroundClass(); checkClass(1)" ng-controller="StudentModuleController as mod">
		<div>
			<ul class="breadcrumb">
			    <li><a href="#"><span><i class="fa fa-home"></i></span></a></li>
			    <li><a href="#">United States</a></li>
			    <li class="active">Math</li>
			</ul>
		</div>
		<div class="col-xs-2">
			<div class="margin-top-bot-5">
				<a href="javascript:;"><img src="/images/class-student/icon-askforhelp.png" ng-click="mod.askHelp()"></a>
			</div>
			<div class="margin-top-bot-5 pointer">
				<img src="/images/class-student/icon-givetip.png" ng-click="mod.giveTip()">
			</div>
		</div>
		{{-- this is a sample iframe only (vimeo) --}}
		<div class="col-xs-8">
			<div class="video-iframe">
				<iframe src="https://player.vimeo.com/video/133667971" width="100%" height="500" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="margin-top-bot-10">
				{!! Form::button('Start'
					,array(
						'class' => 'btn btn-maroon'
						, 'ng-click' => 'tips.searchFnc($event)'
					)
				)!!}
			</div>
			<div class="margin-top-bot-10">
				{!! Form::button('Exit Module'
					,array(
						'class' => 'btn btn-gold'
						, 'ng-click' => 'tips.searchFnc($event)'
					)
				)!!}
			</div>
		</div>
		<div class="row">
			<div class="drawer col-xs-6">
				<div class="button" id="button">
					<img ng-click="mod.toggleBtn()" class="pointer" ng-class="{'flip-270':mod.toggle_bottom,'flip-90':!mod.toggle_bottom, }" src="/images/class-student/btn-slide.png">
				</div>
				<div class="drawer-appear">
					<div class="drawer-inside" ng-class="{'openup' : mod.toggle_bottom}">
						<div class="drawer-header">
							<div class="row">
								<div class="margin-top-5">
									<img class="pull-left" src="/images/class-student/icon-tip_principal.png">
									<h3 class="pull-left">Give Tips</h3>	
								</div>
							</div>
						</div>
						<div class="col-xs-10 col-xs-offset-1 margin-top-15">
							<div class="col-xs-12">
								<div class="clearfix"></div>
								{!! Form::open(['class' => 'form-horizontal margin-top-15']) !!}
								<div class="form-group">
									<label class="control-label col-xs-2">Title</label>
									<div class="col-xs-10">
										{!! Form::text('title', ''
											, array(
											    'class' => 'form-control sidebar-input'
											    , 'placeholder' => 'Title' 
											    , 'ng-model' => 'class.help.title'
											    , 'autocomplete' => 'off')
										) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2">Description</label>
									<div class="col-xs-10">
										{!! Form::textarea('content', ''
							                , array(
							                    'class' => 'form-control sidebar-input'
							                    , 'placeholder' => 'Description' 
							                    , 'ng-model' => 'class.help.content'
							                    , 'autocomplete' => 'off')
							            ) !!}
									</div>
								</div>
							</div>
							<div class="col-xs-12 btn-container">
								{!! Form::button('Submit'
									, array(
									  'id' => 'validate_code_btn'
									  , 'class' => 'btn btn-maroon btn-medium'
									  , 'ng-click' => 'class.submitHelp()'
									)
								) !!}
								{!! Form::button('Back'
									, array(
										'id' => 'validate_code_btn'
										, 'class' => 'btn btn-gold btn-medium'
										, 'ng-click' => 'class.submitHelp()'
										)
								) !!}
							</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			<div class="drawer-help col-xs-6">
				<div class="button" id="button">
					<img ng-click="mod.toggleBtnHelp()" class="pointer" ng-class="{'flip-270':mod.toggle_help_bottom,'flip-90':!mod.toggle_help_bottom, }" src="/images/class-student/btn-slide.png">
				</div>
				<div class="drawer-appear">
					<div class="drawer-inside" ng-class="{'openup' : mod.toggle_help_bottom}">
						<div class="drawer-header">
							<div class="row">
								<div class="margin-top-5">
									<img class="pull-left" src="/images/class-student/icon-tip_principal.png">
									<h3 class="pull-left">Help Request</h3>	
								</div>
							</div>
						</div>
						<div template-directive template-url="{!! route('student.class.module.partials.add_help') !!}"></div>
						<div template-directive template-url="{!! route('student.class.module.partials.list_help') !!}"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_module_controller.js')!!}
	{!! Html::script('/js/student/services/student_module_service.js')!!}
@stop

