<?php
  include_once('connection.php');
 /**
	*  Payment class
	*/
	class Payment
	{

	 /**
		*  This is used for logined user id.
		*
		*  @var int
		*/ 
		private $user_id;
	 /**
		*  This is used for payment amount of cart.
		*
		*  @var float
		*/ 
		private $pay_price;

   /**
    * Create a new payment instance.
    *
    * @return void
    */
		public function __construct($user_id, $pay_price)
		{
			$connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB();

      $this->user_id = $user_id;
      $this->pay_price = $pay_price;
		}

	 /**
    *   Create new payment.
    *
    *   Note! this function check whether first transaction or not and then create new payment
    *   Also this function calls member function that check whether cash rest status can be al
    *   lowed or not.
    *
    *   @return boolean
    */

		public function createPayment() 
		{      
			if ($this->isFirstTransaction()) {
				$rest_price = 100 - $this->pay_price;
			} else {
				if (!$this->isCheckCash()) {
					return false;
				} else {
					$rest_price = $this->isCheckCash() - $this->pay_price;
				}
			}
		
			$query = "INSERT INTO payments (user_id, pay_price, rest_price) VALUES('$this->user_id', '$this->pay_price', '$rest_price')";
      $result = mysqli_query($this->db, $query);

      if ($result ) {
        return true;
      } else {
        return false;
      }    
   
		}
    
   /**
    *  Get cash status.
    *  
    *  @return if rest is less than pay amount, return false, if not, return rest amount
    */
		public function isCheckCash()
		{
			$query = "SELECT * FROM payments WHERE user_id='$this->user_id' ORDER BY payment_id DESC";
			$result = mysqli_query($this->db, $query);
			$data = mysqli_fetch_assoc($result);
			$cash = $data['rest_price'];

			if ($cash < $this->pay_price ) {
				return false;
			} else {
				return $cash;
			}		

		}

	 /**
    *  Get first transaction status.
    *  
    *  @return boolean 
    */
		public function isFirstTransaction () 
		{
			$query = "SELECT * FROM payments WHERE user_id='$this->user_id' ORDER BY payment_id DESC";
			$result = mysqli_query($this->db, $query);
      $count = mysqli_num_rows($result);

			if ($count == 0) {
				return true;
			} else {
				return false;
			}
		}

	 /**
    *  Get all billing status of logined user.
    *  
    *  @return array(pay_price, rest_price, created_at)
    */
		public function getPaymentStatus() 
		{
			$data = array();
			$query = "SELECT * FROM payments WHERE user_id = '$this->user_id'";
			$result = mysqli_query($this->db, $query);
      
      // Get all payments data of logined user 
			while ($row = mysqli_fetch_assoc($result)) {
        array_push($data, $row);
      }			

			return $data;
		}

	}
?>