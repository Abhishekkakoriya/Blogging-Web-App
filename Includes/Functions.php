<?php require_once("Includes/DB.php");?>
<?php
function Redirect_to($New_location){
  header("Location:".$New_location);
  exit;
}

function CheckUserNameExistsOrNot($UserName){
  global $ConnectingDB;
  $sql = "SELECT username FROM admins WHERE username=:userName";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt ->execute();
  $Result =$stmt->rowcount();
  if ($Result==1) {
    return true;
  }else {
    return false;
  }
}
function Login_Attempt($UserName,$Password){
  global $ConnectingDB;
  $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName',$UserName);
  $stmt->bindValue(':passWord',$Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result==1){
    return $Found_Account=$stmt->fetch();
  }else{
    return null;
  }
}
function Confirm_Login(){
  if(isset($_SESSION["UserId"])){
    return true;
  }else{
    $_SESSION["ErrorMessage"]="Login Required!";
    Redirect_to("Login.php");
  }
}
function Totalposts(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM posts";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $Totalposts = array_shift($TotalRows);
  echo $Totalposts;
}
function TotalCategories(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM Category";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalCategories = array_shift($TotalRows);
  echo $TotalCategories;
}
function TotalAdmins(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM admins";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalAdmins = array_shift($TotalRows);
  echo $TotalAdmins;
}
function TotalComments(){
  global $ConnectingDB;
  $sql = "SELECT COUNT(*) FROM comments";
  $stmt = $ConnectingDB->query($sql);
  $TotalRows = $stmt->fetch();
  $TotalComments = array_shift($TotalRows);
  echo $TotalComments;
}
function ApproveCommentAccordingtoPost($PostId){
  global $ConnectingDB;
  $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
  $stmtApprove = $ConnectingDB->query($sqlApprove);
  $RowsTotal = $stmtApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}
function DisApproveCommentAccordingtoPost($PostId){
  global $ConnectingDB;
  $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
  $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
  $RowsTotal = $stmtDisApprove->fetch();
  $Total = array_shift($RowsTotal);
  return $Total;
}
?>
