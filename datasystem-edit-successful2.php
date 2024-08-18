<?php
require('config.php');
$id = $_GET["id"];

$sql = "SELECT * FROM delivery WHERE id=$id";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $user_id = $row['user_id'];
    $order_number = $row['order_number'];
    $product_name = $row['product_name'];
    $product_price = $row['product_price'];
    $product_quantity = $row['product_quantity'];
    $total_product_price = $row['total_product_price'];
    $created_at = $row['created_at'];
    $delivery_at = $row['delivery_at'];
    $username = $row['username'];
    $full_name = $row['full_name'];
    $address = $row['address'];
    $phone = $row['phone'];
    $delivery_name = $row['delivery_name'];
    $delivery_number = $row['delivery_number'];
    $image_delivery = $row['image_delivery'];

    $sql2 = "INSERT INTO report_successful_order (user_id,order_number,product_name,product_price,product_quantity,total_product_price,created_at,delivery_at,username,full_name,address,phone,delivery_name,delivery_number,image_delivery) 
    VALUES ('$user_id','$order_number','$product_name','$product_price','$product_quantity','$total_product_price','$created_at','$delivery_at','$username','$full_name','$address','$phone','$delivery_name','$delivery_number','$image_delivery')";

    // execute query
    $resultall = mysqli_query($conn, $sql2);

    if ($resultall) {
        $sql2 = "DELETE FROM delivery WHERE id=$id";
        mysqli_query($conn, $sql2);

        echo "<script>alert('เพิ่มข้อมูลเรียบร้อย')</script>";
        header('location:myorder-successful.php');
    } else {
        echo "<script>alert('ไม่สามารถเพิ่มข้อมูล')</script>";
        echo "Error: " . mysqli_error($conn);
    }
}
