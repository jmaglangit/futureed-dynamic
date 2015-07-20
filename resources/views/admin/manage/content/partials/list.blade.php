<div ng-if="content.active_list">
	<div class="col-xs-12 success-container" ng-if="content.errors || content.success">
		<div class="alert alert-error" ng-if="content.errors">
			<p ng-repeat="error in content.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="content.success">
            <p>{! content.success !}</p>
        </div>
    </div>

	<div class="col-xs-12">
		<div class="title-mid">
			Search
		</div>

		<div class="form-search">
			{!! Form::open(
				array('id' => 'search_form'
					, 'class' => 'form-horizontal'
					, 'ng-submit' => 'content.searchFnc($event)'
				)
			)!!}
			<div class="form-group">
				<div class="col-xs-4">
					{!! Form::text('search_teaching_module', ''
						,array(
							'placeholder' => 'Teaching Module Name'
							, 'ng-model' => 'content.search.teaching_module'
							, 'class' => 'form-control'
						)
					)!!}
				</div>

				<div class="col-xs-4" ng-init="content.getLearningStyle()">
					<select  name="learning_style" class="form-control" ng-model="content.search.learning_style">
						<option value="">-- Select Learning Style --</option>
						<option ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>
					</select>
				</div>
				
				<div class="col-xs-2">
					{!! Form::button('Search'
						,array(
							'class' => 'btn btn-blue'
							, 'ng-click' => 'content.searchFnc($event)'
						)
					)!!}
				</div>

				<div class="col-xs-2">
					{!! Form::button('Clear'
						,array(
							'class' => 'btn btn-gold'
							, 'ng-click' => 'content.clearFnc($event)'
						)
					)!!}
				</div>
			</div>
		</div>
	</div>
	 
	<div class="col-xs-12">
		<button class="btn btn-blue btn-small content-btn" ng-click="content.setActive(futureed.ACTIVE_ADD)">
			<i class="fa fa-plus-square"></i> Add Content
		</button>

		<div class="title-mid">
			Module Content List
		</div>

		<div class="list-container" ng-cloak>
			<div class="size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'content.table.size'
						, 'ng-change' => 'content.paginateBySize()'
						, 'ng-if' => "content.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<div class="clearfix"></div>
			<div class="table-responsive" ng-init="content.listContents()">
				<table id="tip-list" class="table table-striped table-bordered">
					<thead>
				        <tr>
				            <th>Code</th>
				            <th>Teaching Module Name</th>
				            <th>Learning Style</th>
				            <th>Media Type</th>
				            <th ng-if="content.records.length">Actions</th>
				        </tr>
			        </thead>
			        <tbody>
				        <tr ng-repeat="contentInfo in content.records">
				            <td>{! contentInfo.code !}</td>
				            <td>{! contentInfo.teaching_module !}</td>
				            <td>{! contentInfo.learning_style.name !}</td>
				            <td>{! contentInfo.media_type.name !}</td>
				            <td ng-if="content.records.length">
				            	<div class="row">
				            		<div class="col-xs-4">
				            			<a href="" ng-click="content.setActive(futureed.ACTIVE_VIEW, contentInfo.id)"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="content.setActive(futureed.ACTIVE_EDIT, contentInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
				            		</div>
				            		<div class="col-xs-4">
				            			<a href="" ng-click="content.confirmDelete(contentInfo.id)"><span><i class="fa fa-trash"></i></span></a>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        <tr class="odd" ng-if="!content.records.length && !content.table.loading">
				        	<td valign="top" colspan="7">
				        		No records found
				        	</td>
				        </tr>
				        <tr class="odd" ng-if="content.table.loading">
				        	<td valign="top" colspan="7">
				        		Loading...
				        	</td>
				        </tr>
			        </tbody>
				</table>
			</div>
			<div class="pull-right" ng-if="content.records.length">
				<pagination 
					total-items="content.table.total_items" 
					ng-model="content.table.page"
					max-size="3"
					items-per-page="content.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="content.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>