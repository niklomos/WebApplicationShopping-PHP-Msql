<?php
include_once 'config.php';

// Start the session
session_start();


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data from the database
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
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/bootstrap.min.js"></script>
    <!-- Include FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="./style-index.css">
    <title>ตะกร้าสินค้า</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark nav-search">
        <a class="navbar-brand text-white" href="index.php">BSRU SHOP</a>

        <!-- Display icons when the screen size is small -->
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
                    <button class="btn text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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

    <!-- Display cart items -->
    <div class="container mt-3 mb-4">
        <a href="#" class="btn btn-color rounded-pill mb-3 b-product text-light" style="width:12rem"><b>ตะกร้าสินค้า</b></a>

        <table class="table table-striped">
            <thead class="btn-color text-white">
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['price'], $_POST['quantity'], $_POST['total_price'])) {
                    $product_id = $_POST['id'];
                    $product_name = $_POST['name'];
                    $product_price = $_POST['price'];
                    $product_quantity = $_POST['quantity']; // เพิ่มบรรทัดนี้
                    $total_product_price = $_POST['total_price'];

                    // Add product to cart in $_SESSION
                    $_SESSION['cart'][$user_id][$product_id] = [
                        'id' => $product_id,
                        'name' => $product_name,
                        'price' => $product_price,
                        'quantity' => $product_quantity, // เพิ่มบรรทัดนี้
                        'total_price' => $total_product_price
                    ];

                    // Display confirmation message
                    echo "เพิ่มสินค้า \"$product_name\" จำนวน $product_quantity เรียบร้อยแล้ว";
                }

                // Display cart items
                if (!empty($_SESSION['cart'][$user_id])) {
                    foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
                        echo "<tr>";
                        echo "<td>{$cartItem['name']}</td>";
                        echo "<td>" . number_format($cartItem['price'], 2) . "</td>";
                        echo "<td>{$cartItem['quantity']}</td>";
                        echo "<td>" . number_format($cartItem['total_price'], 2) . "</td>";
                        echo "<td>";
                        echo "<form action='remove_from_cart.php' method='POST'>";
                        echo "<input type='hidden' name='product_id' value='$cartItemID'>";
                        echo "<button type='submit' class='btn btn-danger btn-sm'>ลบ</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>ตะกร้าสินค้าว่างเปล่า</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <!-- Add checkout button -->
        <a href="checkout_fromcart.php?user_fullname=<?php echo urlencode($user_fullname); ?>&user_phone=<?php echo urlencode($user_phone); ?>&user_address=<?php echo urlencode($user_address); ?>" class="btn btn-primary w-25 b-product">ชำระเงิน</a>
    </div>

</body>

</html>
