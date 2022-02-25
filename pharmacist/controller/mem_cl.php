<?php
include_once("../../config/config.inc.php");
include_once("../../config/connectdb.php");
session_start();

if (isset($_POST['key']) && $_POST['key'] == 'form_add_mem') {

    $value = $_POST['data'];

    $name_mem = $value['name_mem'];
    $drug_se = $value['drug_se'];
    $sql_insert_member = "INSERT INTO `member` (`id_mem`, `name_mem`) VALUES (NULL, 'ริส');";

    try {
        if(Database::query($sql_insert_member)){
            $id_mem =  Database::query("SELECT MAX(id_mem) as max FROM `member`",PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['max'];
            
            foreach($drug_se as $row_se){
                $sql_in = "INSERT INTO `drug_allergy` (`id_allgy`, `id_drug`, `id_mem`) VALUES (NULL, '{$row_se}', '$id_mem');";
                Database::query($sql_in);
            }
            echo "success";
        }else{
            echo "error";
        }
    } catch (Exception  $e) {
        echo "Error: " . $e->getMessage();
    }


}

if (isset($_POST['key']) && $_POST['key'] == 'delete_mem') {

    $id_mem = $_POST['id'];

    $drug_allergy = "SELECT * FROM `drug_allergy` WHERE id_mem = '$id_mem'";

    try {
        foreach(Database::query($drug_allergy) as $row_al){
            Database::query("DELETE FROM `drug_allergy` WHERE `drug_allergy`.`id_allgy` = '{$row_al['id_allgy']}'");
        }
        Database::query("DELETE FROM `member` WHERE `member`.`id_mem` = '$id_mem'");
        echo "success";
    } catch (Exception  $e) {
        echo "Error: " . $e->getMessage();
    }


}
if(isset($_POST['key']) && $_POST['key'] == 'form_edit_drug'){
    $id_mem = $_POST['id_mem'];
    $name = $_POST['name'];

    $sql = "UPDATE `member` SET `name_mem` = '$name' WHERE `member`.`id_mem` = '$id_mem';";

    if(Database::query($sql)){
        echo "success";
    }else{
        echo "error";
    }
}