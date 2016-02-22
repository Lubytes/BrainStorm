<?php

//require_once('Register.php');

require_once('header.php');
 

?>

	<h1 class="text-center">Have a new idea? Want to improve other ideas?</h1>
      <div id="login">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Just Login!</h2>
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
