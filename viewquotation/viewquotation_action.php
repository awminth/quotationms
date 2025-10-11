<?php
include('../config.php');

$action = $_POST["action"];
$userid = $_SESSION["naiip_userid"];
$usertype = $_SESSION["naiip_usertype"];


if($action == 'show'){  
    $limit_per_page=""; 
    if($_POST['entryvalue']==""){
        $limit_per_page=10; 
    } else{
        $limit_per_page=$_POST['entryvalue']; 
    }
    
    $page="";
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
        $a .= " AND (c.Title like '%$search%') ";
    } 
    $from=$_POST['from'];  
    $to=$_POST['to'];     
    $quotation=$_POST['quotation'];
    if($from!='' || $to!=''){
        $a .=" and Date(q.Date)>='{$from}' and Date(q.Date)<='{$to}' ";
    }  
    if($quotation!=''){
        $a .=" and q.CreatequotationID={$quotation} ";
    }   
    if($usertype != "Admin"){
        $a .=" and q.UserID='{$userid}' ";
    }
    $sql="SELECT q.*,c.AID AS caid,c.Title AS ctitle,p.Name AS projectname FROM tblquotationvoucher q,
    tblcreatequotation c,tblproject p WHERE q.CreatequotationID=c.AID AND q.ProjectID=p.AID 
    ".$a." ORDER BY q.AID DESC limit $offset,$limit_per_page";
    $result=mysqli_query($con,$sql) or die("SQL a Query");
    $out="";
    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-bordered tabel-sm table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">No</th>
            <th>Quotation Title</th>                                        
            <th>Project Name</th>
            <th>Name</th>
            <th>Date</th>     
            <th width="10%;" class="text-center">Actions</th>       
        </tr>
        </thead>
        <tbody>
        ';
        $no=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["ctitle"]}</td>
                <td>{$row["projectname"]}</td>
                <td>{$row["Name"]}</td>
                <td><span class='badge badge-info'>".enDate($row["Date"])."</span></td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <a href='#' id='btnview' data-toggle='tooltip' data-placement='bottom'
                            title='အသေးစိတ်ကြည့်မည်'
                            data-aid='{$row['AID']}'
                            data-createquotationid='{$row['CreatequotationID']}'
                            data-userid='{$row['UserID']}'
                            class='btn btn-success btn-sm'><i class='fas fa-eye'></i></a>
                        <a href='#' id='btnedit' data-toggle='tooltip' data-placement='bottom'
                            title='ပြင်ဆင်မည်' 
                            data-aid='{$row['AID']}'
                            data-createquotationid='{$row['CreatequotationID']}' 
                            data-createuserid='{$row['UserID']}' class='btn btn-info btn-sm'><i
                            class='fas fa-edit'></i></a>
                        <a href='#' id='btndelete' data-toggle='tooltip' data-placement='bottom'
                            data-aid='{$row['AID']}'
                            data-createquotationid='{$row['CreatequotationID']}'
                            data-filepath='{$row['CompanyPdf']}'
                            title='ဖျက်သိမ်းမည်' class='btn btn-danger btn-sm'><i
                            class='fas fa-trash'></i></a>
                    </div>
                </td>
            </tr>";
        }
        $out.="</tbody>";
        $out.="</table>";

        $sql_total="SELECT q.AID FROM tblquotationvoucher q,tblcreatequotation c,tblproject p
        WHERE q.CreatequotationID=c.AID AND q.ProjectID=p.AID ".$a." 
        ORDER BY q.AID DESC";
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
                if($next_id > $total_links){
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
            <th width="7%;">စဉ်</th>
            <th>Quotation Title</th>                                        
            <th>Project Name</th>
            <th>Name</th>
            <th>Date</th>        
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-center">No data</td>
            </tr>
            </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'view'){
    $aid = $_POST["aid"];
    $createquotationid = $_POST["createquotationid"];
    $vuserid = $_POST["vuserid"];
    printVoucher($createquotationid,$vuserid);
}

if($action == 'edit'){
    $aid = $_POST["aid"];
    $createquotationid = $_POST["createquotationid"];
    $createuserid = $_POST["createuserid"];
    $_SESSION["edit_createquotationaid"] = $createquotationid;
    $_SESSION["edit_createuserid"] = $createuserid;
    echo 1;
}

