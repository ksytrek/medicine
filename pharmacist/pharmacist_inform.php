<?php include("./navbar.php") ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>



<section class="pricing-table section" id="pricing">
    <div class="container">
        <div class="row">
            <h3>ข้อมูลเภสัช</h3>
            <div class="col-sm-12">
                <table id="tb_drug" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อเภสัช</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>รหัสผ่าน</th>
                            <th class="text-center"><a href="javascript:void(0)" onclick="" data-toggle="modal" data-target="#add_pma">เพิ่ม</a></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_pma = "SELECT * FROM `pharmacist`";
                        $i = null;
                        foreach (Database::query($sql_pma) as $row_pma) :
                        ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row_pma['name_pma']; ?></td>
                                <td><?php echo $row_pma['username_pma']; ?></td>
                                <td><?php echo $row_pma['password_pma']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_pma_<?php echo $row_pma['id_pma'] ?>">Edit</button>
                                    <button type=" button" onclick="delete_pma(<?php echo $row_pma['id_pma'] ?>)" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <div id="edit_pma_<?php echo $row_pma['id_pma'] ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">เพิ่มเภสัช</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form_edit_pma_<?php echo $row_pma['id_pma']; ?>" action="javascript:update_pma(<?php echo $row_pma['id_pma']; ?>)" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_pma" value="<?php echo $row_pma['id_pma']; ?>" >
                                                <div class="form-group">
                                                    <label class="control-label">ชื่อเภสัช</label>
                                                    <input type="text" class="form-control" placeholder="ชื่อเภสัช" name="name_pma" value="<?php echo $row_pma['name_pma']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" class="form-control" placeholder="Username" name="username_pma" value="<?php echo $row_pma['username_pma']; ?>">
                                                </div>


                                                <div class="form-group">
                                                    <label class="control-label">Password</label>
                                                    <input type="password" class="form-control" placeholder="Password" name="password_pma" value="<?php echo $row_pma['password_pma']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary">แก้ไข</button>
                                            </div>
                                        </form>
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
<div id="add_pma" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มเภสัช</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_pma" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">ชื่อเภสัช</label>
                        <input type="text" class="form-control" placeholder="ชื่อเภสัช" name="name_pma">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username_pma">
                    </div>


                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password_pma">
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

    $('#form_add_pma').submit(function() {
        var $inputs = $("#form_add_pma :input");
        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });

        console.log(values);
        $.ajax({
            url: "./controller/pma_cl.php",
            type: "POST",
            data: {
                key: "form_add_pma",
                data: values
            },
            success: function(result, textStatus, jqXHR) {
                console.log(result);
                if (result == "success") {
                    alert(result + " : สำเร็จ");
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

    function update_pma(id) {
        const form = document.getElementById('form_edit_pma_' + id);

        $.ajax({
            url: "./controller/pma_cl.php",
            type: "POST",
            data: {
                key: "form_edit_pma",
                id_pma: form.elements['id_pma'].value,
                name_pma: form.elements['name_pma'].value,
                username_pma : form.elements['username_pma'].value,
                password_pma : form.elements['password_pma'].value
            },
            success: function(result, textStatus, jqXHR) {
                console.log(result);
                if (result == "success") {
                    alert(result + " : แก้ไขชื่อสำเร็จ");
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

    function delete_pma(id) {
        if (confirm("Are you sure you want to delete")) {
            $.ajax({
                url: "./controller/pma_cl.php",
                type: "POST",
                data: {
                    key: "delete_pma",
                    id: id
                },
                success: function(result, textStatus, jqXHR) {
                    console.log(result);
                    if (result == "success") {
                        alert(result + " : ลบเภสัชสำเร็จ");
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