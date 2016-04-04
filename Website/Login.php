<?php




if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = "";
	$password = "";
	$nameErr = $passErr = "";
	$val = true; //tests for validation
	$p = $u = "0";
	
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
		
		//check username
		if (empty($_POST["username"])) {
		
			//empty, print error
			$nameErr = "Username is empty";
			$u = "1";
			$val = false;
		
	    } else {
	    	$username = test_input($_POST["username"]);
			$stmt = $dbh->prepare('SELECT * from users WHERE username=:name');
			$stmt->bindParam(':name', $username, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount() > 0){
				$check = $stmt->fetch(PDO::FETCH_ASSOC);
				
				// Username exists, check the password
				if (empty($_POST["password"])) {
		
					//empty, print error
					$passErr = "Password is empty";
					$p = "1";
					$val = false;
		 
				} else {
					
					$password = test_input($_POST["password"]);
					if ($stmt->rowCount() > 0){
						$pword = $check['password'];
						// unhash the password for varification
						$hash = crypt($password, '$6$rounds=5000$4Ds0.2.A.F*pPi(8lxZ+H!3#l+s@wlek.!ls-$');
						if ($pword==$hash) {
					
							//The password is good, fill the session vars and login
							session_name('project');  
							session_start();
							$_SESSION["username"] = "";
							$_SESSION["isAdmin"] = false;
							$_SESSION["loggedIn"] = false;
							$_SESSION["status"] = 0;
							$_SESSION["img"] = "";
							fill_session($check['username'], $check['admin'], $check['status'], $check['picture']);
							header('Location: account.php');
					
						} else {
					
							//the password is wrong, error
							$passErr = "Incorrect password";
							$p = "1";
							$val = false;
					
						}
					}
				}
					
			} else {
	
				//the username doesn't exist, so print an error
				$nameErr = "Username does not exist";
				$u = "1";
				$val = false;
			}
		}
	
	//if it's valid
	if ($val == true) {
		
		//redirect or something
		
	}
	
	
	//close the connection
	$dbh = null;
	
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 
}


//test input for bad chars
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
 
//fill session variables
function fill_session($un, $adm, $st, $pic){
	$_SESSION["username"] = $un;
	if ($adm == 1){
		$_SESSION["isAdmin"] = true;
	} else {
		$_SESSION["isAdmin"] = false;
	}
	$_SESSION["loggedIn"] = true;
	$_SESSION["status"] = $st;
	if (empty($pic)){
		//blank profile image here
		$S_SESSION["img"] = "img/profile/blank.png";
	} else {
		$S_SESSION["img"] = $pic;
	}
}
require_once('header.php');
?>
	<style>
	.error {color: #3366ff;}
	</style>
	<h1 class="text-center">Have a new idea? Want to improve other ideas?</h1>
	
	<!-- Validation Boolean and Display-->
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($u == "1") {echo $nameErr."<br><br>"; $val = "0"; }}?></span>
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($p=="1") {echo $passErr."<br><br>"; $val = "0"; }}?></span>

	
      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Login Please!</h2>
          </div>
          <div class="panel-body">  

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <div class="form-group">        
              <div >
                <input type="text" value="<?php if (!empty($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" name="username" id="username" class="form-control" placeholder="Username" autofocus autocomplete="off">
              </div>
            </div>

            <div class="form-group">  
              <div>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
              </div>
            </div>

            <div class="checkbox">
          		<label>
            	<input type="checkbox" value="remember-me"> Remember me
          		</label>
        	</div>

            <div class="form-group">  
              <div >
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login" value="Sign in" class="btn btn-default">
              </div>
            </div>
            
            </form>


          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#login -->


    <style>
      p {
        text-align: center;
      }
    </style>


      <div id="register" class="alert alert-info" role="alert">
        <p><strong>Don't have a account?</strong>
        <a href="Register.php" class="alert-link">Sign up here!</a></p>
      </div>

    </head>
  </html>

<?php

require_once('footer.php');
?>
