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
	    	<a class="navbar-brand" href="index.php">INFX2670 - Seesion</a>
	    </div>

    	<ul class="nav navbar-nav navbar-left">
	        <li><a href="index.php">First page</a></li>
	        <li class="active"><a href="second.php">Second page</a></li>
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
				echo '<li><a href="logout.php" class="navbar-link">Logout</a></li>';
				echo '</ul>';
			}
		
		?>
	  </div>
	</nav>  

    <div class="container" style="max-width: 800px;">
        <div class="panel panel-default">
          <div class="panel-body">

				<p>A second page to demonstrate that sessions are persisted between visits.</p>
		
		</div>
	</div>
  </body>
</html>

