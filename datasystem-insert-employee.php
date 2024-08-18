<?php
// Create database connection
include_once 'config.php';

// Initialize message variable
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

  $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $level = mysqli_real_escape_string($conn, $_POST['level']);

  $sql = "INSERT INTO employee (fullname,phone,username,password,level) VALUES ('$fullname','$phone','$username','$password','$level')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "เพิ่มข้อมูลสำเร็จ",
            icon: "success"
          }).then(function(result) {
            window.location = "datasystem-manage-employee.php";
          });
        });
      </script>';
  } else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          title: "เพิ่มข้อมูลไม่สำเร็จ",
          icon: "error"
        }).then(function(result) {
          window.location = "datasystem-insert-employee.php";
        });
      });
    </script>';    
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INSERT-EMPLOYEE</title>
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
            <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-plus me-2"></i>INSERT-EMPLOYEE</h2>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="size" value="1000000" class="form-control">
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>ชื่อ-นามสกุล</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="fullname" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>เบอร์โทร</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="phone" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>ชื่อผู้ใช้</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="username" " value="" required>
        </div>
        <div class=" input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>รหัสผ่าน</b></span>
                <input type="password" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="password" value="" required>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input b-button" type="radio" role="switch" id="flexSwitchCheckEnabled" name="level" value="E">
                <label class="form-check-label" for="flexSwitchCheckEnabled">พนักงาน</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input b-button" type="radio" role="switch" id="flexSwitchCheckDisabled" name="level" value="A" onClick="confirmLevel()">
                <label class="form-check-label" for="flexSwitchCheckDisabled">ผู้ดูแลระบบ</label>
              </div>
              <button type="submit" name="upload" class="btn btn-primary mt-3">
                <i class="fas fa-plus"></i> เพิ่มข้อมูล
              </button>
          </div>
        </div>
      </div>
    </div>


    </form>
  </div>
</body>

</html>

<script>
  // Function to show SweetAlert confirmation
  function confirmLevel() {
    Swal.fire({
      icon: 'question',
      title: 'Confirm',
      text: 'คุณต้องการกำหนดสิทธิเป็นผู้ดูแลระบบใช่ไหม?',
      showCancelButton: true,
      confirmButtonText: 'ใช่',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        // หา radio button ที่มี id เป็น "PosPermissionsManage2" และทำการตรวจสอบ
        document.getElementById("flexSwitchCheckDisabled").checked = true;
      } else {
        document.getElementById("flexSwitchCheckEnabled").checked = true;
      }
    });
  }
</script>