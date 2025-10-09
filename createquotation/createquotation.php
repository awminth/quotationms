<?php
include('../config.php');
include(root.'master/header.php'); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Quotation</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <table>
                                <tr>
                                    <td><button id="btnnew" type="button" class="btn btn-sm btn-<?=$color?>"><i
                                                class="fas fa-plus"></i>&nbsp; New
                                        </button></td>
                                    <td>
                                        <form method="POST" action="createquotation_action.php">
                                            <input type="hidden" name="hid">
                                            <input type="hidden" name="ser">
                                            <button type="submit" name="action" value="excel"
                                                class="btn btn-sm btn-<?=$color?>"><i
                                                    class="fas fa-file-excel"></i>&nbsp;Excel</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-5 col-form-label">Show</label>
                                            <div class="col-sm-7">
                                                <select id="entry" class="custom-select btn-sm">
                                                    <option value="10" selected>10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="60%" class="float-right">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Search</label>
                                            <div class="col-sm-10">
                                                <input type="search" class="form-control" id="searching"
                                                    placeholder="Searching . . . . .">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div id="show_table" class="table-responsive-sm">

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- New Modal -->
<div class="modal fade" id="btnnewmodal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-<?=$color?>">
                <h4 class="modal-title">New Quotation</h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmquotation" method="POST">
                <input type="hidden" name="action" value="save">
                <div class='modal-body' data-spy='scroll' data-offset='50'>
                    <div class="form-group">
                        <label for="usr"> Title :</label>
                        <input type="text" class="form-control border-success" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Remark :</label>
                        <textarea rows="5" class="form-control border-success" name="remark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Date :</label>
                        <input type="date" class="form-control border-success" name="dt" value="<?=date('Y-m-d')?>">
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
<div class="modal fade" id="btneditmodal">
    <div class="modal-dialog modal-dialog-centered">
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
                        <label for="usr"> Title :</label>
                        <input type="text" class="form-control border-success" name="etitle" required>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Remark :</label>
                        <textarea rows="5" class="form-control border-success" name="eremark"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="usr"> Date :</label>
                        <input type="date" class="form-control border-success" name="edt">
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

<?php include(root.'master/footer.php'); ?>

<script>
var ajax_url = "<?php echo roothtml.'createquotation/createquotation_action.php'; ?>";
$(document).ready(function() {

    function load_page(page) {
        var entryvalue = $("[name='hid']").val();
        var search = $("[name='ser']").val();
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'show',
                page_no: page,
                entryvalue: entryvalue,
                search: search
            },
            success: function(data) {
                $("#show_table").html(data);
            }
        });
    }
    load_page();

    $(document).on('click', '.page-link', function() {
        var pageid = $(this).data('page_number');
        load_page(pageid);
    });

    $(document).on("change", "#entry", function() {
        var entryvalue = $(this).val();
        $("[name='hid']").val(entryvalue);
        load_page();
    });


    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_page();
    });

    $(document).on("click", "#btnnew", function() {
        $("#btnnewmodal").modal("show");
    });

    $("#frmquotation").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btnnewmodal").modal("hide");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Save data success.",
                        "success");
                    $("[name='title']").val('');
                    $("[name='remark']").val('');
                    swal.close();
                    load_page();
                } else {
                    swal("Error", "Save Data Error.", "Error");
                }
            }
        });
    });

    $(document).on("click", "#btnunactive", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var title = $(this).data("title");
        swal({
                title: "Unactive?",
                text: "Are you sure unactive!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Yes, unactive it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'unactive',
                        aid: aid,
                        title: title
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Unactive data success.",
                                "success");
                            load_page();
                            swal.close();
                        } else {
                            swal("Error",
                                "Unactive data failed.",
                                "error");
                        }
                    }
                });
            });
    });

    $(document).on("click", "#btnactive", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var title = $(this).data("title");
        swal({
                title: "Active?",
                text: "Are you sure Active!",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes, Active it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'active',
                        aid: aid,
                        title: title
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Active data success.",
                                "success");
                            load_page();
                            swal.close();
                        } else {
                            swal("Error",
                                "Active data failed.",
                                "error");
                        }
                    }
                });
            });
    });

    $(document).on("click", "#btnedit", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var title = $(this).data("title");
        var remark = $(this).data("remark");
        var dt = $(this).data("dt");
        $("[name='eaid']").val(aid);
        $("[name='etitle']").val(title);
        $("[name='eremark']").val(remark);
        $("[name='edt']").val(dt);
        $("#btneditmodal").modal("show");
    });

    $("#frmedit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $("#btneditmodal").modal("hide");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Edit data success.",
                        "success");
                    $("[name='etitle']").val('');
                    $("[name='eremark']").val('');
                    swal.close();
                    load_page();
                } else {
                    swal("Error", "Edit Data Error.", "Error");
                }
            }
        });
    });

    $(document).on("click", "#btndelete", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        swal({
                title: "Delete?",
                text: "Are you sure delete!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'delete',
                        aid: aid
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Delete data success.",
                                "success");
                            load_page();
                            swal.close();
                        } else {
                            swal("Error",
                                "Delete data failed.",
                                "error");
                        }
                    }
                });
            });
    });

});
</script>