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

    <!-- Nav -->
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
          <li><a data-toggle="modal" href="#msgModal"data-target="#msgModal">Messages &amp; Notifications
            <span class="glyphicon glyphicon-envelope" ></span></a></li>
          <li><a href="Login.php">Logout
            <span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
 
    </div>
    </nav>



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

          <h5 >
            <a href="profile.php">Whimp</a>
          </h5>

          <p>I feel sad because of whom I never was. I hate the everythingness of everything.</p>
        
        <br>
         <div >
          <h5 >About <small>· <a href="#">Edit</a></small></h5>
          <ul >
            <li><span ></span>Went to <a href="#">Oh, Canada</a>
            <li><span ></span>Became friends with <a href="#">Obama</a>
            <li><span ></span>Worked at <a href="#">Github</a>
            <li><span ></span>Lives in <a href="#">San Francisco, CA</a>
            <li><span ></span>From <a href="#">Seattle, WA</a>
          </ul>
        </div>

        <br>
        <div >
          <h5 >Photos <small>· <a href="#">Edit</a></small></h5>
          <div data-grid="images" data-target-height="150">
            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="">
            </div>

            <div>
              <img data-width="640" data-height="640" data-action="zoom" src="">
            </div>

          </div>
        </div>
      
      </div><!-- jumbo -->
    </div><!-- col-md-3 end -->

  <!-- middle -->
    <div class="col-md-6 ">
       <ul >

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Message">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button" aria-labelledby="..." data-toggle="modal" data-target="#myModal">
                <span class="glyphicon glyphicon-comment"></span></button>
            </span>
          </div>
      <br>
          <div class="jumbotron">
            <p> This part we can show all the interact between this user and other user! </p>
          <br>
            <p> And their genius ideas!</p>
          <br>
            <p>" in short, the period was so far like the present period, that some of its noisiest authorities insisted on its being received, for good or for evil, in the superlative degree of comparison only." </p>
          <br>
            <p>There are times that walk from you like some passing afternoon </p>
          <br>
            <p> When the routine bites hard And ambitions are low </p>
          </div>
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