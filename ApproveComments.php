<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
if(isset($_GET["id"])){
  $SearchQueryParameter = $_GET["id"];
  global $ConnectingDB;
  $Admin = $_SESSION["AdminName"];
  $sql = "UPDATE comments SET status='ON',approvedby='$Admin' WHERE id='$SearchQueryParameter'";
  $Execute = $ConnectingDB->query($sql);
  if($Execute){
    $_SESSION["SuccessMessage"]="Comment Approved Successfully !";
    Redirect_to("Comments.php");
  }else{
    $_SESSION["ErrorMessage"]="Something went Wrong try again";
    Redirect_to("Comments.php");
  }
}
?>
