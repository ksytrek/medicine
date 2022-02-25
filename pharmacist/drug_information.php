<?php include "./navbar.php" ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>



<section class="pricing-table section" id="pricing">
    <div class="container">
        <div class="row">
            <h3>ข้อมูลยา</h3>
            <div class="col-sm-12">
                <table id="tb_drug" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อยา</th>
                            <th>คุณสมบัติ</th>
                            <th>ขนาดยา</th>
                            <th>ราคา</th>
                            <th>วันหมดอายุ</th>
                            <th>คงเหลือ</th>
                            <th class="text-center"><a href="javascript:void(0)" onclick="" data-toggle="modal" data-target="#add_drug">เพิ่ม</a></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_drug = "SELECT * FROM `drug_information`";
                        $i = null;
                        foreach (Database::query($sql_drug) as $row_drug) :
                        ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row_drug['name_drug']; ?></td>
                                <td><?php echo $row_drug['prope_durg']; ?></td>
                                <td><?php echo $row_drug['size_drug']; ?></td>
                                <td><?php echo $row_drug['price_drug']; ?></td>
                                <td><?php echo $row_drug['expi_date_durg']; ?></td>
                                <td><?php echo $row_drug['stock']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#drut_<?php echo $row_drug['id_drug']; ?>">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_drug(<?php echo $row_drug['id_drug']; ?>)">Delete</button>
                                </td>
                            </tr>
                            <div id="drut_<?php echo $row_drug['id_drug']; ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">แก้ไขข้อมูลยา</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form_edit_drug_<?php echo $row_drug['id_drug']; ?>" action="javascript:update_drug(<?php echo $row_drug['id_drug']; ?>)" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_drug" value="<?php echo $row_drug['id_drug']; ?>">
                                                <div class="form-group">
                                                    <label class="control-label">ชื่อยา</label>
                                                    <input type="text" class="form-control" placeholder="ชื่อยา" name="name_drug" value="<?php echo $row_drug['name_drug']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">ขนาดยา</label>
                                                    <input type="text" class="form-control" placeholder="ขนาดยา" name="size_drug" value="<?php echo $row_drug['size_drug']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">คุณสมบัติ</label>
                                                    <input type="text" class="form-control" placeholder="คุณสมบัติ" name="prope_durg" value="<?php echo $row_drug['prope_durg']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">ราคา</label>
                                                    <input type="number" class="form-control" min="0" placeholder="ราคา" name="price_drug" value="<?php echo $row_drug['price_drug']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">คงเหลือ</label>
                                                    <input type="number" class="form-control" min="0" placeholder="คงเหลือ" name="stock" value="<?php echo $row_drug['stock']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">วันหมดอายุ</label>
                                                    <input type="date" class="form-control" placeholder="วันหมดอายุ" name="expi_date_durg" value="<?php echo $row_drug['expi_date_durg']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary">เพิ่ม</button>
                                            </div>
                                        </form>
                                        <script>

                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div id="add_drug" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มยา</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:update_drug(id)" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">ชื่อยา</label>
                        <input type="text" class="form-control" placeholder="ชื่อยา" name="name_drug">
                    </div>
                    <div class="form-group">
                        <label class="control-label">ขนาดยา</label>
                        <input type="text" class="form-control" placeholder="ขนาดยา" name="size_drug">
                    </div>
                    <div class="form-group">
                        <label class="control-label">คุณสมบัติ</label>
                        <input type="text" class="form-control" placeholder="คุณสมบัติ" name="prope_durg">
                    </div>
                    <div class="form-group">
                        <label class="control-label">ราคา</label>
                        <input type="number" class="form-control" min="0" placeholder="ราคา" name="price_drug">
                    </div>
                    <div class="form-group">
                        <label class="control-label">คงเหลือ</label>
                        <input type="number" class="form-control" min="0" placeholder="คงเหลือ" name="stock">
                    </div>
                    <div class="form-group">
                        <label class="control-label">วันหมดอายุ</label>
                        <input type="date" class="form-control" placeholder="วันหมดอายุ" name="expi_date_durg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">เพิ่ม</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tb_drug').DataTable({
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

    $("#form_add_drug").submit(function() {
        var $inputs = $("#form_add_drug :input");
        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });

        $.ajax({
            url: "./controller/form_drug.php",
            type: "POST",
            data: {
                key: "form_add_drug",
                data: values
            },
            success: function(result, textStatus, jqXHR) {
                console.log(result);
                if (result == "success") {
                    alert(result + " : เพิ่มยาสำเร็จ");
                    location.reload();
                } else {
                    alert(result + " : ตรวจพบข้อผิดพลาด");
                }
            },
            error: function(result, textStatus, jqXHR) {
                alert(result + " : ตรวจพบข้อผิดพลาด");
            }
        });
    });

    function update_drug(id) {
        const form = document.getElementById('form_edit_drug_' + id);
        const name = form.elements['name_drug'].value;

        var values = {
            'id_drug': form.elements['id_drug'].value,
            'name_drug': form.elements['name_drug'].value,
            'size_drug': form.elements['size_drug'].value,
            'price_drug': form.elements['price_drug'].value,
            'stock': form.elements['stock'].value,
            'prope_durg': form.elements['prope_durg'].value,
            'expi_date_durg': form.elements['expi_date_durg'].value,
        }


        // console.log(values)
        $.ajax({
            url: "./controller/form_drug.php",
            type: "POST",
            data: {
                key: "form_edit_drug",
                data: values
            },
            success: function(result, textStatus, jqXHR) {
                console.log(result);
                if (result == "success") {
                    alert(result + " : เพิ่มยาสำเร็จ");
                    location.reload();
                } else {
                    alert(result + " : ตรวจพบข้อผิดพลาด");
                }
            },
            error: function(result, textStatus, jqXHR) {
                alert(result + " : ตรวจพบข้อผิดพลาด");
            }
        });
    }

    function delete_drug(id) {
        if (confirm("Are you sure you want to delete")) {
            $.ajax({
                url: "./controller/form_drug.php",
                type: "POST",
                data: {
                    key: "delete_drug",
                    id: id
                },
                success: function(result, textStatus, jqXHR) {
                    console.log(result);
                    if (result == "success") {
                        alert(result + " : ลบยาสำเร็จ");
                        location.reload();
                    } else {
                        alert(result + " : ตรวจพบข้อผิดพลาด");
                    }
                },
                error: function(result, textStatus, jqXHR) {
                    alert(result + " : ตรวจพบข้อผิดพลาด");
                }
            });
        }
    }
</script>
<?php include "./footer.php" ?>