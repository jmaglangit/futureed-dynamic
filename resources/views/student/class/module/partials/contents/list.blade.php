
<div class="col-xs-12 padding-0">
	<!-- <div ng-if="mod.contents.teaching_content.media_type.id == futureed.VIDEO"> -->
	<div ng-if="mod.contents.length > 0 && mod.contents[0].teaching_content.media_type.id == futureed.VIDEO">
		<div class="questions-container col-xs-12 col-md-12">
			<div class="row questions-header">
				<div class="row col-xs-3">
					<button type="button" class="btn btn-gold next-btn left-15 top-7" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
						{{ trans('messages.exit_module') }}
					</button>
				</div>

				<div class="row col-xs-6">
					<h3> {! mod.contents.teaching_content.teaching_module +' '+ mod.record.grade.name  !} </h3>
				</div>

				<div class="row col-xs-3">

					<button type="button" class="btn btn-gold next-btn top-7" ng-click="mod.setActive(futureed.ACTIVE_QUESTIONS)"> {{ trans('messages.skip') }} </button>
				</div>
			</div>

			<!-- For Teaching Video Contents -->
		    <section id="content-video">
			    <div class="content-video-body">
				    <div class="col-sm-3">
		                <ul class="content-video-thumbnail col-xs-12" ng-repeat="content in mod.contents">
		                    <li class="col-xs-12">
			                    <iframe ng-if="content.teaching_content.content_url"
			                            ng-src="{! content.teaching_content.content_url | trustAsResourceUrl !}"
			                            width="100%"
			                            height="30%"
			                            align="middle"
			                            frameborder="2"
			                            webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
		                    <div class="iframe-overlay" ng-click="mod.showContent(content)"></div>
		                    </li>
		                </ul>
		            </div>
		            <div class="col-sm-9">
		                <div class="content-main-video">
		                    <iframe ng-if="mod.content.teaching_content.content_url"
		                            ng-src="{! mod.content.teaching_content.content_url | trustAsResourceUrl !}"
		                            width="100%"
		                            height="100%"
		                            align="middle"
		                            frameborder="2"
		                            webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
		                </div>
		                <div ng-if="mod.table.page_count > 1">
							<div class="previous-btn-position" ng-if="mod.table.page > futureed.DEFAULT_PAGE">
													<span  ng-click="mod.previousPage()"
														   ng-model="mod.table.page">&lt;</span>
							</div>
							<div class="next-btn-position" ng-if="mod.table.page != mod.table.total_items">
													<span  ng-click="mod.nextPage()"
														   ng-model="mod.table.page">&gt;</span>
							</div>
						</div>
		            </div>
	            </div>
			</section>
		</div>
	</div>

	<div ng-if="mod.contents.teaching_content.media_type.id == futureed.IMAGE">
		<div class="questions-container col-xs-12 col-md-12">
			<div class="row questions-header">
				<div class="row col-xs-3">
					<button type="button" class="btn btn-gold next-btn left-15 top-7" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
						{{ trans('messages.exit_module') }}
					</button>
				</div>

				<div class="row col-xs-6">
					<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
				</div>

				<div class="row col-xs-3">

					<button type="button" class="btn btn-gold next-btn top-7" ng-click="mod.setActive(futureed.ACTIVE_QUESTIONS)"> {{ trans('messages.skip') }} </button>
				</div>
			</div>

			<div class="content-body">
				<div class="content-image">
					<img ng-if="mod.contents.teaching_content.original_image_name" ng-src="{! mod.contents.teaching_content.content_url !}" />
				</div>
			</div>
		</div>
	</div>

	<div ng-if="mod.contents.teaching_content.media_type.id == futureed.TEXT">
		<div class="questions-container col-xs-12 col-md-12">
			<div class="row questions-header">
				<div class="row col-xs-3">
					<button type="button" class="btn btn-gold next-btn left-15 top-7" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
						{{ trans('messages.exit_module') }}
					</button>
				</div>

				<div class="row col-xs-6">
					<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
				</div>

				<div class="row col-xs-3">

					<button type="button" class="btn btn-gold next-btn top-7" ng-click="mod.setActive(futureed.ACTIVE_QUESTIONS)"> {{ trans('messages.skip') }} </button>
				</div>
			</div>

			<div class="content-body">
				<div class="content-message">
					<p ng-bind-html="mod.contents.teaching_content.content_text | trustAsHtml"></p>
				</div>
			</div>
		</div>
	</div>

	<div ng-if="mod.contents[0].teaching_content.media_type.id != futureed.VIDEO && mod.contents.teaching_content.media_type.id != futureed.IMAGE">
			here --> {! mod.contents.length !}
		<div class="questions-container col-xs-12 col-md-12">
			<div class="row questions-header">
				<div class="row col-xs-3">
					<button type="button" class="btn btn-gold next-btn left-15 top-7" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
						{{ trans('messages.exit_module') }}
					</button>
				</div>

				<div class="row col-xs-6">
					<h3> {! mod.contents.teaching_content.teaching_module !} </h3>
				</div>

				<div class="row col-xs-3">
					<button type="button" class="btn btn-gold next-btn top-7" ng-click="mod.setActive(futureed.ACTIVE_QUESTIONS)"> {{ trans('messages.skip') }} </button>
				</div>
			</div>
			<div class="content-body">
				<div class="content-message">
					<h3 class="alert alert-info">{!! trans('messages.content_not_available') !!} </h3>
				</div>
			</div>
		</div>
	</div>
</div>
