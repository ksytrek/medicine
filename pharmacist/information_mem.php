<?php include("./navbar.php") ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.jqueryui.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/dataTables.jqueryui.min.js"></script>



<section class="pricing-table section" id="pricing">
    <div class="container">
        <div class="row">
            <h3>ข้อมูลสมาชิก</h3>
            <div class="col-sm-12">
                <table id="tb_drug" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อสมาชิก</th>
                            <th>ยาที่แพ้</th>
                            <th class="text-center"><a href="javascript:void(0)" onclick="" data-toggle="modal" data-target="#add_mem">เพิ่ม</a></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_mem = "SELECT * FROM `member`";
                        $i = null;
                        foreach (Database::query($sql_mem) as $row_mem) :
                        ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $row_mem['name_mem']; ?></td>
                                <td>
                                    <ul>
                                        <?php
                                        foreach (Database::query("SELECT * FROM `drug_allergy` as dr INNER JOIN drug_information as dri  ON dr.id_drug = dri.id_drug  WHERE  id_mem = '{$row_mem['id_mem']}'") as $d) :
                                            echo "<li> * {$d['name_drug']}</li>";
                                        endforeach;
                                        ?>

                                    </ul>

                                </td>
                                <td class="text-center">
                                    <?php
                                    if ($row_mem['id_mem'] != 1) :
                                    ?>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_mem_<?php echo $row_mem['id_mem'] ?>">Edit</button>
                                        <button type=" button" onclick="delete_mem(<?php echo $row_mem['id_mem'] ?>)" class="btn btn-danger btn-sm">Delete</button>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <div id="edit_mem_<?php echo $row_mem['id_mem'] ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">เพิ่มสมาชิก</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="form_edit_mem_<?php echo $row_mem['id_mem'] ?>" action="javascript:update_mem(<?php echo $row_mem['id_mem'] ?>)" method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_mem" value="<?php echo $row_mem['id_mem'] ?>">
                                                <div class="form-group">
                                                    <label class="control-label">ชื่อสมาชิก</label>
                                                    <input type="text" class="form-control" placeholder="ชื่อสมาชิก" name="name_mem" value="<?php echo $row_mem['name_mem'] ?>">
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label class="control-label">เลือกยาที่เเพ้</label>
                                                    <select id="multiple_<?php echo $row_mem['id_mem'] ?>" class="form-control" name="drug_set" multiple>

                                                       
                                                        <?php

                                                        $sql_select_dr = "SELECT * FROM `drug_information`";
                                                        foreach (Database::query($sql_select_dr) as $row_s) :
                                                            // $sql_select_drug_allergy = "SELECT * FROM `drug_allergy` WHERE id_mem = '{$row_mem['id_mem']}'";
                                                            // foreach (Database::query($sql_select_drug_allergy) as $row_dd) :
                                                        ?>
                                                                <option select="select" value="<?php echo $row_s['id_drug'] ?>"><?php echo $row_s['name_drug'] ?></option>
                                                        <?php
                                                            // endforeach;
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                    <script>
                                                        $(document).ready(function() {
                                                            var as = [];
                                                            <?php
                                                            $sql_select_drug_allergy = "SELECT * FROM `drug_allergy` WHERE id_mem = '{$row_mem['id_mem']}'";
                                                            foreach (Database::query($sql_select_drug_allergy) as $row_dd) :
                                                            ?>
                                                            as.push(<?php echo $row_dd['id_drug'] ?>)

                                                            <?php
                                                            endforeach;
                                                            ?>
                                                            $("#multiple_<?php echo $row_mem['id_mem'] ?>").val(as);
                                                        });
                                                    </script>
                                                </div> -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                                <button type="submit" name="submit" class="btn btn-primary">เพิ่ม</button>
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
<div id="add_mem" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสมาชิก</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add_mem" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">ชื่อสมาชิก</label>
                        <input type="text" class="form-control" placeholder="ชื่อสมาชิก" name="name_mem">
                    </div>
                    <div class="form-group">
                        <label class="control-label">เลือกยาที่เเพ้</label>
                        <select class="form-control" name="drug_se" multiple="multiple">

                            <option value="" select>ไม่มียาเเพ้</option>
                            <?php
                            $sql_select_dr = "SELECT * FROM `drug_information`";
                            foreach (Database::query($sql_select_dr) as $row_s) :
                            ?>
                                <option value="<?php echo $row_s['id_drug'] ?>"><?php echo $row_s['name_drug'] ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
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

    $('#form_add_mem').submit(function() {
        var $inputs = $("#form_add_mem :input");
        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });

        console.log(values);
        $.ajax({
            url: "./controller/mem_cl.php",
            type: "POST",
            data: {
                key: "form_add_mem",
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

    function update_mem(id) {
        const form = document.getElementById('form_edit_mem_' + id);

        // var e = document.getElementById("multiple_" + id);
        // var strUser = e.options[e.selectedIndex].text;
        // var values = {
        //     'id_mem': form.elements['id_mem'].value,
        //     'name_mem': form.elements['name_mem'].value,
        //     'drug_se': form.elements['drug_se'].value,
        // }

        // console.log(e);


        // console.log(values)
        $.ajax({
            url: "./controller/mem_cl.php",
            type: "POST",
            data: {
                key: "form_edit_drug",
                name: form.elements['name_mem'].value,
                id_mem: form.elements['id_mem'].value
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

    function delete_mem(id) {
        if (id == 1) {
            alert("ไม่สามารถลบผู้ใช้นี้ได้");
        } else if (confirm("Are you sure you want to delete")) {
            $.ajax({
                url: "./controller/mem_cl.php",
                type: "POST",
                data: {
                    key: "delete_mem",
                    id: id
                },
                success: function(result, textStatus, jqXHR) {
                    console.log(result);
                    if (result == "success") {
                        alert(result + " : ลบสมาชิกสำเร็จ");
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