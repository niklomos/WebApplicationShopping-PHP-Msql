<?php
include_once 'config.php';
session_start();


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



if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $query = "SELECT * FROM register WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username_user = $row['username'];

        // Query เพื่อดึงข้อมูลจากตาราง orders
        $sql = "SELECT * FROM orders WHERE username = '$username_user'";
        $result_orders = $conn->query($sql);


        $sql2 = "SELECT * FROM orders_cart WHERE username = '$username_user'";
        $result_orders2 = $conn->query($sql2);

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
            <title>ตรวจสอบคำสั่งซื้อ</title>
            <style>
                /* ปรับแต่ง CSS เพื่อให้ table ที่แสดงผล responsive สำหรับอุปกรณ์ที่มีขนาดเล็กลง */
                table {
                    width: 100%;
                    margin-bottom: 1rem;
                    color: #212529;
                    border-collapse: collapse;
                    border-spacing: 0;
                }

                th,
                td {
                    padding: 0.75rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }

                tbody tr:nth-of-type(even) {
                    background-color: rgba(0, 0, 0, 0.05);
                }

                @media (max-width: 767.98px) {
                    table {
                        overflow-x: auto;
                        display: block;
                    }
                }
            </style>
        </head>

        <body>
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark nav-search">
                <a class="navbar-brand text-white" href="index.php">BSRU SHOP</a>

                <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
                <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbar1" class="collapse navbar-collapse">
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
                    </ul>
                </div>
            </nav>
            <div class="container justify-content-center align-item-center mt-3 d-flex gap-3">
                <a href="myorder-check.php " class="btn btn-primary rounded-pill b-product" style="width:12rem"><b>กำลังตรวจสอบ</b></a>
                <a href="myorder-delivery.php" class=" btn btn-dark rounded-pill b-product text-light" style="width:12rem"><b>กำลังจัดส่ง</b></a>
                <a href="myorder-successful.php " class=" btn btn-dark rounded-pill b-product text-light" style="width:12rem"><b>จัดส่งสำเร็จ</b></a>
            </div>

            <div class="container mt-5">
                <a href=" " class=" btn btn-color rounded-pill mb-3 b-product text-light" style="width:12rem"><b>รายการคำสั่งซื้อ</b></a>
                <table class=" table ">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคาสินค้า</th>
                            <th>จำนวน</th>
                            <th>รวมราคาสินค้า</th>
                            <th>เลขคำสั่งซื้อ</th>
                            <th>เวลาที่สั่งซื้อ</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_orders->num_rows > 0) {
                            // Loop เพื่อแสดงข้อมูล
                            while ($row = $result_orders->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo number_format($row['product_price'], 2); ?></td>
                                    <td><?php echo $row['product_quantity']; ?></td>
                                    <td><?php echo number_format($row['total_product_price'], 2); ?></td>
                                    <td><?php echo $row['order_number']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>กำลังตรวจสอบ</td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "ไม่พบข้อมูล";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container mt-5">
                <a href=" " class=" btn btn-color rounded-pill mb-3 b-product text-light" style="width:15rem "><b>รายการคำสั่งซื้อจากตะกร้า</b></a>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคาสินค้า</th>
                            <th>จำนวน</th>
                            <th>รวมราคาสินค้า</th>
                            <th>เลขคำสั่งซื้อ</th>
                            <th>เวลาที่สั่งซื้อ</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_orders2->num_rows > 0) {
                            // Loop เพื่อแสดงข้อมูล
                            while ($row2 = $result_orders2->fetch_assoc()) {
                                $product_price = explode(',', $row2['order_price']);
                                $product_quantity = explode(',', $row2['order_quantity']);
                                $product_product = explode(',', $row2['order_product']);
                        ?>
                                <tr>

                                    <td>
                                        <?php foreach ($product_product as $value) {
                                            echo $value . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php foreach ($product_price as $value) {
                                            echo number_format($value, 2) . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php foreach ($product_quantity as $value) {
                                            echo $value . "<br>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo number_format($row2['total_price'], 2); ?></td>
                                    <td><?php echo $row2['order_number']; ?></td>
                                    <td><?php echo $row2['order_date']; ?></td>
                                    <td>กำลังตรวจสอบ</td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "ไม่พบข้อมูล";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </body>

        </html>
<?php
    }
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "กรุณาสมัครสมาชิก",
                        icon: "warning"
                    }).then(function() {
                        window.location = "index.php";
                    });
                });
            </script>';
}
?>

</body>

</html>