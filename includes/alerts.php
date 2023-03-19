<?php
echo "<script>";
if(isset($_SESSION['success'])){
    echo "toastr.success('".$_SESSION['success']."');";
    unset($_SESSION['success']);
}elseif(isset($_SESSION['error'])){
    echo "toastr.error('".$_SESSION['error']."');";
    unset($_SESSION['error']);
}
echo "</script>";
?>