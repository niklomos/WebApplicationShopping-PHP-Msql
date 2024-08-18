<?php
require('config.php');
$items_per_page = 10;

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
    $sql = "SELECT * FROM employee WHERE id = '$search'OR level = '$search' OR  fullname LIKE '%$search%' OR  phone LIKE '%$search%'OR  username LIKE '%$search%' LIMIT $offset, $items_per_page";
} else {
    $sql = "SELECT * FROM employee ORDER BY id DESC LIMIT $offset, $items_per_page";
}

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
$order = $offset + 1;

if ($count == 0 && $current_page > 1) {
    $previous_page = $current_page - 1;
    header("Location: datasystem-manage-employee.php?page=$previous_page&search_input=$search");
    exit();
}

// Construct the total items query
if (!empty($search)) {
    $total_items_query = "SELECT COUNT(*) as total FROM employee WHERE id = '$search'OR level = '$search' OR  fullname LIKE '%$search%' OR  phone LIKE '%$search%'OR  username LIKE '%$search%' ";
} else {
    $total_items_query = "SELECT COUNT(*) as total FROM employee";
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
    <title>MANAGE-EMPLOYEE</title>

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
                        <h2 class="text-center text-light pt-2"><i class="fa-solid fa-list me-2"></i>MANAGE-EMPLOYEE</h2>
                        <div class="d-flex justify-content-between mb-2">
                            <div class=" justify-content-start ">
                                <button type="button" class="btn btn-danger  mt-1" onclick="submitForm();"><i class="fa-solid fa-xmark me-1"></i>ลบข้อมูล</button>
                                <button class="btn btn-primary  mt-1" onclick="checkall()"><i class="fa-solid fa-check me-1"></i>เลือกทั้งหมด</button>
                                <button class="btn btn-warning  mt-1" onclick="uncheckall()"><i class="fa-solid fa-circle-notch me-1"></i></i>ยกเลิก</button>
                            </div>
                            <div class="d-flex justify-content-end ">
                                <a href="datasystem-insert-employee.php" class="btn btn-success " style="border-width: 2px; "><i class="fa-solid fa-plus me-2 "></i>NEW </a>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-2">
                            <form class="input-group" action="" method="get">
                                <input type="text" class="form-control" placeholder="ค้นหา" aria-label="ค้นหา" aria-describedby="basic-addon1" name="search_input" value="<?php echo $search ?>">
                                <button type="submit" name="search" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <?php if ($count > 0) { ?>
                        <table class="table table-striped table-hover   ">
                            <thead class=" ">
                                <tr class="text-start ">
                                    <th class="col-1">ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อผู้ใช้</th>
                                    <th class="d-none">รหัสผ่าน</th>
                                    <th>ระดับ</th>
                                    <th class="col-1 text-center">Action</th>
                                    <th class="col-1 text-center ">Check</th>
                                </tr>
                            </thead>
                            <tbody class="text-start">
                                <?php while ($row = mysqli_fetch_object($result)) { ?>
                                    <?php
                                    $imageURL = 'images/' . $row->image;
                                    ?>
                                    <tr>
                                        <td><?php echo $order++ ?></td>
                                        <td><?php echo $row->fullname ?></td>
                                        <td><?php echo $row->username ?></td>
                                        <td class="d-none"><?php echo $row->password ?></td>
                                        <td><?php
                                            if ($row->level == 'E') {
                                                echo '<i class="fa-solid fa-user me-1 text-dark"></i>';
                                                echo 'พนักงาน';
                                            } elseif ($row->level == 'A') {
                                                echo '<i class="fa-solid fa-user-tie me-1 text-primary"></i>';
                                                echo 'ผู้ดูแลระบบ';
                                            } else {
                                                echo 'สถานะไม่ระบุ';
                                            } ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="#" class="text-danger me-3" onclick="confirmDelete(<?php echo $row->id ?>);">
                                                    <i class="fa-solid fa-delete-left"></i>
                                                </a>
                                                <a href="datasystem-edit-employee.php?id=<?php echo $row->id ?>&page=<?php echo $current_page ?>&search=<?php echo $search ?>" class="text-primary ">
                                                    <i class="fa-solid fa-pen-to-square "></i></a>
                                            </div>
                                        </td>
                                        <form action="multipledelete-manage-employee.php" method="POST" id="deleteForm">
                                            <td class="text-center ">
                                                <div class="form-check">
                                                    <input type="checkbox" name="idcheckbox[]" id="" class=" form-check-input b-button" value="<?php echo $row->id; ?>">
                                                </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'คุณต้องการลบข้อมูลหรือไม่?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0b5ed8',
            cancelButtonColor: '#dc3546',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "deletequerystring-manage-employee.php?idemp=" + id;
            }
        });
        return false; // ป้องกันการเปลี่ยนหน้าเว็บก่อนที่จะยืนยัน
    }
</script>

</html>