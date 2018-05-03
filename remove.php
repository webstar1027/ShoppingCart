<?php
  session_start();
  include_once('include/shoppingcart.php');
  $cart_id = isset($_GET['id']) ? $_GET['id'] : "";

  $cart = new ShoppingCart();
  
  // Remove product from cart
  if($cart->deleteProduct($cart_id) ) {
  	header('Location:products.php?action=delete_success');
  } else {
  	header('Location:products.php?action=delete_failed');
  }
?>
