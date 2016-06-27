<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/css/login.css">
  </head>
  <body>
    <div style="text-align: center">
      <img src="images/yop.png" />
    </div>
    <div class="wrapper">
   <form class="form-signin" action="resources/controller/loginController.php" method="post">
     <h2 class="form-signin-heading">Please login</h2>
     <input type="text" class="form-control"  placeholder="Username" required="" autofocus="" name="uname"/>
     <input type="password" class="form-control"  placeholder="Password" required="" name="pass"/>
     <label class="checkbox">
       <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
     </label>
     <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login"></button>
   </form>
 </body>
 <footer>

</footer>
</html>
