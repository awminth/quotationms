<?php
    include('../config.php');
    include(root . 'master/header.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DashBoard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline p-2">
                <h4 class="p-2">Quotation Title Lists</h4>
                <div class="row" id="showcard">
                
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->


</div>
<!-- /.content-wrapper -->

<?php include(root . 'master/footer.php'); ?>

<script>
var ajax_url = "<?php echo roothtml.'home/home_action.php'; ?>";
$(document).ready(function() {

    function load_page() {
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'show'
            },
            success: function(data) {
                $("#showcard").html(data);
            }
        });
    }
    load_page();

    $(document).on("click", "#btngoquotation", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        $.ajax({
            type: "post",
            url: ajax_url,
            data: {
                action: 'goquotation',
                aid: aid
            },
            success: function(data) {
                window.location.href = "<?= roothtml.'home/quotation.php'?>"
            }
        });
    });
});
</script>