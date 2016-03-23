<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();

//session vars
$username = $_SESSION["username"];
$isAdmin = $_SESSION["isAdmin"];
$loggedIn = $_SESSION["loggedIn"];
$status = $_SESSION["status"];
$img = $_SESSION["img"];

//we want to get the uID from the URL
$uID = htmlspecialchars($_GET["uID"]);
$displayName = "";
$displayProfile = "";
$displayImg = "";
$displayGender = "";
$groupList = "";

$postsList = "";

$modal = "";


//connecting to the database
	if (file_exists('cred/cred.php')){
		include('cred/cred.php');
	}
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
	
		//get user info
		$stmt = $dbh->prepare("SELECT * FROM users WHERE username=:uID");
		$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$displayName = $row["displayName"];
				$displayProfile = $row["description"];
				$displayImg = $row["picture"];
				$displayGender = $row["gender"];
				
				//fill empty images
				if (empty($displayImg)){
					//blank profile image here
					$displayImg = "img/profile/blank.png";
				}
				
			}
		}
		
	//get the user's groups
	$stmt = $dbh->prepare("SELECT * FROM in_group JOIN groups ON groups.groupID=in_group.groupID WHERE in_group.username=:uID");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$groupID = $row["groupID"];
			$groupname = $row["groupname"];
			$groupList .= '<a href="Group.php?gID='.$groupID.'" class="list-group-item">'.$groupname.'</a>';		
		}
	}
	
	//get the user's posts
	$stmt = $dbh->prepare("SELECT * FROM posts JOIN groups ON posts.groupID=groups.groupID WHERE username=:uID");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$postsList .= create_post($row["post_ID"], $row["head"], $row["type"], $row["date_time"], $row["content"], 
			$row["title"], $row["image"], $row["rating"], $row["username"], $row["groupID"], $row["groupname"]);		
		}
	}
	
	//close the connection
	$dbh = null;
	
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 
	
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dname = test_input($_POST["dname"]);
	$bio = test_input($_POST["bio"]);
	$modal = test_input($_POST["modal"]);
	
	//here's where to do the bio stuff
	if ( $modal=="bio" ) {
		try {
			$dbh = new PDO($dsn, $dbname, $dbpword);

		   //if bio form and display name change
		   if (empty($_POST["dname"])) {
			 //don't change
		   } else {
			 //change
				$stmt = $dbh->prepare("UPDATE users SET displayName=:dname WHERE username=:username");
				$stmt->bindParam(':username', $username, PDO::PARAM_STR);
				$stmt->bindParam(':dname', $dname, PDO::PARAM_STR);
				$stmt->execute();
	 
		   }
			//Display Name Validation
		   if (empty($_POST["bio"])) {
			 //don't change
		   } else {
			 //change
			 $stmt = $dbh->prepare("UPDATE users SET description=:bio WHERE username=:username");
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
			$stmt->execute();
		   } 
   
   
			//close the connection
			$dbh = null;

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		header("Location: profile.php?uID=$username");
	}
	
	//here's where to do the img stuff
	if ( $modal=="image" ) {
		try {
			$dbh = new PDO($dsn, $dbname, $dbpword);

		   //put the form stuff here
   
   
			//close the connection
			$dbh = null;

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		header("Location: profile.php?uID=$username");
	}
}
	
function create_post($post_ID, $head, $type, $date, $content, $title, $image, $rating, $username, $groupID, $groupName){
	if ($post_ID > 1) {
		//get the correct post page
		$link = 0;
		$groupN = "";
		if ($head==1){
			$link = $post_ID;
		} else {
			$link = $head;
		}
		//set everyone group to everyone
		if ($groupID==1){
			$groupN = "Public";
		} else {
			$groupN = $groupname;
		}
		//make the string
		return '<div class="panel panel-info panel-post">
				<div class="panel-heading">
				  <h3 class="panel-title"><a href="Posts.php?head='.$link.'">'.$title.'</a></h3>
				</div>
				<div class="panel-body">
				  <p class ="post_date">'.$date.'</p>
				  <p class="post_content">'.$content.'</p>
				  <p class="post_rating">Rating: '.$rating.'</p>
				  <p class="post_group">Group: <a href="Group.php?gID='.$groupID.'">'.$groupN.'</a>
				</div>
				</div>';
	} else {
		return null;
	}
}
		
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
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

    <title>BrainStorm</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    
    <style>
      .container {
        /*max-width: 940px;*/
        width:100%;
      }
      textarea {
        resize: vertical;
      }
      body {
        width: 1px;
        min-width: 100%;
        *width: 100%;
        font-family:"Open Sans","Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size:14px;
        letter-spacing:0px;
        line-height: 1.6;
        color:#1e3948;
        box-sizing:border-box;
        font-weight: 300;
        padding-left:15px;
        padding-right:15px;

      }
      
      .modal-backdrop {
		  z-index: -1;
		}

    </style>


  </head>

  <body >

    <nav class="navbar navbar-default app-navbar">
    <div class="container" style="max-width: 940px;">
      <div class="navbar-header">
        <a class="navbar-brand" href="Login.php">BrainStorm Inc.</a>
      </div>

      <form class="navbar navbar-left navbar-form " role="search">
        <div class="input-group">
           <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" aria-label="...">
                <span class="glyphicon glyphicon-search" ></span></button> 
            </span>
        </div>
      </form>

        <ul class="nav navbar-nav navbar-left">
          <li><a href="account.php">Home</a></li>
          <?php if (!isset($_SESSION["username"])) { echo '<li><a href="Login.php">Login</a></li>'; } ?>
          <?php if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) { echo '<li><a href="profile.php?uID='.$_SESSION["username"].'" data-action=" ">User Profile
            <span class="glyphicon glyphicon-user" ></span></a></li>'; } ?>
          
          
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-hashpopup="true" aria-expanded="false">Groups</a>
          	<ul class="dropdown-menu">
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="ManageGroups.php">Manage Groups</a></li>
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="CreateGroup.php">Create Group</a></li>
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="SearchGroups.php">Search Groups</a></li>
			</ul>
			</li>
			<!--<li><a data-toggle="modal" href="#msgModal">Notifications
            <span class="glyphicon glyphicon-envelope" ></span></a></li>-->
            <li><a href="makePost.php">Post</a></li>
			<li><a href="Logout.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
 
    </div>
    </nav>

<div class="container">



<div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <div style="background-image: url(assets/img/iceland.jpg);"></div>
              <a href="profile.php"><img src=""></a>

                <h3>
                  <?php echo '<img src="'.$displayImg.'" class="profile_img" />'; ?> <?php echo $displayName; ?>
                </h3>
                	<p>
                  <?php echo "Gender: " . $displayGender; ?>
                  </p>
                  <p>
                  <?php echo $displayProfile; ?>
                  <?php if ($username == $uID) { 
                  	echo "</p>".
                  		' <!-- Trigger the modal with a button -->
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#imgModal">Upload new image</button>
						<br /><br />'.
                  		'<button type="button" class="btn btn-info" data-toggle="modal" data-target="#bioModal">Update bio</button>';  
                  } 
                  
                  ?>
                  </p>
                  
                 

                  
          </div>

          <div class="row">
            <h2>Posts</h2>
              <?php echo $postsList; ?>
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

      <!-- groups -->
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
      	<h4>Member of:</h4>
          <div class="list-group">
            <?php echo $groupList; ?>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

</div> <!--container end-->

      <div class="mastfoot">
          <div class="inner" style="text-align: center">
          © 2016 BrainStorm Inc.

          <a href="#">About</a>
          <a href="#">Help</a>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
          <a href="#">Cookies</a>
          <a href="#">Apps</a>
        </div>
      </div>
    

    <script src="jquery/jquery-1.11.2.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/toolkit.js"></script>
    <script src="assets/js/application.js"></script>
    <script>
      // execute/clear BS loaders for docs
      $(function(){
        if (window.BS&&window.BS.loader&&window.BS.loader.length) {
          while(BS.loader.length){(BS.loader.pop())()}
        }
      })
    </script>
    
    
    <?php include "Modal_image.php"; ?>

	<?php include "Modal_bio.php"; ?>

	  
    
  </body>
</html>