<div id="sticky-side-bar" class="sidebar sidebar-toggle" ng-class="{'slide-out':class.bool_change_class}">
	{!! Form::open(
		array(
			  'id' => 'redirect_tip'
			, 'route' => 'student.tips.post.index'
			, 'method' => 'futureed.METHOD_POST'
		)
	) !!}
		{!! Form::hidden('id', null) !!}
	{!! Form::close() !!}

	{!! Form::open(
		array(
			  'id' => 'redirect_help'
			, 'route' => 'student.help.post.index'
			, 'method' => 'futureed.METHOD_POST'
		)
	) !!}
		{!! Form::hidden('id', null) !!}
	{!! Form::close() !!}

	<div class="side-header">
		<img class="tips-img-header" src="/images/class-student/sidebar_header_tips.png" alt="">
	</div>
	<div id="tips_form" class="side-container">
		<div class="clearfix"></div>
		<div ng-show="!class.add_tips && !class.tips.success">
			<div class="sidebar-div" ng-repeat="tip_record in class.tip.records">
				<div class="div-side-content">
					<a href="" ng-click="class.redirectTip(tip_record.id)">{! tip_record.title !}</a>
					<p class="user-detail-star">
						<span ng-repeat="i in tip_record.stars track by $index">
							<img ng-src="{! $index+1 <= tip_record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						</span>
					</p>
					<p class="user-detail"><span><i class="fa fa-user"></i> {! tip_record.student.first_name !} {! tip_record.student.last_name !}</span></p>
					<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
					<p class="user-detail"><span><i class="fa fa-calendar-o"></i> {! tip_record.created_moment !}</span></p>
				</div>
			</div>
			<div class="sidebar-div" ng-if="!class.tip.total">
				<div class="div-side-content">
					<p>No Tips for now...</p>
				</div>
			</div>
		</div>
		<div class="sidebar-div" ng-if="class.alert">
			<div class="alert alert-danger" ng-if="class.tips.errors">
			    <p ng-repeat="error in class.tips.errors track by $index" > 
			      	{! error !}
			    </p>
			</div>
			<div class="alert alert-success" ng-if="class.tips.success">
				<p>Success! You have added a new tip. Your content is currently being reviewed.</p>
			</div>
		</div>
		<div class="clearfix"></div>	
		{!! Form::open(['id' => 'add-tips-form']) !!}
			<div ng-if="class.add_tips && !class.tips.success">
				<div class="sidebar-div">
					<div class="tip-form">
						<div class="form-group">
							<label class="control-label label-side">Title</label>
							{!! Form::text('title', ''
				                , array(
				                    'class' => 'form-control sidebar-input'
				                    , 'placeholder' => 'Title' 
				                    , 'ng-model' => 'class.tips.title'
				                    , 'autocomplete' => 'off')
				            ) !!}
						</div>
						<div class="form-group">
							<label class="control-label label-side">Description</label>
							{!! Form::textarea('description', ''
				                , array(
				                    'class' => 'form-control sidebar-input'
				                    , 'placeholder' => 'Description' 
				                    , 'ng-model' => 'class.tips.content'
				                    , 'autocomplete' => 'off')
				            ) !!}	
						</div>
						<div class="side-btn-container submit-btn-tips">
							{!! Form::button('Submit'
				                , array(
				                  'id' => 'submit'
				                  , 'class' => 'btn btn-blue side-btn'
				                  , 'ng-click' => 'class.submitTips()'
				                )
				            ) !!}
				            {!! Form::button('Back'
				                , array(
				                  'id' => 'back'
				                  , 'class' => 'btn btn-maroon'
				                  , 'ng-click' => 'class.backTips()'
				                )
				            ) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="side-btn-container row" ng-if="class.tips.success">
				<div class="col-xs-6 btn-left">
					{!! Form::button('Add More'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-blue'
		                  , 'ng-click' => 'class.addTips()'
		                )
		            ) !!}
				</div>
				<div class="col-xs-6 btn-right">
					{!! Form::button('Back'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-maroon'
		                  , 'ng-click' => 'class.backTips()'
		                )
		            ) !!}
				</div>
			</div>
			<div class="side-btn-container row" ng-if="!class.add_tips && !class.tips.success">
				<div class="col-xs-6 btn-left">
					{!! Html::link(route('student.tips.index'), 'View More'
		                , array(
		                   'class' => 'btn btn-blue'
		                  , 'ng-if' => 'class.tip.total > 3'
		                )
		            ) !!}
				</div>
				<div class="col-xs-6 btn-right">
					{!! Form::button('Add Tips'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-maroon'
		                  , 'ng-click' => 'class.addTips()'
		                )
		            ) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>

	<div class="side-header">
		<img class="help-img-header" src="/images/class-student/sidebar_header_helprequest.png" alt="">
	</div>
	<div id="help_request_form">
		<div class="side-btn-container row" ng-if="!class.add_help && !class.help.success">
			<div class="col-xs-12 submit-btn-help">
				{!! Form::open(
					array(
						'route' => 'student.help.post.index'
						, 'method' => 'futureed.METHOD_POST'
					)
				) !!}
					{!! Form::hidden('request_type', 'Own') !!}
					{!! Form::submit('My Help Requests'
		                , array(
		                   'class' => 'btn btn-blue'
		                  , 'ng-if' => 'class.help.total'
		                )
		            ) !!}
	            {!! Form::close() !!}
			</div>
		</div>

		<div class="clearfix"></div>
		<div ng-show="!class.add_help && !class.help.success">
			<div class="sidebar-div" ng-repeat="help_record in class.help.records">
				<div class="div-side-content">
					<p class="side-title">
						<a href="" ng-click="class.redirectHelp(help_record.id)">{! help_record.title !}</a>
					</p>
					<p class="user-detail-star">
						<span ng-repeat="i in help_record.stars track by $index">
							<img ng-src="{! $index+1 <= help_record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						</span>
					</p>
					<p class="user-detail"><span><i class="fa fa-user"></i> {! help_record.student.first_name !} {! help_record.student.last_name !}</span></p>
					<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
					<p class="user-detail"><span><i class="fa fa-calendar-o"></i> {! help_record.created_moment !}</span></p>
				</div>
			</div>
			<div class="sidebar-div" ng-if="!class.help.total">
				<div class="div-side-content">
					<p>No Help Requests for now...</p>
				</div>
			</div>
		</div>
	
		<div class="sidebar-div" ng-if="class.alert">
			<div class="alert alert-danger" ng-if="class.help.errors">
			    <p ng-repeat="error in class.help.errors track by $index" > 
			      	{! error !}
			    </p>
			</div>
			<div class="alert alert-success" ng-if="class.help.success">
				<p>Success! You have added a new help request. Your content is currently being reviewed.</p>
			</div>
		</div>

		{!! Form::open(['id' => 'add-help-form']) !!}
			<div ng-if="class.add_help && !class.help.success">
				<div class="sidebar-div">
					<div class="help-form">
						<div class="form-group">
							<label class="control-label label-side">Title</label>
							{!! Form::text('title', ''
				                , array(
				                    'class' => 'form-control sidebar-input'
				                    , 'placeholder' => 'Title' 
				                    , 'ng-model' => 'class.help.title'
				                    , 'autocomplete' => 'off')
				            ) !!}
						</div>
						<div class="form-group">
							<label class="control-label label-side">Description</label>
								{!! Form::textarea('content', ''
					                , array(
					                    'class' => 'form-control sidebar-input'
					                    , 'placeholder' => 'Description' 
					                    , 'ng-model' => 'class.help.content'
					                    , 'autocomplete' => 'off')
					            ) !!}
						</div>
						<div class="side-btn-container submit-btn-help">
							{!! Form::button('Submit'
				                , array(
				                  'id' => 'validate_code_btn'
				                  , 'class' => 'btn btn-blue side-btn'
				                  , 'ng-click' => 'class.submitHelp()'
				                )
				            ) !!}
				            {!! Form::button('Back'
				                , array(
				                  'id' => 'back'
				                  , 'class' => 'btn btn-maroon'
				                  , 'ng-click' => 'class.backHelp()'
				                )
				            ) !!}
						</div>
					</div>
				</div>
			</div>

			<div class="side-btn-container row container-bottom" ng-if="!class.add_help && !class.help.success">
				<div class="col-xs-6 btn-left">
		            {!! Html::link(route('student.help.index'), 'View More'
		                , array(
		                   'class' => 'btn btn-blue'
		                  , 'ng-if' => 'class.help.total > 3'
		                )
		            ) !!}
				</div>
				<div class="col-xs-6 btn-right">
					{!! Form::button('Add Help'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-maroon'
		                  , 'ng-click' => 'class.addHelp()'
		                )
		            ) !!}
				</div>
			</div>
			<div class="side-btn-container row" ng-if="class.help.success">
				<div class="col-xs-6 btn-left">
					{!! Form::button('Add More'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-blue'
		                  , 'ng-click' => 'class.addHelp()'
		                )
		            ) !!}
				</div>
				<div class="col-xs-6 btn-right">
					{!! Form::button('Back'
		                , array(
		                  'id' => 'validate_code_btn'
		                  , 'class' => 'btn btn-maroon'
		                  , 'ng-click' => 'class.backHelp()'
		                )
		            ) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<div class="side-btn-toggle" ng-class="{'div-out':class.bool_change_class, 'flip-horizontal' : !class.bool_change_class }">
	<img src="/images/class-student/btn-slide.png" ng-click="class.click()">
</div>