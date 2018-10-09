<div class="box">
	<div class="box-header">
		<h3 class="box-title">Batch <b><?php echo $this->session->batch_title; ?></b> Payment Configuration</h3>
		<a href="#paymentModal" data-toggle="modal" class="btn btn-primary pull-right" id="create" >Add New</a>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Classroom</th>
					<th>Annual</th>
					<th>Practical</th>
					<th>Exam</th>
					<th>Other</th>
					<th>Total</th>
					<th class='text-center'>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($pays as $pay) {
					echo "<tr>
							<td>{$pay->title}-{$pay->division}</td>
							<td>{$pay->annual}</td>
							<td>{$pay->practical}</td>
							<td>{$pay->exam}</td>
							<td>{$pay->other}</td>
							<td>{$pay->total}</td>
							<td class='text-center'>
								<div class='btn-group' data-id='{$pay->id}'>
									<button type='button' data-toggle='modal' data-target='#paymentModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
									<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
								</div>
							</td>
	                    </tr>";
				}
			?> 
			</tbody>
			<tfoot>
				<tr>
					<th>Classroom</th>
					<th>Annual</th>
					<th>Practical</th>
					<th>Exam</th>
					<th>Other</th>
					<th>Total</th>
					<th class='text-center'>Actions</th>
				</tr>
			</tfoot>
		</table>
	</div>
	<!-- /.box-body -->
</div>

<!-- Modal -->
<div id="paymentModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Payment Details</h4>
			</div>
			<div class="modal-body">
				<form id="payment-form" onsubmit="return false;">
					<div class="form-group">
						<label>Classroom</label>
						<select class="form-control select2" name="class" style="width: 100%;">
		                	<?php
		                		foreach ($classes as $class) {
		                			echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
		                		}
		                 	?>
		                </select>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Annual charges</label>
								<input type="number" class="form-control" name="annual" placeholder="Annual charges" step="50">
								<span class="help-text">Annual fee is charged once per term</span>
							</div>
							<div class="col-sm-6">
								<label>Practical charges</label>
								<input type="number" class="form-control" name="practical" placeholder="Practical charges" step="50">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Exam Fee</label>
								<input type="number" class="form-control" name="exam" placeholder="Exam Charges" step="50">
							</div>
							<div class="col-sm-6">
								<label>Other Payments</label>
								<input type="number" class="form-control" name="other" placeholder="Other Payments" step="50">
							</div>
						</div>
					</div>
					<div class="form-group form-actions">
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="deleteModal" class="modal modal-danger fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delete</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Do you really want to delete this record?</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="delete-btn">Yes</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#create').on('click', function(){
			$('#payment-form').on('submit', function(){
				ObjCommon.postCall('settings/createPayment', $(this).serialize(), true);
			});
		});

		$('button.edit').on('click', function(){
			ObjCommon.getCall('settings/getPaymentByID/'+$(this).closest('div').attr('data-id') , function(data){
				$.each(data, function( index, value ) {
					$('#payment-form').find('[name="'+index+'"]').val(value);
				});

				$('#payment-form').off();
				$('#payment-form').on('submit', function(){
					ObjCommon.postCall('settings/updatePayment', $(this).serialize()+'&id='+data.id, true);
				});

			});
		});

		$('button.delete').on('click', function(){
			var elem = $(this).closest('div.btn-group');
			$('#delete-btn').off();
			$('#delete-btn').on('click', function(){
				ObjCommon.getCall('settings/deletePayment/' + elem.attr('data-id'), function(data){
					$('#deleteModal').modal('hide');
					elem.closest('tr').remove();
					ObjCommon.setSuccessMsg(data);
				});
			});
		});
	});
</script>