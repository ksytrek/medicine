<?php
include("./navbar.php");


?>

<!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css
https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css -->
<!-- https://code.jquery.com/jquery-3.6.0.min.js -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
if (isset($key) && $key == 'pharmacist') :
?>

    <div id="print"></div>
    <script>
        function printDiv(id_oh, id_pma) {
            var divContents = document.getElementById("print").innerHTML;
            var a = window.open('export.php?id_oh=' + id_oh + '&id_pma=' + id_pma, "", "height='500', width='500'");
            // , '', "height='100%', width='100%'"
            // a.document.write('<html>');
            // a.document.write('<body > <h1>Div contents are <br>');
            // a.document.write(divContents);
            // a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    </script>
    <section class="pricing-table section" id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>รายการซื้อยา</h4>

                    <div class="form-group">
                        <label class="control-label">ลูกค้า : </label>
                        <select id="select_mem" class="form-control">
                            <!-- <option value="1" select>ไม่ระบุตัวตน</option> -->
                            <?php
                            $sql_mem = "SELECT * FROM `member`";
                            foreach (Database::query($sql_mem, PDO::FETCH_ASSOC) as $row_mem) :
                            ?>
                                <option value="<?php echo $row_mem['id_mem'] ?>"><?php echo $row_mem['name_mem'] ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!-- <th scope="col">ลำดับ</th> -->
                                <th scope="col">ชื่อยา</th>
                                <th scope="col">ราคา</th>
                                <th scope="col">จำนวน</th>
                                <th scope="col">รวม</th>
                            </tr>
                        </thead>
                        <tbody id="tb_shell">
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div style="text-align: right;">
                                รวม &nbsp;&nbsp;&nbsp; <strong id="sum_total"> </strong> &nbsp;&nbsp;&nbsp; บาท
                                <br>
                                <button onclick="sell()" class="btn btn-primary btn-sm">ขาย</button>
                            </div>

                        </div>
                    </div>
                    <script>
                        function sell() {
                            id_mem = $("#select_mem").val();
                            id_pma = "<?php echo $_SESSION["id"] ?>"

                            const json = readCookie('product');
                            const product = JSON.parse(json);
                            const trnsale = JSON.stringify(product)
                            // console.log(trnsale);
                            if (product == null || product == '') {
                                return alert('กรุณาเพิ่มสินค้า')
                            }
                            $.ajax({
                                url: "controller/add_product.php",
                                type: "POST",
                                data: {
                                    key: "add_trnsale",
                                    data: trnsale,
                                    id_pma: "<?php echo $_SESSION["id"] ?>",
                                    id_mem: id_mem
                                },
                                success: function(result, textStatus, jqXHR) {
                                    // console.log(result);
                                    if (result == 'success') {
                                        removeCookie('product');
                                        alert("ขายสินค้าสำเร็จ")
                                        <?php
                                        $sql_Max = "SELECT MAX(id_oh) as max_s FROM `order_history`";
                                        $max_id = Database::query($sql_Max,PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->max_s;
                                        $sql_ord_D = "SELECT * FROM `order_history` WHERE id_oh = '$max_id'";
                                        $id_pma_d = Database::query($sql_ord_D,PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->id_pma;
                                        ?>
                                        printDiv(<?php echo $max_id ?>,<?php echo $id_pma_d ?>)

                                        location.reload();
                                        update_product();
                                    } else if (result == 'error') {
                                        alert('ระบบตรวจพบข้อผิดพลาดบางอย่าง')
                                    } else {
                                        alert(result);
                                    }
                                },
                                error: function(result, textStatus, jqXHR) {
                                    alert('ระบบตรวจพบข้อผิดพลาดบางอย่าง\n this Server');
                                }
                            });

                            // alert(id_pma);
                        }
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h4>รายการยาในคลัง</h4>
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ชื่อยา</th>
                                <th>คุณสมบัติ</th>
                                <th>ขนาดยา</th>
                                <th>ราคา</th>
                                <th>วันหมดอายุ</th>
                                <th>คงเหลือ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql_drug = "SELECT * FROM `drug_information`";
                            foreach (Database::query($sql_drug) as $row_drug) :
                            ?>
                                <tr>
                                    <td><?php echo  $row_drug['name_drug']; ?></td>
                                    <td><?php echo  $row_drug['prope_durg']; ?></td>
                                    <td><?php echo  $row_drug['size_drug']; ?></td>
                                    <td><?php echo  $row_drug['price_drug']; ?></td>
                                    <td><?php echo  $row_drug['expi_date_durg']; ?></td>
                                    <td><?php echo  $row_drug['stock']; ?></td>
                                    <td class="text-center"><a href="javascript:add_product('<?php echo  $row_drug['id_drug']; ?>','<?php echo  $row_drug['name_drug']; ?>','<?php echo  $row_drug['price_drug']; ?>',1,'<?php echo  $row_drug['stock']; ?>')">เพิ่ม</a></td>
                                </tr>

                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

<?php
elseif (isset($key) && $key == 'admin') :

    $sql_or = "SELECT SUM(sum_pi) as sum FROM `order_history`;";
    $sql_mem = "SELECT COUNT(id_mem) as count FROM `member`;";
    $sql_pma = "SELECT COUNT(id_pma) as count FROM `pharmacist`;";
    $sql_a = "SELECT COUNT(id_drug) as count FROM `drug_information`;";
?>

    <section class="pricing-table section" id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4>Dashboard</h4>
                </div>
            </div>
            <div class="row">


                <div class="col-sm bg-primary">
                    <div class="card">
                        <div class="card-body">
                            ยอดขายรามทั้งหมด : <?php echo Database::query($sql_or, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['sum']; ?> บาท
                        </div>
                    </div>
                </div>
                <div class="col-sm bg-warning">
                    <div class="card">
                        <div class="card-body">
                            จำนวนสมาชิก : <?php echo Database::query($sql_mem, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['count']; ?> ค้น
                        </div>
                    </div>
                </div>
                <div class="col-sm bg-success">
                    <div class="card">
                        <div class="card-body">
                            จำนวนเภสัช : <?php echo Database::query($sql_pma, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['count']; ?> ค้น
                        </div>
                    </div>
                </div>
                <div class="col-sm bg-success">
                    <div class="card">
                        <div class="card-body">
                            จำนวนยา : <?php echo Database::query($sql_a, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_ASSOC)['count']; ?> ชนิด
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <canvas id="myChart" width="100%" height="40px"></canvas>
                <script>
                    var itm = [];
                    var label_p = [];
                    <?php
                    $sql_drug_ = "SELECT * FROM `drug_information`";
                    foreach (Database::query($sql_drug_, PDO::FETCH_ASSOC) as $row_d) :
                    ?>
                        label_p.push('<?php echo $row_d['name_drug'] ?>');
                    <?php endforeach;
                    foreach (Database::query($sql_drug_, PDO::FETCH_ASSOC) as $row_r) :
                        $item = 0;
                        foreach (Database::query("SELECT * FROM `detail_history` WHERE id_drug = '{$row_r['id_drug']}'", PDO::FETCH_ASSOC) as $row_de) :
                            $item += $row_de['item'];
                        endforeach;
                    ?>
                        itm.push('<?php echo $item ?>');
                    <?php

                    endforeach; ?>

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: label_p,
                            datasets: [{
                                label: [],
                                data: itm,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>

            </div>
        </div>
    </section>

<?php
endif;
?>



<script>
    $(document).ready(function() {
        $('#example').DataTable({
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
        update_product();
        // alert('Example')
    });
</script>


<?php
include("./footer.php")
?>