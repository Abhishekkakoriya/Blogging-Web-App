<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset ="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equip="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/805037b310.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/styles.css">
  <title>Blog Page</title>
  <style media="screen">
  .heading{
    font-family: Bitter,Georgia,"Times New Roman",Times,serif;
    font-weight: bold;
    color: #005E90;
  }
  .heading:hover{
    color: #0090DB;
  }
  </style>
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
    <div class="container">
      <div class="row mt-4">
        <!--Main Area-->
        <div class="col-sm-8">
          <h1> Complete </h1>
          <h1 class="lead">by Abhi </h1>
          <?php echo ErrorMessage();
          echo SuccessMessage(); ?>
          <?php
          global $ConnectingDB;
          //Sql query when search button is active
          if(isset($_GET["SearchButton"])){
            $Search = $_GET["Search"];
            $sql = "SELECT * FROM posts
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':search','%'.$Search.'%');
            $stmt->execute();
          }//Query when pagination is active i.e Blog.php?page=1
          elseif (isset($_GET["page"])) {
            $Page = $_GET["page"];
            if($Page==0||$Page<1){
            $ShowPostFrom=0;
          }else{
            $ShowPostFrom=($Page*5)-5;
          }
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
            $stmt=$ConnectingDB->query($sql);
            //query when category is active in URL
          }elseif (isset($_GET["category"])) {
            $Category = $_GET["category"];
            $sql = "SELECT * FROM posts WHERE category=:categoryName";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':categoryName',$Category);
            $stmt->execute();
          }
          // The deafult SQL Query
          else{
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
            $stmt = $ConnectingDB->query($sql);
          }

          while ($DataRows = $stmt->fetch()) {
            $PostId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $PostTitle = $DataRows["title"];
            $Category = $DataRows["category"];
            $Admin = $DataRows["author"];
            $Image = $DataRows["image"];
            $PostDescription = $DataRows["post"];

          ?>
          <div class="card">
            <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-imp-top" />
            <div class="card-body">
              <h4 class="card-title"><?php echo htmlentities($PostTitle); ?> </h4>
              <small class="text-muted">Category : <span class="text-dark"><a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?></span></a> & Written by <span class="text-dark"><a href="Profile.php?username=<?php echo htmlentities($Admin);?>"><?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
              <span style="float:right;" class="badge text-dark">Comments
              <?php echo ApproveCommentAccordingtoPost($PostId); ?></span>
              <hr>
              <p class="card-text">
                <?php if(strlen($PostDescription>150)){
                  $PostDescription = substr($PostDescription,0,150)."...";} echo htmlentities($PostDescription); ?></p>
              <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                <span class="btn btn-success"> Read More >></span>
              </a>
            </div>
          </div>
        <?php } ?>
        <!--Pagination-->
        <nav>
          <ul class="pagination pagination-lg">
            <!--Creating Backward Button-->
            <?php if(isset($Page)){
              if ($Page>1) {
                ?>
            <li class="page-item">
              <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
            </li>
          <?php } } ?>
          <!--Creating backward button end-->
            <?php
            global $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM posts";
            $stmt=$ConnectingDB->query($sql);
            $RowPagination=$stmt->fetch();
            $TotalPosts=array_shift($RowPagination);
            $PostPagination=$TotalPosts/5;
            $PostPagination=Ceil($PostPagination);
            for($i=1; $i <= $PostPagination; $i++){
              if(isset($Page)){
                if ($i==$Page) { ?>
            <li class="page-item active">
              <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
            </li>
            <?php
          }else {
            ?><li class="page-item">
              <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
            </li>
          <?php }
        } } ?>
        <!-- Creating forward button-->
        <?php if(isset($Page)&&!empty($Page)){
          if ($Page+1<=$PostPagination) {
            ?>
        <li class="page-item">
          <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
        </li>
      <?php } } ?>
          </ul>
        </nav>
      </div>
          <!--Main Area End-->

          <!--Side Area Start-->
        <div class="col-sm-4">
          <div class="card mt-4">
            <div class="card-body">
              <img src="images/Start_blog.jpg" class="d-block img-fluid mb-3" alt="">
              <div class="text-center">
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum,
              </div>
            </div>
          </div>
          <br>
          <div class="card">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Sign Up </h2>
            </div>
            <div class="card-body">
              <button type="button" class=" d-grid gap-2 col-8 mx-auto pt-2 btn btn-success text-center text-white mb-3" name="button">Join the Forum</button>
                <button type="button" class=" d-grid gap-2 col-8 mx-auto pt-2 btn btn-danger text-center text-white mb-3" name="button">Login</button>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="" placeholder="Enter your Email" value="">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary btn-sm text-center text-white py-2" name="button">Subscribe Now</button>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="card">
              <div class="card-header bg-primary text-light">
                <h2 class="lead">Categories</h2>
              </div>
                <div class="card-body">
                  <?php
                  global $ConnectingDB;
                  $sql = "SELECT * FROM category ORDER BY id desc";
                  $stmt = $ConnectingDB->query($sql);
                  while($DataRows = $stmt->fetch()){
                    $CategoryId = $DataRows["id"];
                    $CategoryName = $DataRows["title"];
                  ?>
                  <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a><br>
                <?php } ?>
              </div>
            </div>
            <br>
            <div class="card">
              <div class="card-header bg-info text-white">
                <h2 class="lead">Recent Posts</h2>
              </div>
              <div class="card-body">
              <?php
              global $ConnectingDB;
              $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
              $stmt = $ConnectingDB->query($sql);
              while($DataRows=$stmt->fetch()){
                $Id = $DataRows["id"];
                $Title = $DataRows["title"];
                $DateTime = $DataRows["datetime"];
                $Image = $DataRows["image"];
                ?>
                <div class="media">
                  <img src="Uploads/<?php echo htmlentities($Image); ?>" class="img-fluid align-self-start" width="110" height="100" alt="">
                  <div class=" media-body ml-2">
                    <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead"><?php echo htmlentities($Title)  ?></h6></a>
                    <p class="small"><?php echo htmlentities($DateTime) ?></p>
                  </div>
                </div>
                <hr>
          <?php } ?>
        </div>
      </div>
    </div>
        <!--Side Area End-->
      </div>
    </div>
        <!--HEADER END-->
<br>
    <!--FOOTER-->
    <footer class="bg-dark text-white">
      <div class="container">
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
