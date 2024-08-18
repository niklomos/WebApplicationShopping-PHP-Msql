<?php
include_once 'config.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
            $productId = $cartItem['name'];
            $quantity = $cartItem['quantity'];

            // ดึงจำนวนสินค้าปัจจุบันจากฐานข้อมูล
            $productQuery = "SELECT product_amount FROM product WHERE id = $cartItemID";
            $productResult = $conn->query($productQuery);
            if ($productResult->num_rows > 0) {
                $productRow = $productResult->fetch_assoc();
                $currentStock = $productRow['product_amount'];

                // เช็คว่าจำนวนสินค้าที่จะสั่งซื้อมากกว่าจำนวนสินค้าในสต็อกหรือไม่
                if ($quantity > $currentStock) {
                    // แสดงข้อความว่าไม่มีสินค้าในสต็อกเพียงพอ
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "<h5>ไม่มีสินค้าในสต็อกสำหรับจำนวนที่คุณต้องการสั่งซื้อ</h5>",
                                icon: "error"
                            }).then(function() {
                                window.location = "cart.php";
                            });
                        });
                    </script>';
                    exit(); // หยุดการทำงานหากไม่มีสินค้าในสต็อกเพียงพอ
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $query = "SELECT * FROM register WHERE id = $user_id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username_user = $row['username'];
            $fullname = $row['full_name'];
            $phone = $row['phone'];
            $address = $row['address'];
            // อัปโหลดไฟล์สลิป
            $targetDir = "slip/"; // โฟลเดอร์ที่จะเก็บรูปภาพ
            $image = $_FILES['image']['name'];
            $targetFilePath = $targetDir . $image;

            // รายละเอียดสินค้าจากตะกร้า
            $orderProductArray = [];
            $orderPriceArray = [];
            $orderQuantityArray = [];
            $orderDetails = '';
            $totalPrice = 0;

            if (!empty($_SESSION['cart'][$user_id])) {
                foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
                    $orderProductIDArray[] = $cartItem['id'];
                    $orderProductArray[] = $cartItem['name'];
                    $orderPriceArray[] = $cartItem['price'];
                    $orderQuantityArray[] = $cartItem['quantity'];
                    $orderDetails .= "ราคารวม: " . $cartItem['total_price'] . "\n\n";

                    $totalPrice += $cartItem['total_price'];
                }
            }
            $orderproductid = implode(",\n", $orderProductIDArray);
            $orderproduct = implode(",\n", $orderProductArray);
            $orderprice = implode(",\n", $orderPriceArray);
            $orderquantity = implode(",\n", $orderQuantityArray);

            // สร้างเลขคำสั่งซื้อ
            function generateOrderNumber()
            {
                $orderNumber = date('ymd'); // YYMMDD
                $orderNumber .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3); // 3 ตัวอักษรภาษาอังกฤษสุ่ม
                $orderNumber .= substr(str_shuffle('0123456789'), 0, 3); // 3 ตัวเลขสุ่ม
                $orderNumber .= 'C'; // ตัวอักษร 'C'
                return $orderNumber;
            }

            // เรียกใช้ฟังก์ชันสร้างเลขคำสั่งซื้อ
            $orderNumber = generateOrderNumber();
        }
    }

    // เพิ่มข้อมูลการสั่งซื้อลงในตาราง 'orders'
    $insertOrderQuery = "INSERT INTO orders_cart (user_id,order_number, username, fullname, phone, address,order_product, order_price,order_quantity ,order_details, total_price, slip_image,pro_id) 
            VALUES ($user_id,'$orderNumber', '$username_user', '$fullname', '$phone', '$address', '$orderproduct','$orderprice','$orderquantity',' $orderDetails', $totalPrice, '$image',' $orderproductid')";

    if ($conn->query($insertOrderQuery) === TRUE) {
        // ทำการอัปโหลดไฟล์สลิปและล้างตะกร้า
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);

        // ลดจำนวน product_amount ในฐานข้อมูล product
        if (!empty($_SESSION['cart'][$user_id])) {
            foreach ($_SESSION['cart'][$user_id] as $cartItemID => $cartItem) {
                $productId = $cartItem['name'];
                $quantity = $cartItem['quantity'];

                // ดึงข้อมูลจำนวนปัจจุบันของสินค้า
                $productQuery = "SELECT * FROM product WHERE id = $cartItemID";
                $productResult = $conn->query($productQuery);
                if ($productResult->num_rows > 0) {
                    $productRow = $productResult->fetch_assoc();
                    $currentAmount = $productRow['product_amount'];

                    // คำนวณจำนวนใหม่
                    $newAmount = $currentAmount - $quantity;

                    // อัปเดตจำนวนในฐานข้อมูล product
                    $updateProductQuery = "UPDATE product SET product_amount = $newAmount WHERE id = $cartItemID";
                    if ($conn->query($updateProductQuery) !== TRUE) {
                        echo "เกิดข้อผิดพลาดในการอัปเดตจำนวนสินค้า: " . $conn->error;
                    }
                }
            }
        }

        // แสดง alert และเด้งไปยังหน้า index.php
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "<h5>การสั่งซื้อถูกดำเนินการแล้วรอตรวจสอบ</h5>",
                        icon: "success"
                    }).then(function() {
                        window.location = "index.php";
                    });
                });
            </script>';
        unset($_SESSION['cart'][$user_id]);
    } else {
        // เกิดข้อผิดพลาดในการเพิ่มลงในตาราง
        echo "เกิดข้อผิดพลาดในการสั่งซื้อ: " . $conn->error;
    }
}
?>
