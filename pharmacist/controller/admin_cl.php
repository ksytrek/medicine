<?php
include_once("../../config/config.inc.php");
include_once("../../config/connectdb.php");
session_start();

if (isset($_POST['key']) && $_POST['key'] == 'form_edit_admin') {

    $value = $_POST['data'];
    $id_admin = $value['id_ad'];
    $name_ad = $value['name_ad'];
    $username_ad = $value['username_ad'];
    $password_ad = $value['password_ad'];

    if(Database::query("UPDATE `admin` SET `username_ad` = '$username_ad', `password_ad` = '$password_ad', `name_ad` = '$name_ad' WHERE `admin`.`id_ad` = '$id_admin';")){
        echo "success";
    }else{
        echo "error";
    }

}