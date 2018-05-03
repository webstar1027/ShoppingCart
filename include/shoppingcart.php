<?php
  include_once('connection.php');
 /**
	*  shopping cart model class
	*/
	class ShoppingCart 
	{
	 /**
	  *  This is used for identifying user cart.
	  *
	  *  @var int
	  */
		private $cart_id;
	 /**
	  *  This is used for identifying user.
	  *
	  *  @var int
	  */
		private $user_id;
	 /**
	  *  This is used for identifying product.
	  *
	  *  @var int
	  */
		private $product_id;
	 /**
	  *  This is used for number of product.
	  *
	  *  @var int
	  */
		private $quantity;
	 /**
		*  This is used to get connection of MySQL server.
		*
		*  @var instance of connection
		*/
		public $db;

	 /**
    * Create a new shopping cart instance.
    *
    * @return void
    */
		public function __construct()
		{
			$connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB();
		}

	 /**
	  *  Check if there exists current logined user's of given product.
	  *  
	  *  @param product_id, $user_id
	  *
	  *  @return boolean
	  */
	  public function isProduct($product_id, $user_id)
	  {
	  	$data = array();
	  	$query = "SELECT * FROM carts WHERE product_id='$product_id' AND user_id ='$user_id'";	  	
	  	$result = mysqli_query($this->db, $query);    	  

      while ($row = mysqli_fetch_assoc($result)) {
       	array_push($data, $row);
      }						

      if (count($data) != 0) {
      	return true;
      } else {
      	return false;
      }
	  }

	 /**
	  *  Get all products of logined user.
	  *  
	  *  @param  user_id
	  *
	  *  @return array
	  */
	  public function countProduct($user_id)
	  {
	  	$data = array();
	  	$query = "SELECT * FROM carts AS a INNER JOIN products AS b ON a.product_id = b.product_id WHERE a.user_id='$user_id'";
	  	$result = mysqli_query($this->db, $query);

	  	while ($row = mysqli_fetch_assoc($result)) {
       array_push($data, $row);
      }			

      return $data;

	  }

	 /**
	  *  Create product of logined user cart.
	  *  
	  *  @param  user_id
	  *
	  *  @return boolean
	  */
	  public function createProduct($product_id, $user_id, $quantity)
	  {	  	
	  	$query = "INSERT INTO carts (user_id, product_id, quantity) VALUES('$user_id', '$product_id', '$quantity')";
	  	$result = mysqli_query($this->db, $query);
	  	
      if ($result ) {
        return true;
      } else {
        return false;
      }     
	  }

	 /**
	  *  Delete product of logined user cart.
	  *  
	  *  @param  user_id
	  *
	  *  @return boolean
	  */
	  public function deleteProduct($cart_id) {

	  	$query = "DELETE FROM carts WHERE cart_id='$cart_id'";
	  	$result = mysqli_query($this->db, $query);

      if ($result ) {
        return true;
      } else {
        return false;
      }     
	  }
	}
?>