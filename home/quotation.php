<?php
include('../config.php');
include(root.'master/header.php');

function create_code(){
   // အချိန်ကို မိုက်ခရိုစက္ကန့်အထိ အခြေခံပြီး 13-character string တစ်ခု ထုတ်ပေးပါတယ်
$quickCode = uniqid();

echo $quickCode; // ဥပမာ: 6702c2e4726e8
}


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
                        <div class="card-header">
                            <a href="<?= roothtml.'home/newquotation.php'?>" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> New</a>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div id="showtable"></div>
                                <hr class="my-3">
                                <!-- For text boxes -->
                                <div class="col-sm-10 float-right">
                                    <form id="frmsave" method="POST">
                                        <input type="hidden" name="action" value="save" />
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput1">Select Category</label>
                                                <div class="col-md-9 mx-auto">
                                                    <input type="number" class="form-control border-primary text-right"
                                                        placeholder="Discount" value="0" name="disc" id="disc">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control"
                                                    for="userinput1">TotalPrice</label>
                                                <div class="col-md-9 mx-auto">
                                                    <input type="number" class="form-control border-primary text-right"
                                                        placeholder="TotalPrice" name="finaltotalprice" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput1">Deposit
                                                    Amount</label>
                                                <div class="col-md-9 mx-auto">
                                                    <input type="number" class="form-control border-primary text-right"
                                                        placeholder="Deposit Amount" name="payamt" value="0"
                                                        id="payamt">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput1">Remain</label>
                                                <div class="col-md-9 mx-auto">
                                                    <input type="number" class="form-control border-primary text-right"
                                                        placeholder="Remain" name="change" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control"
                                                    for="userinput1">CustomerName</label>
                                                <div class="col-md-8 mx-auto">
                                                    <select class="form-control border-success select2"
                                                        name="customername" id="customername">
                                                        <option value="">Choose Customer</option>

                                                    </select>
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    <div class="input-group-text"><i id="newcustomer"
                                                            class="fas fa-plus-circle text-teal"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="timesheetinput3">Date</label>
                                                <div class="col-md-9 mx-auto">
                                                    <div class="position-relative has-icon-left">
                                                        <input type="date" id="timesheetinput3"
                                                            class="form-control border-primary" name="dt"
                                                            value="<?= date("Y-m-d")?>">
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
                                                    class="la la-save"></i>Save</button>
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

<!-- voucher Modal -->
<div class="modal fade text-left" id="vouchermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel25"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <label class="modal-title text-text-bold-600" id="myModalLabel25">အရောင်းဘောက်ချာ</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnpayclose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmvoucher" method="POST">
                <input type="hidden" name="action" value="viewvoucher" />
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary"><i class="la la-print"></i>Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(root.'master/footer.php'); ?>

<script>
var ajax_url = "<?php echo roothtml.'home/quotation_action.php'; ?>";

