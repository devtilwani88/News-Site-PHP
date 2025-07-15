<?php include 'config.php'; ?>
<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
              <?php
                  /* Calculate Offset Code */
                  $limit = 5;
                  if(isset($_GET['page'])){
                    $page = $_GET['page'];
                  }else{
                    $page = 1;
                  }
                  $offset = ($page - 1) * $limit;

                  if($_SESSION["Utype"] == '1'){
                    /* select query of post table for admin user */
                    $sql = "SELECT news.NewsId, news.Title, news.Content,news.NDate,
                    news_category.Category,users.Uname,news.category FROM news
                    LEFT JOIN news_category ON news.category = news_category.CatId
                    LEFT JOIN users ON news.author = users.Uid
                    ORDER BY news.NewsId DESC LIMIT {$offset},{$limit}";
                  }elseif($_SESSION["Utype"] == '0'){
                    /* select query of post table for normal user */
                    $sql = "SELECT news.NewsId, news.Title, news.Content,news.NDate,
                    news_category.Category,users.Uname,news.category FROM news
                    LEFT JOIN news_category ON news.category = news_category.CatId
                    LEFT JOIN users ON news.author = users.Uid
                    WHERE news.author = {$_SESSION['Uid']}
                    ORDER BY news.NewsId DESC LIMIT {$offset},{$limit}";
                  }

                  $result = mysqli_query($conn, $sql) or die("Query Failed.");
                  if(mysqli_num_rows($result) > 0){
                    ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>

                          <?php
                        $serial = $offset + 1;
                        while($row = mysqli_fetch_assoc($result)) {?>
                          <tr>
                              <td class='id'><?php echo $serial; ?></td>
                              <td><?php echo $row['Title']; ?></td>
                              <td><?php echo $row['Category']; ?></td>
                              <td><?php echo $row['NDate']; ?></td>
                              <td><?php echo $row['Uname']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['NewsId']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['NewsId']; ?>&catid=<?php echo $row['category']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial++;
                        } ?>
                      </tbody>
                  </table>
                  <?php
                }else {
                  echo "<h3>No Results Found.</h3>";
                }
                // show pagination
                if($_SESSION["Utype"] == '1'){
                  /* select query of post table for admin user */
                  $sql1 = "SELECT * FROM news";
                }elseif($_SESSION["Utype"] == '0'){
                  /* select query of post table for normal user */
                  $sql1 = "SELECT * FROM news
                  WHERE author = {$_SESSION['Uid']}";
                }
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if(mysqli_num_rows($result1) > 0){

                  $total_records = mysqli_num_rows($result1);

                  $total_page = ceil($total_records / $limit);

                  echo '<ul class="pagination admin-pagination">';
                  if($page > 1){
                    echo '<li><a href="post.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for($i = 1; $i <= $total_page; $i++){
                    if($i == $page){
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if($total_page > $page){
                    echo '<li><a href="post.php?page='.($page + 1).'">Next</a></li>';
                  }
                  echo '</ul>';
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>