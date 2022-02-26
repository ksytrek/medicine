<?php
include_once("../../config/config.inc.php");
include_once("../../config/connectdb.php");
session_start();

if (isset($_POST['key']) && $_POST['key'] == 'form_add_pma') {

    $value = $_POST['data'];

    $name_pma = $value['name_pma'];
    $username_pma = $value['username_pma'];
    $password_pma = $value['password_pma'];
    $sql_insert_pmaber = "INSERT INTO `pharmacist` (`id_pma`, `name_pma`,`username_pma`,`password_pma`) VALUES (NULL, '$name_pma','$username_pma','$password_pma');";
    $row_c = null;
    $row_c = Database::query("SELECT * FROM `pharmacist` WHERE username_pma = '$username_pma' ", PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC);
    // echo isset($row_c) && $row_c == null;
    if (isset($row_c) && $row_c == null) {
        try {
            if (Database::query($sql_insert_pmaber)) {
                echo "success";
            } else {
                echo "error";
            }
        } catch (Exception  $e) {
            echo "Error: " . $e->getMessage();
        }
    }else {
        echo "ตรวจพบ Username มีอยู่ในระบบ";
    }
}

if (isset($_POST['key']) && $_POST['key'] == 'delete_pma') {

    $id_pma = $_POST['id'];

    try {
        Database::query("DELETE FROM `pharmacist` WHERE `pharmacist`.`id_pma` = '$id_pma'");
        echo "success";
    } catch (Exception  $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_POST['key']) && $_POST['key'] == 'form_edit_pma') {
    $id_pma = $_POST['id_pma'];
    $name_pma = $_POST['name_pma'];
    $username_pma = $_POST['username_pma'];
    $password_pma = $_POST['password_pma'];

    $sql = "UPDATE `pharmacist` SET 
                `username_pma` = '$username_pma', `password_pma` = '$password_pma', `name_pma` = '$name_pma'
            WHERE `id_pma` = '$id_pma';";

    if (Database::query($sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
