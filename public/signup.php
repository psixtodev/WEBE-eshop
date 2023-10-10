<?php require_once("../resources/config.php"); ?>
<!-- it leads you to 'resources/templates/front/header.php' -->
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
<?php signup(); ?>

<!-- Page Content -->
<div class="container">
<header>
            <h1 class="text-center">SignUp</h1>
            <h2 class="text-center bg-warning" ><?php display_message(); ?></h2>
<div class="col-sm-4 col-sm-offset-5">


<form action="" method="post" enctype="multipart/form-data">

     <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" class="form-control" >
         
     </div>


      <div class="form-group">
          <label for="email">Email</label>
      <input type="text" name="email" class="form-control"   >
         
     </div>

      <div class="form-group">
          <label for="password">Password</label>
      <input type="password" name="password" class="form-control"  >
         
     </div>

      <div class="form-group">

      <input type="submit" name="signup" class="btn btn-primary" value="signup" >
         
     </div>
      
  </div>

</form>
</div> 

</header>


</div>


<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
