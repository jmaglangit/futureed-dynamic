<div class="sidebar sidebar-toggle" ng-class="{'slide-out':class.bool_change_class, 'send-behind':!class.send_behind}">
	<div class="side-header">
		<img class="tips-img-header" src="/images/class-student/sidebar_header_tips.png" alt="">
	</div>
	<div class="clearfix"></div>
	<div ng-show="!class.add_tips && !class.tips.success">
		<div class="sidebar-div">
			<div class="div-side-content">
				<p class="side-title">How to Add</p>
				<p class="user-detail-star"><img src="/images/class-student/icon-star_yellow.png"></p>
				<p class="user-detail"><span><i class="fa fa-user"></i> Username</span></p>
				<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
				<p class="user-detail"><span><i class="fa fa-calendar-o"></i> Some Date</span></p>
			</div>
		</div>
		<div class="sidebar-div">
			<div class="div-side-content">
				<p class="side-title">How to Add</p>
				<p class="user-detail-star"><img src="/images/class-student/icon-star_yellow.png"></p>
				<p class="user-detail"><span><i class="fa fa-user"></i> Username</span></p>
				<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
				<p class="user-detail"><span><i class="fa fa-calendar-o"></i> Some Date</span></p>
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
			{!! Form::button('View More'
                , array(
                  'id' => 'validate_code_btn'
                  , 'class' => 'btn btn-blue'
                  , 'ng-click' => 'studentValidateCode(reset_code)'
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
	<div class="side-header">
		<img class="help-img-header" src="/images/class-student/sidebar_header_helprequest.png" alt="">
	</div>
	<div class="clearfix"></div>
	<div ng-show="!class.add_help && !class.help.success">
		<div class="sidebar-div">
			<div class="div-side-content">
				<p class="side-title">How to Add</p>
				<p class="user-detail-star"><img src="/images/class-student/icon-star_yellow.png"></p>
				<p class="user-detail"><span><i class="fa fa-user"></i> Username</span></p>
				<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
				<p class="user-detail"><span><i class="fa fa-calendar-o"></i> Some Date</span></p>
			</div>
		</div>
		<div class="sidebar-div">
			<div class="div-side-content">
				<p class="side-title">How to Add</p>
				<p class="user-detail-star"><img src="/images/class-student/icon-star_yellow.png"></p>
				<p class="user-detail"><span><i class="fa fa-user"></i> Username</span></p>
				<p class="user-detail"><span><i class="fa fa-tag"></i> Some Tag</span></p>
				<p class="user-detail"><span><i class="fa fa-calendar-o"></i> Some Date</span></p>
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
	{!! Form::open(['id' => 'help-form']) !!}
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
			{!! Form::button('View More'
                , array(
                  'id' => 'validate_code_btn'
                  , 'class' => 'btn btn-blue'
                  , 'ng-click' => 'studentValidateCode(reset_code)'
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
<button class="bottom" ng-click="class.click()" ng-if="class.boolChangeClass">Toggle Sidebar</button>
</div>

<button ng-click="class.click()" ng-if="!class.boolChangeClass">Toggle Sidebar</button>