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
                    <h1>Log History</h1>
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
                        <div class="card-header">
                            <h3 class="card-title">Log History</h3>
                        </div>
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
                                <label>User</label>
                                <select class="form-control select2" name="user">
                                    <option value="">Select User</option>
                                    <?=load_user();?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="btnsearch" class="form-control btn btn-sm btn-<?=$color?>"><i
                                        class="fas fa-search"></i>&nbsp;Search</button>
                            </div>
                            <div class="form-group">
                                <form method="POST" action="log_action.php">
                                    <input type="hidden" name="hid">
                                    <input type="hidden" name="ser">
                                    <input type="hidden" name="from">
                                    <input type="hidden" name="to">
                                    <input type="hidden" name="user">
                                    <button type="submit" name="action" value="excel"
                                        class="btn btn-block btn-<?=$color?>"><i
                                            class="fas fa-file-excel"></i>&nbsp;Excel</button>
                                </form>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">

                        </div>

                        <div class="card-body">
                            <table width="100%">
                                <tr>
                                    <td width="20%">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-6 col-form-label">Show</label>
                                            <div class="col-sm-6">
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
                                                    placeholder="Search by description or username">
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

<?php include(root.'master/footer.php'); ?>

<script>
$(document).ready(function() {

    function load_pag(page) {
        var entryvalue = $("[name='hid']").val();
        var search = $("[name='ser']").val();
        var to = $("[name='to']").val();
        var from = $("[name='from']").val();
        var user = $("[name='user']").val();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'setting/log_action.php' ?>",
            data: {
                action: 'show',
                page_no: page,
                entryvalue: entryvalue,
                search: search,
                to: to,
                from: from,
                user: user
            },
            success: function(data) {
                $("#show_table").html(data);

            }
        });
    }
    load_pag();

    $(document).on('click', '.page-link', function() {
        var pageid = $(this).data('page_number');
        load_pag(pageid);
    });

    $(document).on("change", "#entry", function() {
        var entryvalue = $(this).val();
        $("[name='hid']").val(entryvalue);
        load_pag();
    });


    $(document).on("keyup", "#searching", function() {
        var serdata = $(this).val();
        $("[name='ser']").val(serdata);
        load_pag();
    });

    $(document).on("click", "#btnsearch", function(e) {
        e.preventDefault();
        var to = $("[name='to']").val();
        var from = $("[name='from']").val();
        var user = $("[name='user']").val();
        $("[name='to']").val(to);
        $("[name='from']").val(from);
        $("[name='user']").val(user);
        load_pag();
    });



});
</script>