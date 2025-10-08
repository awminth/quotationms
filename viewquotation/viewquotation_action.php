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
        $a = " and (v.VNO like '%$search%' or c.Name like '%$search%' or u.UserName like '%$search%') ";
    } 
    $from=$_POST['from'];  
    $to=$_POST['to'];     
    $customer=$_POST['customer'];   
    $b="";
    $c="";
    if($from!='' || $to!=''){
        $b=" and Date(v.Date)>='{$from}' and Date(v.Date)<='{$to}' ";
    }  
    if($customer!=''){
        $c=" and v.CustomerID={$customer} ";
    }   
    $sql="select v.*,Date(v.Date) as vdate,c.Name,u.UserName 
    from tblvoucher v,tblcustomer c,tbluser u 
    where v.UserID=u.AID and v.CustomerID=c.AID and v.Chk='Cash' ".$b.$c.$a." 
    order by AID desc limit $offset,$limit_per_page";
    $result=mysqli_query($con,$sql) or die("SQL a Query");
    $out="";
    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-bordered tabel-sm table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">စဉ်</th>
            <th>Date</th>                                        
            <th>VNO</th>
            <th>Customer</th>
            <th class="text-right">SubTotal</th>                                                                             
            <th>Disc</th>
            <th>Tax</th>
            <th class="text-right">Total</th>  
            <th class="text-right">Cash</th> 
            <th class="text-right">Refund</th> 
            <th>Cashier</th>     
            <th width="10%;" class="text-center">Actions</th>       
        </tr>
        </thead>
        <tbody>
        ';
        $no=0;
        $totalamt=0;
        $totaldis=0;
        $totaltax=0;
        $total=0;
        $totalcash=0;
        $totalrefund=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $totalamt+=$row["TotalAmt"];
            $totaldis+=$row["Dis"];
            $totaltax+=$row["Tax"];
            $total+=$row["Total"];
            $totalcash+=$row["Cash"];
            $totalrefund+=$row["Refund"];
            $out.="<tr>
                <td>{$no}</td>
                <td><span class='badge badge-info'>".enDate($row["vdate"])."</span></td>
                <td><span class='badge badge-info'>{$row["VNO"]}</span></td>
                <td>{$row["Name"]}</td>
                <td class='text-right' >".number_format($row["TotalAmt"])."</td>                                       
                <td  class='text-right' >".number_format($row["Dis"])."</td>
                <td class='text-right' >".number_format($row["Tax"])."</td>
                <td class='text-right' >".number_format($row["Total"])."</td>
                <td class='text-right' >".number_format($row["Cash"])."</td>
                <td class='text-right' >".number_format($row["Refund"])."</td>
                <td >{$row["UserName"]}</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <a href='#' id='viewsell' data-toggle='tooltip' data-placement='bottom'
                            title='အသေးစိတ်ကြည့်မည်' data-vno='{$row['VNO']}'
                            data-customerid='{$row['CustomerID']}'
                            data-cusname='{$row['Name']}'
                            data-userid='{$row['UserID']}'
                            data-date='{$row['Date']}'
                            data-totalamt='{$row['TotalAmt']}'
                            data-total='{$row['Total']}'
                            data-dis='{$row['Dis']}'
                            data-tax='{$row['Tax']}'
                            data-cash='{$row['Cash']}'
                            data-refund='{$row['Refund']}' 
                            data-credit='{$row['Credit']}' 
                            data-chk='{$row['Chk']}' 
                            class='btn btn-success btn-sm'><i class='fas fa-eye'></i></a>
                        <a style='display:none;' href='#' id='editsell' data-toggle='tooltip' data-placement='bottom'
                            title='ပြင်ဆင်မည်' 
                            data-vno='{$row['VNO']}'
                            data-customerid='{$row['CustomerID']}'
                            data-customername='{$row['Name']}'
                            data-totalamt='{$row['TotalQty']}'
                            data-totalqty='{$row['TotalAmt']}' 
                            data-chk='{$row['Chk']}'  class='btn btn-info btn-sm'><i
                            class='fas fa-edit'></i></a>
                        <a href='#' data-vno='{$row['VNO']}' id='deletesell' data-toggle='tooltip' data-placement='bottom'
                            title='ဖျက်သိမ်းမည်' class='btn btn-danger btn-sm'><i
                            class='fas fa-trash'></i></a>
                    </div>
                </td>
            </tr>";
        }
        $out.="</tbody>";
        $out.="<tfoot>
                    <tr>                                                                               
                        <td></td>
                        <td></td>  
                        <td></td>                                     
                        <td>စုစုပေါင်း</td>
                        <td class='text-right' >".number_format($totalamt)."</td>                                       
                        <td class='text-right'>".number_format($totaldis)."</td>
                        <td class='text-right' >".number_format($totaltax)."</td>
                        <td class='text-right' >".number_format($total)."</td>
                        <td class='text-right' >".number_format($totalcash)."</td>
                        <td class='text-right' >".number_format($totalrefund)."</td>
                        <td></td>   
                        <td></td>                                 
                    </tr>
                </tfoot>";
        $out.="</table>";

        $sql_total="select v.AID  
        from tblvoucher v,tblcustomer c,tbluser u 
        where v.UserID=u.AID and v.CustomerID=c.AID and v.Chk='Cash' ".$b.$c.$a." 
        order by AID desc";
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
            <th>Date</th>                                        
            <th>VNO</th>
            <th>Customer</th>
            <th class="text-right">စုစုပေါင်း</th>                                                                             
            <th>Disc</th>
            <th>Tax</th>
            <th class="text-right">စုစုပေါင်း</th>  
            <th class="text-right">Cash</th>  
            <th class="text-right">Refund</th>  
            <th>Cashier</th>          
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="12" class="text-center">No data</td>
            </tr>
            </tbody>
        </table>
        ';
        echo $out;
    }
}

