<?php

session_name('project');  
session_start();

require_once('header.php');
 

?>
<style>
.error {color: #3366ff;}
</style>
<!--Validation of entries-->	
<?php
// define variables and set to empty values
$nameErr = $genderErr = $passErr = "";
$name = $gender = $pass = "";
$val = "1";
$p = "0";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   //Username Validation
   if (empty($_POST["username"])) {
     $nameErr = "Username is required";
   } else {
     $username = test_input($_POST["username"]);
   }
    //Display Name Validation
   if (empty($_POST["dname"])) {
     $dnameErr = "Display Name is required";
   } else {
     $dname = test_input($_POST["dname"]);
   } 
	//Gender validation
   if (empty($_POST["gender"])) {
     $genderErr = "Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);
   }

   //Gender validation
   if (empty($_POST["password"])) {
     $passErr = "You must enter in a password";
	 $p = "1";
   } else if($_POST["password"] != $_POST["passwordConfirm"]){
     $passErr = "Password must be the same as the confirmation";
	 $p = "1";
   }
   else{
	   $pass = test_input($_POST["password"]);
   }
   
   
   
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
	 
<!-- Validation Boolean and Display-->
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["gender"])) {echo $genderErr."<br><br>"; $val = "0";}} ?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["username"])) {echo $nameErr."<br><br>"; $val = "0"; }}?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["dname"])) {echo $dnameErr."<br><br>"; $val = "0";}} ?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($p=="1") {echo $passErr."<br><br>"; $val = "0"; }}?></span>
	 
      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Sign up</h2>
          </div>
          <div class="panel-body">  

		  
			<!--Registration Form-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

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