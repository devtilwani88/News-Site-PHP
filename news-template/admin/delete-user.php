<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>

<?php
 include "header.php"; 
 include 'config.php'; 

 $empid = $_GET['id'];

 $sql = "DELETE FROM `users` WHERE `Uid` = $empid";

 if(mysqli_query($conn,$sql)){
    header("Location: {$hostname}/admin/users.php");
}

mysqli_close($conn);

?>