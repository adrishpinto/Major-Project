<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>

<head><link rel="stylesheet" href="custom/css/style.css"></head>
<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">
	


<div class="row">
	
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
	<div class="col-md-4">
		
		<div class="panel panel-success sz">
			<div class="panel-heading ">
				<a href="product.php" style="text-decoration:none;color:black;">
					Total Product
					<span class="badge pull pull-right"><?php echo $countProduct; ?></span>	
				</a>	
			</div> <!--/panel-hdeaing-->
			<a href="product.php">
			<div class="panel-body bg"></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
	<div class="col-md-4">
		<div class="panel panel-danger sz">
			<div class="panel-heading b">
				<a href="product.php" style="text-decoration:none;color:black;">
					Low Stock
					<span class="badge pull pull-right"><?php echo $countLowStock; ?></span>	
				</a>	
			</div> <!--/panel-hdeaing-->
			<a href="product.php">
			<div class="panel-body bg1"></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
	
	
	<?php } ?>  
		<div class="col-md-4">
			<div class="panel panel-info sz">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
	        </div>
			<div class="panel-body bg2"></div>
					
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
	</div>
    <div class="col-md-1"></div>
	<div class="col-md-5">
		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo date('d') .'-'.date('m').'-'.date('Y'); ; ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo date('l')?></p>
		  </div>
		</div> 
		<br/>
	</div>
		<div class="col-md-5">
		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php if($totalRevenue) {
		    	echo $totalRevenue;
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> INR Total Revenue</p>
		  </div>
		</div> 

	</div>
	<div class="col-md-1"></div>
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
	</div>	
    
	<div class="s col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> User Wise Order</div>
			<div class="panel-body">
				<table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Name</th>
			  			<th style="width:20%;">Orders in Rupees</th>
			  		</tr>
			  	</thead>
			  	<tbody>
					<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $orderResult['username']?></td>
							<td><?php echo $orderResult['totalorder']?></td>
							
						</tr>
						
					<?php } ?>
				</tbody>
				</table>
				<!--<div id="calendar"></div>-->
			</div>	
		</div>
		
	</div> 
	<?php  } ?>
	
</div> <!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
</script>

<?php require_once 'includes/footer.php'; ?>