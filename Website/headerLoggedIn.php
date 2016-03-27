<!-- Nav -->
<script>
function showResults(str) {
    if (str.length == 0) { 
        document.getElementById("livesearch").innerHTML = "";
		document.getElementById("livesearch").style.border="0px";
        return;
    }
	else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
				document.getElementById("livesearch").style.border="1px solid #A5ACB2";
            }
        };
        xmlhttp.open("GET", "livesearch.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>




    <nav class="navbar navbar-default app-navbar">
    <div class="container" style="max-width: 940px;">
      <div class="navbar-header">
		
        <?php if (isset($_SESSION["username"])) { echo '<a class="navbar-brand" href="account.php">BrainStorm Inc.</a>'; }
			else {echo '<a class="navbar-brand" href="Login.php">BrainStorm Inc.</a>';}?>
      </div>

      <form class="navbar navbar-left navbar-form " role="search">
        <div class="input-group">
		<input type="text" size="30" onkeyup="showResults(this.value)"></input>
		<div id="livesearch"></div>
			<span class="input-group-btn">
              <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" ></span></button> 
            </span>
           <!-- <input type="text" class="form-control" placeholder="Search for..."> -->
           
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
			<li><a href="Logout.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
 
    </div>
    </nav>