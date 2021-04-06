<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$name = '';
$description = '';
$update = false;

if(isset($_POST['save'])){
    $name = $_POST['name'];
    $description = $_POST['description'];

    //Image part
    $target_dir = "Images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    
    //INSERT Queries
    $mysqli->query("INSERT INTO planes (name, description) VALUES('$name', '$description')") or
        die($mysqli->error);

    $mysqli->query("INSERT INTO images (url, planes_id) VALUES('$target_file', (SELECT MAX(id) FROM planes))") or
    die($mysqli->error);
    
    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = "success";


    header("location: index.php");
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];

    $mysqli->query("DELETE FROM planes WHERE id=$id") or
        die($mysqli->error());

    $_SESSION['message'] = "Record has been deleted";
    $_SESSION['msg_type'] = "danger";
    
    header("location: index.php");
}

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM planes WHERE id=$id") or die($mysqli->error());
    if ($result->num_rows){
        $row = $result->fetch_array();
        $name = $row['name'];
        $location = $row['description'];
    }
}

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['description'];

    $mysqli->query("UPDATE planes SET name='$name', description='$description' WHERE id=$id") or
        die($mysqli->error());

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['msg_type'] = "warning";

    header("location: index.php");
}