$(document).ready(function() {

    function loadpage(page) {
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

        // calculate();
    }
    loadpage();

    function calculate() {
        var qty = $("[name='qty']").val();
        var sellpriceperunit = $("[name='sellpriceperunit']").val();
        var totalprice = qty * sellpriceperunit;
        $("[name='totalprice']").val(totalprice);
    }

    function calculate_one() {
        var totalpriceshow = Number($('#showtablecreate #totalpriceshow').text().replace(/,/g, ''));

        var predisc = $("[name='disc']").val();
        var disc = predisc * totalpriceshow / 100;
        var finaltotalprice = totalpriceshow - disc;
        var totalpay = $("[name='payamt']").val();
        var change = totalpay - finaltotalprice;
        $("[name='finaltotalprice']").val(finaltotalprice);
        $("[name='change']").val(change);
        $("[name='pretotalprice']").val(totalpriceshow);
        var $changeInput = $("[name='change']");
        $changeInput.val(change);
        if (change < 0) {
            $changeInput.addClass('text-danger');
        } else {
            $changeInput.removeClass('text-danger');
        }
    }

    $(document).on("keyup", "#sellpriceperunit, #qty", function() {
        calculate();
    });

    $(document).on("keyup", "#disc,#payamt", function() {
        calculate_one();
    });

    $("#frmsavetemp").on("submit", function(e) {
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
                    $("[name='eaid']").val(0);
                    $("[name='itemname']").val('');
                    $("[name='qty']").val('');
                    $("[name='sellpriceperunit']").val('');
                    $("[name='totalprice']").val('');
                    window.location.reload();
                    load_pagecreate();

                } else {
                    swal("Error", "Save Data Error.", "Error");
                }
            }
        });
    });

    $(document).on('click', '#btnedittemp', function(e) {
        e.preventDefault();
        var aid = $(this).data('aid');
        var itemcode = $(this).data('itemcode');
        var itemname = $(this).data('itemname');
        var qty = $(this).data('qty');
        var sellpriceperunit = $(this).data('sellpriceperunit');
        var totalprice = $(this).data('totalprice');
        $("[name='eaid']").val(aid);
        $("[name='itemcode']").val(itemcode);
        $("[name='itemname']").val(itemname);
        $("[name='qty']").val(qty);
        $("[name='sellpriceperunit']").val(sellpriceperunit);
        $("[name='totalprice']").val(totalprice);
    });

    $(document).on("click", "#btndeletetemp", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");

        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'deletetemp',
                aid: aid
            },
            success: function(data) {
                if (data == 1) {
                    swal("Successful",
                        "Delete data success.",
                        "success");
                    load_pagecreate();
                    swal.close();
                } else {
                    swal("Error",
                        "Delete data failed.",
                        "error");
                }
            }
        });

    });

    $("#frmsave").on("submit", function(e) {
        e.preventDefault();
        var customerid = $("[name='customername']").val();
        if (customerid == '') {
            swal("Information", "Please select customer name.", "info");
            return;
        }
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {

                if (data != 0) {
                    $("#frmvoucher").html(data);
                    $("#vouchermodal").modal("show");
                    $("[name='disc']").val(0);
                    $("[name='pretotalprice']").val('');
                    $("[name='finaltotalprice']").val('');
                    $("[name='payamt']").val('');
                    $("[name='change']").val('');
                    $("[name='customername']").val('');
                    load_pagecreate();
                } else {
                    swal("Error", "Save Data Error.", "error");
                }
            }
        });
    });



    ////////////////////////////////////////////////////////////////////
    // View Pre Order Page
    ////////////////////////////////////////////////////////////////////
    function load_pageview(page) {
        var entryvalue = $("[name='hid']").val();
        var search = $("[name='ser']").val();
        var from = $("[name='hfrom']").val();
        var to = $("[name='hto']").val();
        var customer = $("[name='hcustomer']").val();

        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'showvieworder',
                page_no: page,
                entryvalue: entryvalue,
                search: search,
                from: from,
                to: to,
                customer: customer
            },
            success: function(data) {
                $("#showvieworder").html(data);
            }
        });
    }
    load_pageview();

    $(document).on('click', '.page-link', function() {
        var pageid = $(this).data('page_number');
        load_pageview(pageid);
    });

    $(document).on("change", "#entry", function() {
        var entryvalue = $(this).val();
        $("[name='hid']").val(entryvalue);
        load_pageview();
    });

    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pageview();
    });

    $(document).on("click", "#btnsearch", function() {
        var from = $("[name='dtfrom']").val();
        var to = $("[name='dtto']").val();
        $("[name='hfrom']").val(from);
        $("[name='hto']").val(to);
        load_pageview();
    });

    $(document).on("change", "#customername1", function() {
        var serdata = $(this).val();
        $("[name='hcustomer']").val(serdata);
        load_pageview();
    });

    $(document).on("click", "#btnvieworder", function() {
        var vno = $(this).data("vno");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'viewvoucher',
                vno: vno
            },
            success: function(data) {
                $("#frmvoucher").html(data);
                $("#vouchermodal").modal("show");
            }
        });
    });

    $(document).on("click", "#btnconfirm", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        swal({
                title: "Confirm?",
                text: "Are you sure Confirm PreOrder!",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes, Confirm it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'confirm',
                        aid: aid
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Confirm data success.",
                                "success");
                            load_pageview();
                            swal.close();
                        } else {
                            swal("Error",
                                "Confirm data failed.",
                                "error");
                        }
                    }
                });
            });
    });

    $(document).on("click", "#btnreturn", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        swal({
                title: "Preorder Return?",
                text: "Are you sure Return PreOrder!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Yes, Return it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'return',
                        aid: aid
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Return data success.",
                                "success");
                            load_pageview();
                            swal.close();
                        } else {
                            swal("Error",
                                "Return data failed.",
                                "error");
                        }
                    }
                });
            });
    });

    // add customer
    $(document).on("click", "#newcustomer", function() {
        $("#btnnewmodal").modal("show");
    });

    $(document).on("click", "#btncancel", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        swal({
                title: "Preorder Cancel?",
                text: "Are you sure Cancel PreOrder!",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Cancel it!",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    data: {
                        action: 'cancel',
                        aid: aid
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Cancel data success.",
                                "success");
                            load_pageview();
                            swal.close();
                        } else {
                            swal("Error",
                                "Cancel data failed.",
                                "error");
                        }
                    }
                });
            });
    });


    $(document).on("click", "#btnsave", function(e) {
        e.preventDefault();
        var name = $("#name").val();
        var phno = $("#phno").val();
        var address = $("#address").val();
        var email = $("#email").val();
        if (name == "" || phno == "" || address == "") {
            swal("Information", "Please fill all data", "info");
        } else {
            $.ajax({
                type: "post",
                url: "<?php echo roothtml.'pos/pos_action.php' ?>",
                data: $("#frm").serialize() + "&action=save",
                success: function(data) {
                    if (data == 1) {
                        swal("Successful!", "Save Successful.",
                            "success");
                        window.location.reload();
                    } else {
                        swal("Error!", "Error Save.", "error");
                    }
                }
            });
        }
    });

    $(document).on("click", "#btndeleteorder", function(e) {
        e.preventDefault();
        var vno = $(this).data("vno");
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
                        action: 'deleteorder',
                        vno: vno
                    },
                    success: function(data) {
                        if (data == 1) {
                            swal("Successful",
                                "Delete data success.",
                                "success");
                            load_pageview();
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