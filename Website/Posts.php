<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();
//require_once('header.php');

$uID = $_SESSION['username'];
$hID = $_GET["head"];
$username = '';
$postsList = "";
$postmembers = array();
$nameErr = $descErr = $postErr = $loginErr = "";
$g = $d = $l = '0';
$val = true; //tests for validation
$post_styles = "<style>"; //post placements
$left = 0;
$top = 100;
$grouplist = '<option value="1" select>Everyone</option>'.
			'<option value="2">Private</option>';
$modal_script = "";


//change this to privacy setting
if ($_SESSION["loggedIn"] == true) {
	$l = '0';
	$username = $_SESSION["username"];

} else {
	$l = '1'; //user isn't logged in
	$loginErr = "You must be part of this group to see a post.";

}

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
	
	//get head post
	$stmt = $dbh->prepare("SELECT * FROM posts WHERE post_ID=:hID");
	$stmt->bindParam(':hID', $hID, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$latest_post = $row["post_ID"];
			//get all groups and their names
			$postsList .= create_post($row["post_ID"], $row["head"], $row["type"], $row["date_time"], $row["content"], 
			$row["title"], $row["image"], $row["rating"], $row["username"]);		
		}
	}
	
	post_all_posts($latest_post);
	
	$post_styles.= "</style>";
	
	
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
			$grouplist .= '<option value="'.$groupID.'">'.$groupname.'</option>';		
		}
	}
	
	//sets the correct head value based on button clicked
	$head = $hID;
	
	if (isset($_GET["replyTo"])) {
		//this whole section is gonna open a modal for the full stuff or something I'm not sure yet
		$replyTo = $_GET["replyTo"];
		$modal_script =  '<script> $(document).ready(function(){
				$("#myModal").modal();
				}); </script>';
	}

	//close the connection
	$dbh = null;

} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
} 


function create_post($post_ID, $head, $type, $date, $content, $title, $image, $rating, $username){
	if ($post_ID > 1) {
		//get the correct post page
		if ($head==1){
			$class = "post headPost";
		} else {
			$class = "childOf" .$head . " post smallPost";
		}
		global $left, $top, $post_styles;
		
		//set up styles
		$post_styles .= "div #".$post_ID. "{
							left: ".$left."px;
							top: ".$top."px;
						}
						";
		$left = $left + 250;
		$top = $top + 200;
		//make the string
		return '<div class="'.$class.'" id="'.$post_ID.'">
				  <h3>'.$title.'</h3>
				  <p class="post_content">'.$content.'</p>
				  <button type="submit" name="replyTo" value="'.$post_ID.'" class="btn btn-default">Full View</button>
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




//this function recursively prints all the posts
function post_all_posts($current_post){


	//make dbh and postslist global so we can access them
	global $postsList, $dbh;
	$headID = $current_post;
	$stmt = $dbh->prepare("SELECT * FROM posts WHERE head=:hID");
	$stmt->bindParam(':hID', $headID, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$postsList .= create_post($row["post_ID"], $row["head"], $row["type"], $row["date_time"], $row["content"], 
			$row["title"], $row["image"], $row["rating"], $row["username"]);
			
			//now recursively do the rest	
			post_all_posts($row["post_ID"]);
		}
	} else {
		//there's no children
		return;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  
  <?php echo $post_styles ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>BrainStorm</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

	
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
	
	
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="css/jsPlumbToolkit-defaults.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/jsPlumbToolkit-demo.css">
	<link rel="stylesheet" href="css/demo.css">
	
	
	
	<style>
      .container {
        max-width: 940px;
      }
      textarea {
        resize: vertical;
      }
    
    
	.error {color: #3366ff;}
	</style>
	
	</head>

  <body>

    <nav class="navbar navbar-default">
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
          
          <?php if (isset($_SESSION["username"])) { echo '<li><a href="profile.php?uID='.$_SESSION["username"].'" data-action=" ">User Profile
            <span class="glyphicon glyphicon-user" ></span></a></li>'; } ?>
          
          
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-hashpopup="true" aria-expanded="false">Groups</a>
          	<ul class="dropdown-menu">
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="ManageGroups.php">Manage Groups</a></li>
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="CreateGroup.php">Create Group</a></li>
			  <li role="presentation"><a role="menuitem" tabindex="-1" href="SearchGroups.php">Search Groups</a></li>
			</ul>
			</li>
			<li><a data-toggle="modal" href="#msgModal">Notifications
            <span class="glyphicon glyphicon-envelope" ></span></a></li>
			<li><a href="Logout.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>

 
    </div>
    </nav>

    <div class="container">
	
	<h1 class="text-center">Have a new idea? Want to improve other ideas?</h1>
	
	<!-- Validation Boolean and Display-->
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($l=="1") {echo $loginErr."<br><br>"; $val = false; }}?></span>
	<span class="error"> <?php if ($g=="1") {echo $postErr."<br><br>"; $val = false; }?></span>


    
    
   
<!--  start of jsplumb -->   
 <div class="jtk-demo-main">
			<!-- demo -->
            <div class="jtk-demo-canvas canvas-wide source-target-demo jtk-surface jtk-surface-nopan" id="canvas">
            
            <form action="Posts.php" method="get" enctype='multipart/form-data'>
            <input type="hidden" name="head" value="<?php echo $hID; ?>">
            <?php echo $postsList; ?>
            </form>
            
            </div>
			<!-- /demo -->
<!-- JS -->
        
        <!-- support lib for bezier stuff -->
        <script src="jsplumb/lib/jsBezier-0.7.js"></script>
        <!-- event adapter -->
		<script src="jsplumb/lib/mottle-0.7.1.js"></script>
		<!-- geometry functions -->
        <script src="jsplumb/lib/biltong-0.2.js"></script>
		<!-- drag -->
        <script src="jsplumb/lib/katavorio-0.13.0.js"></script>
        <!-- jsplumb util -->
        <script src="jsplumb/src/util.js"></script>
        <script src="jsplumb/src/browser-util.js"></script>
        <!-- main jsplumb engine -->
        <script src="jsplumb/src/jsPlumb.js"></script>
        <!-- base DOM adapter -->
        <script src="jsplumb/src/dom-adapter.js"></script>
        <script src="jsplumb/src/overlay-component.js"></script>
        <!-- endpoint -->
        <script src="jsplumb/src/endpoint.js"></script>
        <!-- connection -->
        <script src="jsplumb/src/connection.js"></script>
        <!-- anchors -->
        <script src="jsplumb/src/anchors.js"></script>
        <!-- connectors, endpoint and overlays  -->
        <script src="jsplumb/src/defaults.js"></script>
        <!-- bezier connectors -->
        <script src="jsplumb/src/connectors-bezier.js"></script>
        <!-- SVG renderer -->
        <script src="jsplumb/src/renderers-svg.js"></script>

        <!-- common adapter -->
        <script src="jsplumb/src/base-library-adapter.js"></script>
        <!-- no library jsPlumb adapter -->
        <script src="jsplumb/src/dom.jsPlumb.js"></script>
        <!-- /JS -->

		<!--  demo code -->
		<script src="jsplumb/demo.js"></script>  

       
            



        
		
		
		
 

	<?php
	echo $modal_script;
	include('Modal_full.php');
	//require_once('footer.php');
	?>


	
		
    </body>
</html>


<!--  end of jsplumb -->
	
	




