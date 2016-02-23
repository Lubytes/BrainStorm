<?php

//require_once('Register.php');

require_once('header.php');
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$username = "";
	$password = "";
	
	//connecting to the database
	$dsn = 'mysql:host=localhost;dbname=brainstorm;port=8889';
	$name = 'root';
	$pword = 'root';

	try {
		$dbh = new PDO($dsn, $name, $pword);
		
		//check username
		if (empty($_POST["username"])) {
		
			//empty, print error
		
	    } else {
	    	$username = test_input($_POST["username"]);
			$stmt = $dbh->prepare('SELECT * from users WHERE username=:name');
			$stmt->bindParam(':name', $username);
			$stmt->execute();
			//$row = $stmt->fetch();
			if ($stmt->rowCount() > 0){
				$check = $stmt->fetch(PDO::FETCH_ASSOC);
				
				// Username exists, fill the session variables
		
			} else {
	
				//the username doesn't exist, so print an error
			}
		}
		
		//check password
		if (empty($_POST["password"])) {
		
		 	//empty, print error
		 
	    } else {
	    	$password = test_input($_POST["password"]);
			$stmt = $dbh->prepare('SELECT * from users WHERE username=:name');
			$stmt->bindParam(':name', $username);
			$stmt->execute();
			if ($stmt->rowCount() > 0){
				$check = $stmt->fetch(PDO::FETCH_ASSOC);
				$hash = $check['password'];
				// unhash the password for varification
				if (password_verify($password, $hash)) {
					
					//The password is good, login
					
				} else {
					
					//the password is wrong, error
					
				}
		
			} else {
	
				//the username doesn't exist, so print an error
			}
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
 

?>

	<h1 class="text-center">Have a new idea? Want to improve other ideas?</h1>
      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Just Login!</h2>
          </div>
          <div class="panel-body">  

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <div class="form-group">        
              <div >
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus autocomplete="off">
              </div>
            </div>

            <div class="form-group">  
              <div>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
              </div>
            </div>

            <div class="form-group">  
              <div >
                <input type="submit" name="submit_login" value="Sign in" class="btn btn-default">
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
