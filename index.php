<?php 
	$con=mysqli_connect('localhost','root','','demo') or die("connection failed");
	$start_date_err="";
					$end_date_err="";
					if (isset($_POST['submit'])) {
						if (empty($_POST['start_date'])) {
							$start_date_err= '<label class="text-danger">start date is required<label>';
						}
						elseif (empty($_POST['end_date'])) {
							$end_date_err= '<label class="text-danger">end date is required<label>';
						}
						else{
							$file_name="order_data.csv";
							header("Content-Description:File Transfer");
							header("Content-Disposition:attachment;filename=$file_name");
							header("Content-Type:application/csv;");

							$file=fopen("php://output", "w");

							$header=array("Sr no","Customer name","order item","order value","order date");
							fputcsv($file, $header);

							$query1="SELECT * FROM `tbl_order` where order_date >='".$_POST['start_date']."' and order_date <='".$_POST['end_date']."' order by order_date desc";
							// $query1="SELECT * FROM `tbl_order` ";
							$fireQuery1=mysqli_query($con,$query1);
							// $resQuery1=mysqli_fetch_array($fireQuery1);

							// foreach ($resQuery1 as $row) {
							while($resQuery1=mysqli_fetch_array($fireQuery1))
							{
								$data=array();$i=1;
								$data[]=$i;
								$data[]=$resQuery1['order_customer_name'];
								$data[]=$resQuery1['order_item'];
								$data[]=$resQuery1['order_value'];
								$data[]=$resQuery1['order_date'];
								$i++;
								fputcsv($file, $data);
								}
								
								fclose($file);
								exit;
						}
						
					}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Date Range Search in Datatables using PHP Ajax</title>
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  	<link rel="stylesheet" type="text/css" href="bootstrap-datepicker/bootstrap-datepicker.css">
  	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  	<script src="bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <style>
   body
   {
    margin:0;
    padding:0;
    background-color:#fff;
   }
   .box
   {
    width:1270px;
    padding:20px;
    background-color:#fff;
    border:1px solid #ccc;
    border-radius:5px;
    margin-top:25px;
   }
  </style>
  

</head>
<body>
	<div class="container">
		<h3 align="center" class="my-2"> Date Range Search in Datatables using PHP Ajax</h3>
		<div class="card my-3">
			<div class="card-body">
				<?php 
					
				 ?>
				<form method="post" class="form-inline">
						<div class="form-group col-md-3">
							<input type="text" name="start_date" id="start_date" placeholder="Start date" class="form-control" readonly required="">
							<?php if(isset($start_date_err)) echo $start_date_err; ?>
						</div>
						<div class="form-group col-md-3">
							<input type="text" name="end_date" id="end_date" placeholder="end date" class="form-control" readonly required="" >
							<?php if(isset($end_date_err)) echo $end_date_err; ?>
						</div>
						<div class="form-group col-md-6">
							<input type="submit" name="submit" id="submit" value="export" class="btn btn-primary" >
						</div>
						
				</form>
			</div>
		</div>
	</div>
	<div class="container pt-5" style="border:2px solid ">
		<table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Sr no.</th>
					<th>Customer name</th>
					<th>order item</th>
					<th>order value</th>
					<th>order date</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$i=1;
					$query="SELECT * FROM `tbl_order` order by order_date desc";
					$fire=mysqli_query($con,$query);
					while ($row=mysqli_fetch_array($fire)) {
						
				 ?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['order_customer_name'];?></td>
					<td><?php echo $row['order_item'];?></td>
					<td><?php echo $row['order_value'];?></td>
					<td><?php echo $row['order_date'];?></td>
				</tr>
				<?php $i++; ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
    $('#dataTable').DataTable();
    
    // $('#end_date').datepicker();
} );

	</script>
	<script>
  $( function() {
    $( "#start_date" ).datepicker(
        { format: 'yyyy-mm-dd'
            }
        );
  } );
</script>
<script>
  $( function() {
    $( "#end_date" ).datepicker(
        { format: 'yyyy-mm-dd'
            }
        );
  } );
</script>

</body>
</html>