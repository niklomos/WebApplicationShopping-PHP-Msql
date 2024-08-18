<?php
// เริ่ม Session (หากยังไม่ได้เริ่ม)
session_start();

// ล้างข้อมูล Session ทั้งหมด
session_unset($_SESSION['admin_id']);


// เด้งไปยังหน้า login.php
header("Location: datasystem-login.php");
exit();
?>
