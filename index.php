<?php include '/resources/include/header.php'; ?>
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
<?php include '/resources/include/footer.php'; ?>
