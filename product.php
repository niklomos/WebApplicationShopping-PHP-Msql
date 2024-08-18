<?php
require('config.php');
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM register WHERE id = $user_id";
    $result2 = $conn->query($query);

    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $username_user = $row2['username'];
    }
}
$id = $_GET["id"];


$sql = "SELECT * FROM product where id=$id ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$physical_properties = explode('#', $row['product_detail']);


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
    <title>สินค้า</title>
</head>

<body>
    <!-- Navbar -->
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

    <!-- แสดงข้อมูลรายการสินค้า -->
    <div class="container mt-3 mb-4">
        <div class="card mb-3 cardimg-more b-product" style="max-width: 1500px;">
            <div class="row g-0">
                <!-- รายละเอียดของรูปภาพและข้อมูลสินค้า -->
                <?php
                $imageURL = 'images/' . $row['product_images'];
                ?>
                <div class="col-md-4 col-sm-12">
                    <img src="<?php echo $imageURL ?>" class="img-more card-imgmore" alt="..." width="100%">
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="card-body">
                        <h3 class="card-title text-center fw-bold mb-3 f-head"><?php echo $row['product_name']; ?></h3>
                        <h5 class="card-text mb-3 text-danger"><b><?php echo "฿" . number_format($row['product_price'], 2) ?></b></h5>
                        <hr>
                        <h5 class="card-text mb-3"><b class="">รายละเอียด</b></h5>
                        <h6 class="card-text mb-3"><?php foreach ($physical_properties as $property) {
                                                        $trimmed_property = trim($property); // ตัดช่องว่างที่อยู่ด้านหน้าและด้านหลังของข้อมูล
                                                        if (!empty($trimmed_property)) { // ตรวจสอบว่าข้อมูลไม่เป็นค่าว่าง
                                                            echo "<li> $trimmed_property</li>";
                                                        }
                                                    } ?></h6>
                        <hr>
                        <h5 class="card-text mb-3  "><b>ประเภทสินค้า:</b><a href="index.php?type_name=<?php echo $row['type_name'] ?>" class="text-decoration-none "><?php echo $row['type_name'] ?> </a></h5>
                        <?php
                        if (($row['product_amount'] == 0)) {
                        ?>
                            <h6 class="card-title text-start text-danger "><b>สินค้าหมด!!</b></h6>

                        <?php } elseif ($row['product_amount'] >= 1 && $row['product_amount'] <= 5) { ?>
                            <h6 class="card-title text-start text-danger "><b>จำนวนสินค้าคงเหลือ <?php echo $row['product_amount'] ?> ชิ้น</b></h6>
                        <?php } ?>

                        <!-- ปุ่มเพิ่มและลดจำนวนสินค้า -->
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary b-product" type="button" id="decrement">-</button>
                            <input type="text" class="form-control text-center b-product" id="quantity" name="quantity" value="1" style="height: 50px;" max="<?php echo $row['product_amount']; ?>">
                            <button class="btn btn-outline-secondary b-product" type="button" id="increment">+</button>
                        </div>
                        <?php
                        // ตรวจสอบค่า product_amount และกำหนดให้ปุ่มเพิ่มสินค้าเป็น disabled หาก product_amount เท่ากับ 0
                        $isDisabled = ($row['product_amount'] == 0) ? "disabled" : "";

                        // ...

                        ?>

                        <div class="d-flex">
                            <form action="cart.php" method="POST" class="col-6">
                                <!-- รายละเอียดสินค้า -->
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['product_price']; ?>">
                                <input type="hidden" name="quantity" id="cart_quantity" value="1">
                                <input type="hidden" name="total_price" id="total_price" value="<?php echo $row['product_price']; ?>">
                                <button type="submit" class="btn btn-primary btn-block b-product btn-dm rounded-pill <?php echo $isDisabled; ?>"><i class="fas fa-shopping-cart mr-2"></i>เพิ่มลงตะกร้า</button>
                            </form>
                            <form action="payment.php" method="POST" class="col-6">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                                <input type="hidden" name="quantity" id="payment_quantity" value="1">
                                <input type="hidden" name="total_price" id="product_total_price" value="<?php echo $row['product_price']; ?>">
                                <button class="btn btn-success btn-block b-product btn-md rounded-pill" type="submit" <?php echo $isDisabled; ?>><i class="fas fa-store mr-2"></i>ซื้อ</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- แสดงข้อมูลรายการสินค้า(จบ) -->
</body>
<script>
    var quantity = 1; // เริ่มต้นด้วย 1 หรือค่าที่ต้องการ
    var maxQuantity = <?php echo $row['product_amount']; ?>; // รับค่าจำนวนสินค้าสูงสุดจากฐานข้อมูล

    // เพิ่มจำนวนสินค้า
    document.getElementById("increment").addEventListener("click", function() {
        if (quantity < maxQuantity) { // ตรวจสอบว่ายังไม่เกินจำนวนสินค้าสูงสุด
            quantity++;
            document.getElementById("quantity").value = quantity;
            updateTotalPrice();
            document.getElementById("cart_quantity").value = quantity; // เพิ่มบรรทัดนี้
            document.getElementById("payment_quantity").value = quantity;
        }
    });

    // ลดจำนวนสินค้า แต่ต้องไม่ต่ำกว่า 1
    document.getElementById("decrement").addEventListener("click", function() {
        if (quantity > 1) {
            quantity--;
            document.getElementById("quantity").value = quantity;
            updateTotalPrice();
            document.getElementById("cart_quantity").value = quantity; // เพิ่มบรรทัดนี้
            document.getElementById("payment_quantity").value = quantity;
        }
    });

    // อัปเดตราคารวมเมื่อมีการเปลี่ยนแปลงจำนวน
    function updateTotalPrice() {
        var pricePerItem = <?php echo $row['product_price']; ?>;
        var newQuantity = parseInt(document.getElementById("quantity").value);
        var newTotalPrice = pricePerItem * newQuantity;
        document.getElementById("total_price").value = newTotalPrice;
        document.getElementById("product_total_price").value = newTotalPrice;
    }
</script>

</html>