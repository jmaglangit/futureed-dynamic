@extends('student.app')

	@section('navbar')
	    @include('student.partials.main-nav')
	@stop

	@section('content')
	<div class="container dshbrd-con" ng-cloak>
		<div class="wrapr"> 
			<div class="side-nav">
				@include('student.partials.dshbrd-side-nav')
			</div>
			<div class="content">
				<div class="hdr">
				<div class="avtrcon">
					<img ng-src="{! user.avatar !}">
				</div>
				<div class="detcon">
					<div class="rwrdscon">
						<h3>
							<div class="rbn-left"></div>
							<div class="rbn-right"></div>
							Quick <span>Rewards</span>
						</h3>
						<div class="points">
							<span class="star">☆</span>
							<div class="pcon">
								<span>20</span> points
							</div>
							<a href="" class="lnk">See all points</a>
						</div>
					</div>
					<h2>
							<span class="thin">Change</span> Avatar</h2>
					<p>
						Select your new avatar.
					</p>
				</div>
			</div>
				<div class="form-content">
					<div class="alert alert-success" ng-if="has_avatar">
						You have successfully changed your avatar.
					</div>
					<div class="col-md-10 col-md-offset-1" ng-if="!has_avatar">
			      		{!! Form::open(array('id' => 'change_avatar_form')) !!}
				        <div class="form-select-password">

				          <div class="alert alert-danger" ng-if="errors">
				            <p ng-repeat="error in errors" > 
				              {! error !}
				            </p>
				          </div>

				          <div class="form_content">
				            <ul class="avatar_list list-unstyled list-inline" ng-init="getAvatarImages('true')">
				              <li class="item avtrcon" style="width:20%" ng-repeat="avatar in avatars" ng-click="highlightAvatar($event)">
				                 <img ng-src="{! avatar.url !}" alt="{! avatar.name !}">
				                 <input type="hidden" id="avatar_id" name="avatar_id" value="{! avatar.id !}">
				              </li>
				            </ul>
						  </div>
				        </div>
				        
				        <input type="hidden" ng-model="session_user" />
				      {!! Form::close() !!}
				    </div>
				    <div class="btn-container" ng-if="!has_avatar">
				    	{!! Form::button('Proceed'
				    		, array(
				    			'class' => 'btn btn-maroon btn-medium'
				    			, 'ng-if' => 'enable'
				    			, 'ng-click' => 'selectAvatar()'
				    		)
				    	) !!}

				    	{!! Html::link(route('student.profile.index'), 'Cancel'
				    		, array(
				    			'class' => 'btn btn-gold btn-medium'
				    		)	
				    	) !!}
			      	</div>
				</div>
			</div>
		</div>
	</div>
	@stop

	@section('footer')

	@overwrite

	@section('scripts')

	@stop