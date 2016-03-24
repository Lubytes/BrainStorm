<!-- Nav -->
    <nav class="navbar navbar-default app-navbar">
    <div class="container" style="max-width: 940px;">
      <div class="navbar-header">
		
        <?php if (isset($_SESSION["username"])) { echo '<a class="navbar-brand" href="account.php">BrainStorm Inc.</a>'; }
			else {echo '<a class="navbar-brand" href="Login.php">BrainStorm Inc.</a>';}?>
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