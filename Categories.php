<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
  $Category = $_POST["CategoryTitle"];
  $Admin = $_SESSION["Username"];
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Category)){
    $_SESSION["ErrorMessage"] = "All Fields must be filled out";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)<3) {
    $_SESSION["ErrorMessage"] = "Category title should be greater then 2 characters";
    Redirect_to("Categories.php");
  }elseif (strlen($Category)>49) {
    $_SESSION["ErrorMessage"] = "Category title should be less then 50 characters";
    Redirect_to("Categories.php");
  }else{
    $sql = "INSERT INTO category(title,author,datetime)";
    $sql .= "VALUES(:categoryName,:adminName,:dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':dateTime',$DateTime);
    $Execute=$stmt->execute();

    if($Execute){
      $_SESSION["SuccessMessage"] = "Category with Id : ".$ConnectingDB->lastInsertId()." Added Successfully";
      Redirect_to("Categories.php");
    }else{
      $_SESSION["ErrorMessage"] = "Something went wrong";
      Redirect_to("Categories.php");
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
          <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Manage Categories </h1>
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
      <form class="" action="Categories.php" method="post">
        <div class="card">
          <div class="card-header" id="Category-header">
            <h1 style="color:aliceblue;"> Add New Categories</h1>
          </div>
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="title" id="category-title"> Category Title:</label>
              <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
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
      <h2> Existing Category</h2>
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>No. </th>
            <th>Date & Time</th>
            <th>Category Name</th>
            <th>Creator Name</th>
            <th>Action</th>
          </tr>
        </thead>
      <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM category ORDER BY id desc";
      $Execute = $ConnectingDB->query($sql);
      $SrNo = 0;
      while ($DataRows=$Execute->fetch()){
        $CategoryId = $DataRows["id"];
        $CategoryDate = $DataRows["datetime"];
        $CategoryName = $DataRows["title"];
        $CreatorName = $DataRows["author"];
        $SrNo++;

      ?>
       <tbody>
         <tr>
           <td><?php echo htmlentities($SrNo); ?></td>
           <td><?php echo htmlentities($CategoryDate); ?></td>
           <td><?php echo htmlentities($CategoryName); ?></td>
           <td><?php echo htmlentities($CreatorName); ?></td>
           <td><a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
         </tr>
       </tbody>
       <?php } ?>
       </table>
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
