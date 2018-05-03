<?php 
	session_start();
	include_once('include/connection.php');
	include_once('template/header.php');
	include_once('template/navbar.php');

 /**
  *  Login class
  */
  class Login 
  {
   
    private $email;   
    private $password;
    public $db;

   /**
    * Create a new payment instance.
    *
    * @return void
    */
    public function __construct($email, $password)
    {     
      $this->email = $email;
      $this->password = sha1($password);

      $connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB();
    }

   /**
    * log in site.
    * 
    * @param useremail, password
    *
    * @return boolean
    */
    public function login() {    
     
      $query = "SELECT * FROM users WHERE email='$this->email' AND password='$this->password'";
      $result = mysqli_query($this->db, $query);    
      $data = mysqli_fetch_array($result,MYSQLI_ASSOC);  
      $count = mysqli_num_rows($result);  
      
      if ($count == 1) {  
        $_SESSION['login'] = true;  
        $_SESSION['id'] = $data['id']; 
        return true;  
      } else {  
        return false;  
      }  
    }
  }
  
  // Check if email and password is in request
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $password = $_POST['password'];
    $email  = $_POST['email'];   

    $login = new Login($email, $password);
    $result = $login->login();

    if ($result) {
      header('Location:products.php');
    } else {
      $error = "Your credential info is incorrect.";
    }
  }
?>
<!--  Style for login page -->
<style>
.wrapper {
  margin-top: 80px;
  margin-bottom: 80px;
}
.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.1);
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 30px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  font-size: 14px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>


<div class="container"> 
	<div class="wrapper">
    <form class="form-signin" method="post" action="login.php">       
      <?php 
        if (isset($error)) {
      ?> 
        <div class="alert alert-success" role="alert">
          <?php echo $error;?>            
        </div>
      <?php
        }
      ?>   
      <h4 class="form-signin-heading">Login</h4>
      <input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>       
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
    </form>
  </div>
</div>
 
<?php include('template/footer.php'); ?>