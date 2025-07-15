<?php include 'header.php'; ?>
<?php include 'connection.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  include "config.php";
                  if(isset($_GET['cid'])){
                    $cat_id = $_GET['cid'];

                    $sql1 = "SELECT * FROM news_category WHERE CatId = {$cat_id}";
                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                    $row1 = mysqli_fetch_assoc($result1);

                  ?>
                  <h2 class="page-heading"><?php echo $row1['Category']; ?> News</h2>
                  <?php

                    /* Calculate Offset Code */
                    $limit = 3;
                    if(isset($_GET['page'])){
                      $page = $_GET['page'];
                    }else{
                      $page = 1;
                    }
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT news.NewsId, news.Title, news.Content,news.NDate,news.author,
                        news_category.Category,users.Uname,news.category,news.post_img FROM news
                        LEFT JOIN news_category ON news.category = news_category.CatId
                        LEFT JOIN users ON news.author = users.Uid
                    WHERE news.category = {$cat_id}
                    ORDER BY news.NewsId DESC LIMIT {$offset},{$limit}";

                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                              <a class="post-img" href="single.php?id=<?php echo $row['NewsId']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                              <div class="inner-content clearfix">
                                  <h3><a href='single.php?id=<?php echo $row['NewsId']; ?>'><?php echo $row['Title']; ?></a></h3>
                                  <div class="post-information">
                                      <span>
                                          <i class="fa fa-tags" aria-hidden="true"></i>
                                          <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['Category']; ?></a>
                                      </span>
                                      <span>
                                          <i class="fa fa-user" aria-hidden="true"></i>
                                          <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['Uname']; ?></a>
                                      </span>
                                      <span>
                                          <i class="fa fa-calendar" aria-hidden="true"></i>
                                          <?php echo $row['NewsId']; ?>
                                      </span>
                                  </div>
                                  <p class="description">
                                      <?php echo substr($row['Content'],0,130) . "..."; ?>
                                  </p>
                                  <a class='read-more pull-right' href='single.php?id=<?php echo $row['NewsId']; ?>'>read more</a>
                              </div>
                            </div>
                        </div>
                    </div>
                    <?php
                      }
                    }else{
                      echo "<h2>No Record Found.</h2>";
                    }

                    // show pagination
                    if(mysqli_num_rows($result1) > 0){

                      $total_records = $row1['post'];

                      $total_page = ceil($total_records / $limit);

                      echo '<ul class="pagination admin-pagination">';
                      if($page > 1){
                        echo '<li><a href="category.php?cid='.$cat_id .'&page='.($page - 1).'">Prev</a></li>';
                      }
                      for($i = 1; $i <= $total_page; $i++){
                        if($i == $page){
                          $active = "active";
                        }else{
                          $active = "";
                        }
                        echo '<li class="'.$active.'"><a href="category.php?cid='.$cat_id .'&page='.$i.'">'.$i.'</a></li>';
                      }
                      if($total_page > $page){
                        echo '<li><a href="category.php?cid='.$cat_id .'&page='.($page + 1).'">Next</a></li>';
                      }

                      echo '</ul>';
                    }
                  }else{
                    echo "<h2>No Record Found.</h2>";
                  }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>