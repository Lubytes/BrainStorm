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
          <li><a href="profile.php" data-action=" ">User Profile
            <span class="glyphicon glyphicon-user" ></span></a></li>
          <li><a data-toggle="modal" href="#msgModal">Messages &amp; Notifications
            <span class="glyphicon glyphicon-envelope" ></span></a></li>
          <li><a href="Login.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
 
    </div>
    </nav>

<div class="container">

<div class="row row-offcanvas">
  <div class="col-lg-12">

  <div class="row">
    <div class="col-lg-8">
      <div class="jumbotron">
      <div style="background-image: url(assets/img/iceland.jpg);"></div>
          <a href="profile.php"><img src=""></a>

          <h5 >
            <a href="profile.php">Whimp</a>
          </h5>

          <p>I feel sad because of whom I never was. I hate the everythingness of everything.</p>

      </div><!-- jumble end-->
    </div><!-- col-lg-8 end-->
  </div><!-- column end-->
  </div><!-- col-lg-12 end-->
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