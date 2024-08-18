<?php
require('config.php');

if (isset($_POST['search1'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search_input']);
    // Query to get products with the specified date
    $sql = "SELECT * FROM report_successful_order WHERE DATE(sucessful_at) = '$search'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $order = 1;
} else {
}

if (isset($_POST['search'])) {
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $month = mysqli_real_escape_string($conn, $_POST['month']);


    $sql = "SELECT * FROM report_successful_order WHERE YEAR(sucessful_at) = '$year' AND MONTH(sucessful_at) = '$month'  ";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $order = 1;
} else {
    // If no date is provided, retrieve all products

}
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORT-SALES</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php
    include_once 'includeCSS.php';
    include_once 'includeJS.php';
    includeJS();
    includeCSS();
    include_once 'navbar_function.php';
    include_once 'sidebar_function.php';
    session_start();

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
    }
    include_once 'check_login_function.php';
    echo generateCheck($admin_level);
    echo generateNavbar();
    echo generateSidebar($username, $admin_level);
    ?>
    <div class="wrapper">
        <div class="content-wrapper">
                <div class="container pt-3">
                <div class="card ">
                    <div class="card-header pb-3" style="background-color:#2C3E50">
                    <h2 class="text-center text-light  pt-2"><i class="fa-solid fa-chart-pie me-2"></i>REPORT-SALES</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class=" input-group mb-4">
                                <input type="date" class="form-control ip" name="search_input" required>
                                <button type="submit" name="search1" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <form action="" method="post">
                            <div class=" input-group mb-2">
                                <span class="input-group-text bg-dark text-light" id="basic-addon1"><b>ปี</b></span>
                                <select class="form-control " id="yearSelect" name="year">
                                    <option selected>เลือกปี</option>
                                    <?php
                                    // กำหนดค่าขอบเขตของปีที่ต้องการ (ตั้งแต่ 2023 ถึง 3000)
                                    $start_year = 2023;
                                    $end_year = 3000;

                                    // สร้าง dropdown สำหรับเลือกปี
                                    for ($year = $start_year; $year <= $end_year; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                            <!-- ส่วนที่เป็นเนื้อหาของ dropdown -->
                            <div class=" input-group mb-2">
                                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>เดือน</b></span>
                                <select class="form-control " id="typeSelect" name="month">
                                    <option selected>เลือกเดือน</option>
                                    <option value="01">มกราคม</option>
                                    <option value="02">กุมภาพันธ์</option>
                                    <option value="03">มีนาคม</option>
                                    <option value="04">เมษายน</option>
                                    <option value="05">พฤษภาคม</option>
                                    <option value="06">มิถุนายน</option>
                                    <option value="07">กรกฎาคม</option>
                                    <option value="08">สิงหาคม</option>
                                    <option value="09">กันยายน</option>
                                    <option value="10">ตุลาคม</option>
                                    <option value="11">พฤศจิกายน</option>
                                    <option value="12">ธันวาคม</option>
                                </select>
                            </div>
                            <div class=" justify-content-center align-item-center">
                                <button type="submit" name="search" class="btn btn-dark"> ค้นหา</button>
                                <?php
                                if (isset($_POST['search1'])) {
                                    $search = $_POST['search_input']; // ตั้งตัวแปร $search ด้วยค่าจาก $_POST['search1']
                                    echo '<a class="btn btn-outline-primary ">ยอด: ' . $search . '</a>'; // ใช้ . เพื่อผนวกสตริงและตัวแปร $search
                                } elseif (isset($_POST['search'])) {
                                    $year = $_POST['year']; // ตั้งตัวแปร $year ด้วยค่าจาก $_POST['search']
                                    $month = $_POST['month']; // ตั้งตัวแปร $year ด้วยค่าจาก $_POST['search']
                                    echo '<a class="btn btn-outline-primary ">ยอดเดือน:' . $month . ' ปี: ' . $year . '</a>'; // ใช้ . เพื่อผนวกสตริงและตัวแปร $year
                                } else {
                                }
                                ?>

                            </div>
                    </div>
                </div>
                </form>
                <?php if ($count > 0) { ?>
                    <div class="container table-responsive p-0 mt-5">
                        <table class="table  table-bordered   ">
                            <thead class="table-dark table table-avatar text-nowrap">
                                <tr class="text-center">
                                    <th>ลำดับ</th>
                                    <th>เลขสั่งซื้อ</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>ราคารวม</th>
                                    <th>เวลา</th>
                                </tr>
                            </thead>

                            <?php
                            while ($row = mysqli_fetch_object($result)) {
                                $total_price += $row->total_product_price;
                            ?>
                                <tbody class="text-center">
                                    <tr>
                                        <td><?php echo $order++ ?></td>
                                        <td><?php echo $row->order_number ?></td>
                                        <td><?php echo $row->product_name ?></td>
                                        <td><?php echo number_format($row->total_product_price,2) ?></td>
                                        <td><?php echo $row->sucessful_at ?></td>



                                    </tr>
                                <?php } ?>
                                </tbody>
                        </table>

                        <div class="container text-end">
                            <a href="#" class="btn-success   " style="text-decoration: none;"><b>รวมทั้งหมด <?php echo number_format($total_price, 2); ?> บาท</b></a>

                        </div>


                    </div>
                <?php } else { ?>


                <?php } ?>

            </div>
        </div>
    </div>
    </div>
</body>

</html>