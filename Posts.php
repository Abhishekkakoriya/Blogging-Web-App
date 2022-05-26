<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset ="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equip="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/805037b310.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/styles.css">
  <title>Posts</title>
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
          <a href="Blogs.php?page=1" class="nav-link"> Live Blog</a>
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
          <h1><i class="fas fa-blog" style="color:red;"></i> Blog Posts </h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="AddNewPost.php" class="btn btn-primary d-grid mx-auto">
              <i class="fas fa-edit"></i> Add New Post </a>
            </div>
            <div class="col-lg-3 mb-2">
              <a href="Categories.php" class="btn btn-info d-grid mx-auto">
                <i class="fas fa-plus"></i> Add New Categories </a>
              </div>
              <div class="col-lg-3 mb-2">
                <a href="Admins.php" class="btn btn-warning d-grid mx-auto">
                  <i class="fas fa-user-plus"></i> Add New Admin </a>
                </div>
                <div class="col-lg-3">
                  <a href="Comments.php" class="btn btn-success d-grid mx-auto">
                    <i class="fas fa-check"></i> Approve Comments </a>
                  </div>
        </div>
      </div>
    </header>
        <!--HEADER END-->

        <!--Main Area-->
        <section class="container py-2 mb-4">
          <div class="row">
            <div class="col-lg-12" style="min-height:400px;">
              <?php echo ErrorMessage();
              echo SuccessMessage(); ?>
              <table class="table table-striped table-hover">
                <thead class="thead-dark">

                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>Date & Time</th>
                  <th>Banner</th>
                  <th>Comments</th>
                  <th>Action</th>
                  <th>Live Preview</th>
                </tr>
              </thead>
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM posts";
                $stmt = $ConnectingDB->query($sql);
                $Sr = 0;
                while($DataRows = $stmt->fetch()){
                  $Id        = $DataRows["id"];
                  $DateTime  = $DataRows["datetime"];
                  $PostTitle = $DataRows["title"];
                  $Category  = $DataRows["category"];
                  $Admin     = $DataRows["author"];
                  $Image     = $DataRows["image"];
                  $PostText  = $DataRows["post"];
                  $Sr++;
                 ?>
                 <tbody>
                 <tr>
                   <td><?php echo $Sr ?></td>
                   <td><?php if(strlen($PostTitle)>18){$PostTitle= substr($PostTitle,0,20).'..';}
                     echo $PostTitle; ?></td>
                   <td><?php if(strlen($Category)>10){$Category= substr($Category,0,10).'..';} echo $Category; ?></td>
                   <td><?php if(strlen($Admin)>06){$Admin= substr($Admin,0,6).'..';} echo $Admin; ?></td>
                   <td><?php if(strlen($DateTime)>11){$DateTime= substr($DateTime,0,11).'..';}echo $DateTime; ?></td>
                   <td><img src="Uploads/<?php echo $Image; ?>" width="170px;" height="50px"</td>
                   <td>

                     <?php
                     $Total = ApproveCommentAccordingtoPost($Id);
                     if ($Total>0) {
                       ?>
                        <span class="badge bg-success">
                          <?php
                       echo $Total; ?>
                       </span>
                     <?php } ?>

                     <?php
                     $Total = DisApproveCommentAccordingtoPost($Id);
                     if ($Total>0) {
                       ?>
                        <span class="badge bg-danger">
                          <?php
                       echo $Total; ?>
                       </span>
                     <?php } ?>
                    </td>
                   <td>
                     <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning"> Edit </span></a>
                   <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger"> Delete </span></a>
                 </td>
                   <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary"> Live Preview </span></a></td>
                 </tr>
               </body>
               <?php } ?>
              </table>


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
