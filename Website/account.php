<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
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

    <title>BrainStorm</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

	<?php
	//session vars
	$username = $_SESSION["username"];
	
	$friends = array();
	$postsList = "";
	
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
		
		//create a list of users that the logged in user is following
		$stmt = $dbh->prepare("SELECT * FROM follows WHERE follower=:username");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				array_push($friends,$row["username"]);	
			}
		}
		
		
		//get the user's posts
		
		foreach($friends as $friend){
			$stmt = $dbh->prepare("SELECT * FROM posts JOIN groups ON posts.groupID=groups.groupID WHERE username=:uID ORDER BY DATE_TIME DESC");
			$stmt->bindParam(':uID', $friend, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					//get all groups and their names
					$postsList .= create_post($row["post_ID"], $row["head"], $row["type"], $row["date_time"], $row["content"], 
					$row["title"], $row["image"], $row["rating"], $row["username"], $row["groupID"], $row["groupname"]);		
				}
			}
		}
		
		
		
	}catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	
	//returns the tree of the id for linking
	function get_tree($id){
		$pid = $id;
		global $dbh;
		$stmt = $dbh->prepare("SELECT * FROM posts WHERE post_ID=:pID");
		$stmt->bindParam(':pID', $id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if ($row["head"] == 1){
					return $pid;
				} else {
					return get_tree($row["head"]);
				}
			
			}
		}
	}
	
	function create_post($post_ID, $head, $type, $date, $content, $title, $image, $rating, $username, $groupID, $groupName){
	if ($post_ID > 1) {
		//get the correct post page
		$link = 0;
		$groupN = "";
		$link = get_tree($post_ID);
		//set everyone group to everyone
		if ($groupID==1){
			$groupN = "Public";
		} else {
			$groupN = $groupName;
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
        position: relative;

      }

    </style>


  </head>


  <body >

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Message</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

	<!--Header Includer--?
   <?php include('headerLoggedIn.php'); ?>



<!-- the actual body -->
<div class="container">

<div class="row row-offcanvas row-offcanvas-left">
  <div class="col-lg-12">


  <div class="row">
  <!-- left -->
    <div class="col-md-3 ">
      <div class="jumbotron">
      <div style="background-image: url(assets/img/iceland.jpg);"></div>
          <a href="profile.php"><img src=""></a>

          <h3 >
            Following:
          </h3>

        <br>
         <div>
          <ul>
			<?php
			
			foreach($friends as $friend){
            
			echo "<li>"."$friend"."</li>";
			
			}
			?>
          </ul>
        </div>

        <br>
      
      </div><!-- jumbo -->
    </div><!-- col-md-3 end -->

  <!-- middle -->
    <div class="col-md-6 ">
       <ul >

          
      <br>

            <h3>Following Posts</h3>
			<?php echo $postsList; ?>
		  

      </ul>
    </div>

    <!-- right -->
    <div class="col-md-3 ">
      <div class="jumbotron">
        <div >
        <h5 >Friends <small>· <a href="#userModal"  data-toggle="modal">View All</a></small></h5>
        <ul >
          <li >
            <a href="#">
              <img src="">
            </a>
            <div>
              <strong>Jen</strong> @Jen
            </div>
          </li>
           <li >
            <a href="#">
              <img src="">
            </a>
            <div >
              <strong>Alex</strong> @Alex
            </div>
          </li>
        </ul>
      
        <div>
          Jennifer just visit your page.
        </div>
     </div >
   
      <br>

      <div >
        <h5 >Likes <small>· <a href="#">View All</a></small></h5>
        <ul >
          <li >
            <a href="#">
              <img src="">
            </a>
            <div>
              <strong>Sam</strong> @sam
              <div >
                <button >
                  <span ></span> Follow</button>
              </div>
            </div>
          </li>
           <li >
            <a href="#">
              <img src="">
            </a>
            <div >
              <strong>Mike</strong> @mike
              <div >
                <button >
                  <span ></span> Follow</button></button>
              </div>
            </div>
          </li>
        </ul>
      
        <div>
          Emma really likes these nerds, no one knows why though.
        </div>
      
      </div>

       <br>

      <div >
        <h5 >Followers <small>· <a href="#userModal"  data-toggle="modal">View All</a></small></h5>
        <ul >
          <li >
            <a href="#">
              <img src="">
            </a>
            <div>
              <strong>John</strong> @john
              <div >
                <button >
                  <span ></span> Follow</button>
              </div>
            </div>
          </li>
           <li >
            <a href="#">
              <img src="">
            </a>
            <div >
              <strong>Amy</strong> @amy
              <div >
                <button >
                  <span ></span> Follow</button></button>
              </div>
            </div>
          </li>
        </ul>
      
        <div>
          John just followed you.
        </div>
      
      </div>

      </div><!-- jumble end-->
    </div><!-- col-md-3 end-->
    </div><!-- row end-->
  </div>
</div>
    


</div> <!--container end-->

      <div>
        <div class="container" style="text-align: center">
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
  </body>
</html>