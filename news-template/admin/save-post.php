<?php include 'config.php'; ?>
<?php
if(isset($_FILES['fileToUpload'])){
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // Fixed

    $extensions = array("jpeg","jpg","png");

    if(!in_array($file_ext, $extensions)){
        $errors[] = "Please choose a JPG/JPEG or PNG file only.";
    }

    if($file_size > 2097152){
        $errors[] = "File size must be 2MB or lower.";
    }

    $new_name = time(). "-".basename($file_name);
    $target = "upload/".$new_name;

    if(empty($errors)){
        move_uploaded_file($file_tmp, $target);
    } else {
        print_r($errors);
        die();
    }
}

session_start();

if(isset($_POST['post_title']) && isset($_POST['postdesc']) && isset($_POST['category'])){
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $description = mysqli_real_escape_string($conn, $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M, Y");
    $author = $_SESSION['Uid'];

    $new_name = isset($new_name) ? $new_name : ""; // Ensure variable exists

    $sql = "INSERT INTO news(Title, content, category, NDate, author, post_img)
            VALUES('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$new_name}');";
    
    $sql .= "UPDATE news_category SET post = post + 1 WHERE CatId = '{$category}'";

    if(mysqli_multi_query($conn, $sql)){
        header("location: {$hostname}/admin/post.php");
    } else {
        echo "<div class='alert alert-danger'>Query Failed.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Missing form fields.</div>";
}
?>
