<?php
  session_start();
  include('include/connection.php');
	include_once('include/shoppingcart.php');

  $product_id = isset($_GET['id']) ? $_GET['id'] : "";
  $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1; 
  $user_id = $_SESSION['id'];  
	
  $cart = new ShoppingCart(); 
  
  // Check if product is in cart, if it is, don't add
	if ($cart->isProduct($product_id, $user_id)) {	  
	  header("Location: products.php?action=exists");
	}	else {	   
    if ($cart->createProduct($product_id, $user_id, $quantity)) {	      
      header("Location: products.php?action=added");
    } else {
      header("Location: products.php?action=failed_add");
    }
	}
?>