<?php
  include "config.php";

  $post_id = $_GET['id'];
  $cat_id = $_GET['catid'];

  $sql1 = "SELECT * FROM news WHERE NewsId = {$post_id}";
  $result = mysqli_query($conn, $sql1) or die("Query Failed : Select");
  $row = mysqli_fetch_assoc($result);

  unlink("upload/".$row['post_img']);

  $sql = "DELETE FROM news WHERE NewsId = {$post_id};";
  $sql .= "UPDATE news_category SET post= post - 1 WHERE CatId = {$cat_id}";

  if(mysqli_multi_query($conn, $sql)){
    header("location: {$hostname}/admin/post.php");
  }else{
    echo "Query Failed";
  }
?>