if($action == 'view'){
    $vno = $_POST["vno"];
    echo print_voucher($vno);
}

if($action == 'edit'){
    $vno = $_POST["vno"];
    $customerid = $_POST["customerid"];
    $customername = $_POST["customername"];
    $totalamt = $_POST["totalamt"];
    $totalqty = $_POST["totalqty"];
    $userid = $_SESSION["naiip_userid"];
    $chk = $_POST["chk"];

    $sql_temp = 'insert into tblsale_temp (RemainID,CodeNo,ItemName,Qty,SellPrice,UserID) 
    select RemainID,CodeNo,ItemName,Qty,SellPrice,"'.$userid.'"  
    from tblsale where VNO="'.$vno.'"';
    if(mysqli_query($con,$sql_temp)){
        $_SESSION["editcustomerid"] = $customerid;
        $_SESSION["editcustomername"] = $customername;
        $_SESSION["editsalevno"] = $vno; 
        $_SESSION["editsalechk"] = $chk; 
        echo 1;
    }else{
        echo 0;
    }
}

if($action == 'delete'){
    $vno = $_POST["vno"];
    $sqlsale="select * from tblsale where VNO='{$vno}'";
    $result=mysqli_query($con,$sqlsale);
    if(mysqli_num_rows($result)>0){
        while( $rowqty = mysqli_fetch_array($result)){      
       
            $sqlremain="select Qty from tblremain where CodeNo='{$rowqty['CodeNo']}'";
            $result1=mysqli_query($con,$sqlremain);
            $rowqty1 = mysqli_fetch_array($result1);
            $newqty=$rowqty['Qty']+$rowqty1['Qty'];

            $sqlremain1="update tblremain set Qty={$newqty} where CodeNo='{$rowqty['CodeNo']}'";
            mysqli_query($con,$sqlremain1);
        }

        $sqldel1 ="delete from tblsale where VNO='{$vno}'";       
        mysqli_query($con,$sqldel1);
        $sqldel2= "delete from tblvoucher where VNO='{$vno}'";
        mysqli_query($con,$sqldel2);

        save_log($_SESSION["naiip_username"]." သည် vno: ".$vno." ၏ cash အရောင်းစာရင်းအားဖျက်သွားသည်။");
        echo 1;
    }else{
        echo 0;
    }
}

