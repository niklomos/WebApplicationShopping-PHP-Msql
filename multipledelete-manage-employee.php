<?php 
require('config.php');
$id_array=$_POST["idcheckbox"];
$multiple_id=implode(",",$id_array);


$sql_select = "SELECT level FROM employee WHERE id IN ($multiple_id)";
$result = mysqli_query($conn, $sql_select);

$level_array=[];
while ($row = mysqli_fetch_object($result)) {
    $level_array[] = $row->level;
}

$checklevel = true;
foreach($level_array as $levels){
    if ( trim( $levels) == 'A') {
        $checklevel = false;
        break 1; // Exit both loops if a match is found
    }
}

if(!$checklevel){
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "ไม่สามารถลบผู้ดูแลระบบได้ ",
            text: "กรุณาเปลี่ยนสถานะของแอคเคาท์ก่อน",
            icon: "warning",
            confirmButtonText: "ตกลง"
          }).then(function() {
            window.location = "' . $_SERVER['HTTP_REFERER'] . '";
          });
        });
      </script>';
    exit(0);
}else{
    $sql="DELETE FROM employee WHERE id in ($multiple_id)";
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