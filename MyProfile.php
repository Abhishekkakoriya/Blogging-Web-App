<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
//Fetching the exisiting Admin data
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
  $ExistingName = $DataRows["aname"];
  $ExisitingUsername = $DataRows['username'];
  $ExistingHeadline = $DataRows['aheadline'];
  $ExistingBio = $DataRows['abio'];
  $ExisitingImage = $DataRows['aimage'];
}
//Fetching exisiting data end
if(isset($_POST["Submit"])){
  $AName = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio = $_POST["Bio"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Images/".basename($_FILES["Image"]["name"]);
if (strlen($AHeadline)>30) {
    $_SESSION["ErrorMessage"] = "Headline Should be less then 30 characters";
    Redirect_to("MyProfile.php");
  }elseif (strlen($ABio)>500) {
    $_SESSION["ErrorMessage"] = "Bio should be less then 500 characters";
    Redirect_to("MyProfile.php");
  }else{
    //query to update admin data when everything is fine
    global $ConnectingDB;
    if(!empty($_FILES["Image"]["name"])){
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline',abio='$ABio',aimage='$Image'
              WHERE id='$AdminId'";
    }else{
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline',abio='$ABio'
              WHERE id='$AdminId'";
    }
    $Execute= $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

    if($Execute){
      $_SESSION["SuccessMessage"] = "Details Updated Successfully";
      Redirect_to("MyProfile.php");
    }else{
      $_SESSION["ErrorMessage"] = "Something went wrong";
      Redirect_to("MyProfile.php");
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
  <title>My Profile</title>
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
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a href="MyProfile.php" class="nav-link"> 👤︁ My Profile</a>
        </li>
        <li class="nav-item">
          <a href="Dashboard.php" class="nav-link"> Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="Posts.php" class="nav-link"> Posts</a>
        </li>
        <li class="nav-item">
          <a href="Categories.php" class="nav-link"> Categories</a>
        </li>
        <li class="nav-item">
          <a href="Admins.php" class="nav-link"> Manage Admins</a>
        </li>
        <li class="nav-item">
          <a href="Comments.php" class="nav-link"> Comments</a>
        </li>
        <li class="nav-item">
          <a href="Blog.php?page=1" class="nav-link"> Live Blog</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item "><a href="Logout.php" class="nav-link">Logout</a></li>

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
          <div class="col-md-12">
          <h1><i class="fas fa-user text-success mr-2" style="color:#27aae1;"></i> @<?php echo $ExisitingUsername ?> </h1>
          <small><?php echo $ExistingHeadline ?> </small>
          </div>
        </div>
      </div>
    </header>
      <!--HEADER END-->
    <!--MAIN AREA-->
<section class="container py-2 mb-4">
  <div class="row">
    <!--Left Area-->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h3> <?php echo $ExistingName ?></h3>
    </div>
    <div class="card-body">
      <img src="images/<?php echo $ExisitingImage ?>" class="block img-fluid mb-3" alt="">
      <div class="">
      <?php echo $ExistingBio ?>
  </div>
</div>
</div>
</div>
    <!--Right Area-->

    <div class="col-md-9" style="min-height:400px;">
      <?php echo ErrorMessage();
      echo SuccessMessage(); ?>
      <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
        <div class="card bg-dark text-light">
          <div class="card-header bg-secondary text-light">
            <h4>Edit Profile</h4>
          </div>
          <div class="card-body">
            <div class="form-group mb-2">
              <input class="form-control" type="text" name="Name" id="title" placeholder="Your name here" value="">
            </div>
            <div class="form-group">
              <input class="form-control" type="text" name="Headline" id="title" placeholder="Headline" value="">
              <small class="text-muted"> Add a Professional headline like, Developer </small>
              <span class="text-danger">Not more then 30 characters</span>
            </div>
            <div class="form-group mt-2">
                <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
              </div>

          <div class="form-group">
            <label for="ImageSelect" id="category-title"> Select Image</label>
            <div class="custom-file">
              <input class="custom-file-input" type="File" name="Image" id="ImageSelect" value="">
              <label for="ImageSelect" class="custom-file-label"></label>
            </div>
          </div>


            <div class="row">
              <div class="d-grid gap-2 col-6 mx-auto pt-2">
                <a href="Dashboard.php" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Back To Dashboard </a>
              </div>
              <div class="d-grid gap-2 col-6 mx-auto pt-2">
                <button type="submit" name="Submit" class="btn btn-success"><i class="fas fa-check"></i> Publish </button>


            </div>
          </div>
        </div>
      </div>
      </form>
  </div>
</div>
</section>
    <!--MAIN AREA END-->

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
