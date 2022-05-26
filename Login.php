<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}

if (isset($_POST["Submit"])){
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if(empty($UserName)||empty($Password)){
    $_SESSION["ErrorMessage"] = "All Field must be filled out";
    Redirect_to("Login.php");
  }else {
    //code for checking username and password from database
    $Found_Account=Login_Attempt($UserName,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"]=$Found_Account["id"];
      $_SESSION["Username"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["AdminName"];
      if(isset($_SESSION["TrackingURL"])){
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
      Redirect_to("Dashboard.php");
    }
    }else{
      $_SESSION["ErrorMessage"] = "Incorrect Userame/Password";
      Redirect_to("Login.php");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset ="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equip="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/805037b310.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/styles.css">
  <title>Login</title>
</head>
<body>
  <!--NAVBAR-->
  <div style="height:10px; background:#27aae1;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="#" class="navbar-brand"> Techies.com </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

      </div>
    </div>
  </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!--NAVBAR END-->
    <!--HEADER-->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
      </div>
    </header>
        <!--HEADER END-->
        <!--Main Area Start-->
        <section class="container py-2 mb-4">
          <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
              <br><br><br>
              <?php echo ErrorMessage();
              echo SuccessMessage(); ?>
              <div class="card bg-secondary text-light">
                <div class="card-header">
                  <h4>Login</h4>
                </div>
                  <div class="card-body bg-dark">
                  <form class="" action="Login.php" method="post">
                    <div class="form-group">
                      <label for="username" id="category-title">Username:</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text text-white bg-warning py-3"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="Username" id="username" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" id="category-title">Password:</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text text-white bg-warning py-3"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="Password" id="password" value="">
                      </div>
                    </div>
                    <input type="submit" name="Submit" class="d-grid gap-2 col-12 mx-auto pt-1 btn btn-success btn-lg btn-block" value="Login">
                    </form>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--Main Area End-->

    <!--FOOTER-->
    <footer class="bg-dark text-white">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
          <p class="lead text-center small"> Developed by  | Abhi | <span id="year"></span>&copy; ----All right Reserved.</p>
          <p class="text-center small"> <a style="color: white;"> This site is for practice purpose only Abhi have all the rights. No one is allowed to distribute copies other than<br> &#8482; Abhi </a></p>
        </div>
      </div>
    </div>
    <div style="height:10px; background:#27aae1;"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
  document.getElementById("year").innerHTML = new Date().getFullYear();
  </script>

</body>
</html>
