<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./style-user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container ">
        <h1 class="text1 mt-3 text-center">SIGNUP</h1>
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="input-group mb-3 col-sm12">
                <span class="input-group-text btn-color text-light ip" id="basic-addon1"><b>USERNAME</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="username" style="height: 50px;" value="" required>
            </div>

            <div class="input-group mb-3 col-sm12">
                <span class="input-group-text btn-color text-light ip" id="basic-addon1"><b>EMAIL</b></span>
                <input type="email" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="email" style="height: 50px;" value="" required>
            </div>

            <!-- ช่องกรอกรหัสผ่าน -->
            <div class="input-group mb-3 col-sm12 ">
                <span class="input-group-text btn-color text-light ip " id="basic-addon1"><b>PASSWORD</b></span>
                <input type="password" class="form-control ip" id="password" aria-label="name" aria-describedby="basic-addon1" name="password" style="height: 50px;" value="" required>
                <button class="btn btn-light ip" type="button" id="togglePassword">
                    <i class="bi bi-eye-slash "></i>
                </button>
            </div>


            <!-- ช่องยืนยันรหัสผ่าน -->
            <div class="input-group mb-3 col-sm12 ">
                <span class="input-group-text btn-color text-light ip " id="basic-addon1"><b>CONFIRM_PASSWORD</b></span>
                <input type="password" class="form-control ip" id="con_password" aria-label="name" aria-describedby="basic-addon1" name="con_password" style="height: 50px;" value="" required>
                <button class="btn btn-light ipi" type="button" id="togglePassword2">
                    <i class="bi bi-eye-slash "></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary btn-sm ip rounded-pill" style="width:12rem">สมัครสมาชิก</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function สำหรับการ validate ฟอร์ม
        function validateForm() {
            
            var password = document.getElementById("password").value;
            var conPassword = document.getElementById("con_password").value;

            if (password !== conPassword) {
        Swal.fire({
            title: "รหัสผ่านไม่ตรงกัน",
            text: "กรุณากรอกข้อมูลให้ตรงกัน",
            icon: "error"
        });
        return false;
    }
    return true;
}
        // Function สำหรับแสดง/ซ่อนรหัสผ่าน
        function togglePassword(buttonId, inputId) {
            var passwordInput = document.getElementById(inputId);
            var buttonIcon = document.getElementById(buttonId).querySelector('i');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                buttonIcon.classList.remove("bi-eye-slash");
                buttonIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                buttonIcon.classList.remove("bi-eye");
                buttonIcon.classList.add("bi-eye-slash");
            }
        }

        // Event Listener สำหรับการคลิกปุ่มแสดง/ซ่อนรหัสผ่าน
        document.getElementById("togglePassword").addEventListener('click', function() {
            togglePassword("togglePassword", "password");
        });

        document.getElementById("togglePassword2").addEventListener('click', function() {
            togglePassword("togglePassword2", "con_password");
        });
    </script>

</body>

</html>

<?php
include_once 'config.php';
// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมาจากฟอร์ม
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO register(username, email, password) values ('$username', '$email', '$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "สมัครสมาชิกสำเร็จ",
                    text: "ยินดีตอนรับ",
                    icon: "success"
                }).then(function() {
                    window.location = "login.php";
                });
            });
        </script>';
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "สมัครสมาชิกไม่สำเร็จ",
                    text: "' . mysqli_error($conn) . '",
                    icon: "warning"
                }).then(function() {
                    window.location = "register.php";
                });
            });
        </script>';
    }
}
?>