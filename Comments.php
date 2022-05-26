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
  <title>Comments</title>
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
          <h1><i class="fas fa-comments" style="color:red;"></i> Manage Comments </h1>
          </div>
        </div>
      </div>
    </header>
    <!--HEADER END-->
    <!--Main Area Start -->
    <section class="container py-2 mb-4">
      <div class="row" style="min-height:30px;">
        <div class="col-lg-12" style="min-height:400px;">
          <?php echo ErrorMessage();
          echo SuccessMessage(); ?>
          <h2> Un-Approved Comments</h2>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No. </th>
                <th>Date & Time</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Approve</th>
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows=$Execute->fetch()){
            $CommentId = $DataRows["id"];
            $DateTimeOfComment = $DataRows["datetime"];
            $CommenterName = $DataRows["name"];
            $CommentContent = $DataRows["comment"];
            $CommentPostId = $DataRows["post_id"];
            $SrNo++;

          ?>
           <tbody>
             <tr>
               <td><?php echo htmlentities($SrNo); ?></td>
               <td><?php echo htmlentities($DateTimeOfComment); ?></td>
               <td><?php echo htmlentities($CommenterName); ?></td>
               <td><?php echo htmlentities($CommentContent); ?></td>
               <td ><a href="ApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
               <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
               <td style="min-width:140px;"><a class="btn btn-primary" href="Fullpost.php?id=<?php echo $CommentPostId; ?>">Live Preview</a></td>
             </tr>
           </tbody>
           <?php } ?>
           </table>
           <h2> Approved Comments</h2>
           <table class="table table-striped table-hover">
             <thead class="thead-dark">
               <tr>
                 <th>No. </th>
                 <th>Date & Time</th>
                 <th>Name</th>
                 <th>Comment</th>
                 <th>Revert</th>
                 <th>Action</th>
                 <th>Details</th>
               </tr>
             </thead>
           <?php
           global $ConnectingDB;
           $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
           $Execute = $ConnectingDB->query($sql);
           $SrNo = 0;
           while ($DataRows=$Execute->fetch()){
             $CommentId = $DataRows["id"];
             $DateTimeOfComment = $DataRows["datetime"];
             $CommenterName = $DataRows["name"];
             $CommentContent = $DataRows["comment"];
             $CommentPostId = $DataRows["post_id"];
             $SrNo++;

           ?>
            <tbody>
              <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                <td><?php echo htmlentities($CommenterName); ?></td>
                <td><?php echo htmlentities($CommentContent); ?></td>
                <td style="min-width:140px;"><a href="DisApproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
                <td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                <td style="min-width:140px;"><a class="btn btn-primary" href="Fullpost.php?id=<?php echo $CommentPostId; ?>">Live Preview</a></td>
              </tr>
            </tbody>
            <?php } ?>
            </table>

        </div>
      </div>
    </section>
    <!-- Main Area End -->
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
