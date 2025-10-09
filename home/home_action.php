<?php
include('../config.php');

$action = $_POST["action"];

if($action == 'show'){     
    $sql="SELECT * FROM tblcreatequotation WHERE Status = '1'  
    ORDER BY AID DESC";
    $result=mysqli_query($con,$sql) or die("SQL a Query");
    $out="";
    if(mysqli_num_rows($result) > 0){     
        while($row = mysqli_fetch_array($result)){ 
            $out.='
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="#" id="btngoquotation" data-aid="'.$row["AID"].'">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i
                                    class="fas fa-file-invoice"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text p-2">'.$row["Title"].'</span>
                                <span class="info-box-number p-2" style="font-size: 1rem;">
                                    '.$row["Remark"].'
                                </span>
                                <span class="info-box-number p-2" style="font-size: 0.8rem;">
                                    '.enDate($row["Date"]).'
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            ';
        }      
    }
    else{
        $out.='
            <a href="#">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i
                            class="fas fa-file-invoice"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-number p-2" style="font-size: 1rem;">
                            No Data To Show
                        </span>
                    </div>
                </div>
            </a>
        '; 
    }
    echo $out;

}

if($action == "goquotation"){
    $aid = $_POST["aid"];
    $_SESSION["quotationaid"] = $aid;
    echo 1;
}

?>