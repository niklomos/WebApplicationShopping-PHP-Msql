<?php
require('config.php');
session_start();

$id = $_GET["id"];
$page = $_GET["page"];
$search = $_GET["search"];

$sql = "SELECT * FROM orders_cart WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

?>
<?php
if (isset($_POST['upload'])) {
    // Get image name
    $image_delivery = $_FILES['image_delivery']['name'];

    // Get text
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $slip_image = mysqli_real_escape_string($conn, $_POST['slip_image']);
    $order_number = mysqli_real_escape_string($conn, $_POST['order_number']);
    $product_name = mysqli_real_escape_string($conn, $_POST['order_product']);
    $product_price = mysqli_real_escape_string($conn, $_POST['order_price']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['order_quantity']);
    $total_product_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $created_at = mysqli_real_escape_string($conn, $_POST['order_date']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);  // แก้ชื่อตัวแปรจาก full_name เป็น username
    $full_name = mysqli_real_escape_string($conn, $_POST['fullname']);  // แก้ชื่อตัวแปรจาก full_name เป็น username
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $delivery_name = mysqli_real_escape_string($conn, $_POST['delivery_name']);
    $delivery_number = mysqli_real_escape_string($conn, $_POST['delivery_number']);


    $target = "images/" . basename($image_delivery);

    $sql = "INSERT INTO delivery (user_id,order_number,product_name,product_price,product_quantity,total_product_price,created_at,username,full_name,address,phone,delivery_name,delivery_number,image_delivery) 
    VALUES ('$user_id','$order_number','$product_name','$product_price','$product_quantity','$total_product_price','$created_at','$username','$full_name','$address','$phone','$delivery_name','$delivery_number','$image_delivery')";

    $sql2 = "INSERT INTO report_allorder (slip_image,user_id,order_number,product_name,product_price,product_quantity,total_product_price,created_at,username,full_name,address,phone) 
VALUES ('$slip_image','$user_id','$order_number','$product_name','$product_price','$product_quantity','$total_product_price','$created_at','$username','$full_name','$address','$phone')";

    // execute query
    mysqli_query($conn, $sql);
    mysqli_query($conn, $sql2);

    if (move_uploaded_file($_FILES['image_delivery']['tmp_name'], $target)) {
        $sql3 = "DELETE FROM orders_cart WHERE id=$id";
        mysqli_query($conn, $sql3);

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลสำเร็จ",
                icon: "success"
              }).then(function() {
                if ("' . $search . '" !== "") {
                    window.location = "datasystem-show-order-cart.php?search_input=' . $search . '&page=' . $page . '";
                } else {
                    window.location = "datasystem-show-order-cart.php?page=' . $page . '&search_input=' . $search . '";
                }
              });
            });
          </script>';;
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลไม่สำเร็จ",
                icon: "error"
              }).then(function() {
                window.location = "datasystem-edit-delivery2.php";
              });
            });
          </script>';;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT-DELIVERY</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php
    include_once 'includeCSS.php';
    include_once 'includeJS.php';
    includeJS();
    includeCSS();
    include_once 'navbar_function.php';
    include_once 'sidebar_function.php';
    session_start();

    // เช็คว่ามี session 'admin_id' หรือไม่
    if (isset($_SESSION['admin_id'])) {
        // ดึงค่า admin_id จาก session
        $admin_id = $_SESSION['admin_id'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $querynew = "SELECT * FROM employee WHERE id = $admin_id";
        $resultnew = $conn->query($querynew);

        if ($resultnew->num_rows > 0) {
            $rownew = $resultnew->fetch_assoc();
            $username = $rownew['username'];
            $admin_level = $rownew['level'];
        }
    }
    echo generateNavbar();
    echo generateSidebar($username, $admin_level);
    ?>
    <?php
    // ใช้ substr() เพื่อตัดเครื่องหมาย ',' ตัวสุดท้ายออก
    // $last_comma_pos = strrpos($row['order_quantity'], ',');
    // if ($last_comma_pos !== false) {
    //     $order_quantity = substr($row['order_quantity'], 0, $last_comma_pos);
    // } else {
    //     $order_quantity = $row['order_quantity'];
    // }
    // $last_comma_pos_product = strrpos($row['order_product'], ',');
    // if ($last_comma_pos_product !== false) {
    //     $order_product = substr($row['order_product'], 0, $last_comma_pos_product);
    // } else {
    //     $order_product = $row['order_product'];
    // }

    // ใช้ substr() เพื่อตัดเครื่องหมาย ',' ตัวสุดท้ายออก
    // $last_comma_pos_price = strrpos($row['order_price'], ',');
    // if ($last_comma_pos_price !== false) {
    //     $order_price = substr($row['order_price'], 0, $last_comma_pos_price);
    // } else {
    //     $order_price = $row['order_price'];
    // }
    ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="container pt-3">
                <div class="card ">
                    <div class="card-header " style="background-color:#2C3E50">
                        <h2 class="text-center text-light  pt-2 "> <i class="fa-solid fa-truck-fast me-2"></i>DELIVERY-ORDERS-CART</h2>
                    </div>
                    <div class="card-body">
                        <form action=" " method="POST" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <a class="text-primary toggle-form"><i class="fa-solid fa-circle-chevron-down me-1"></i></a>
                            </div>
                            <div class="toggleable ">
                                <div class="input-group mb-3 d-none">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text text-dark ip bg-warning">ID</span>
                                    </div>
                                    <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" class="form-control  ip" readonly>
                                </div>
                                <div class="input-group mb-3  d-none">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>user_id</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="user_id" value="<?php echo $row['user_id']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>สลิป</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="slip_image" value="<?php echo $row['slip_image']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลขคำสั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_number" value="<?php echo $row['order_number']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_product" value="<?php echo $row['order_product']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคาสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_price" value="<?php echo $row['order_price']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>จำนวนสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_quantity" value="<?php echo$row['order_quantity']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคารวม</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="total_price" value="<?php echo $row['total_price']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เวลาสั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_date" value="<?php echo $row['order_date']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อผู้ใช้</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="username" value="<?php echo $row['username']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อผู้สั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="fullname" value="<?php echo $row['fullname']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ที่อยู่</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="address" value="<?php echo $row['address']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เบอร์โทร</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="phone" value="<?php echo $row['phone']; ?>" readonly>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <img src="images/<?php echo $row['image_delivery']; ?>" alt="" width="250px">
                            </div>
                            <div class="input-group mb-3 col-sm12">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลือกไฟล์ภาพ</b></span>
                                <input type="file" class="form-control ip" placeholder="" aria-label="images" aria-describedby="basic-addon1" name="image_delivery" value="" required>
                            </div>
                            <div class="input-group mb-3 col-sm12">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อบริษัทขนส่ง</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="delivery_name" value="" required>
                            </div>
                            <div class="input-group mb-3 col-sm12">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลขพัสดุ</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="delivery_number" value="" required>
                            </div>
                            <button type="submit" class="my-3 btn btn-primary " name="upload">
                                <i class="fa-solid fa-pen-to-square me-1"></i>
                                อัปเดตข้อมูล</button>
                            <a href="datasystem-show-order-cart.php" target="" class="my-2 btn btn-danger "><i class="fa-solid fa-circle-notch me-1"></i></i>ยกเลิก</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(".toggle-form").click(function() {
            $(".toggleable").toggle(500);
        });
    });
</script>

</html>