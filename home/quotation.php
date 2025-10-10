<?php
    include('../config.php');
    include(root.'master/header.php');
    $userid = $_SESSION["naiip_userid"];
    $createquotationid = $_SESSION["quotationaid"];

    $eaid = 0;
    $name_project = "projectid";
    $name_name = "name";
    $name_dt = "dt";
    $projectid = 0;
    $name = "";
    $dt = date("Y-m-d");
    $frm = "frmsavevoucher";
    $actionvoucher = "savevoucher";
    $voucherclass = "save";
    $btnvoucher = "Save";
    $sql = "SELECT * FROM tblquotationvoucher WHERE CreatequotationID='$createquotationid'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)){
        $row = mysqli_fetch_array($result);
        $eaid = $row["AID"];
        $projectid = $row["ProjectID"];
        $name = $row["Name"];
        $dt = $row["Date"];
        $frm = "frmeditvoucher";
        $actionvoucher = "editvoucher";
        $voucherclass = "edit";
        $btnvoucher = "Edit";
        $name_project = "eprojectid";
        $name_name = "ename";
        $name_dt = "edt";
    }
    $usertype = GetString("SELECT UserType FROM tbluser WHERE AID='{$userid}'");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Quotation</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header row">
                            <div>
                                <a href="<?= roothtml.'home/home.php'?>" class="btn btn-primary"><i class="fas fa-back"></i> Back</a>
                            </div>
                            <div>
                                <a href="#" class="btn btn-primary" id="btnnew"><i class="fas fa-plus"></i> New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div id="showtable"></div>
                                <hr class="my-3">
                                <!-- For text boxes -->
                                <div class="col-sm-10 float-right">
                                    <form id="<?= $frm?>" method="POST">
                                        <input type="hidden" name="action" value="<?= $actionvoucher?>" />
                                        <input type="hidden" name="eaid" value="<?= $eaid?>">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput1">Project Name :
                                                </label>
                                                <div class="col-md-9 mx-auto">
                                                    <select class="form-control border-success select2"
                                                        name="<?= $name_project?>">
                                                        <option value="">Choose Project</option>
                                                        <?=load_project($projectid);?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput1">Name : </label>
                                                <div class="col-md-9 mx-auto">
                                                    <input type="text" name="<?= $name_name?>"
                                                        class="form-control border-primary" value="<?= $name?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="timesheetinput3">Date :
                                                </label>
                                                <div class="col-md-9 mx-auto">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="date" id="timesheetinput3"
                                                            class="form-control border-primary" name="<?= $name_dt?>"
                                                            value="<?= $dt?>">
                                                        <div class="form-control-position">
                                                            <i class="ft-message-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success form-control col-sm-6"><i
                                                    class="fas fa-<?=$voucherclass?>"></i><?= $btnvoucher?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- New Modal -->
<div class="modal fade" id="newmodal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-<?=$color?>">
                <h4 class="modal-title">New Quotation</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmsave" method="POST">
                <input type="hidden" name="action" value="save">
                <div class='modal-body' data-spy='scroll' data-offset='50'>
                    <div class="form-group">
                        <label for="usr"> Category Name :</label>
                        <div>
                            <select class="form-control border-success select2" name="categoryid" required>
                                <option value="">Choose Category</option>
                                <?=load_category();?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Item Name :</label>
                        <textarea rows="5" class="form-control border-success" name="itemname"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Specification :</label>
                        <textarea rows="5" class="form-control border-success" name="specification"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Qty :</label>
                        <input type="number" name="qty" class="form-control border-success" value="0">
                    </div>
                    <div class="form-group">
                        <label for="usr"> Website Link :</label>
                        <input type="text" name="weblink" class="form-control border-success">
                    </div>
                    <div class="form-group">
                        <label for="usr"> Remark :</label>
                        <textarea rows="5" class="form-control border-success" name="remark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Date :</label>
                        <input type="date" name="dt" class="form-control border-success" value="<?= date("Y-m-d")?>">
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-<?=$color?>'><i class="fas fa-save"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editmodal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-<?=$color?>">
                <h4 class="modal-title">Edit Quotation</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmedit" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="eaid">
                <div class='modal-body' data-spy='scroll' data-offset='50'>
                    <div class="form-group">
                        <label for="usr"> Category Name :</label>
                        <div>
                            <select class="form-control border-success select2" name="ecategoryid">
                                <option value="">Choose Category</option>
                                <?=load_category();?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Item Name :</label>
                        <textarea rows="5" class="form-control border-success" name="eitemname"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Specification :</label>
                        <textarea rows="5" class="form-control border-success" name="especification"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Qty :</label>
                        <input type="number" name="eqty" class="form-control border-success" value="0" id="qty">
                    </div>
                    <div class="form-group" <?= $usertype == "Admin" ? "" : "style='display:none;'"?>>
                        <label for="usr"> Unit Price :</label>
                        <input type="number" name="eunitprice" class="form-control border-success" value="0"
                            id="unitprice">
                    </div>
                    <div class="form-group" <?= $usertype == "Admin" ? "" : "style='display:none;'"?>>
                        <label for="usr"> Total Price :</label>
                        <input type="number" name="etotalprice" class="form-control border-success" value="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Website Link :</label>
                        <input type="text" name="eweblink" class="form-control border-success">
                    </div>
                    <div class="form-group">
                        <label for="usr"> Remark :</label>
                        <textarea rows="5" class="form-control border-success" name="eremark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Date :</label>
                        <input type="date" name="edt" class="form-control border-success" value="<?= date("Y-m-d")?>">
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-<?=$color?>'><i class="fas fa-edit"></i>
                        Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- voucher Modal -->
