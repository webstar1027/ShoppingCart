<?php
  session_start();
  include_once('include/connection.php');
	include_once('template/header.php');
	include_once('template/navbar.php');
	include_once('include/shoppingcart.php');
	include_once('include/product.php');
	include_once('include/payment.php');

	// Create product instance
	$product = new Product();
	$product_data = $product->getProducts();
  
  // Create shopping cart instance
	$user_cart = new ShoppingCart();
	$cart_data = $user_cart->countProduct($_SESSION['id']);

  // Create payment instance
	$payment = new Payment($_SESSION['id'], 0);
  $billing_status = $payment->getPaymentStatus(); 
?>

<!--  Products page style -->
<style>
  table {
  	margin-top: 50px;
  }

	thead th {
		text-align: center;
		background-color: black;
		color: white;
	}

	.products {		 	
		float: left;
		padding: 2%;
		position: relative;
		top:1%;
		left: 10%;
	}

	.product-item {
		border: 1px solid #eee;
		border-radius: 5px;
		width: 202px;
		height: auto;		
    display:inline-block;  
    box-sizing: border-box;
    padding: 1%;
    margin-right: 15px;
	}

  label {
 	  padding-left:3%;
 	  display: block !important;
  }

  button {
 	  background-color: #87cefa !important;
 	  border-color: #87cefa !important;
   	color: #191970 !important;
 	  width:100%;
 	  margin-top: 20px; 	
  }

  .rating-star:before {
	  color: #f80;		
	  font-size: 2em;
	  font-family: FontAwesome;
	  display: inline-block;
	  content:"\f005";
	  padding-right: 5px;
	 
 	}
 	.rating-star-empty:before {
	  color: #ddd;		
	  font-size: 2em;
	  font-family: FontAwesome;
	  display: inline-block;
	  content:"\f005";
	  padding-right: 5px;
	
 	}
  .success-box {
	  margin:0px 0;
	  padding:10px 10px;
	  border:1px solid #eee;
	  background:#f9f9f9;
	}

	.success-box img {
	  margin-right:10px;
	  display:inline-block;
	  vertical-align:top;
	}

	.success-box > div {
	  vertical-align:top;
	  display:inline-block;
	  color:#888;
	}

	.star-box > div {
	  margin:50px 0;
	  padding:10px 10px;
	  border:1px solid #eee;
	  background:#f9f9f9;
	}

	.star-box img {
	  margin-right:10px;
	  display:inline-block;
	  vertical-align:top;
	}

	.star-box > div {
	  vertical-align:top;
	  display:inline-block;
	  color:#888;
	}

	.rating-stars ul {
	  list-style-type:none;
	  padding:0;
	  
	  -moz-user-select:none;
	  -webkit-user-select:none;
	}

	.rating-stars ul > li.star {
	  display:inline-block;	  
	}

	.modal-body{
	    max-height: calc(80vh - 250px);
	    overflow-y: auto;
	}

	.rating-stars ul > li.star > i.fa {
	  font-size:2.5em; 
	  color:#ccc; 
	}

	.rating-stars ul > li.star.hover > i.fa {
	  color:#FFCC36;
	}

	.rating-stars ul > li.star.selected > i.fa {
	  color:#FF912C;
	}

	.rating-fixed {
		padding:8px 0px 4px 0px;
		text-align:left;
	}

	.rating-fixed i.fa {
	  font-size:2.5em; 
	  color:#FF912C; 
	}

	.rating-fixed i.cd {
	  font-size:2.5em; 
	  color:#ccc;
	}

	.rating-fixed span {
		font-size:25px;
		color:#11458E;
		padding-right:15px;
		text-align:left;
		font-weight:bold;
	}

	.rating-fixed-mobile i.fa {
	  font-size:2.5em; 
	  color:#FF912C; 
	}

	.rating-fixed-mobile i.cd {
	  font-size:2.5em; 
	  color:#ccc; 
	}

	.rating-fixed-mobile span {
		font-size:25px;
		color:#11458E;
		padding-right:15px ;
		text-align:left;
		font-weight:bold;
	}

	.selected{
	  color:#FF912C;
	}

	.comment-icon {
    color: #11458E;
    text-shadow: 1px 1px 1px #ccc;
    font-size: 2.5em; 
	  padding:22px 0px 5px 0px;
	}

	.comment-icon:hover {
	  color: #FF912C;
	}

	.img_frame {
    float:left;
    position: relative;
    top: 0px
	}

	.name_class {
		font-size:25px;
		color:#11458E;
		padding-right:15px ;
		text-align:left;
		font-weight:bold;
	}

	.star-in {
	  position: relative;
	  display: inline-block;
	  font-size: 28px;
	  padding-right:9px;
	  padding-top:10px;
	}

	.star-under {
	  color: #ddd;
	}

	.star-over {
	  color: #f80;
	  overflow: hidden;
	  position: absolute;
	  top: 0;
	  left: 0;
	}

	.star-empty {
	  overflow: hidden;
	  position: absolute;
	  top: 0;
	  left: 0;
	}
