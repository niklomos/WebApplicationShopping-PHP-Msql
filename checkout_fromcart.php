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
        $fullname = $row['full_name'];
        $phone = $row['phone'];
        $address = $row['address'];
    }
}

?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/bootstrap.min.js"></script>
    <!-- เรียกใช้ FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style-index.css">
    <title>ชำระเงินผ่านตะกร้า</title>
</head>

<body>
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
            </ul>
        </div>
    </nav>
    <!-- แสดงข้อมูลที่อยู่ -->
    <form action="process_order.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

        <div class="container mt-5">
            <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><b>ทำการสั่งซื้อ</b></a>

            <div class="card mb-3 border-dark b-product" style="width: 100%">
                <div class="card-body">
                    <h6>ชื่อ: <?php echo $fullname; ?></h6>
                    <h6>เบอร์โทรศัพท์:<?php echo $phone; ?></h6>
                    <h6>ที่อยู่:<?php echo $address; ?></h6>
                </div>
            </div>
        </div>

        <!-- แสดงรายละเอียดสินค้า -->
        <div class="container mt-3">
            <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><b>รายละเอียดสินค้า</b></a>

            <table class="table table-striped">
                <thead class="btn-color text-light">
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['cart'][$user_id])) {
                        foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
                            echo "<tr>";
                            echo "<td>{$cartItem['name']}</td>";
                            echo "<td>" . number_format($cartItem['price'], 2) . "</td>";
                            echo "<td>{$cartItem['quantity']}</td>";
                            echo "<td>" . number_format($cartItem['total_price'], 2) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>ไม่มีรายการสินค้าในตะกร้า</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div>
                <!-- Calculate and display the total sum -->
                <?php
                if (!empty($_SESSION['cart'][$user_id])) {
                    $totalSum = 0;

                    foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
                        $totalSum += $cartItem['total_price'];
                    }

                    echo '<div class="total-sum">';
                    echo '<a href=" " class=" btn btn-outline-success mt-2 mb-2"><h4><b>ยอดชำระเงินทั้งหมด:</b> ' . number_format($totalSum, 2) . ' บาท</h4></a>';
                    echo '</div>';
                } else {
                    echo '<div class="total-sum">';
                    echo '<h3>ไม่มีรายการสินค้าในตะกร้า</h3>';
                    echo '</div>';
                }
                ?>
            </div>
            <?php
            $query = $conn->query("SELECT * FROM payment WHERE status = 'enabled'");

            $row = $query->fetch_assoc();
            $imageURL = 'images/' . $row['images'];
            ?>
            <div class="justify-content-between mb-4">
                <div>
                    <img src="<?php echo $imageURL ?>" class="" alt="..." style="width: 20rem;">
                </div>
                <div>
                    <h6 class=""><b>ชื่อธนาคาร:</b> <?php echo $row['account_name']; ?></h6>
                </div>
                <div>
                    <h6 class=""><b>เลขบัญชีธนาคาร:</b> <?php echo $row['account_number']; ?></h6>
                </div>
                <div class="input-group mb-3 col-sm12 ">

                    <span class="input-group-text btn-color text-light b-product" id="basic-addon1"><b>แนบสลิป</b></span>

                    <input type="file" class="form-control b-product" placeholder="" aria-label="images" aria-describedby="basic-addon1" name="image" style="height: 50px;" value="" required>

                </div>



                <button type="submit" class="btn btn-primary w-25 b-product">ยืนยันการสั่งซื้อ</button>


            </div>
        </div>
        </div>
    </form>
</body>
<!-- JavaScript เพื่อตรวจสอบความครบถ้วนของข้อมูล -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function validateForm() {
        var fullname = "<?php echo $fullname; ?>";
        var address = "<?php echo $address; ?>";
        var phone = "<?php echo $phone; ?>";

        if (fullname.trim() === "" || address.trim() === "" || phone.trim() === "") {
            Swal.fire({
                title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                icon: "warning"
            }).then(function() {
                window.location = "address.php";
            });
            return false;
        }
        return true;
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        var checkedProduct = false; // ตัวแปรบอกว่าการเช็คสินค้าเสร็จสมบูรณ์แล้วหรือไม่

        // เมื่อหน้าเว็บโหลดเสร็จ
        // ส่งคำขอ Ajax ไปยังไฟล์ PHP ที่ตรวจสอบสินค้า
        $.ajax({
            url: 'check_product_amount.php',
            method: 'POST',
            dataType: 'json',
            data: { cart: <?php echo json_encode($_SESSION['cart'][$user_id]); ?> }, // ส่งข้อมูลตะกร้าสินค้าไปยังไฟล์ PHP
            success: function(response){
                if(response.status == 'success'){
                    // ตั้งค่าตัวแปรเพื่อบ่งชี้ว่าการเช็คสินค้าเสร็จสมบูรณ์แล้ว
                    checkedProduct = true;
                    // นำไปใช้ในส่วนอื่น ๆ ต่อไปตามต้องการ
                } else {
                    // แสดงข้อความแจ้งเตือนถ้าสินค้ามีจำนวนไม่เพียงพอ
                    Swal.fire({
                        title: "ไม่มีสินค้าในสต็อกสำหรับจำนวนที่คุณต้องการสั่งซื้อ",
                        icon: "error"
                    }).then(function() {
                        window.location = "cart.php";
                    });
                }
            }
        });

        // ถ้าการเช็คสินค้าเสร็จสมบูรณ์แล้ว ให้กลับไปที่หน้า checkout_fromcart.php
        if (checkedProduct) {
            window.location = "checkout_fromcart.php";
        }
    });
</script>


</html>