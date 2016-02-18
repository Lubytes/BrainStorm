<?php

	#
	# REQUIRING ADDITIONAL FILES
	#
	# For this example, we're using an array to contain all of the user information.
	# This array is contained in the users.php file which is included below.
	#

	require_once('users.php');	

    #
    # ESTABLISHING A SESSION
    # 
    # Sessions are initiated by using the session_start() function, they can also be
    # customized to only pertain to particular paths in the URL, to expire at a 
    # particular time, and to be named by a custom name (other than the default
    # PHPSESSID).
    #
    
	//session_set_cookie_params(0, '/~username/', 'web.cs.dal.ca');
	//session_name('ClassDemoPages');
	session_start();

	if (!isset($_SESSION['user_data'])) {
	
		$_SESSION['user_data']['username'] = '';
		$_SESSION['user_data']['password'] = '';
		$_SESSION['user_data']['access'] = '';
	}

	#
	# SETTING USER DATA IN THE SESSION
	#
	# If the login form has been submitted, and the username and password match
	# one of the records in the users array, then set the relevant user info
	# is stored in the $_SESSION array. Every subsequent page that starts the 
	# session - using session_start() - will have access to this data. 
	#
	
	if (isset($_POST['submit_login'])) {

		foreach ($users as $user) {
		
			if ($user['username'] == $_POST['username'] &&
				$user['password'] == sha1($_POST['password'])) {

				$_SESSION['user_data'] = $user;

			} 
			
		}

	} 
	

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>INFX2670 - Session</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


	<nav class="navbar navbar-default">
	  <div class="container" style="max-width: 800px;">
	    <div class="navbar-header">
	    	<a class="navbar-brand" href="index.php">INFX2670 - Session</a>
	    </div>

    	<ul class="nav navbar-nav navbar-left">
	        <li class="active"><a href="index.php">First page</a></li>
	        <li><a href="second.php">Second page</a></li>
		</ul>

		<?php

			#
			# TRIGGERING CUSTOM OUTPUT BASED ON USER
			#
			# Using info in the $_SESSION superglobal is a key way to determine
			# whether or not content should be printed to the page. In this case
			# a Logout link only makes sense for a logged in user, so the link
			# is only displayed if a logged in user is detected.
			#

			if ($_SESSION['user_data']['access'] != '') {
				echo '<ul class="nav navbar-nav navbar-right">';
				echo '<li class="navbar-text">Welcome, '.$_SESSION['user_data']['username'].'!</li>';
				echo '<li><a href="logout.php">Logout</a></li>';
				echo '</ul>';
			}
		
		?>
	  </div>
	</nav>  

    <div class="container" style="max-width: 800px;">
        <div class="panel panel-default">
          <div class="panel-body">
		
			<h1>Using Sessions</h1>

			<?php

			//print_r($_SESSION);


			if ($_SESSION['user_data']['access'] == '') {
			?>

				<p>A landing page for establishing sessions.</p>

				<form action="index.php" method="post" class="form-horizontal">

				<div class="form-group">				
					<label for="username" class="col-sm-2 control-label">Username:</label> 
					<div class="col-sm-10">
						<input type="text" name="username" id="username">
					</div>
				</div>
				<div class="form-group">	
					<label for="password" class="col-sm-2 control-label">Password:</label>
					<div class="col-sm-10">
						<input type="password" name="password" id="password">
					</div>
				</div>
				<div class="form-group">	
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="submit_login" value="Login" class="btn btn-default"></p>
					</div>
				</div>
				
				</form>

			<?php
			}
			else {
			?>
				<div class="alert alert-success">
				<p>You are logged in.</p>
				</div>
			<?php
			}
			?>			

			<div>

				<?php
				
					#
					# PERMISSION CONTROLLED CONTENT
					#
					# This code shows content only to users with particular permission levels.
					# With further development, this section could be used to display content
					# to regular users and offer the option to edit, the same content, for admin
					# users.
					#
				
					if ($_SESSION['user_data']['access'] == 1) {
					
						echo "<a href='#edit'>Fake Edit Link</a>";

					}
				
					if ($_SESSION['user_data']['access'] == 5 || $_SESSION['user_data']['access'] == 1) {
					
						echo "<p>Some typical page content would be displayed here.</p>";					
					
					}				
				?>
      
    </div>

    <script src="jquery/jquery-1.11.2.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>

