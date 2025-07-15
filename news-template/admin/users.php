<?php include "header.php"; ?>
<?php include 'config.php'; ?>
<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
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
                  /* select query of user table with offset and limit */
                  $sql2 = "SELECT `Uid`, `Uname`, `Utype`, `Upassword`, `Fname`, `Lname` FROM `users` ORDER BY `Uid` DESC LIMIT {$offset},{$limit}";
                  $result = mysqli_query($conn, $sql2) or die("Query Failed.");
                  if(mysqli_num_rows($result) > 0){
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>User Id</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>User Name</th>
                          <th>Password</th>
                          <th>User Type</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          <?php                          
                    $i= $offset+1;
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['Uid']."</td>";
                        echo "<td>".$row['Fname']."</td>";            
                        echo "<td>".$row['Lname']."</td>";            
                        echo "<td>".$row['Uname']."</td>";
                        echo "<td>".$row['Upassword']."</td>";
                        echo "<td>" . ($row['Utype'] ? "Admin" : "Normal") . "</td>";
            
                        ?>
                        <td class='edit'><a href='update-user.php?id=<?php echo $row["Uid"];?>'><i class='fa fa-edit'></i></a></td>   
                        <td class='delete'><a href='delete-user.php?id=<?php echo $row["Uid"]?>'><i class='fa fa-trash-o'></i></a></td>
                        <?php
                        echo "</tr>";
                        $i++;
                    }
                }else{
                    echo 'Nothing to Display';
                } 
                ?>
                      </tbody>
                  </table>
                  <?php
                // show pagination
                $sql1 = "SELECT `Uid`, `Uname`, `Utype`, `Upassword`, `Fname`, `Lname` FROM `users`";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if(mysqli_num_rows($result1) > 0){

                  $total_records = mysqli_num_rows($result1);

                  $total_page = ceil($total_records / $limit);

                  echo '<ul class="pagination admin-pagination">';
                  if($page > 1){
                    echo '<li><a href="users.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for($i = 1; $i <= $total_page; $i++){
                    if($i == $page){
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if($total_page > $page){
                    echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>';
                  }
                  echo '</ul>';
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
  <?php include "footer.php"; ?>