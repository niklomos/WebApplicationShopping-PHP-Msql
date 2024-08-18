<?php
require('config.php');
$id = $_GET["id"];
$page = $_GET["page"];
$search = $_GET["search"];

$sql = "SELECT * FROM employee WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // Update the record in the database
    $update_sql = "UPDATE employee SET fullname ='$fullname', phone ='$phone', username ='$username', password ='$password', level ='$level'WHERE id=$id";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลสำเร็จ",
                icon: "success"
              }).then(function() {
                if ("' . $search . '" !== "") {
                    window.location = "datasystem-manage-employee.php?search_input=' . $search . '&page=' . $page . '";
                } else {
                    window.location = "datasystem-manage-employee.php?page=' . $page . '&search_input=' . $search . '";
                }
              });
            });
          </script>';;
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลไม่สำเร็จ",
                icon: "error"
              }).then(function() {
                window.location = "datasystem-edit-employee.php";
              });
            });
          </script>';;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEDIT-EMPLOYEE</title>

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
                    <div class="card-header " style="background-color:#2C3E50">
                        <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-pen-to-square  me-2"></i>EDIT-EMPLOYEE</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="input-group mb-3 d-none">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text text-dark ip bg-warning">ID</span>
                                </div>
                                <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" class="form-control  ip">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อ-นามสกุล</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="fullname" aria-describedby="basic-addon1" name="fullname" value="<?php echo $row['fullname']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เบอร์โทร</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="phone" aria-describedby="basic-addon1" name="phone" value="<?php echo $row['phone']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อผู้ใช้</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="username" aria-describedby="basic-addon1" name="username" value="<?php echo $row['username']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>รหัสผ่าน</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="password" aria-describedby="basic-addon1" name="password" value="<?php echo $row['password']; ?>">
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input ip" type="radio" role="switch" id="flexSwitchCheckEnabled" name="level" value="E" <?php if ($row['level'] == 'E') {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="flexSwitchCheckEnabled">พนักงาน</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input ip" type="radio" role="switch" id="flexSwitchCheckDisabled" name="level" value="A" <?php if ($row['level'] == 'A') {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="flexSwitchCheckDisabled">ผู้ดูแลระบบ</label>
                            </div>

                            <button type="submit" class="my-3 btn btn-primary " name="update">
                                <i class="fa-solid fa-pen-to-square me-1"></i>
                                อัปเดตข้อมูล</button>
                            <a href="datasystem-manage-employee.php" target="" class="my-2 btn btn-danger "><i class="fa-solid fa-circle-notch me-1"></i></i>ยกเลิก</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>