<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>

<?php
 include "header.php"; 
 include 'config.php'; 

 $empid = $_GET['id'];

 $sql = "DELETE FROM `news_category` WHERE `CatId` = $empid";

 if(mysqli_query($conn,$sql)){
    header("Location: {$hostname}/admin/category.php");
}

mysqli_close($conn);

?>