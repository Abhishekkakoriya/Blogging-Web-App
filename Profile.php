<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<!--Fetching Existing data-->

<?php
  $SearchQueryParameter = $_GET["username"];
  global $ConnectingDB;
  $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
  $stmt=$ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName', $SearchQueryParameter);
  $stmt->execute();
  $Result = $stmt->rowcount();
if($Result==1){
  while ($DataRows=$stmt->fetch()) {
    $ExistingName = $DataRows["aname"];
    $ExistingBio = $DataRows["abio"];
    $ExistingImage = $DataRows["aimage"];
    $ExistingHeadline = $DataRows["aheadline"];
  }
}else {
  $_SESSION["ErrorMessage"]="Bad Request";
  Redirect_to("Blog.php?page=1");
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
  <title>Profile</title>
</head>
<body>
  <!--NAVBAR-->
  <!--NAVBAR-->
  <div style="height:10px; background:#27aae1;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="#" class="navbar-brand"> Techies.com </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a href="Dashboard.php" class="nav-link"> Home </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"> About Us</a>
        </li>
        <li class="nav-item">
          <a href="Blog.php" class="nav-link"> Blog </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"> Contact Us </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"> Features</a>

      </ul>
      <ul class="navbar-nav">
        <form class="form-inline" action="Blog.php">
          <div class="form-group">
          <input class="form-control pb-1 "type="text" name="Search" placeholder="Search here" value="">
          <button class="btn btn-primary" name="SearchButton">Go</button>
        </div>
      </form>
      </ul>
      </div>
    </div>
  </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!--NAVBAR END-->
    <!--HEADER-->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
          <h1><i class="fas fa-user text-success mr-2" style="color:red;"></i><?php echo htmlentities($ExistingName); ?> </h1>
          <h3><?php echo htmlentities($ExistingHeadline); ?></h3>
          </div>
        </div>
      </div>
    </header>
        <!--HEADER END-->
        <section class="container py-2 mb-4">
          <div class="row">
            <div class="col-md-3">
              <img src="images/<?php echo htmlentities($ExistingImage); ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
            </div>
            <div class="col-md-9">
              <div class="card">
                <div class="card-body">
                  <p class="lead"><?php echo htmlentities($ExistingBio); ?></p>
                </div>
              </div>
            </div>
          </div>
        </section>
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
