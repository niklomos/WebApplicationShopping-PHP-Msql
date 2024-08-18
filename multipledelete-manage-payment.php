<?php 
require('config.php');
$id_array=$_POST["idcheckbox"];
$multiple_id=implode(",",$id_array);


$sql_select = "SELECT status FROM payment WHERE id IN ($multiple_id)";
$result = mysqli_query($conn, $sql_select);

$level_array=[];
while ($row = mysqli_fetch_object($result)) {
    $status_array[] = $row->status;
}

$checkstatus = true;
foreach($status_array as $status){
    if ( trim( $status) == 'enabled') {
        $checkstatus = false;
        break 1; // Exit both loops if a match is found
    }
}

if(!$checkstatus){
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "ไม่สามารถลบบัญชีได้ ",
            text: "มีบางบัญชีเปิดใช้งานอยู่",
            icon: "warning",
            confirmButtonText: "ตกลง"
          }).then(function() {
            window.location = "' . $_SERVER['HTTP_REFERER'] . '";
          });
        });
      </script>';
    exit(0);
}else{
    $sql="DELETE FROM payment WHERE id in ($multiple_id)";
    $result=mysqli_query($conn,$sql);
    
    if($result)
    {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit(0);
    }
    else
    {
        echo mysqli_error($conn);
    }
}



?>