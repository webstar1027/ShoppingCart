<?php
 	session_start();
 	include_once('include/connection.php');
 	include_once('include/payment.php');

 	$total_price = $_GET['total_price'];
 	$user_id = $_SESSION['id'];

 	$payment = new Payment($user_id, $total_price);

 	if ($payment->createPayment()) {
 		$billing = $payment->getPaymentStatus();
 		$_SESSION['billing'] = $billing;
 		
 		header("Location: products.php?action=payment_success");
 	} else {
 		header("Location: products.php?action=payment_failed");
 	}

?>