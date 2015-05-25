<div ng-if="admincon.client_list && !admincon.add_client">
<div class="content-title">
					<div class="title-main-content">
						<span>Client Management</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
	                <div class="col-xs-3" style="padding:0;">
						<div class="btn btn-gold" ng-click="admincon.setActiveAdmin('add_client')">
							<div class="row">
								<i class="fa fa-plus-square"></i>
							</div>
							<div class="row">
								Add User
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="title-mid">
						Search
					</div>
				</div>
				<div class="col-xs-12 search-container">
					<div class="form-search">
						{!! Form::open(
							array('id' => 'search_form'
								, 'method' => 'POST'
								, 'class' => 'form-inline'
								)
							)!!}
						<div class="form-group">
							<div class="col-xs-5">
								{!! Form::text('search_name', ''
									,array(
										'placeholder' => 'Name'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-5">
								{!! Form::text('search_email', ''
									,array(
										'placeholder' => 'Email Address'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-2">
								{!! Form::button('Search'
									,array(
										'class' => 'btn btn-gold'
										)
								)!!}
							</div>
						</div>
						<div class="form-group" style="margin-top:20px;">
							<div class="col-xs-5">
								{!! Form::text('search_school', ''
									,array(
										'placeholder' => 'School'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-5">
								{!! Form::select('search_role', array('Teacher' => 'teacher', 'Principal' => 'principal')
									, null
									,array(
										'placeholder' => 'Email Address'
										, 'ng-model' => 'search_name'
										, 'class' => 'form-control'
										)
								)!!}
							</div>
							<div class="col-xs-2">
								{!! Form::button('clear'
									,array(
										'class' => 'btn btn-white'
										)
								)!!}
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="title-mid">
						Client List
					</div>
				</div>
				<div class="col-xs-12 table-container">
					<div class="list-container" ng-cloak>
						<table id="client-list" datatable="ng"class="table table-striped table-hover dt-responsive" style="width:100%">
							<thead>
				        <tr>
				            <th>Name</th>
				            <th>Email</th>
				            <th>Role</th>
				            <th>Action</th>
				        </tr>
				        </thead>
				        <tbody>
				        <tr ng-repeat="person in ::persons" data-id>
				            <td>{! person.id !}</td>
				            <td>{! person.firstName !}</td>
				            <td>{! person.lastName !}</td>
				            <td>
				            	<div class="row">
				            		<div class="col-xs-3">
				            			<a href="#" id="{! person.id !}"><span><i class="fa fa-eye"></i></span></a>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-pencil"></i></span>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-ban"></i></span>
				            		</div>
				            		<div class="col-xs-3">
				            			<span><i class="fa fa-trash	"></i></span>
				            		</div>	
				            	</div>
				            </td>
				        </tr>
				        </tbody>

						</table>
					</div>
				</div>
</div>