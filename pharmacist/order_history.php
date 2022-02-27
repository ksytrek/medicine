<?php include("./navbar.php");

$date_sq = '';
$start_date = '';
$end_date = '';
if (isset($_GET['submit'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $date_sq = " WHERE  ord.dateTime_oh BETWEEN '$start_date' and '$end_date' ";
}

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>


<section class="pricing-table section" id="pricing">
    <div class="container">
        <h3>ประวัติการขาย</h3>
        <form action="" method="GET">
            <div class="form-group ">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="start_date" class="form-control" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                    </div>
                    <div class="col-md-2 text-center">
                        ถึง
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end_date" class="form-control" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date("Y-m-d"); ?>">

                    </div>
                    <div class="col-md-2 text-center">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">ค้นหา</button>
                    </div>
                </div>

            </div>
        </form>


        <div class="row">
            <div class="col-sm-12">
                <table id="tb_ordertl" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ผู้ขาย</th>
                            <th>ผู้ชื่อ</th>
                            <th>ราคารวม</th>
                            <th>วันที่ขาย</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php


                        $sql_ord = "SELECT * FROM `order_history` as ord 
                                    INNER JOIN member as mm ON mm.id_mem = ord.id_mem 
                                    INNER JOIN pharmacist as pha on pha.id_pma = ord.id_pma  
                                    $date_sq ORDER BY ord.dateTime_oh DESC";
                        $i = null;
                        foreach (Database::query($sql_ord) as $row_ord) :
                        ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row_ord['name_pma']; ?></td>
                                <td><?php echo $row_ord['name_mem']; ?></td>
                                <td><?php echo $row_ord['sum_pi']; ?></td>
                                <td><?php echo $row_ord['dateTime_oh']; ?></td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detli_<?php echo $row_ord['id_oh'] ?>">รายละเอียด</a>
                                    <a href="javascript:window.print()" class="btn btn-primary btn-sm" >พิมพ์</a>
                                    <button onclick="window.print()">Print this page</button>

                                    <a href="./export?id_oh=<?php echo Encode_valu::encode($row_ord['id_oh'],"id_oh")  ?>&id_pma=<?php echo Encode_valu::encode($row_ord['id_pma'],"id_pma") ?>" class="btn btn-info btn-sm">ใบเสร็จ</a>
                                </td>
                                <div id="detli_<?php echo $row_ord['id_oh'] ?>" class="modal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">รายละเอียดซื้อ - ขาย</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row" style="background-color: darkgray;">
                                                        <div class="col-sm">
                                                            <strong>ลำดับ</strong>
                                                        </div>
                                                        <div class="col-sm">
                                                            <strong>ชื่อยา</strong>
                                                        </div>
                                                        <div class="col-sm">
                                                            <strong>จำนวน</strong>

                                                        </div>
                                                        <div class="col-sm">
                                                            <strong>ราคา</strong>

                                                        </div>
                                                        <div class="col-sm">
                                                            <strong>ราคารวม</strong>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $swl = "SELECT * FROM `detail_history` as det INNER JOIN drug_information as dru ON det.id_drug = dru.id_drug WHERE det.id_oh = '{$row_ord['id_oh']}'";
                                                    $o = null;
                                                    foreach (Database::query($swl, PDO::FETCH_ASSOC) as $row) :
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <?php echo ++$o ?>
                                                            </div>
                                                            <div class="col-sm">
                                                                <?php echo $row['name_drug'] ?>
                                                            </div>
                                                            <div class="col-sm">
                                                                <?php echo $row['item'] ?>
                                                            </div>
                                                            <div class="col-sm">
                                                                <?php echo $row['price_drug'] ?>
                                                            </div>
                                                            <div class="col-sm">
                                                                <?php echo $row['price_drug'] *  $row['item'] ?>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
                                                <!-- <a href="javascript:void(0)" class="btn btn-info btn-sm">ใบเสร็จ</a> -->
                                                <!-- <button type="submit" class="btn btn-primary">เพิ่ม</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>

                        <?php
                        // SELECT * FROM `detail_history` as det INNER JOIN drug_information as dru ON det.id_drug = dru.id_drug WHERE det.id_oh = ''
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#tb_ordertl').DataTable({
            lengthMenu: [
                [10, 25, 50, 60, -1],
                [10, 25, 50, 60, "All"]
            ],
            language: {
                sProcessing: "กำลังดำเนินการ...",
                sLengthMenu: "แสดง_MENU_ แถว",
                sZeroRecords: "ไม่พบข้อมูล",
                sInfo: "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 แถว",
                sInfoFiltered: "(กรองข้อมูล _MAX_ ทุกแถว)",
                sInfoPostFix: "",
                sSearch: "ค้นหา:",
                sUrl: "",
                oPaginate: {
                    "sFirst": "เริ่มต้น",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "สุดท้าย"
                }
            },
            retrieve: true,
        });
        // alert('Example')
    });
    F
</script>
<?php include("./footer.php") ?>
