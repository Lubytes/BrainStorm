<?php

session_name('project');  
session_start();

require_once('header.php');
 

?>
	 
      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Sign up</h2>
          </div>
          <div class="panel-body">  

		  
			<!--Registration Form-->
            <form action="Login.php" method="post" >

			<!--Username-->
			Identifiers:
			<br>
            <div class="form-group">        
              <div >
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus autocomplete="off">
              </div>
            </div>
			<!--Display Name-->
			<div class="form-group">        
              <div >
                <input type="text" name="dname" id="dname" class="form-control" placeholder="Display Name" autofocus autocomplete="off">
              </div>
            </div>
			<hr>
			<!--Email-->
			<div class="form-group">        
              <div >
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus autocomplete="off">
              </div>
            </div>
			<hr>
			<!--Password-->
			Password:
			<br>
            <div class="form-group">  
              <div>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
              </div>
            </div>
			<!--Conrfirm Password-->
			<div class="form-group">  
              <div>
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" placeholder="Confirm Password" autocomplete="off">
              </div>
            </div>
			<hr>
			<!--Gender-->
			<div class="form-group" id="ggender" style="">
			   Identified Gender:
			   <br>
			   <input type="radio" name="gender" 
			   <?php if(isset($gender) && $gender=="female") echo "checked";?>
			   value="female">Female
			   <input type="radio" name="gender" 
			   <?php if(isset($gender) && $gender=="male") echo "checked";?>
			   value="male">Male
			   <input type="radio" name="gender" 
			   <?php if(isset($gender) && $gender=="other") echo "checked";?>
			   value="other">Other 
			 </div>
			
			
			
			
			
			
			<!--Register Button-->
			<hr>
            <div class="form-group">  
              <div >
                <input type="submit" name="submit_login" value="Register" class="btn btn-default">
              </div>
            </div>
            
            </form>


          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> 


<?php

	require_once('footer.php');
?>