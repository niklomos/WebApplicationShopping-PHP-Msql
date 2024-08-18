<?php
session_start();
include_once 'config.php';
// ตรวจสอบ Session หากมี ID ผู้ใช้ที่เข้าสู่ระบบ
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


// รับข้อมูลจาก POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['quantity'];
    $total_product_price = $_POST['total_price'];
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- เรียกใช้ FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style-index.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark  nav-search">
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
    <!-- Navbar หรือเมนูด้านบน (ถ้ามี) -->
    <div class="container mt-5">
        <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><b>ทำการสั่งซื้อ</b></a>
        <div class="card mb-3 border-dark b-product" style="width: 100%">
            <div class="card-body">
                <h6>ชื่อ: <?php echo $fullname; ?></h6>
                <h6>เบอร์โทรศัพท์:<?php echo $phone; ?></h6>
                <h6>ที่อยู่:<?php echo $address; ?></h6>
            </div>
        </div>

        <!-- ตารางหรือส่วนอื่น ๆ ในหน้า payment.php -->
        <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><b>รายละเอียดสินค้า</b></a>
        <table class="table table-striped">
            <thead class="btn-color text-light">
                <tr>
                    <th>รายการสินค้า</th>
                    <th>ราคาต่อชิ้น</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $_POST['product_name']; ?></td>
                    <td><?php echo number_format($_POST['product_price'], 2); ?></td>
                    <td><?php echo $_POST['quantity']; ?></td>
                    <td><?php echo number_format($_POST['total_price'], 2); ?></td>
                </tr>
            </tbody>
        </table>
        <a href="#" class="btn btn-outline-success mt-2 mb-2">
            <h4><b>ยอดชำระเงินทั้งหมด:</b> <?php echo number_format($_POST['total_price'], 2); ?> บาท</h4>
        </a>
        <?php
        $query = $conn->query("SELECT * FROM payment WHERE status ='enabled'");

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
        </div>

        <!-- Existing form elements here -->

        <form action="save_order.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <div class="input-group mb-3 col-sm12">

                <span class="input-group-text btn-color  text-light b-product" id="basic-addon1"><b>แนบสลิป</b></span>

                <input type="file" class="form-control ip" placeholder="" aria-label="images" aria-describedby="basic-addon1" name="image" style="height: 50px;" value="" required>

            </div>
            <input type="text" name="id" value="<?php echo $product_id; ?>" style="display: none;">
            <input type="text" name="product_name" value="<?php echo $product_name; ?>" style="display: none;">

            <input type="text" name="product_price" value="<?php echo $product_price; ?>" style="display: none;">

            <input type="text" name="quantity" value="<?php echo $product_quantity; ?>" style="display: none;">

            <input type="text" name="total_price" value="<?php echo $total_product_price; ?>" style="display: none;">

            <button type="submit" class="btn btn-primary w-25 b-product mb-3">ยืนยันการสั่งซื้อ</button>
        </form>


    </div>

    <!-- ส่วนท้ายหน้าเว็บ (ถ้ามี) -->

    <!-- เรียกใช้ Bootstrap JavaScript และ jQuery (ถ้าต้องการ) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
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

</html>