<?php
include_once("../../config/config.inc.php");
include_once("../../config/connectdb.php");
session_start();

if (isset($_POST['key']) && $_POST['key'] == 'add_trnsale') {

    $id_pma = $_POST['id_pma'];
    $id_mem = $_POST['id_mem'];

    $value = json_decode($_POST['data']);

    $sum_total = 0;
    foreach ($value as $key => $val) {
        // print_r($val->price_unit);
        
        $sum_total += $val->num_item * $val->price_unit;
        // echo $sum_total;
    }

    $sql_in_order = "INSERT INTO `order_history` (`id_oh`, `dateTime_oh`, `id_pma`, `id_mem`, `sum_pi`) VALUES (NULL, current_timestamp(), '$id_mem', '$id_mem', '$sum_total');";

    try {
        if(Database::query($sql_in_order)){
            $id_order =  Database::query("SELECT MAX(id_oh) as max FROM `order_history`",PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['max'];
            
            foreach ($value as $key => $val) {
                // print_r($val->price_unit);
                $sql_insert = "INSERT INTO `detail_history` (`id_detail_his`, `id_drug`, `item`, `id_oh`) VALUES (NULL, '{$val->id_drug}', '{$val->num_item}', '$id_order');";
                Database::query($sql_insert);
            }
        }
        echo "success";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage;
    }


}
