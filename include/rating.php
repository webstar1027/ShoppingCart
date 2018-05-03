<?php
	include_once('connection.php');  
 /**
  *  Rate class.
  */
  class Rate {
   /**
		*  This is used for logined user id.
		*
		*  @var int
		*/ 
 		private $user_id;
 	 /**
		*  This is used for product id.
		*
		*  @var int
		*/ 
 		private $product_id;
 	 /**
		*  This is used for rating value of product.
		*
		*  @var int
		*/ 
 		private $ratingValue;
 	 /**
		*  This is used to get connection of MySQL server.
		*
		*  @var instance of connection
		*/
 		public $db;

   /*
    *  constructor
    */
 		public function __construct($product_id, $ratingValue, $user_id)
		{
			$connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB();

      $this->product_id = $product_id;
      $this->ratingValue = $ratingValue;
      $this->user_id = $user_id;
		}

	 /**
    * Create rating of given product.
    *
    * @return array(status, message)    
    */
		public function crateRateValue()
		{
			if ($this->isRating()) {
				$response = array('status' => 0, 'message' => 'Sorry, You have rated before!');				
			} else {				
				$query = "INSERT INTO ratings (user_id, product_id, rating_value) VALUES('$this->user_id', '$this->product_id', '$this->ratingValue')";
	      $result = mysqli_query($this->db, $query);

	      if ($result ) {
	        $response = array('status' => 1, 'message'=> 'Thanks for rating!');	       
	      } else {
	        $response = array('status' => 0, 'message'=> 'Server Error');
	      }      
	      
 		  }

 		  return json_encode($response);
			
		}

	 /**
    * Calculate average rating of each product.
    *
    * @return array(average rate)    
    */
		public function calcAverageRate()
		{
	    $data = array();
	    $averageRate = array();

	    for ($i = 0; $i < 4; $i++) {
	    	$id = $i +1; // product id
	     	$query = "SELECT * FROM ratings WHERE product_id = '$id'";
		  	$result = mysqli_query($this->db, $query);		  
		  	$count = mysqli_num_rows($result);

		    if($count != 0) {
	    		$sum = 0.0;
			  	$count = 0;

			  	while ($row = mysqli_fetch_assoc($result)) {
		          $sum += $row['rating_value'];
		          $count++;
		      }   

		      array_push($averageRate, round($sum/$count));

		    } else {
		    	array_push($averageRate, 0);
		    }

	    }		

	    return $averageRate;

		}

	 /**
    * Check whether logined user rated this product or not.
    *
    * @return boolean
    */
		public function isRating()
		{
			$data = array();
	  	$query = "SELECT * FROM ratings WHERE product_id='$this->product_id' AND user_id ='$this->user_id'";	  	
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

 	}
?>