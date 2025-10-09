<?php
include('../config.php');

$action = $_POST["action"];

if($action == 'show'){ 
    $limit_per_page=""; 
    if($_POST['entryvalue']==""){
        $limit_per_page=10; 
    } else{
        $limit_per_page=$_POST['entryvalue']; 
    }
    
    $page="";
    $no=0;
    if(isset($_POST["page_no"])){
        $page=$_POST["page_no"];                
    }
    else{
        $page=1;                      
    }

    $offset = ($page-1) * $limit_per_page;                                               
   
    $search = $_POST['search'];
    $a = "";
    if($search != ''){    
        $a = " and Title like '%$search%' ";
    }    
    $sql="SELECT * FROM tblcreatequotation WHERE AID IS NOT NULL ".$a." 
    ORDER BY AID DESC limit {$offset},{$limit_per_page}";
    $result=mysqli_query($con,$sql) or die("SQL a Query");
    $out="";
    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-bordered table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">No</th>
            <th>Title</th>
            <th>Remark</th>
            <th class="text-center">Date</th>
            <th width="10%;" class="text-center">Action</th>           
        </tr>
        </thead>
        <tbody>
        ';
        
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $colour = "";
            $colour = $row["Status"] == "1" ? "success" : "warning";
            $out.="<tr>
                <td>{$no}</td>
                <td><span class='badge badge-".$colour."' style='font-size: 14px; padding: 8px 12px;'>{$row["Title"]}</span></td>  
                <td><span class='badge badge-".$colour."' style='font-size: 14px; padding: 8px 12px;'>{$row["Remark"]}</span></td>  
                <td class='text-center'><span class='badge badge-info' style='font-size: 12px; padding: 6px 10px;'>".enDate($row["Date"])."</span></td>  
                <td class='text-center'>
                    <div class='dropdown dropleft'>
                    <a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-h text-primary' style='font-size:22px;cursor:pointer;'></i>
                    </a>
                        <div class='dropdown-menu'>";
                        if($row["Status"] == 1){
                            $out .= "
                            <a href='#' id='btnunactive' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-title='{$row['Title']}'>
                                <i class='fas fa-pause-circle text-warning'
                                style='font-size:13px;'></i>
                                Unactive</a>";
                        }
                        else{
                            $out .= "
                            <a href='#' id='btnactive' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-title='{$row['Title']}'>
                                <i class='fas fa-play-circle text-success'
                                style='font-size:13px;'></i>
                                Active</a>
                            ";
                        }
                        $out .= "
                            <div class='dropdown-divider'></div>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-title='{$row['Title']}'
                                data-remark='{$row['Remark']}'
                                data-dt='{$row['Date']}'>
                                <i class='fas fa-edit text-primary'
                                style='font-size:13px;'></i>
                            Edit</a>
                            <div class='dropdown-divider'></div>
                            <a href='#' id='btndelete' class='dropdown-item'
                                data-aid='{$row['AID']}'><i
                                class='fas fa-trash text-danger'
                                style='font-size:13px;'></i>
                            Delete</a>                          
                        </div>
                    </div>
                </td>  
            </tr>";
        }
        $out.="</tbody>";
        $out.="</table>";

        $sql_total="SELECT AID FROM tblcreatequotation WHERE AID IS NOT NULL ".$a." 
        ORDER BY AID DESC";
        $record = mysqli_query($con,$sql_total) or die("fail query");
        $total_record = mysqli_num_rows($record);
        $total_links = ceil($total_record/$limit_per_page);

        $out.='<div class="float-left"><p>Total Records -  ';
        $out.=$total_record;
        $out.='</p></div>';

        $out.='<div class="float-right">
                <ul class="pagination">
            ';      
        
        $previous_link = '';
        $next_link = '';
        $page_link = '';

        if($total_links > 4){
            if($page < 5){
                for($count = 1; $count <= 5; $count++)
                {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            }else{
                $end_limit = $total_links - 5;
                if($page > $end_limit){
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $end_limit; $count <= $total_links; $count++)
                    {
                        $page_array[] = $count;
                    }
                }else{
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for($count = $page - 1; $count <= $page + 1; $count++)
                    {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }            

        }else{
            for($count = 1; $count <= $total_links; $count++)
            {
                $page_array[] = $count;
            }
        }

        for($count = 0; $count < count($page_array); $count++){
            if($page == $page_array[$count]){
                $page_link .= '<li class="page-item active">
                                    <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
                                </li>';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0){
                    $previous_link = '<li class="page-item">
                                            <a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a>
                                    </li>';
                }
                else{
                    $previous_link = '<li class="page-item disabled">
                                            <a class="page-link" href="#">Previous</a>
                                    </li>';
                }

                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links){
                    $next_link = '<li class="page-item disabled">
                                        <a class="page-link" href="#">Next</a>
                                </li>';
                }else{
                    $next_link = '<li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a>
                                </li>';
                }
            }else{
                if($page_array[$count] == '...')
                {
                    $page_link .= '<li class="page-item disabled">
                                        <a class="page-link" href="#">...</a>
                                    </li> ';
                }else{
                    $page_link .= '<li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a>
                                    </li> ';
                }
            }
        }

        $out .= $previous_link . $page_link . $next_link;

        $out .= '</ul></div>';

        echo $out; 
        
    }
    else{
        $out.='
        <table class="table table-bordered table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">No</th>
            <th class="text-center">Title</th>
            <th class="text-center">Remark</th>         
            <th class="text-center">Date</th>         
        </tr>
        </thead>
        <tbody>
        <tr>
                <td colspan="4" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        '; 
        echo $out;
    }

}

