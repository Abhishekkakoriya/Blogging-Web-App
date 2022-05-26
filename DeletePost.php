<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php Confirm_Login(); ?>
<?php
$SearchQueryParameter = $_GET['id'];
global $ConnectingDB;
$sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
$stmt = $ConnectingDB ->query($sql);
while ($DataRows=$stmt->fetch()){
  $TitleToBeDeleted = $DataRows["title"];
  $CategoryToBeDeleted = $DataRows["category"];
  $ImageTobeDeleted = $DataRows["image"];
  $PostToBeDeleted = $DataRows["post"];

}
//echo $ImageTobeUpdated;
if(isset($_POST["Submit"])){
   // Query to Delete Post in DB When everything is fine
    global $ConnectingDB;
    $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);


    if($Execute){
      $Target_Path_To_DELETE_Image = "Uploads/$ImageTobeDeleted";
      unlink($Target_Path_To_DELETE_Image);
      $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
      Redirect_to("Posts.php");
    }else{
      $_SESSION["ErrorMessage"] = "Something went wrong";
      Redirect_to("Posts.php");
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
  <title>Delete Post</title>
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
          <a href="Blog.php?page=1 " class="nav-link"> Live Blog</a>
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
          <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Delete Post </h1>
          </div>
        </div>
      </div>
    </header>
      <!--HEADER END-->
    <!--MAIN AREA-->
<section class="container py-2 mb-4">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
        <?php echo ErrorMessage();
      echo SuccessMessage();

      ?>
      <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
        <div class="card bg-secondary text-light">
          <div class="card-body bg-dark">
            <div class="form-group mb-2">
              <label for="title" id="category-title"> Post Title:</label>
              <input disabled class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="<?php echo $TitleToBeDeleted ?> ">
            </div>
            <div class="form-group mb-2">
              <span for="title" id="category-title">Existing Category: </span>
              <?php echo $CategoryToBeDeleted; ?>
              <br>
          </div>
          <div class="form-group">
            <span for="title" id="category-title">Existing Image: </span>
            <img src="Uploads/<?php echo $ImageTobeDeleted; ?>" width=170px; height="70px;">

          </div>
          <div class="form-group">
              <label for="PostDescription" id="category-title"> Post:</label>
              <textarea disabled class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
              <?php echo $PostToBeDeleted; ?></textarea>
            </div>

            <div class="row">
              <div class="d-grid gap-2 col-6 mx-auto pt-2">
                <a href="Dashboard.php" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Back To Dashboard </a>
              </div>
              <div class="d-grid gap-2 col-6 mx-auto pt-2">
                <button type="submit" name="Submit" class="btn btn-danger">
                  <i class="fas fa-trash"></i> Delete
                </button>


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
