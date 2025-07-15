<?php include "header.php"; ?>
<?php include 'config.php'; ?>
<?php 

if($_SESSION["Utype"] == 0){
  $post_id = $_GET['id'];
  $sql2 = "SELECT author FROM news WHERE NewsId = {$post_id}";
  $result2 = mysqli_query($conn, $sql2) or die("Query Failed.");

  $row2 = mysqli_fetch_assoc($result2);

  if($row2['author'] != $_SESSION["Uid"]){
    header("location: {$hostname}/admin/post.php");
  }
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
    <?php
        include "config.php";

        $post_id = $_GET['id'];
        $sql = "SELECT news.NewsId, news.Title, news.Content,news.post_img,
        news_category.Category, news.Category FROM news
        LEFT JOIN news_category ON news.Category = news_category.CatId
        LEFT JOIN users ON news.author = users.Uid
        WHERE news.NewsId = {$post_id}";

        $result = mysqli_query($conn, $sql) or die("Query Failed.");
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)) {
      ?>
        <!-- Form for show edit-->
        <form action="save-update-post.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $row['NewsId']; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['Title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5">
                <?php echo $row['Content']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Category</label>
                <select class="form-control" name="category">
                <option disabled> Select Category</option>
                    <?php
                    include "config.php";
                    $sql1 = "SELECT * FROM news_category";

                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                    if(mysqli_num_rows($result1) > 0){
                      while($row1 = mysqli_fetch_assoc($result1)){
                        if($row['Category'] == $row1['CatId']){
                          $selected = "selected";
                        }else{
                          $selected = "";
                        }
                        echo "<option {$selected} value='{$row1['CatId']}'>{$row1['Category']}</option>";
                      }
                    }
                  ?>
                </select>
                <input type="hidden" name="old_category" value="<?php echo $row['Category']; ?>">
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="upload/<?php echo $row['post_img']; ?>" height="150px">
                <input type="hidden" name="old_image" value="<?php echo $row['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
        <?php
          }
        }else{
          echo "Result Not Found.";
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>