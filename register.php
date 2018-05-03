<?php  
  session_start();
  include_once('template/header.php');
  include_once('template/navbar.php');  
  include_once('include/connection.php');

  class Register 
  {
    private $username;
    private $password;
    private $email;
    public $db;

   /**
    * Create register instance.
    * 
    * @return void
    */
    public function __construct($username, $password, $email)
    {      
      $this->username = $username;
      $this->password = sha1($password);
      $this->email = $email;

      $connectDB = new ConnectionDatabase();
      $this->db = $connectDB->connectDB();      
    }

   /**
    * Register user on database.
    * 
    * @return message
    */
    public function registerUser() 
    {
      $query = "INSERT INTO users (username, email, password) VALUES('$this->username', '$this->email', '$this->password')";
      $result = mysqli_query($this->db, $query);

      if ($result ) {
        $smg = "User Created Successfully";
      } else {
        $smg = "User registeration Failed";
      }

      return $smg;

    }   

  }

  if (isset($_POST['username']) && isset($_POST['password'])) {
    $register = new Register($_POST['username'], $_POST['password'], $_POST['email'] );
    $smg = $register->registerUser();

    session_write_close();
    header('Location:login.php');
  }  
?>

<!-- register page style -->
<style>
.wrapper {
  margin-top: 80px;
  margin-bottom: 80px;
}

.form-signup {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

.form-signup .form-signup-heading,
.form-signup .checkbox {
  margin-bottom: 30px;
}

.form-signup .checkbox {
  font-weight: normal;
}

.form-signup .form-control {
  position: relative;
  font-size: 14px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.form-signup .form-control:focus {
  z-index: 2;
}

.form-signup input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

.form-signup input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>

<div class="container"> 
  <div class="wrapper">
    <form class="form-signup" action="register.php" method="post">  
      <?php 
        if (isset($smg)) {
      ?> 
        <div class="alert alert-success" role="alert">
          <?php echo $smg;?>            
        </div>
      <?php
        }
      ?>   
      <h4 class="form-signup-heading">Register</h4>
      <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
      <input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>       
      <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>   
      <a href="login.php">Click here Sing in </a>
    </form>
  </div>
</div>

<?php include('template/footer.php'); ?>