<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Your Payments</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="payment-table" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Transaction ID</th>
					<th>Bursar</th>
					<th>Amount paid</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($payments as $pay) {
					echo "<tr>
							<td>$pay->payment_id</td>
							<td>$pay->name</td>
							<td>$pay->amount</td>
                            <td>$pay->paid</td>
			            </tr>";
				}
			?> 
			</tbody>
		</table>
	</div>
</div>
