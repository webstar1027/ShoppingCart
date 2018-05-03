<?php   

   /**
    *    Database class
    */
    class ConnectionDatabase
    {
     /**
      *  MySQL server hostname
      *
      *  @var string
      */ 
    	private $hostName;
     /**
      *  MySQL server username
      *
      *  @var string
      */ 
    	private $userName;
     /**
      *  MySQL server password
      *
      *  @var string
      */ 
    	private $password;
     /**
      *  MySQL server database name
      *
      *  @var string
      */ 
    	private $dbName;
      

     /**
      * Create a new database connection instance.
      *
      * @return void
      */
    	public function __construct() 
      {    	
    		$this->hostName = 'localhost';
    		$this->userName = 'root';
    		$this->password = 'root';
    		$this->dbName = 'shoppingcart';
    	}

     /**
      *   Get database connection by given connection info.
      *
      *   @param hostname, username, password, dbname
      *
      *   @return connection to the MySQL server
      */

      public function connectDB () 
      {
      	$connection = mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);

      	if (!$connection ) {
      		return json_encode(['connection' => false, 'message' => mysqli_error($connection)]);
      	}

      	return $connection;
      }

     /**
      *   Database connection.
      *   
      *   @param connection
      *
      *   @return void
      */

      public function dieDB($connection) 
      {
         mysqli_close($connection);
      }

    }

    
  
?>