<?php

	//connecting to the database
	include('cred/cred.php');
	//set credentials if they are not set already
	if (!isset($dsn)) {
		$dsn = 'mysql:host=localhost;dbname=brainstorm;port=8889';
	}
	if (!isset($dbname)) {
		$dbname = 'root';
	}
	if (!isset($dbpword)) {
		$dbpword = 'root';
	}
	 
try {
    $dbh = new PDO($dsn, $dbname, $dbpword);
    foreach($dbh->query('SELECT * from posts') as $row) {
        //print_r($row);
    }
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

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
$nameErr = $genderErr = $passErr = $dnameErr = $emailErr = "";
$username = $dname = $gender = $email = $pass = "";
$val = "1";
$p = "0";
$u = "0";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
   //Username Validation
   if (empty($_POST["username"])) {
     $nameErr = "Username is required";
     $u = "1";
   } else {
     $username = test_input($_POST["username"]);
     //check for the username in the db
	 $username = test_input($_POST["username"]);
	 $stmt = $dbh->prepare('SELECT * from users WHERE username=:name');
	 $stmt->bindParam(':name', $username);
	 $stmt->execute();
	 if ($stmt->rowCount() > 0){
	 	$nameErr = "Username is not unique";
	 	$u = "1";
	 }
        
     
   }
    //Display Name Validation
   if (empty($_POST["dname"])) {
     $dnameErr = "Display Name is required";
   } else {
	 $dname = test_input($_POST["dname"]);
   } 
   
    //Email Validation
   if (empty($_POST["email"])) {
     $emailErr = "Email is required";
   } else if(preg_match("/^.*[@]{1}.*\.*$/", $_POST["email"]) == 0){
	 $email = test_input($_POST["email"]);
	 $emailErr = "Email does not match required format: email[@]lawl[.]ca";
   } 
   else{
	   $email = test_input($_POST["email"]);
   }
   
   
	//Gender validation
   if (empty($_POST["gender"])) {
     $genderErr = "Gender is required";
   } else {
     $gender = test_input($_POST["gender"]);
   }

   //password validation
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
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($u == "1") {echo $nameErr."<br><br>"; $val = "0"; }}?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (! $emailErr == "") {echo $emailErr."<br><br>"; $val = "0";}} ?></span>
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
			
            <div class="form-group">        
              <div >
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus autocomplete="off" value="<?php if(isset($username)) echo "$username";?>">
              </div>
            </div>
			<!--Display Name-->
			
			<div class="form-group">        
              <div >
                <input type="text" name="dname" id="dname" class="form-control" placeholder="Display Name" autofocus autocomplete="off" value="<?php if(isset($dname)) echo "$dname";?>">
              </div>
            </div>
			
			<!--Email-->
			
			<div class="form-group">        
              <div >
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" autofocus autocomplete="off" value="<?php if(isset($email)) echo "$email";?>">
              </div>
            </div>
			
			<!--Gender-->
			
			<div class="form-group" id="ggender" style="">
			   Gender:
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

			<!--Password-->
			Password:
			
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
			
			
			
			
			
			
			
			
			<!--Register Button-->
			
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
	//if everything is good, add to db
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && $val=="1"){
	//hash the password
		$hash = crypt($pass, '$6$rounds=5000$4Ds0.2.A.F*pPi(8lxZ+H!3#l+s@wlek.!ls-$');
		$blank='';
		$admin = 0;
		$zero = 0;
		//insert
		$stmt = $dbh->prepare("INSERT INTO users (username, password, email, displayName, gender, picture, description, status, admin)
							VALUES (:username, :password, :email, :displayName, :gender, :picture, :description, :status, :admin)");
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hash);
		$stmt->bindParam(':email', $blank);
		$stmt->bindParam(':displayName', $dname);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':picture', $blank);
		$stmt->bindParam(':description', $blank);
		$stmt->bindParam(':status', $zero);
		$stmt->bindParam(':admin', $admin);
		$stmt->execute();
	}
	
	//close the connection
	$dbh = null;
	
	require_once('footer.php');
?>