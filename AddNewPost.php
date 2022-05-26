<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST["Category"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Uploads/".basename($_FILES["Image"]["name"]);
  $PostText = $_POST["PostDescription"];
  $Admin = $_SESSION["Username"];
  date_default_timezone_set("Asia/Mumbai");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"] = "Title Cant be Empty";
    Redirect_to("AddNewPost.php");
  }elseif (strlen($PostTitle)<4) {
    $_SESSION["ErrorMessage"] = "Post title should be greater then 3 characters";
    Redirect_to("AddNewPost.php");
  }elseif (strlen($PostText)>9999) {
    $_SESSION["ErrorMessage"] = "Post Description should be less then 50 characters";
    Redirect_to("AddNewPost.php");
  }else{

    global $ConnectingDB;
    $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':postTitle',$PostTitle);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':postDescription',$PostText);
    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

    if($Execute){
      $_SESSION["SuccessMessage"] = "Post with Id : ".$ConnectingDB->lastInsertId()." Added Successfully";
      Redirect_to("AddNewPost.php");
    }else{
      $_SESSION["ErrorMessage"] = "Something went wrong";
      Redirect_to("AddNewPost.php");
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
  <title>Categories</title>
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
          <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Add New Post </h1>
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
      echo SuccessMessage(); ?>
      <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
        <div class="card">
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="title" id="category-title"> Post Title:</label>
              <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here" value="">
            </div>
            <div class="form-group">
              <label for="CategoryTitle" id="category-title"> Choose Category:</label>
              <select class="form-control" id="CategoryTitle" name="Category">
                <?php
                global $ConnectingDB;
                $sql = "SELECT id,title FROM category";
                $stmt = $ConnectingDB->query($sql);
                while ($DateRows = $stmt->fetch()){
                  $ID = $DateRows["id"];
                  $CategoryName = $DateRows["title"];
                 ?>
                 <option> <?php echo $CategoryName; ?></option>
               <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ImageSelect" id="category-title"> Select Image</label>
            <div class="custom-file">
              <input class="custom-file-input" type="File" name="Image" id="ImageSelect" value="">
              <label for="ImageSelect" class="custom-file-label">Select Image</label>
            </div>
          </div>
          <div class="form-group">
              <label for="PostDescription" id="category-title"> Post:</label>
              <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
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
