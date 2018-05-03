<?php
	session_start();
	include('include/rating.php');
  include('include/product.php');

  $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : "";
  $ratingValue = isset($_POST['rating']) ? $_POST['rating'] : "";
  $user_id = $_SESSION['id']; 

	$rate = new Rate($product_id, $ratingValue, $user_id);
	echo  $rate->crateRateValue(); 
 
  $product = new Product();
  
  // After calculating each product average rating, add to product
  if ($product->insertAverageRatingToProduct($rate->calcAverageRate())) {
  	header("Location : products.php?action=rating_success");
  } else {
  	header('Location : products.php?action=rating_failed');
  }


?>
