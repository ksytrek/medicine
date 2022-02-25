<?php

require_once("../config/config.inc.php");
require_once("../config/connectdb.php");

session_start();

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rw_pha = null;
    $sql_pha = "SELECT * FROM `pharmacist` WHERE username_pma = '$username' AND password_pma = '$password'";
    $rw_pha = Database::query($sql_pha,PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);

    // && $rw_pha['username_pma'] == $username && $rw_pha['password_pma'] == $password
    if(isset($rw_pha) && $rw_pha != null) {
        $_SESSION['key'] = $rw_pha['status'];
        $_SESSION['id'] = $rw_pha['id_pma'];
        echo "<script> 
                alert('เข้าสู่ระบบสำเร็จ') ;
                location.assign('../pharmacist/index');
            </script>";
    }else{
        $sql_ad = "SELECT * FROM `admin` WHERE username_ad = '$username' AND password_ad = '$password'";
        $rw_ad = Database::query($sql_ad,PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);

        if(isset($rw_ad) && $rw_ad != null){
            $_SESSION['key'] = $rw_ad['status'];
            $_SESSION['id'] = $rw_ad['id_ad'];
            echo "<script> 
                    alert('เข้าสู่ระบบสำเร็จ') ;
                    location.assign('../admin/index');
                </script>";
        }else{
            // echo "FETCH_ASSOC";
            session_destroy();
            echo "<script> 
                    alert('กรุณาตรวจสอบ User และ Password ใหม่') ;
                    location.assign('../index');
                </script>";
            
        }
    }
}
