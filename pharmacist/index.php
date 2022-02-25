<?php include("./navbar.php") ?>

<!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css
https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css -->
<!-- https://code.jquery.com/jquery-3.6.0.min.js -->


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>

<script>
    $(document).ready(function() {
        var product = [];
        if (readCookie('product') == null) {

            createCookie("product", JSON.stringify(product));

        }
    });
    //  COOKie function 
    function createCookie(name, value, days = 1) { // date /1 วัน
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var name1 = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(name1) == 0) {
                return c.substring(name1.length, c.length);
            }
        }
        return null;
    }

    function removeCookie(name) {
        createCookie(name, "", -1);
    }

    function add_product(id_drug, name_drug, price_unit, num_item) {
        var product = [];
        var int_i = 0;

        product_new = {
            id_drug: id_drug,
            name_drug: name_drug,
            price_unit: price_unit,
            price_unit: price_unit,
            num_item: num_item
        };

        if (readCookie('product') == null) {
            createCookie("product", JSON.stringify(product));

            product.push(product_new);
            createCookie("product", JSON.stringify(product));
            update_product();

        } else {
            product = JSON.parse(readCookie('product')); // array type
            product.forEach(function(value, i) {
                if (value.id_drug == id_drug) {
                    int_i += 1;
                    product[i].num_item += num_item;
                }
            });

            if (int_i == 0) {

                product.push(product_new);
                createCookie("product", JSON.stringify(product));

                update_product();
            } else {
                createCookie("product", JSON.stringify(product));
                update_product();
            }

        }
        $("#" + num_item).val(1);
    }

    function update_product() {
        // var product = json.parse(readCookie('product'));
        var str_items = "";

        const json = readCookie('product');
        const product = JSON.parse(json);

        var sum_total = 0;

        $('#tb_shell').empty();
        // tb_mg_room.clear();
        product.forEach(function(value, index) {
            // alert(index);

            str_items += '<tr>' +
                '<td>' + value.name_drug + '</td>' +
                '<td>' + value.price_unit + '</td>' +
                '<td>' + value.num_item + '</td>' +
                '<td>' + value.num_item * value.price_unit + '</td>' +
                '</tr>';
            sum_total += value.num_item * value.price_unit;

        });
        // alert(product.length)
        if (product.length == 0 || product == null) {

            str_items += "<tr><td>ไม่พบรายการ</td><td></td><td></td><td></td></tr>";
        }
        $("#sum_total").html(sum_total)
        $('#tb_shell').html(str_items);
    }

    // add_product('1', 'ยา', '150', 6);
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
                        $.ajax({
                            url: "controller/add_product.php",
                            type: "POST",
                            data: {
                                key: "add_trnsale",
                                data : trnsale,
                                id_pma: "<?php echo $_SESSION["id"] ?>",
                                id_mem: id_mem
                            },
                            success: function(result, textStatus, jqXHR) {
                                console.log(result);
                                if (result == 'success') {
                                    removeCookie('product');
                                    alert("ขายสินค้าสำเร็จ")
                                    // location.reload();
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
                                <td class="text-center"><a href="javascript:add_product('<?php echo  $row_drug['id_drug']; ?>','<?php echo  $row_drug['name_drug']; ?>','<?php echo  $row_drug['price_drug']; ?>',1)">เพิ่ม</a></td>
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