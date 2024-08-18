<?php
require('config.php');
session_start();

$items_per_page = 5;

// Get the current page number from the query string, default to page 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $items_per_page;

// Initialize $search variable
$search = '';

// Check if search input is provided
if (isset($_GET['search_input'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search_input']);
}

// Construct the SQL query based on search input
if (!empty($search)) {
    $sql = "SELECT * FROM orders_cart WHERE id = '$search' OR order_product LIKE '%$search%'OR order_number LIKE '%$search%' OR fullname LIKE '%$search%'OR phone LIKE '%$search%' LIMIT $offset, $items_per_page";
} else {
    $sql = "SELECT * FROM orders_cart ORDER BY id ASC LIMIT $offset, $items_per_page";
}

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$order = $offset + 1;

if ($count == 0 && $current_page > 1) {
    $previous_page = $current_page - 1;
    header("Location: datasystem-show-order-cart.php?page=$previous_page&search_input=$search");
    exit();
}

// Construct the total items query
if (!empty($search)) {
    $total_items_query = "SELECT COUNT(*) as total FROM orders_cart WHERE id = '$search' OR order_product LIKE '%$search%'OR order_number LIKE '%$search%' OR fullname LIKE '%$search%'OR phone LIKE '%$search%'";
} else {
    $total_items_query = "SELECT COUNT(*) as total FROM orders_cart ";
}

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
    <title>SHOW-ORDER-CART</title>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

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
        <div class="content-wrapper">
            <div class="container pt-3">
                <div class="card ">
                    <div class="card-header pb-3" style="background-color:#2C3E50">
                        <h2 class="text-center text-light pt-2 pb-2"><i class="fa-solid fa-cart-plus me-2"></i>ORDERS-CART</h2>
                        <div class="d-flex mb-2">
                            <form class="input-group" action="" method="get">
                                <input type="text" class="form-control" placeholder="ค้นหา" aria-label="ค้นหา" aria-describedby="basic-addon1" name="search_input" value="<?php echo $search ?>">
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
                                        <th class="text-center">เลขคำสั่งซื้อ</th>
                                        <th>รายการสินค้า</th>
                                        <th>จำนวน</th>
                                        <th class="d-none">ราคา</th>
                                        <th>ราคารวม</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th class="text-center">สลิป</th>
                                        <th class="text-center">เลขพัสดุ</th>



                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    <?php while ($row = mysqli_fetch_object($result)) { ?>
                                        <?php
                                        $imageURL = 'slip/' . $row->slip_image;
                                        ?>
                                        <?php
                                        // ใช้ substr() เพื่อตัดเครื่องหมาย ',' ตัวสุดท้ายออก
                                        // $last_comma_pos_price = strrpos($row->order_price, ',');
                                        // if ($last_comma_pos_price !== false) {
                                        //     $order_price = substr($row->order_price, 0, $last_comma_pos_price);
                                        // } else {
                                        //     $order_price = $row->order_price;
                                        // }
                                        ?>

                                        <tr>
                                            <td><?php echo $order++ ?></td>
                                            <td class="text-center"><?php echo $row->order_number ?></td>
                                            <td><?php echo $row->order_product ?></td>
                                            <td><?php echo  $row->order_quantity ?></td>
                                            <td class="d-none" ><?php echo $row->order_price ?></td>
                                            <td><?php echo number_format($row->total_price, 2) ?></td>
                                            <td><?php echo $row->fullname ?></td>


                                            <td class="text-center" width="80px"><img src="slip/<?php echo $row->slip_image ?>" alt="" width="100%"></td>

                                            <td class="text-center">
                                                <a href="datasystem-edit-delivery2.php?id=<?php echo $row->id ?>&page=<?php echo $current_page ?>&search=<?php echo $search ?>" class="text-primary">
                                                    <i class="fa-solid fa-truck-fast"></i></a>
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
                if ($total_items > $items_per_page) {
                    include_once 'pagination_function.php'; // เปลี่ยนชื่อไฟล์เป็นชื่อที่คุณเก็บฟังก์ชัน generatePagination ไว้
                    echo generatePagination($current_page, $total_pages, $search);
                }
                ?>

                </form>

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
<script>
    function submitForm() {
        document.getElementById('deleteForm').submit();
    }
</script>

</html>