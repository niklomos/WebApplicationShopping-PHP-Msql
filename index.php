<?php
include_once 'config.php';
// เริ่ม Session (หากยังไม่ได้เริ่ม)

session_start();
session_name('user_id');
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
        /* Sidebar CSS */
        #sidebar {
            height: 100vh;
            width: 250px;
            position: absolute;
            top: 75px;
            left: -250px;
            background-color: #343a40;
            transition: all 0.3s;
            padding-top: 56px;
            /* เพิ่มเพื่อให้มีการเลื่อนได้ */
        }


        #sidebar a {
            padding: 8px 15px;
            text-align: left;
            width: 100%;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        #sidebar .close-btn {
            position: absolute;
            top: 5px;
            right: 20px;
            font-size: 25px;
        }

        .open-btn {
            font-size: 30px;
            cursor: pointer;
            position: absolute;
            top: 3px;
            left: 10px;
        }

        /* ปรับขนาดของ Navbar เพื่อไม่ให้ Sidebar ทับกับโลโก้ */
        .navbar {
            padding-left: 50px;
            /* ปรับขนาดให้เท่ากับความกว้างของ Sidebar */
        }

        /* เพิ่มคุณลักษณะเต็มหน้าจอ */
        .full-screen {
            width: 100%;
            /* กว้างเต็มหน้าจอ */
            height: 100%;
            /* สูงเต็มหน้าจอ */
            left: 0;
            /* ตำแหน่งที่เริ่มจากด้านซ้าย */
        }

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
        <a class="navbar-brand text-light" href="index.php">BSRU SHOP</a>
        <span class="open-btn text-light " id="openSidebar">&#9776;</span>

        <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
        <button class="navbar-toggler ml-auto ip" data-bs-toggle="collapse" data-bs-target="#navbar1">
            <span class="navbar-toggler-icon "></span>
        </button>

        <div id="navbar1" class="collapse navbar-collapse ">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-light"><i class="fas fa-user mr-2"></i>
                        <?php echo $username_user; ?>
                    </a>
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
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-light"><i class="fas fa-sign-out-alt mr-1"></i>ออกจากระบบ</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Navbar สำหรับค้นหา -->
    <nav class="navbar navbar-expand-lg  nav-search">
        <div class="container d-flex justify-content-center align-items-center">
            <form action="index.php" method="GET" class="d-flex">
                <input type="text" class="form-control mr-2 input-search ip" placeholder="ค้นหาสินค้าที่ต้องการที่นี่" aria-label="name" aria-describedby="basic-addon1" name="search_input" value="" required style="width: 700px;">
                <button type="submit" class="btn btn-outline-light ip">ค้นหา</button>
            </form>
        </div>
    </nav>

    <div id="products-container-fluid" class="container mt-5 mb-3">
        <div class="row g-2 ms-3">
            <?php
            $limit = 6; // จำนวนรายการที่ต้องการแสดงในแต่ละหน้า
            $page = isset($_GET['page']) ? $_GET['page'] : 1; // หน้าปัจจุบัน

            $start = ($page - 1) * $limit; // คำนวณเริ่มต้นแถวของข้อมูลในการดึงจากฐานข้อมูล

            if (isset($_GET['type_name'])) {
                $type_name = $_GET['type_name'];
                $sql = "SELECT * FROM product WHERE type_name = '$type_name' LIMIT $start, $limit ";
            } elseif ($_GET['search_input']) {
                $search = $_GET['search_input'];
                $sql = "SELECT * FROM product WHERE id = '$search' OR product_name LIKE '%$search%' OR type_name LIKE '%$search%' OR product_detail LIKE '%$search%' LIMIT $start, $limit ";
            } else {
                $sql = "SELECT * FROM product ORDER BY id DESC LIMIT $start, $limit";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageURL = 'images/' . $row['product_images'];
            ?>



                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                        <div class="card b-product h-100" style="width: 20rem;">
                            <img src="<?php echo $imageURL ?>" class="card-img-top mx-auto d-block" alt="...">
                            <div class="card-body ">
                                <h5 class="card-title text-start fw-bold">
                                    <?php echo $row['product_name']; ?>
                                </h5>
                                <h6 class="card-title text-start">
                                    <?php echo $row['product_title']; ?>
                                </h6>
                                <p class="card-title text-start fw-bold text-danger">
                                    <?php echo "฿" . number_format($row['product_price'], 2); ?>
                                </p>
                                <?php
                                if ($row['product_amount'] <= 0) {
                                    echo "<h5 class='text-danger'>สินค้าหมด!!!</h5>";
                                }
                                ?>

                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <form action="index-favorite-process.php" method="post">
                                    <input type="text" name="product_id" value="<?php echo $row['id']; ?>" hidden>
                                    <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" hidden>
                                    <input type="text" name="username" value="<?php echo $username_user; ?>" hidden>

                                    <?php
                                    $id_product = $row['id'];
                                    $name_product = $row['product_name'];

                                    $sql_fv = "SELECT * FROM favorite WHERE product_id = $id_product AND username = '$username_user' AND product_name = '$name_product' ";

                                    $result_1 = $conn->query($sql_fv);

                                    ?>
                                    <?php if ($result_1->num_rows > 0) {
                                        while ($row_1 = $result_1->fetch_assoc()) {
                                            $fv_id = $row_1['id'];
                                        }
                                    ?>
                                        <form action="" method="get">
                                            <a href="deletequerystring-favorite-index.php?idemp=<?php echo $fv_id ?>  " class="btn btn-link text-danger"><i class="fas fa-heart fa-lg "></i></a>
                                        </form>
                                    <?php } else { ?>
                                        <input type="hidden" name="page" value="<?php echo $page; ?>">
                                        <button class="btn btn-link text-dark" type="submit" name="favorite"><i class="far fa-heart fa-lg "></i></button>
                                    <?php } ?>
                                </form>
                                <a href="product.php?id=<?php echo $row['id']; ?>" class="btn btn-detail btn-sm d-grid rounded-pill ip text-light " style="width:70%;">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>




                <?php
                }
            } else { ?>
                <p>No products found.</p>
            <?php } ?>
        </div>
    </div>

    <?php

    if (isset($_GET['type_name'])) {
        $sql_total = "SELECT COUNT(*) AS total FROM product  WHERE  type_name = '$type_name' LIMIT $start, $limit";
    } elseif ($_GET['search_input']) {
        $sql_total = "SELECT COUNT(*) AS total FROM product  WHERE id = '$search' OR product_name LIKE '%$search%' OR type_name LIKE '%$search%' OR product_detail LIKE '%$search%' LIMIT $start, $limit";
    } else {
        $sql_total = "SELECT COUNT(*) AS total FROM product  ";
    }

    $result_total = $conn->query($sql_total);
    $row_total = $result_total->fetch_assoc();
    $total_pages = ceil($row_total['total'] / $limit); // คำนวณจำนวนหน้าทั้งหมด


    ?>

    <!-- Pagination -->
    <nav aria-label="Page navigation example" class="navbar-light bg-white">
        <ul class="pagination justify-content-center">
            <?php
            // Check if type_name or search_input is set
            if (isset($_GET['type_name'])) {
                $type_name = $_GET['type_name'];
                $sql_total = "SELECT COUNT(*) AS total FROM product WHERE type_name = '$type_name'";
            } elseif (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
                $search = $_GET['search_input'];
                $sql_total = "SELECT COUNT(*) AS total FROM product WHERE id = '$search' OR product_name LIKE '%$search%' OR type_name LIKE '%$search%' OR product_detail LIKE '%$search%'";
            } else {
                $sql_total = "SELECT COUNT(*) AS total FROM product";
            }

            $result_total = $conn->query($sql_total);
            $row_total = $result_total->fetch_assoc();
            $total_pages = ceil($row_total['total'] / $limit); // Calculate total pages

            // Previous page
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link text-dark" href="?';
                if (isset($_GET['type_name'])) {
                    echo 'type_name=' . $_GET['type_name'] . '&';
                } elseif (isset($_GET['search_input'])) {
                    echo 'search_input=' . $_GET['search_input'] . '&';
                }
                echo 'page=' . ($page - 1) . '">Previous</a></li>';
            }

            // Numbered pages
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">';
                echo '<a class="page-link" href="?';
                if (isset($_GET['type_name'])) {
                    echo 'type_name=' . $_GET['type_name'] . '&';
                } elseif (isset($_GET['search_input'])) {
                    echo 'search_input=' . $_GET['search_input'] . '&';
                }
                echo 'page=' . $i . '">' . $i . '</a>';
                echo '</li>';
            }

            // Next page
            if ($page < $total_pages) {
                echo '<li class="page-item"><a class="page-link text-dark" href="?';
                if (isset($_GET['type_name'])) {
                    echo 'type_name=' . $_GET['type_name'] . '&';
                } elseif (isset($_GET['search_input'])) {
                    echo 'search_input=' . $_GET['search_input'] . '&';
                }
                echo 'page=' . ($page + 1) . '">Next</a></li>';
            }
            ?>
        </ul>
    </nav>


    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block  mt-5 order-md-1 order-2 b-product " style=" background-color: #0060ad;">
        <a href="#" class="navbar-brand btn btn-color rounded-pill mb-3 b-product" style="width:10rem"><b>หมวดหมู่สินค้า</b></a>
        <span class="close-btn text-light" id="closeSidebar">&times;</span>

        <!-- เพิ่มรายการอื่น ๆ ที่คุณต้องการให้เห็นใน Sidebar -->

        <!-- ดึงข้อมูลประเภทสินค้าจากฐานข้อมูล -->
        <ul class="nav flex-column ">
            <?php
            $type_query = mysqli_query($conn, "SELECT type_name FROM type");
            $current_type = isset($_GET['type_name']) ? $_GET['type_name'] : ''; // หมวดหมู่สินค้าที่ถูกเลือก

            while ($type = mysqli_fetch_assoc($type_query)) {
                $type_name = $type['type_name'];
                $active_class = ($type_name == $current_type) ? 'btn btn-outline-light' : ''; // เช็คว่าหมวดหมู่สินค้านี้ถูกเลือกหรือไม่
                echo '<li class="nav-item"><a class="nav-link text-light ' . $active_class . '" href="index.php?type_name=' . $type_name . '">' . $type_name . '</a></li>';
            }
            ?>

        </ul>
    </nav>

    <!-- Include Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#openSidebar").click(function() {
                $("#sidebar").css("left", "0");
            });
            $("#closeSidebar").click(function() {
                $("#sidebar").css("left", "-100%");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var inputSearch = document.querySelector(".input-search");
            var width = window.innerWidth;

            if (width <= 768) {
                inputSearch.style.width = "200px";

            }
        });
    </script>


</body>

</html>