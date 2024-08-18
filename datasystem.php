<?php
include_once 'config.php';

include_once 'includeCSS.php';
    include_once 'includeJS.php';
    includeJS();
    includeCSS();
    include_once 'navbar_function.php';
    include_once 'sidebar_function.php';
    session_start();
    session_name('admin_id');
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
    }else{
        header("Location:datasystem-login.php");
            exit(); // ออกจากการทำงานของ script
    }

// เริ่ม Session (หากยังไม่ได้เริ่ม)



// ตรวจสอบ Session หากมี ID ผู้ใช้ที่เข้าสู่ระบบ

        // ตรวจสอบระดับของผู้ใช้และสร้างเงื่อนไขในการแสดงหน้าต่าง ๆ

        // หากเป็นผู้ดูแลระบบ
        // ทำคำสั่ง SQL เพื่อนับจำนวนแถวทั้งหมดในตาราง orders
        $query = "SELECT COUNT(*) as total_orders FROM orders";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_orders = $row['total_orders'];
        } else {
        }

        $query2 = "SELECT COUNT(*) as total_orders_cart FROM orders_cart";
        $result2 = $conn->query($query2);

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $total_orders_cart = $row2['total_orders_cart'];
        } else {
        }
        $query3 = "SELECT COUNT(*) as total_delivery FROM delivery";
        $result3 = $conn->query($query3);

        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_assoc();
            $total_delivery = $row3['total_delivery'];
        } else {
        }
?>
        <!DOCTYPE html>
        <html lang="th">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
           
        </head>
        <body class="hold-transition sidebar-mini layout-fixed">
            <div class="wrapper">

                <?php
    echo generateNavbar();
    echo generateSidebar($username, $admin_level);
    ?>
       
    </div>
        </body>

        </html>