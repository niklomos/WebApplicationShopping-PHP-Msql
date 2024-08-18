<?php
require('config.php');
// Define the number of items per page
$items_per_page = 10;

// Get the current page number from the query string, default to page 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $items_per_page;
if (isset($_POST['search'])) {
    session_start();
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $query = "SELECT * FROM employee WHERE id = $admin_id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $admin_level = $row['level'];

            // ตรวจสอบระดับของผู้ใช้และสร้างเงื่อนไขในการแสดงหน้าต่าง ๆ

        }
    }
    $search = mysqli_real_escape_string($conn, $_POST['search_input']);
    // Query to get products with the specified type_name
    $sql = "SELECT * FROM report_successful_order WHERE id = '$search' OR product_name LIKE '%$search%'OR order_number LIKE '%$search%' OR full_name LIKE '%$search%'OR phone LIKE '%$search%'OR username LIKE '%$search%'OR delivery_name LIKE '%$search%' OR delivery_number LIKE '%$search%'  LIMIT $offset, $items_per_page";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $order = $offset + 1; // Start order from the correct number
} else {
    session_start();
    if (isset($_SESSION['admin_id'])) {
        $admin_id = $_SESSION['admin_id'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $query = "SELECT * FROM employee WHERE id = $admin_id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $admin_level = $row['level'];

            // ตรวจสอบระดับของผู้ใช้และสร้างเงื่อนไขในการแสดงหน้าต่าง ๆ

        }
    }

    // หากเป็นผู้ดูแลระบบ


    $sql = "SELECT * FROM report_successful_order ORDER BY id DESC  LIMIT $offset, $items_per_page";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $order = $offset + 1; // Start order from the correct number
}
$total_items_query = "SELECT COUNT(*) as total FROM report_successful_order";
$total_items_result = mysqli_query($conn, $total_items_query);
$total_items = mysqli_fetch_assoc($total_items_result)['total'];

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORT-ORDERS-SUCCESSFUL</title>

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
                        <h2 class="text-center text-light pt-2 pb-2"><i class="fa-solid fa-file me-2"></i>REPORT-SUCCESSFUL</h2>
                        <div class="d-flex mb-2">
                            <form class="input-group" action="" method="post">
                                <input type="text" class="form-control" placeholder="ค้นหา" aria-label="ค้นหา" aria-describedby="basic-addon1" name="search_input" value="" required>
                                <button type="submit" name="search" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <?php if ($count > 0) { ?>
                            <table class="table table-striped table-hover">
                                <thead class=" ">
                                    <tr class="text-start">
                                        <th class="col-1">ลำดับ</th>
                                        <th>บริษัท</th>
                                        <th>เลขพัสดุ</th>
                                        <th class="text-center">เลขคำสั่งซื้อ</th>
                                        <th>รายการสินค้า</th>
                                        <th class="text-center">เวลา</th>
                                        <th>ชื่อผู้ใช้</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_object($result)) { ?>
                                        <?php
                                        $imageURL = 'slip/' . $row->image_delivery;
                                        ?>
                                        <tr class="text-start">
                                            <td><?php echo $order++ ?></td>
                                            <td><?php echo $row->delivery_name ?></td>
                                            <td><?php echo $row->delivery_number ?></td>
                                            <td class="text-center"><?php echo $row->order_number ?></td>
                                            <td><?php echo $row->product_name ?></td>
                                            <td class="text-center"><?php echo $row->sucessful_at ?></td>
                                            <td><?php echo $row->username ?></td>
                                            <td><?php echo $row->full_name ?></td>
                                            <td class="text-center">
                                                <a href="datasystem-report-order-successful-detail.php?id=<?php echo $row->id ?>  " class="text-primary ">
                                                    <i class="fa-solid fa-up-right-from-square"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>

                            <div class="d-flex justify-content-center align-content-center pt-5 pb-5">
                                <p class="display-6 text-secondary"><b>No data found</b></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                // Display pagination only if there are more items than the items per page
                if ($total_items > $items_per_page) {
                    // Include the function file where you defined `generatePagination`
                    include 'pagination_function.php';

                    // Call the function to generate pagination HTML
                    echo generatePagination($current_page, $total_pages);
                }
                ?>
            </div>
        </div>
    </div>


</body>
<script>
    function checkall() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    }

    function uncheckall() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
</script>

</html>