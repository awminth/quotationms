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
                <h4 class="p-2">Pre Order</h4>
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-4">
                        <a href="<?= roothtml.'home/quotation.php'?>">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i
                                        class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text p-2">Pre Order</span>
                                    <span class="info-box-number p-2" style="font-size: 1rem;">
                                        Title One
                                    </span>
                                    <span class="info-box-number p-2" style="font-size: 0.8rem;">
                                        Remark
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->


</div>
<!-- /.content-wrapper -->




<?php include(root . 'master/footer.php'); ?>

<script>
$(document).ready(function() {

    $(document).on("click", "#showprint", function() {
        $("#btnnewmodal").modal("show");
    });

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData = {
        labels: [
            '<?= (isset($arr[0]) ? $arr[0] : 'null') ?>',
            '<?= (isset($arr[1]) ? $arr[1] : 'null') ?>',
            '<?= (isset($arr[2]) ? $arr[2] : 'null') ?>',
            '<?= (isset($arr[3]) ? $arr[3] : 'null') ?>',
        ],
        datasets: [{
            data: [
                <?= (isset($arr1[0]) ? $arr1[0] : 0) ?>,

                <?= (isset($arr1[1]) ? $arr1[1] : 0) ?>,

                <?= (isset($arr1[2]) ? $arr1[2] : 0) ?>,

                <?= (isset($arr1[3]) ? $arr1[3] : 0) ?>
            ],
            backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#00c0ef'],
        }]
    }
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    });





});
</script>