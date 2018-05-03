<style>
  ul > li > a {
    font-size: 14px;
    font-weight: 400;
    color: white !important;
  }
</style>

<nav class="navbar navbar-default" style="background-color: #1b1b1b;">
	<div class="container">
  	<div class="navbar-header" >
  		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
   			<span class="sr-only">Toggle navigation</span>
  			<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
  		</button>
  	</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
  	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  		<ul class="nav navbar-nav navbar-right">       
        <?php 
          if (isset($_SESSION['id'])) {
          ?>           
            <li><a href="logout.php">Logout</a></li>            
         <?php 
          } else {
          ?>
            <li><a href="login.php">Login </a></li>
            <li><a href="register.php">Register</a></li>
         <?php
          }
          ?>    	
  		</ul>   		
  	</div>
	</div>
</nav>  