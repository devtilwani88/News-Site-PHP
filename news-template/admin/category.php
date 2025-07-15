<?php include "header.php"; ?>
<?php include 'config.php'; ?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php
                 $limit = 5;
                 if(isset($_GET['page'])){
                   $page = $_GET['page'];
                 }else{
                   $page = 1;
                 }
                 $offset = ($page - 1) * $limit;
                    
                $sql = "SELECT `CatId`, `Category`, `post` FROM `news_category` ORDER BY `CatId` ASC LIMIT {$offset},{$limit}";    
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result) > 0){
                ?>
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Id</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                            $i= $offset+1; 
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$row['CatId']."</td>";
                                echo "<td>".$row['Category']."</td>";
                                echo "<td>".$row['post']."</td>";
                                ?>
                                <td class='edit'><a href='update-category.php?id=<?php echo $row['CatId'];?>'><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a href='delete-category.php?id=<?php echo $row['CatId'];?>'><i class='fa fa-trash-o'></i></a></td>
                                <?php
                                echo "</tr>";
                                $i++;
                                }
                            }
                                else{
                                echo "Nothing To Display";
                                }
                            ?>                      
                    </tbody>
                </table>
                <?php

                    $sql1 = "SELECT `CatId`, `Category`, `post` FROM `news_category`";
                    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                    if(mysqli_num_rows($result1) > 0){

                    $total_records = mysqli_num_rows($result1);

                    $total_page = ceil($total_records / $limit);

                    echo '<ul class="pagination admin-pagination">';
                    if($page > 1){
                        echo '<li><a href="category.php?page='.($page - 1).'">Prev</a></li>';
                    }
                    for($i = 1; $i <= $total_page; $i++){
                        if($i == $page){
                        $active = "active";
                        }else{
                        $active = "";
                        }
                        echo '<li class="'.$active.'"><a href="category.php?page='.$i.'">'.$i.'</a></li>';
                    }
                    if($total_page > $page){
                        echo '<li><a href="category.php?page='.($page + 1).'">Next</a></li>';
                    }
                    echo '</ul>';
                    }

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>