<div class="modal fade text-left" id="vouchermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <label class="modal-title text-text-bold-600" id="myModalLabel25">Quotation Print</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnpayclose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmvoucher" method="POST">
                <input type="hidden" name="action" value="viewvoucher" />
                <div id="printdata" class="container">

                </div>
                <div style='text-align: right; margin-bottom: 20px; margin-right: 20px;'>
                    <button class='btn btn-primary' id='btnprint'>Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(root.'master/footer.php'); ?>

<script>
var ajax_url = "<?php echo roothtml.'home/quotation_action.php'; ?>";

$(document).ready(function() {

    //print js fun
    function print_fun(place) {
        printJS({
            printable: place,
            type: 'html',
            style: 'table, tr,td {font-weight: bold; font-size: 10px;border-bottom: 1px solid LightGray;border-collapse: collapse;}' +
                '.txtc{text-align: center;font-weight: bold;}' +
                '.txtr{text-align: right;font-weight: bold;}' +
                '.txtl{text-align: left;font-weight: bold;}' +
                ' h5{ text-align: center;font-weight: bold;}' +
                '.fs{font-size: 10px;font-weight: bold;}' +
                '.txt,h5 {text-align: center;font-size: 10px;font-weight: bold;}' +
                '.lt{width:50%;float:left;font-weight: bold;}' +
                '.rt{width:50%;float:right;font-weight: bold;}' +
                '.wno{width:5%;font-weight: bold;}',
        });
    }

    function loadpage() {
        $.ajax({
            type: "post",
            url: ajax_url,
            global: false,
            data: {
                action: 'show'
            },
            success: function(data) {
                $("#showtable").html(data);
                $("[name='itemname']").focus();
            }
        });
    }
    loadpage();

    function calculate() {
        var qty = $("[name='eqty']").val();
        var unitprice = $("[name='eunitprice']").val();
        var totalprice = qty * unitprice;
        $("[name='etotalprice']").val(totalprice);
    }

    $(document).on("keyup", "#qty", function() {
        calculate();
    });

    $(document).on("keyup", "#unitprice", function() {
        calculate();
    });

    $(document).on("click", "#btnprint", function(e) {
        e.preventDefault();
        print_fun("printdata");
    });

    $(document).on("click", "#btnnew", function() {
        $("#newmodal").modal("show");
    });

    $("#frmsave").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            global: false,
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Save data success.",
                        "success");
                    $("[name='itemname']").val('');
                    $("[name='specification']").val('');
                    $("[name='qty']").val('0');
                    $("[name='weblink']").val('');
                    $("[name='remark']").val('');
                    swal.close();
                    loadpage();
                } else {
                    swal("Error", "Save Data Error.", "Error");
                }
            }
        });
    });

    $(document).on('click', '#btnedit', function(e) {
        e.preventDefault();
        var aid = $(this).data('aid');
        var categoryid = $(this).data('categoryid');
        var itemname = $(this).data('itemname');
        var specification = $(this).data('specification');
        var qty = $(this).data('qty');
        var weblink = $(this).data('weblink');
        var remark = $(this).data('remark');
        var dt = $(this).data('dt');
        $("[name='eaid']").val(aid);
        $("[name='ecategoryid']").val(categoryid).trigger('change');
        $("[name='eitemname']").val(itemname);
        $("[name='especification']").val(specification);
        $("[name='eqty']").val(qty);
        $("[name='eweblink']").val(weblink);
        $("[name='eremark']").val(remark);
        $("[name='edt']").val(dt);
        $("#editmodal").modal("show");
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#editmodal").modal("hide");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            global: false,
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Edit data success.",
                        "success");
                    $("[name='eitemname']").val('');
                    $("[name='especification']").val('');
                    $("[name='eqty']").val('0');
                    $("[name='eweblink']").val('');
                    $("[name='eremark']").val('');
                    swal.close();
                    loadpage();
                } else {
                    swal("Error", "Edit Data Error.", "Error");
                }
            }
        });
    });

    $(document).on("click", "#btndelete", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var itemname = $(this).data("itemname");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'delete',
                aid: aid,
                itemname: itemname
            },
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Delete data success.",
                        "success");
                    loadpage();
                    swal.close();
                } else {
                    swal("Error",
                        "Delete data failed.",
                        "error");
                }
            }
        });

    });

    $("#frmsavevoucher").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            global: false,
            success: function(data) {
                if (data != 0) {
                    swal("Successful",
                        "Save data success.",
                        "success");
                    swal.close();
                    $("#printdata").html(data);
                    $("#vouchermodal").modal("show");
                } else {
                    swal("Error", "Save Data Error.", "Error");
                }
            }
        });
    });

    $("#frmeditvoucher").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            global: false,
            success: function(data) {
                if (data != 0) {
                    swal("Successful",
                        "Edit data success.",
                        "success");
                    swal.close();
                    $("#printdata").html(data);
                    $("#vouchermodal").modal("show");
                } else {
                    swal("Error", "Edit Data Error.", "Error");
                }
            }
        });
    });

    $(document).on("click", "#btnpayclose", function(e) {
        e.preventDefault();
        window.location.href = "<?= roothtml.'home/home.php' ?>."
    });

});
</script>