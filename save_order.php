<?php
session_start();
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจาก POST request
    $product_id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['quantity'];
    $total_product_price = $_POST['total_price'];

    // รับข้อมูลรูปภาพสลิปแนบ
    $targetDir = "slip/"; // โฟลเดอร์ที่จะเก็บรูปภาพ
    $image = $_FILES['image']['name'];
    $targetFilePath = $targetDir . $image;

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
    } else {
        // ในกรณีที่ไม่มี Session user_id หรือผู้ใช้ไม่ได้เข้าสู่ระบบ
        // คุณสามารถใช้ชื่อจากฐานข้อมูลในรูปแบบตามคำขอหรือตัวเลือกอื่น ๆ
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
    }
    // สร้างเลขคำสั่งซื้อ
    function generateOrderNumber()
    {
        $orderNumber = date('ymd'); // YYMMDD
        $orderNumber .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3); // 3 ตัวอักษรภาษาอังกฤษสุ่ม
        $orderNumber .= substr(str_shuffle('0123456789'), 0, 3); // 3 ตัวเลขสุ่ม
        $orderNumber .= 'R'; // ตัวอักษร 'R'
        return $orderNumber;
    }

    // เรียกใช้ฟังก์ชันสร้างเลขคำสั่งซื้อ
    $orderNumber = generateOrderNumber();

    if ($conn->query($query) === TRUE) {
        // เก็บรูปภาพสลิป
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);

        // แสดงข้อความแจ้งเตือน
        echo "<script>alert('การสั่งซื้อเสร็จสมบูรณ์'); window.location.href = 'index.php';</script>";
    } else {
        // echo "Error: " . $query . "<br>" . $conn->error;
    }
}
// ตรวจสอบว่า product มีพอจำนวนสินค้าหรือไม่
$query = "SELECT product_amount FROM product WHERE product_name = '$product_name' LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $availableAmount = $row['product_amount'];

    if ($availableAmount >= $product_quantity) {
        // อัปเดตจำนวนสินค้าในฐานข้อมูล
        $query = "UPDATE product SET product_amount = product_amount - $product_quantity WHERE product_name = '$product_name'";
        if ($conn->query($query) === TRUE) {
            // เพิ่มข้อมูลลงฐานข้อมูล
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO orders (user_id, order_number, username, full_name, address, phone, product_name, product_price, product_quantity, total_product_price, slip_image,pro_id) 
                      VALUES ('$user_id', '$orderNumber', '$username_user', '$fullname', '$address', '$phone', '$product_name', '$product_price', '$product_quantity', '$total_product_price', '$image', '$product_id')";

            if ($conn->query($query) === TRUE) {
                // เก็บรูปภาพสลิป
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);

                // แสดงข้อความแจ้งเตือน
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
            } else {
                // echo "Error: " . $query . "<br>" . $conn->error;
            }
        } else {
            // echo "Error updating product amount: " . $conn->error;
        }
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "<h5>ไม่มีสินค้าในสต็อกสำหรับจำนวนที่คุณต้องการสั่งซื้อ</h5>",
            icon: "error"
        }).then(function() {
            window.location = "index.php";
        });
    });
</script>';
    }
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        title: "<h5>ไม่พบสินค้าที่คุณต้องการสั่งซื้อ</h5>",
        icon: "error"
    }).then(function() {
        window.location = "index.php";
    });
});
</script>';
    
}