if($action == 'excel'){
    $search = $_POST['ser'];
    $a = "";
    if($search != ''){  
        $a = " and (v.VNO like '%$search%' or c.Name like '%$search%' or u.UserName like '%$search%') ";
    } 
    $from=$_POST['hfrom'];  
    $to=$_POST['hto'];     
    $customer=$_POST['hcustomer'];   
    $b="";
    $c="";
    if($from!='' || $to!=''){
        $b=" and Date(v.Date)>='{$from}' and Date(v.Date)<='{$to}' ";
    }  
    if($customer!=''){
        $c=" and v.CustomerID={$customer} ";
    }   
    $sql="select v.*,Date(v.Date) as vdate,c.Name,u.UserName 
    from tblvoucher v,tblcustomer c,tbluser u 
    where v.UserID=u.AID and v.CustomerID=c.AID and v.Chk='Cash' ".$b.$c.$a." 
    order by AID desc ";
    $result = mysqli_query($con,$sql);
    $out="";
    $fileName = "SaleReport-".date('d-m-Y').".xls";
    if(mysqli_num_rows($result) > 0){
        $out .= '<head><meta charset="utf-8"></head>
        <table >  
            <tr>
                <td colspan="11" align="center"><h3>Cash Report</h3></td>
            </tr>
            <tr><td colspan="11"><td></tr>
            <tr>  
                <th style="border: 1px solid ;">No</th>  
                <th style="border: 1px solid ;">VNO</th>  
                <th style="border: 1px solid ;">Customer</th>  
                <th style="border: 1px solid ;">TotalQty</th>
                <th style="border: 1px solid ;">Discount</th>  
                <th style="border: 1px solid ;">Tax</th>  
                <th style="border: 1px solid ;">TotalAmt</th>
                <th style="border: 1px solid ;">Cash</th>
                <th style="border: 1px solid ;">Refund</th>
                <th style="border: 1px solid ;">Cashier</th>  
                <th style="border: 1px solid ;">Date</th>  
            </tr>';
        $no=0;
        while($row = mysqli_fetch_array($result)){
            $no = $no + 1;
            $out .= '
                <tr>  
                    <td style="border: 1px solid ;">'.$no.'</td>  
                    <td style="border: 1px solid ;">'.$row["VNO"].'</td>  
                    <td style="border: 1px solid ;">'.$row["Name"].'</td>  
                    <td style="border: 1px solid ;">'.$row["TotalQty"].'</td>
                    <td style="border: 1px solid ;">'.$row["Dis"].'</td>  
                    <td style="border: 1px solid ;">'.$row["Tax"].'</td>  
                    <td style="border: 1px solid ;">'.number_format($row["Total"]).'</td>
                    <td style="border: 1px solid ;">'.number_format($row["Cash"]).'</td>
                    <td style="border: 1px solid ;">'.number_format($row["Refund"]).'</td>
                    <td style="border: 1px solid ;">'.$row["UserName"].'</td>  
                    <td style="border: 1px solid ;">'.enDate($row["vdate"]).'</td>     
                </tr>';
        }
        $out .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo $out;
    }else{
        $out .= '<head><meta charset="utf-8"></head>
        <table >  
            <tr>
                <td colspan="11" align="center"><h3>Cash Report</h3></td>
            </tr>
            <tr><td colspan="11"><td></tr>
            <tr>  
                <th style="border: 1px solid ;">No</th>  
                <th style="border: 1px solid ;">VNO</th>  
                <th style="border: 1px solid ;">Customer</th>  
                <th style="border: 1px solid ;">TotalQty</th>
                <th style="border: 1px solid ;">Discount</th>  
                <th style="border: 1px solid ;">Tax</th>  
                <th style="border: 1px solid ;">TotalAmt</th>
                <th style="border: 1px solid ;">Cash</th>
                <th style="border: 1px solid ;">Refund</th>
                <th style="border: 1px solid ;">Cashier</th>  
                <th style="border: 1px solid ;">Date</th>  
            </tr>
            <tr>
                <td colspan="11" style="border: 1px solid ;" align="center">No data</td>
            </tr>';
        $out .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo $out;
    }   
    
}



?>