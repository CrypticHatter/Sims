<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Completed Payments</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="completed-table" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Payment ID</th>
					<th>Student ID</th>
					<th>Student</th>
					<th>Classroom</th>
					<th>Amount Paid</th>
					<th class='text-center'>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($completes as $pay) {
					echo "<tr>
							<td>$pay->payment_id</td>
							<td>$pay->std_id</td>
							<td>$pay->name</td>
							<td>$pay->title - $pay->division</td>
							<td>$pay->amount</td>
							<td class='text-center' data-pay='$pay->payment_id' data-std='$pay->std_id'>
								<div class='btn-group'>
									<button type='button' class='btn btn-sm btn-danger cancel-pay'>Cancel Payment</button>
								</div>
							</td>
	                    </tr>";
				}
			?> 
			</tbody>
			<tfoot>
				<tr>
					<th>Payment ID</th>
					<th>Student ID</th>
					<th>Student</th>
					<th>Classroom</th>
					<th>Amount Paid</th>
					<th class='text-center'>Actions</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#completed-table').DataTable();
		$('button.cancel-pay').on('click', function(){
			var elem = $(this).closest('td');
			ObjCommon.postCall('admin/cancelPayment', {std_id: elem.attr('data-std'),payment_id:elem.attr('data-pay')}, false);
			$(this).closest('tr').remove();
		});
	});
</script>