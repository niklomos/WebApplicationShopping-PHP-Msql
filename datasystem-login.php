<?php

include_once 'config.php';

// ตรวจสอบการส่งค่าผ่าน POST จากแบบฟอร์ม Login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบการตรงกันของข้อมูลที่ส่งมากับข้อมูลในฐานข้อมูล
    $query = "SELECT * FROM employee WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // เข้าสู่ระบบสำเร็จ
        // สามารถทำการเก็บข้อมูลผู้ใช้ (เช่น ID) ใน Session หรือ Cookie ได้ตามความต้องการ

        // เริ่ม Session (หากยังไม่ได้เริ่ม)
        session_start();

        // เก็บ ID ผู้ใช้ใน Session
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];

        // เปลี่ยนหน้าไปยัง index.php
        header("Location: datasystem.php");
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
                        window.location = "datasystem-login.php";
                    });
                });
            </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
     body{
         position:fixed;
         width:100%;
     }
 </style>
</head>

<body class="hold-transition login-page">



    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary " style="margin-top:auto;">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Shopping</b>Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="password" id="password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>



                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>


    </div>
    <!-- /.login-box -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->


</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>