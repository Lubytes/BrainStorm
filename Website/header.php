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

    
    <style>
      .container {
        max-width: 940px;
      }
      textarea {
        resize: vertical;
      }
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
			<!--<li><a data-toggle="modal" href="#msgModal">Notifications
            <span class="glyphicon glyphicon-envelope" ></span></a></li>-->
            <li><a href="makePost.php">Post</a></li>
			<li><a href="Logout.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>

 
    </div>
    </nav>

    <div class="container">

   
