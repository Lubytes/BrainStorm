<?php

session_name('project');  
session_start();

require_once('header.php');
 

?>

      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Sign up</h2>
          </div>
          <div class="panel-body">  

            <form action="Login.php" method="post" >

            <div class="form-group">        
              <div >
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus autocomplete="off">
              </div>
            </div>

            <div class="form-group">  
              <div>
                <input type="password" name="password" id="password" class="form-control" placeholder="password" autocomplete="off">
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
      </div> 


<?php

	require_once('footer.php');
?>