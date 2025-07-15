<?php include "header.php"; ?>
<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>
    <?php
    if(isset($_POST['save'])){
       include "config.php";

    $uname = mysqli_real_escape_string($conn,$_POST['user']);
    $pwd = mysqli_real_escape_string($conn,md5($_POST['pwd']));
    $utype = mysqli_real_escape_string($conn,$_POST['Utype']);
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);

    $sql = "SELECT Uname FROM users WHERE Uname = '{$uname}'";
    $result = mysqli_query($conn,$sql) or die("Query Failed.");

    if(mysqli_num_rows($result)>0){
        echo "<p style='color:red;text-align:center;margin: 10px 0;'>UserName Already Exists.</p>";
    }
    else{
        $sql1 = "INSERT INTO `users`(`Uname`, `Utype`, `Upassword`,`Fname`,`Lname`) VALUES ('$uname','$utype','$pwd','$fname','$lname')";

        if(mysqli_query($conn,$sql1)){
            header("Location: {$hostname}/admin/users.php");
        }
    }

    }
    ?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                    <form class="post-form"  method="post">
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username"  >
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="pwd" class="form-control" placeholder="Password"  >
                      </div>
                      <div class="form-group">
                          <label>User Type</label>
                          <select class="form-control" name="Utype" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option> 
                          </select>
                      </div>

                      <div class="form-group">
                          <label>First Name</label> 
                          <input type="text" name="fname" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>Last Name</label> 
                          <input type="text" name="lname" class="form-control">
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>