if($action == 'save'){
    $title = $_POST["title"];
    $remark = $_POST["remark"];
    $status = "1";
    $dt = $_POST["dt"];
    $data = [
        "Title" => $title,
        "Remark" => $remark,
        "Status" => $status,
        "Date" => $dt
    ];
    $result = insertData_Fun("tblcreatequotation",$data);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် quotation name(".$title .")အမည်ဖြင့်အသစ်သွင်းသွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == 'unactive'){
    $aid = $_POST["aid"];
    $title = $_POST["title"];
    $status = "0";
    $data = [
        "Status" => $status
    ];
    $where = [
        "AID" => $aid
    ];
    $result = updateData_Fun("tblcreatequotation",$data,$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် quotation name(".$title .")အား Unactiveလုပ်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == 'active'){
    $aid = $_POST["aid"];
    $title = $_POST["title"];
    $status = "1";
    $data = [
        "Status" => $status
    ];
    $where = [
        "AID" => $aid
    ];
    $result = updateData_Fun("tblcreatequotation",$data,$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် quotation name(".$title .")အား Activeလုပ်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == 'edit'){
    $aid = $_POST["eaid"];
    $title = $_POST["etitle"];
    $remark = $_POST["eremark"];
    $dt = $_POST["edt"];
    $data = [
        "Title" => $title,
        "Remark" => $remark,
        "Date" => $dt
    ];
    $where = [
        "AID" => $aid
    ];
    $result = updateData_Fun("tblcreatequotation",$data,$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် quotation name(".$title .")အားပြင်ဆင်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $where = [
        "AID" => $aid
    ];
    $result = deleteData_Fun("tblcreatequotation",$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် quotation အားဖျက်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
    
}

if($action == 'excel'){
    $search = $_POST['ser'];
    $a = "";
    if($search != ''){    
        $a = " and Title like '%$search%' ";
    }    
    $sql="SELECT * FROM tblcreatequotation WHERE AID IS NOT NULL ".$a." 
    ORDER BY AID DESC";
    $result = mysqli_query($con,$sql);
    $out="";
    $fileName = "QuotationReport-".date('d-m-Y').".xls";
    $out .= '<head><meta charset="utf-8"></head>
        <table >  
            <tr>
                <td colspan="4" align="center"><h3>Quotation</h3></td>
            </tr>
            <tr><td colspan="4"><td></tr>
            <tr>  
                <th style="border: 1px solid ;">No</th>  
                <th style="border: 1px solid ;">Title</th>
                <th style="border: 1px solid ;">Remark</th>     
                <th style="border: 1px solid ;">Date</th>     
            </tr>';
    if(mysqli_num_rows($result) > 0){
        $no=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $out .= '
                <tr>  
                    <td style="border: 1px solid ;">'.$no.'</td>  
                    <td style="border: 1px solid ;">'.$row["Title"].'</td>       
                    <td style="border: 1px solid ;">'.$row["Remark"].'</td>          
                    <td style="border: 1px solid ;">'.$row["Date"].'</td>          
                </tr>';
        }
        $out .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo $out;
    }
    else{
        $out .= '
            <tr>
                <td colspan="4" style="border: 1px solid ;" align="center">No data</td>
            </tr>';
        $out .= '</table>'; 
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo $out;
    }    
}

?>