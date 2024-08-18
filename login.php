<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- เรียกใช้งานไฟล์ CSS ของ Bootstrap -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./style-user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text1 text-center">Login</h1>
                <!-- แบบฟอร์มสำหรับ Login -->
                <form action="" method="POST">
                    <div class="input-group mb-3 col-sm12">
                        <span class="input-group-text btn-color text-light ip" id="basic-addon1"><b>EMAIL</b></span>
                        <input type="email" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="email" style="height: 50px;" value="" required>
                    </div>

                    <div class="input-group mb-3 col-sm12 ">
                        <span class="input-group-text btn-color text-light ip " id="basic-addon1"><b>PASSWORD</b></span>
                        <input type="password" class="form-control ip" id="password" aria-label="name" aria-describedby="basic-addon1" name="password" style="height: 50px;" value="" required>
                        <button class="btn btn-light ip" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash "></i>
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm btn-lg ip rounded-pill" style="width:12rem">เข้าสู่ระบบ</button>
                        <!-- เพิ่มปุ่มสมัครสมาชิกที่นี่ -->
                        <button type="button" class="btn btn-success btn-sm btn-lg ip rounded-pill" onclick="window.location.href='register.php'" style="width:12rem">สมัครสมาชิก</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- เรียกใช้งานไฟล์ JavaScript ของ Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.querySelector('i').classList.toggle('bi-eye-slash');
            togglePassword.querySelector('i').classList.toggle('bi-eye');
        });
    </script>
</body>

</html>

<?php
// เรียกใช้ไฟล์ config.php เพื่อเชื่อมต่อกับฐานข้อมูล MySQL
include_once 'config.php';

// ตรวจสอบการส่งค่าผ่าน POST จากแบบฟอร์ม Login
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ตรวจสอบการตรงกันของข้อมูลที่ส่งมากับข้อมูลในฐานข้อมูล
    $query = "SELECT * FROM register WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // เข้าสู่ระบบสำเร็จ
        // สามารถทำการเก็บข้อมูลผู้ใช้ (เช่น ID) ใน Session หรือ Cookie ได้ตามความต้องการ

        // เริ่ม Session (หากยังไม่ได้เริ่ม)
        session_start();

        // เก็บ ID ผู้ใช้ใน Session
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];

        // เปลี่ยนหน้าไปยัง index.php
        header("Location: index.php");
        exit();
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "เข้าสู่ระบบไม่สำเร็จ",
                    text: "กรุณาลองใหม่อีกครั้ง",
                    icon: "warning"
                }).then(function() {
                    window.location = "login.php";
                });
            });
        </script>';
    }
}
?>