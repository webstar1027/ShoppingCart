<?php
	include_once('connection.php');

 /**
	*  product class
	*/

	class Product 
	{

	 /**
		*  This is used to get connection of MySQL server.
		*
		*  @var instance of connection
		*/
		private $db;  
	 /**
		*  This is used for product name.
		*
		*  @var string
		*/
		private $name;
	 /**
		*  This is used for product price.
		*
		*  @var float
		*/
		private $price;
    
   /**
    * Create a new product instance.
    *
    * @return void
    */
		public function __construct()
		{
			$connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB(); 
		}
    
   /**
    * Get all products.
    *
    * @return array(product_id, name, price)    
    */
		public function getProducts()
		{
			$data = array();

			$query = "SELECT * FROM products";
			$result = mysqli_query($this->db, $query);

			while ($row = mysqli_fetch_assoc($result)) {
       array_push($data, $row);
      }			

			return $data;
		}

	 /**
    * Update average rating of each product.
    *
    * Note! This function receive average array data of each product calculated
    *       from rating table.
    *
    * @param raitng array
    *
    * @return boolean
    */
		public function insertAverageRatingToProduct ($data) 
		{					
			$count = 1;
			$flag = false;

			foreach($data as $item) {				
		    $query = "UPDATE products SET rating = '$item' WHERE product_id = '$count'";
		    $result = mysqli_query($this->db, $query);
		    $count ++;

		    if (!$result) {
		    	$flag = true;
		    }
			}

			if ($flag == true) {
				return false;
			} else {
				return true;
			}
		}
	}
?>