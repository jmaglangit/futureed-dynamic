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
							<span class="thin">Student</span> Rewards
					</h2>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ut erat a erat vehicula pulvinar.
					</p>
				</div>
			</div>
				<div class="form-content col-md-12">
					<div class="alert alert-info">
						No Rewards yet.
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