if($action == 'delete'){
    $aid = $_POST["aid"];
    $createquotationid = $_POST["createquotationid"];
    $filepath = $_POST["filepath"];
    //delete quotationsell
    $whereone = [
        "CreatequotationID" => $createquotationid,
        "UserID" => $userid
    ];
    $resone = deleteData_Fun("tblquotation",$whereone);
    if($resone){
        //delete quotationvoucher
        $wheretwo = [
            "AID" => $aid
        ];
        $restwo = deleteData_Fun("tblquotationvoucher",$wheretwo);
        if($restwo){
            //delete pdf file
            if($filepath != "" || $filepath != NULL){
                if(file_exists(root."upload/files/".$filepath)){
                    unlink(root.'upload/files/'.$filepath);
                }
            }
            save_log($_SESSION["naiip_username"]." သည် Quotation Voucher အားဖျက်သွားသည်။");
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        echo 0;
    }
}

if($action == 'excel'){
    $search = $_POST['ser'];
    $a = ""; 
    $from=$_POST['hfrom'];  
    $to=$_POST['hto'];     
    $quotation=$_POST['hquotation'];
    if($search != ''){  
        $a .= " AND (c.Title like '%$search%') ";
    }
    if($from!='' || $to!=''){
        $a .=" and Date(q.Date)>='{$from}' and Date(q.Date)<='{$to}' ";
    }  
    if($quotation!=''){
        $a .=" and q.CreatequotationID={$quotation} ";
    }   
    $sql="SELECT q.*,c.AID AS caid,c.Title AS ctitle,p.Name AS projectname FROM tblquotationvoucher q,
    tblcreatequotation c,tblproject p WHERE q.CreatequotationID=c.AID AND q.ProjectID=p.AID AND 
    q.UserID='{$userid}' ".$a." ORDER BY q.AID DESC";
    $result = mysqli_query($con,$sql);
    $out="";
    $fileName = "QuotationVoucherList-".date('d-m-Y').".xls";
    $out .= '<head><meta charset="utf-8"></head>
            <table >  
                <tr>
                    <td colspan="5" align="center"><h3>QuotationVoucherList</h3></td>
                </tr>
                <tr><td colspan="5"><td></tr>
                <tr>  
                    <th style="border: 1px solid ;">No</th>  
                    <th style="border: 1px solid ;">Quotation Title</th>                                        
                    <th style="border: 1px solid ;">Project Name</th>
                    <th style="border: 1px solid ;">Name</th>
                    <th style="border: 1px solid ;">Date</th>   
                </tr>';
    if(mysqli_num_rows($result) > 0){
        $no=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $out .= '
                <tr>  
                    <td style="border: 1px solid ;">'.$no.'</td>  
                    <td style="border: 1px solid ;">'.$row["ctitle"].'</td>  
                    <td style="border: 1px solid ;">'.$row["projectname"].'</td>  
                    <td style="border: 1px solid ;">'.$row["Name"].'</td>
                    <td style="border: 1px solid ;">'.enDate($row["Date"]).'</td>     
                </tr>';
        }
    }
    else{
        $out .= '
            <tr>
                <td colspan="5" style="border: 1px solid ;" align="center">No data</td>
            </tr>';
    } 
    $out .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename='.$fileName);
    echo $out;  
    
}

if($action == 'excelquotation'){
    $voucheraid = $_POST["voucheraid"];
    $vcreatequotationid = $_POST["vcreatequotationid"];
    $vuserid = $_POST["vuserid"];
    $sql="SELECT q.*,c.Title as title FROM tblquotation q,tblcreatequotation c WHERE 
    q.CreatequotationID=c.AID AND q.CreatequotationID = '{$vcreatequotationid}' AND 
    q.UserID='{$vuserid}' ORDER BY q.AID DESC";
    $result = mysqli_query($con,$sql);
    $out="";
    $fileName = "QuotationList-".date('d-m-Y').".xls";
    $out .= '<head><meta charset="utf-8"></head>
            <table >  
                <tr>
                    <td colspan="7" align="center"><h3>QuotationList</h3></td>
                </tr>
                <tr><td colspan="7"><td></tr>
                <tr>  
                    <th style="border: 1px solid ;">No</th>  
                    <th style="border: 1px solid ;">Quotation Title</th>                                        
                    <th style="border: 1px solid ;">Item Name</th>
                    <th style="border: 1px solid ;">Specification</th>
                    <th style="border: 1px solid ;">Qty</th>   
                    <th style="border: 1px solid ;">Unit Price</th>   
                    <th style="border: 1px solid ;">Total Price</th>   
                </tr>';
    if(mysqli_num_rows($result) > 0){
        $no=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $out .= '
                <tr>  
                    <td style="border: 1px solid ;">'.$no.'</td>  
                    <td style="border: 1px solid ;">'.$row["title"].'</td>  
                    <td style="border: 1px solid ;">'.$row["ItemName"].'</td>  
                    <td style="border: 1px solid ;">'.$row["Specification"].'</td>
                    <td style="border: 1px solid ;">'.number_format($row["Qty"]).'</td>    
                    <td style="border: 1px solid ;">'.number_format($row["UnitPrice"]).'</td>  
                    <td style="border: 1px solid ;">'.number_format($row["TotalPrice"]).'</td>   
                </tr>';
        }
    }
    else{
        $out .= '
            <tr>
                <td colspan="7" style="border: 1px solid ;" align="center">No data</td>
            </tr>';
    } 
    $out .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename='.$fileName);
    echo $out;  
    
}



?>