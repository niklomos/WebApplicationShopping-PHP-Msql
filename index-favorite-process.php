<?php 
require_once('config.php');

if (isset($_POST['favorite'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $username_user = $_POST['username'];
    


    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql = "INSERT INTO favorite (product_id, product_name,username)
            VALUES ('$product_id', '$product_name', '$username_user')";

    if ($conn->query($sql) === TRUE) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }

}
?>






