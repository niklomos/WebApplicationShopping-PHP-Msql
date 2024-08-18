<?php 
require('config.php');
$id_array=$_POST["idcheckbox"];
$mutiple_id=implode(",",$id_array);

$sql="DELETE FROM report_allorder WHERE id in ($mutiple_id)";
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

?>