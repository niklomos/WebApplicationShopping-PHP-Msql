<?php
// เริ่ม Session (หากยังไม่ได้เริ่ม)
session_start();

// ลบเฉพาะค่าของ $_SESSION['user_id']
unset($_SESSION['user_id']);

// เด้งไปยังหน้า login.php
header("Location: login.php");
exit();
?>