</style>

<div class="container">
	<!--  alert message part -->
	<?php
	if (isset($_GET['action'])) { 
		echo "<div class='col-md-12' style='font-size:14px;text-align:center;'>";
	    if ($_GET['action']=='added') {
        echo "<div class='alert alert-success alert-dismissible'>";
          echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "<strong>Success!</strong> &nbsp Product was added to your cart!";
        echo "</div>";
	    }
	 		else if ($_GET['action']=='exists') {
        echo "<div class='alert alert-warning alert-dismissible'>";
      		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "<strong>Warning!</strong> &nbsp You added product already!. Please confirm cart status.";
        echo "</div>";
	    }
	    else if ($_GET['action']=='failed_add') {
        echo "<div class='alert alert-danger alert-dismissible'>";
          echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "Unable to add product to cart. Please contact Admin.";
        echo "</div>";
	    }
	    else if ($_GET['action']=='delete_success') {
        echo "<div class='alert alert-success alert-dismissible'>";
      		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "<strong>Success!</strong> &nbsp Product was deleted in your cart!";
        echo "</div>";
	    }
	     else if ($_GET['action']=='delete_danger') {
        echo "<div class='alert alert-info alert-dismissible'>";
      		echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "Product can not be deleted, Please contact Admin";
        echo "</div>";
	    }
	    else if ($_GET['action']=='payment_success') {
        echo "<div class='alert alert-success alert-dismissible'>";
          echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "<strong>Success!</strong> &nbsp Payment is performed successfully!";
        echo "</div>";
	    }
	    else if ($_GET['action']=='payment_failed') {
        echo "<div class='alert alert-warning alert-dismissible'>";
          echo "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
          echo "<strong>Warning!</strong> &nbsp There is no enough money on your cash!";
        echo "</div>";
	    }
	  echo "</div>";
	}?>
  <!-- alert message end -->

  <!-- Display product item -->
  <div class="row">
		<div class="col-md-12 products">
		  <?php 
		  foreach ($product_data as $item) {
		  ?>
		    <div class="col-md-3 product-item">		   	 
		   	  <div class="wrapper">
			   	 	<img src="images/<?php echo $item['image'];?>" class="img-responsive"/>	 		
			   	 	 <?php
			   	 	  if ($item['rating'] == 5) { 
			   	 	 ?> 
							<span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span>
						 <?php 
						   } elseif ($item['rating'] == 4) {
						 ?>
						    <span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span>
						 <?php 
						  } elseif ($item['rating'] == 3) { 
						 ?>
						    <span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span>
						 <?php 
						  } elseif ($item['rating'] == 2) { 
						 ?>
						    <span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span>
						 <?php 
						  } else  {
						 ?>
						    <span id="<?php echo $item['product_id'];?>" class="rating-star"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span><span id="<?php echo $item['product_id'];?>" class="rating-star-empty"></span>
						 <?php 
					    } 
					    ?>	   	 
			   	 	<label class="control-label"> <?php echo $item['name'];?></label>
			   	 	<label class="control-label" id="<?php echo $item['product_id'];?>"> $<?php echo $item['price'];?></label>			   	 			   	 	
	   	 	 	  <label class="control-label" for="quantity<?php echo $item['product_id'];?>"> Queantity</label>
	   	 	 	  <input type="txt" class="form-control" name="quantity<?php echo $item['product_id'];?>" value="">	
	   	 	 	  <button class="btn btn-primary add-cart" id="<?php echo $item['product_id'];?>">Add to Cart</button>		   	 
			   	</div>		   	
		   </div>
		   <?php
		  }?>
		</div>
	</div>
  <!--Pproduct item display  end -->

	<!-- Display products registed on cart -->
	<?php
	if (!empty($cart_data)) {
	?>	
	<div class="row" style="margin-bottom: 60px;">
		<div class="responsive">
			<table class="table table-bordered table-hover table-inverse" style="text-align: center;">
				<thead>
					<tr>
					 	<th>#</th>
					 	<th>Name</th>
					 	<th>Quantity</th>
					 	<th>Price</th>
					 	<th>Remove</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					$sum = 0;
					foreach ($cart_data as $item) {
					?>
					<tr>
						<td><?php echo $count++;?></td>
						<td><?php echo $item['name'];?></td>
						<td><?php echo $item['quantity'];?></td>
						<td><?php echo '$'.floatval($item['price'])*floatval($item['quantity']);?></td>
						<td><a href="remove.php?id=<?php echo $item['cart_id'];?>">remove</a></td>
					</tr>
					<?php
					 $sum += floatval($item['price'])*floatval($item['quantity']);
					}					
					?>
					<tr>
						<td colspan="3"> Total price </td>
						<td ><?php echo '$'.$sum;?> <input type="hidden" name="total_price" value="<?php echo $sum;?>"></td>			
					</tr>
				</tbody>
			</table>			
		</div>
	</div>
	<?php
  }  
  ?>
  <!-- Product registered on cart  display end -->
  
  <!-- Display payment status for shopping product -->
  <?php
	if (!empty($billing_status)) {
	?>	
	<div class="row" style="margin-bottom: 60px;">
		<div class="responsive">
			<table class="table table-bordered table-hover table-inverse" style="text-align: center;">
				<thead>
					<tr>
					 	<th>#</th>
					 	<th>Tranaction Date</th>
					 	<th>Charge value</th>
					 	<th>Rest Value</th>					
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					foreach ($billing_status as $billing) {
					?>
					<tr>
						<td><?php echo $count++;?></td>
						<td><?php echo date('Y-m-d', strtotime($billing['created_at']));?></td>
						<td><?php echo '$'.$billing['pay_price'];?></td>					
						<td><?php echo '$'.$billing['rest_price'];?></td>
					</tr>
					<?php				
					}					
					?>				
				</tbody>
			</table>			
		</div>
	</div>
	<?php
  }  
  ?>
  <!-- Payment status for shopping product display end -->

	<div class="row">
		<label class="control-label"> Shipping Type </label>
		<select class="form-control" id="ship_type">
			<option selected></option>
			<option value="0">Pick Up</option>
			<option value="5">UPS </option>			
		</select>
		<div class="text-center">
			<button class="btn btn-primary" id="payment" style="width: 20%;margin-bottom: 100px;"> Pay </button>
		</div>
	</div>

	<!-- Display rating modal dialog for giving rate -->
	<div class="modal fade" id="myModal" role="dialog" tabindex="-1">
	  <div class="modal-dialog modal-sm" role="document">						     
      <div class="modal-content">	  

        <div class="modal-header" style="border:none;">         
	       <i class="fa fa-close" data-dismiss="modal" style="float:right;cursor:pointer;"></i>	      
	      </div>       

			  <div class="modal-body">		

				  <div id="alert-error-model" class="alert alert-danger hidden">
				    <button type="button" class="close dismissable">&times;</button>
				   	<span></span>
				  </div>
				  
				  <div class="row">
				    <div class="col-md-12">					     
				      <div class='rating-stars star-box'  style="text-align:center">					     
						    <ul class='stars'>
						      <input type="hidden" id="rating_product_id" name="rating_product_id" value="">
						       	<li class='star' title='Poor' data-value='1'><i class='fa fa-star fa-fw'></i></li>
						       	<li class='star' title='Fair' data-value='2'><i class='fa fa-star fa-fw'></i></li>
						       	<li class='star' title='Good' data-value='3'><i class='fa fa-star fa-fw'></i></li>
						       	<li class='star' title='Excellent' data-value='4'><i class='fa fa-star fa-fw'></i></li>
						       	<li class='star' title='WOW!!!' data-value='5'><i class='fa fa-star fa-fw'></i></li>
						    </ul>
				      </div>
				      <div class='success-box'>
					      <div class='clearfix'></div>
					      <div class='text-message'></div>
					      <div class='clearfix'></div>
				      </div>
				    </div>					  
				  </div>					
		    </div>							 
  	  </div>
	  </div>
	</div>
</div>

<?php require_once('template/footer.php');