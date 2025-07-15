<?php include "header.php"; ?>
<?php include 'config.php'; ?>
<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>


<?php
    if(isset($_POST['sumbit'])){
        $cat_name = $_POST['cat_name'];
        $cat_id = $_POST['cat_id'];

        $sql = "UPDATE `news_category` SET `Category` = '$cat_name' WHERE `CatId` = $cat_id"; 

        if(mysqli_query($conn,$sql)){
            header("Location: {$hostname}/admin/category.php");
        }
    }
?>

<?php
    $empid = $_GET['id'];
    
    $sql1 = "SELECT `Category` FROM `news_category` WHERE `CatId` = '$empid'";
    $result = mysqli_query($conn,$sql1);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

       ?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $empid;?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['Category'];?>" placeholder="" required>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>
                </div>
              </div>
            </div>
          </div>

<?php
 }
}

?>
<?php include "footer.php"; ?>