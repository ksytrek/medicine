<?php
include_once("../../config/config.inc.php");
include_once("../../config/connectdb.php");
session_start();

if (isset($_POST['key']) && $_POST['key'] == 'form_add_drug') {

    $value = $_POST['data'];

    $name_drug = $value['name_drug'];
    $size_drug = $value['size_drug'];
    $price_drug = $value['price_drug'];
    $stock = $value['stock'];
    $prope_durg = $value['prope_durg'];
    $expi_date_durg = $value['expi_date_durg'];

    $sql_insert_drug = "INSERT INTO `drug_information` (`id_drug`, `name_drug`, `size_drug`, `price_drug`, `stock`, `prope_durg`, `expi_date_durg`, `status`) VALUES 
                                            (NULL, '$name_drug', '$size_drug', '$price_drug', '$stock', '$prope_durg', '$expi_date_durg', '1');";


    try {
        if(Database::query($sql_insert_drug)){
            echo "success";
        }else{
            echo "error";
        }
    } catch (Exception  $e) {
        echo "Error: " . $e->getMessage();
    }


}

if (isset($_POST['key']) && $_POST['key'] == 'form_edit_drug') {

    $value = $_POST['data'];
    $id_drug = $value['id_drug'];
    $name_drug = $value['name_drug'];
    $size_drug = $value['size_drug'];
    $price_drug = $value['price_drug'];
    $stock = $value['stock'];
    $prope_durg = $value['prope_durg'];
    $expi_date_durg = $value['expi_date_durg'];

    $sql_udate_drug = "UPDATE `drug_information` SET 
                            `name_drug` = '$name_drug', 
                            `size_drug` = '$size_drug', 
                            `price_drug` = '$price_drug', 
                            `stock` = '$stock', 
                            `prope_durg` = '$prope_durg', 
                            `expi_date_durg` = '$expi_date_durg' 
                            WHERE `drug_information`.`id_drug` = '$id_drug';";
    try {
        if(Database::query($sql_udate_drug)){
            echo "success";
        }else{
            echo "error";
        }
    } catch (Exception  $e) {
        echo "Error: " . $e->getMessage();
    }


}

if (isset($_POST['key']) && $_POST['key'] == 'delete_drug'){
    $id_drug = $_POST['id'];

    $sql_delete_drug = "DELETE FROM `drug_information` WHERE `drug_information`.`id_drug` = '$id_drug'";

    try {
        if(Database::query($sql_delete_drug)){
            echo "success";
        }else{
            echo "error";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}
