<?php
include_once 'config.php';
// เริ่ม Session (หากยังไม่ได้เริ่ม)
session_start();

// ตรวจสอบ Session หากมี ID ผู้ใช้ที่เข้าสู่ระบบ
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $query = "SELECT * FROM register WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username_user = $row['username'];
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/bootstrap.min.js"></script>
    <!-- เรียกใช้ FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style-index.css">
    <title>หน้าแรก</title>

    <style>
        .card-img {
            width: 70%;
            height: 70%;

        }
    </style>
</head>

<body>
    <!-- ส่วนเนื้อหาของหน้าเว็บ -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand text-white" href="index.php">BSRU SHOP</a>


        <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
        <button class="navbar-toggler ml-auto ip" data-bs-toggle="collapse" data-bs-target="#navbar1">
            <span class="navbar-toggler-icon "></span>
        </button>

        <div id="navbar1" class="collapse navbar-collapse ">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-light"><i class="fas fa-user mr-2"></i><?php echo $username_user; ?></a>
                </li>
                <li class="nav-item">
                    <a href="address.php" class="nav-link text-light"><i class="fas fa-map-marker-alt mr-2"></i>ที่อยู่</a>
                </li>
                <li class="nav-item ">
                    <a href="cart.php" class="nav-link text-light"><i class="fa-solid fa-cart-plus mr-2"></i>ตะกร้า</a>
                </li>
                <li class="nav-item ">
                    <a href="myorder-check.php" class="nav-link text-light">
                        <i class="fa-solid fa-truck-fast mr-2"></i>คำสั่งซื้อ
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn  text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog text-light" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark btn-color text-light">
                        <li><a class="dropdown-item" href="manage-personal.php">จัดการข้อมูลส่วนตัว<i class="fa-solid fa-user-pen ms-1"></i></a></li>
                        <li><a class="dropdown-item" href="myorder-successful.php">การซื้อของฉัน<i class="fa-brands fa-shopify ms-1"></i></a></li>
                        <li><a class="dropdown-item " href="favorite.php">รายการโปรด<i class="fa-solid fa-heart ms-1"></i></a></li>
                    </ul>
                </li>
                <!-- เพิ่มปุ่ม Logout ด้านขวา -->

            </ul>
        </div>
    </nav>

    <div class="container d-flex justify-content-center mt-4">
        <a href=" " class=" btn btn-color text-light rounded-pill mb-3 b-product   align-items-center" style="width:20rem" d-flex justify-content-center><b>รายการโปรด</b></a>
    </div>



    <?php
    include_once 'config.php';


    $sql_fv = "SELECT * FROM favorite WHERE username = '$username_user'";
    $result_fv = mysqli_query($conn, $sql_fv);

    if ($result_fv->num_rows > 0) {
        $product_found = array();
        $product_name_fv = array();
        $fv_id = array();
        while ($row_fv = $result_fv->fetch_assoc()) {
            $fv_id[] = $row_fv['id'];
            $product_id_fv = $row_fv['product_id'];
            $product_name_fv[] = $row_fv['product_name'];
            $product_found[] = $product_id_fv;
        }


        $product_name_string = implode(',',  $product_name_fv);
        $product_ids_string = implode(',', $product_found);
        $fv_id_string = implode(',', $fv_id);

        // สร้าง string ของ id เพื่อใช้ query ร่วมกัน


        $sql_product = "SELECT * FROM product WHERE id IN ($product_ids_string) ";
        $result_product = mysqli_query($conn, $sql_product);


        $sql_fv2 = "SELECT * FROM favorite WHERE  id IN ($fv_id_string)   ";
        $result_fv2 = mysqli_query($conn, $sql_fv2);



        if (($result_product->num_rows > 0) && ($result_fv2->num_rows > 0)) {
    ?>

            <div class="container mt-5 mb-3">
                <div class="row g-2 ms-3">
                    <?php while (($row = $result_product->fetch_assoc()) && ($row_fv2 = $result_fv2->fetch_assoc())) { ?>
                        <?php
                        $imageURL = 'images/' . $row['product_images'];
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                            <div class="card b-product h-100" style="width: 20rem;">
                                <img src="<?php echo $imageURL ?>" class="card-img-top mx-auto d-block" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-start fw-bold"><?php echo $row['product_name']; ?></h5>
                                    <h6 class="card-title text-start"><?php echo $row['product_title']; ?></h6>
                                    <p class="card-title text-start fw-bold text-danger"><?php echo "฿" . number_format($row['product_price'], 2); ?></p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">


                                    <form action="" method="get">
                                        <?php
                                        $product_name = $row['product_name'];
                                        $sql_fv3 = "SELECT * FROM favorite WHERE  product_name = '$product_name' AND username='$username_user' ";
                                        $result_fv3 = mysqli_query($conn, $sql_fv3);
                                        while ($row_fv3 = $result_fv3->fetch_assoc()) {

                                        ?>
                                            <a href="deletequerystring-favorite.php?idemp=<?php echo $row_fv3['id'] ?>  " class="btn btn-link text-danger" type="submit" name="favorite" onclick="return confirm('คุณต้องการลบออกจากรายการโปรดใช่มั้ย')">
                                                <i class="fas fa-heart fa-lg "></i> </a>

                                        <?php } ?>
                                    </form>


                                    <a href="product.php?id=<?php echo $row['id']; ?>" class="btn btn-color text-light btn-sm d-grid rounded-pill ip" style="width:100%;">ดูรายละเอียด</a>
                                </div>
                            </div>
                        </div>


                    <?php } ?>
                <?php } ?>

            <?php } else { ?>
                <p>No products in your favorite .</p>
            <?php } ?>

</body>

</html>