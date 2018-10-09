<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Pending Payments</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="payment-table" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Student ID</th>
					<th>Student</th>
					<th>Classroom</th>
					<th>Total Due</th>
					<th class='text-center'>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($pendings as $pay) {
					echo "<tr>
							<td>$pay->std_id</td>
							<td>$pay->name</td>
							<td>$pay->title - $pay->division</td>
							<td>$pay->total</td>
							<td class='text-center' data-id='$pay->id' data-std='$pay->std_id' data-price='$pay->total'>
								<div class='btn-group'>
									<button type='button' class='btn btn-sm btn-success accept-pay'>Pay</button>
								</div>
							</td>
			            </tr>";
				}
			?> 
			</tbody>
			<tfoot>
				<tr>
					<th>Student ID</th>
					<th>Student</th>
					<th>Classroom</th>
					<th>Total Due</th>
					<th class='text-center'>Actions</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div id="conf-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirm</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
				<label>Do you want to confirm the payment?</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="yes-btn">Yes</button>
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
			</div>
		</div>

	</div>
</div>
<script>
	$(document).ready(function(){
		$('#payment-table').DataTable();
		
		$('button.accept-pay').on('click', function(){
			$('#conf-modal').modal('show');
			var elem = $(this).closest('td');
			$('#yes-btn').click(function(){
				ObjCommon.postCall('admin/completePayment', {std_id: elem.attr('data-std'),payment_id:elem.attr('data-id'), amount:elem.attr('data-price')}, true);
			});
		});
	});
</script>