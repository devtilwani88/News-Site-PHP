<?php include "header.php"; ?>
<?php include 'config.php'; ?>
<?php 
  if($_SESSION["Utype"] == 0){
    header("Location: {$hostname}/admin/post.php");
  }
?>

<?php
if(isset($_POST['submit'])){

$id = mysqli_real_escape_string($conn,$_POST['Uid']);
$uname = mysqli_real_escape_string($conn,$_POST['user']);
$pwd = mysqli_real_escape_string($conn,md5($_POST['pwd']));
$utype = mysqli_real_escape_string($conn,$_POST['Utype']);
$fname = mysqli_real_escape_string($conn,$_POST['fname']);
$lname = mysqli_real_escape_string($conn,$_POST['lname']);

 $sql2 = "UPDATE `users` SET `Uname`='$uname',`Utype`='$utype',`Upassword`='$pwd',`Fname`='$fname',`Lname`='$lname' WHERE `Uid` = '$id'";


if(mysqli_query($conn,$sql2)){
    header("Location: {$hostname}/admin/users.php");
}
}
?>

<?php
    $empid = $_GET['id'];

    $sql = "SELECT `Uname`, `Utype`, `Upassword`, `Fname`, `Lname` FROM `users` WHERE `Uid` = '$empid'";

    $result = mysqli_query($conn,$sql) or die("Query Failed.");
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            ?>
       <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                  <div class="form-group">
                <input type="hidden" name="Uid" class="form-control" value="<?php echo $empid;?>">
                </div>
                        <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" value="<?php echo $row['Uname']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="pwd" class="form-control" value="<?php echo $row['Upassword']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Type</label>
                          <select class="form-control" name="Utype" value="<?php echo $row['Utype']; ?>">
                            <?php
                              if($row['Utype'] == 1){
                                echo "<option value='0'>normal User</option>
                                      <option value='1' selected>Admin</option>";
                              }else{
                                echo "<option value='0' selected>normal User</option>
                                      <option value='1'>Admin</option>";
                              }
                            ?>
                          </select>
                      </div>
                      <div class="form-group">
                      <label>First Name</label>
                      <input type="text" name="fname" class="form-control" value="<?php echo $row['Fname']?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" name="lname" class="form-control" value="<?php echo $row['Lname']?>" placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update"  />
                  </form>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div> 
<?php
 }
}
?>
<?php include "footer.php"; ?>