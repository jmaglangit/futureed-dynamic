<div id="delete_modal" ng-show="help.confirm.delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Delete Help Request
			</div>
			<div class="modal-body">
				Are you sure you want to delete this help request?
			</div>
			<div class="modal-footer">
				<div class="btncon col-md-8 col-md-offset-4 pull-left">
					{!! Form::button('Yes'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'help.deleteHelp()'
							, 'data-dismiss' => 'modal'
						)
					) !!}

					{!! Form::button('No'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'data-dismiss' => 'modal'
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>