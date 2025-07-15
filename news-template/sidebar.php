<?php include 'connection.php'; ?>

<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
     <!-- recent posts box -->
     <div class="recent-post-container">
        <h4>Top News</h4>
        <?php
        include "config.php";

        /* Calculate Offset Code */
        $limit = 3;

        $sql = "SELECT news.NewsId, news.Title, news.NDate,
        news_category.Category,news.category,news.post_img FROM news
        LEFT JOIN news_category ON news.category = news_category.CatId
        ORDER BY news.NewsId ASC LIMIT {$limit}";

        $result = mysqli_query($conn, $sql) or die("Query Failed. : Recent Post");
        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)) {
      ?>
        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo $row['NewsId']; ?>">
                <img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php?id=<?php echo $row['NewsId']; ?>"><?php echo $row['Title']; ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?cid=<?php echo $row['category']; ?>'><?php echo $row['Category']; ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?php echo $row['NDate']; ?>
                </span>
                <a class="read-more" href="single.php?id=<?php echo $row['NewsId']; ?>">read more</a>
            </div>
        </div>
    <?php
      }
    }
    ?>
    </div>
    <!-- /recent posts box -->
</div>