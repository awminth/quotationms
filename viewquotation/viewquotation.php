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
                    <h1>View Quotation</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="form-group">
                                <label>From</label>
                                <input type="date" value="<?=date('Y-m-d')?>" name="from" class="form-control " />

                            </div>
                            <div class="form-group">
                                <label>To</label>
                                <input type="date" value="<?=date('Y-m-d')?>" name="to" class="form-control " />

                            </div>
                            <div class="form-group">
                                <label>QuotationTitle</label>
                                <select class="form-control select2" name="quotationid">
                                    <option value="">Select Title</option>
                                    <?=load_quotation()?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="btnsearch" class="form-control btn btn-sm btn-<?=$color?>"><i
                                        class="fas fa-search"></i>&nbsp;Search</button>
                            </div>
                            <form method="POST" action="viewquotation_action.php">
                                <input type="hidden" name="hid">
                                <input type="hidden" name="ser">
                                <input type="hidden" name="hfrom">
                                <input type="hidden" name="hto">
                                <input type="hidden" name="hquotation">
                                <button type="submit" name="action" value="excel"
                                    class="form-control btn btn-sm btn-<?=$color?>"><i
                                        class="fas fa-file-excel"></i>&nbsp;Excel</button>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">

                        <div class="card-body">
                            <table width="100%">
                                <tr>
                                    <td width="25%">
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
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Search</label>
                                            <div class="col-sm-9">
                                                <input type="search" class="form-control" id="searching"
                                                    placeholder="Searching . . . . . ">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div id="show_table" class="table-responsive">

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

<!-- voucher Modal -->
<div class="modal fade text-left" id="vouchermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary m-1">
                <label class="modal-title text-text-bold-600" id="myModalLabel25">Quotation Print</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnpayclose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmvoucher" method="POST">
                <input type="hidden" name="action" value="viewvoucher" />
                <input type="hidden" name="voucheraid"/>
                <input type="hidden" name="vcreatequotationid"/>
                <div id="printdata" class="container">

                </div>
                <div class="d-flex justify-content-end m-2">
                    <button class='btn btn-success mr-2' id='btnexcel'>Excel</button>
                    <button class='btn btn-primary' id='btnprint'>Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(root.'master/footer.php'); ?>

<script>
var ajax_url = "<?php echo roothtml.'viewquotation/viewquotation_action.php'; ?>";
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

    function load_page(page) {
        var entryvalue = $("[name='hid']").val();
        var search = $("[name='ser']").val();
        var from = $("[name='hfrom']").val();
        var to = $("[name='hto']").val();
        var quotation = $("[name='hquotation']").val();
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'show',
                page_no: page,
                entryvalue: entryvalue,
                search: search,
                from: from,
                to: to,
                quotation: quotation
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

    $(document).on("click", "#btnsearch", function() {
        var from = $("[name='from']").val();
        var to = $("[name='to']").val();
        var quotationid = $("[name='quotationid']").val();
        $("[name='hfrom']").val(from);
        $("[name='hto']").val(to);
        $("[name='hquotation']").val(quotationid);
        load_page();
    });

    $(document).on("click", "#btnprint", function(e) {
        e.preventDefault();
        print_fun("printdata");
    });

    $(document).on("click", "#btnview", function() {
        var aid = $(this).data("aid");
        var createquotationid = $(this).data("createquotationid");
        $("[name='voucheraid']").val(aid);
        $("[name='vcreatequotationid']").val(createquotationid);
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'view',
                aid: aid,
                createquotationid: createquotationid
            },
            success: function(data) {
                $("#printdata").html(data);
                $("#vouchermodal").modal("show");
            }
        });
    });

    $(document).on("click", "#btnexcel", function(e) {
        e.preventDefault();
        var voucheraid = $("[name='voucheraid']").val();
        var vcreatequotationid = $("[name='vcreatequotationid']").val();
        if (!vcreatequotationid) {
            swal("Information", "Please open a voucher first.", "info");
            return;
        }
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = "<?php echo roothtml.'viewquotation/viewquotation_action.php'; ?>";
        var actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'excelquotation';
        form.appendChild(actionInput);
        var aidInput = document.createElement('input');
        aidInput.type = 'hidden';
        aidInput.name = 'voucheraid';
        aidInput.value = voucheraid || '';
        form.appendChild(aidInput);
        var cqidInput = document.createElement('input');
        cqidInput.type = 'hidden';
        cqidInput.name = 'vcreatequotationid';
        cqidInput.value = vcreatequotationid;
        form.appendChild(cqidInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    $(document).on("click", "#btnedit", function() {
        var aid = $(this).data("aid");
        var createquotationid = $(this).data("createquotationid");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'edit',
                aid: aid,
                createquotationid: createquotationid
            },
            success: function(data) {
                if (data == 1) {
                    window.location.href =
                        "<?= roothtml.'viewquotation/editquotation.php'?>";
                } else {
                    swal("Error", "Error", "error");
                }
            }
        });

    });

    $(document).on("click", "#btndelete", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var createquotationid = $(this).data("createquotationid");
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
                        aid: aid,
                        createquotationid: createquotationid
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