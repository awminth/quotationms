<?php
include('../config.php');

$action = $_POST["action"];
$userid = $_SESSION["naiip_userid"];

if($action == 'show'){
    $aid = $_SESSION["edit_createquotationaid"];
    $createuserid = $_SESSION["edit_createuserid"];
    $sql="SELECT q.*,c.Title AS title,g.Name AS categoryname FROM tblquotation q,tblcreatequotation c,tblcategory g 
    WHERE q.CreatequotationID=c.AID AND q.CategoryID=g.AID AND q.CreatequotationID='{$aid}' AND q.UserID='{$createuserid}' 
    ORDER BY q.AID DESC";
    $result=mysqli_query($con,$sql) or die("SQL a Query");
    $out="";
    if(mysqli_num_rows($result) > 0){
        $out.='
        <table class="table table-bordered table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">No</th>
            <th>QuotationTitle</th>
            <th>CategoryName</th>
            <th>ItemName</th>
            <th>Specification</th>
            <th>Qty</th>
            <th>UnitPrice</th>
            <th>TotalPrice</th>
            <th>WebsiteLink</th>
            <th>Remark</th>
            <th>Date</th>
            <th width="10%;" class="text-center">Action</th>           
        </tr>
        </thead>
        <tbody>
        ';
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["title"]}</td>  
                <td>{$row["categoryname"]}</td>  
                <td>{$row["ItemName"]}</td>  
                <td>{$row["Specification"]}</td>  
                <td>".number_format($row["Qty"])."</td>  
                <td>".number_format($row["UnitPrice"])."</td>  
                <td>".number_format($row["TotalPrice"])."</td>  
                <td><a href='".$row["WebsiteLink"]."' target='_blank'>{$row["WebsiteLink"]}</a></td>  
                <td>{$row["Remark"]}</td>  
                <td>".enDate($row["Date"])."</td>  
                <td class='text-center'>
                    <div class='dropdown dropleft'>
                    <a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-h text-primary' style='font-size:22px;cursor:pointer;'></i>
                    </a>
                        <div class='dropdown-menu'>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-categoryid='{$row['CategoryID']}'
                                data-itemname='{$row['ItemName']}'
                                data-specification='{$row['Specification']}'
                                data-qty='{$row['Qty']}'
                                data-unitprice='{$row['UnitPrice']}'
                                data-totalprice='{$row['TotalPrice']}'
                                data-weblink='{$row['WebsiteLink']}'
                                data-remark='{$row['Remark']}'
                                data-dt='{$row['Date']}'>
                                <i class='fas fa-edit text-primary'
                                style='font-size:13px;'></i>
                            Edit</a>
                            <div class='dropdown-divider'></div>
                            <a href='#' id='btndelete' class='dropdown-item'
                                data-aid='{$row['AID']}'
                                data-itemname='{$row['ItemName']}'><i
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
        echo $out; 
        
    }
    else{
        $out.='
        <table class="table table-bordered table-striped responsive nowrap">
        <thead>
        <tr>
            <th width="7%;">No</th>
            <th>QuotationTitle</th>
            <th>CategoryName</th>
            <th>ItemName</th>
            <th>Specification</th>
            <th>Qty</th>
            <th>WebsiteLink</th>
            <th>Remark</th>
            <th>Date</th>        
        </tr>
        </thead>
        <tbody>
        <tr>
                <td colspan="9" class="text-center">No data</td>
            </tr>
        </tbody>
        </table>
        '; 
        echo $out;
    }

}

if($action == "save"){
    $createquotationid = $_SESSION["edit_createquotationaid"];
    $categoryid = $_POST["categoryid"];
    $itemname = $_POST["itemname"];
    $specification = $_POST["specification"];
    $qty = $_POST["qty"];
    $weblink = $_POST["weblink"];
    $remark = $_POST["remark"];
    $dt = $_POST["dt"];
    $data = [
        "CategoryID" => $categoryid,
        "ItemName" => $itemname,
        "Specification" => $specification,
        "Qty" => $qty,
        "WebsiteLink" => $weblink,
        "Remark" => $remark,
        "CreatequotationID" => $createquotationid,
        "Date" => $dt,
        "UserID" => $userid
    ];  
    $result = insertData_Fun("tblquotation",$data);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် Quotation name(".$itemname .")အမည်ဖြင့်အသစ်သွင်းသွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == "edit"){
    $aid = $_POST["eaid"];
    $categoryid = $_POST["ecategoryid"];
    $itemname = $_POST["eitemname"];
    $specification = $_POST["especification"];
    $qty = $_POST["eqty"];
    $unitprice = $_POST["eunitprice"];
    $totalprice = $_POST["etotalprice"];
    $weblink = $_POST["eweblink"];
    $remark = $_POST["eremark"];
    $dt = $_POST["edt"];
    $data = [
        "CategoryID" => $categoryid,
        "ItemName" => $itemname,
        "Specification" => $specification,
        "Qty" => $qty,
        "UnitPrice" => $unitprice,
        "TotalPrice" => $totalprice,
        "WebsiteLink" => $weblink,
        "Remark" => $remark,
        "Date" => $dt
    ];  
    $where = [
        "AID" => $aid
    ];
    $result = updateData_Fun("tblquotation",$data,$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် Quotation name(".$itemname .")အားပြင်ဆင်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == "delete"){
    $aid = $_POST["aid"];
    $itemname = $_POST["itemname"];
    $where = [
        "AID" => $aid
    ];
    $result = deleteData_Fun("tblquotation",$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် Quotation name(".$itemname .")အားဖျက်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

if($action == "editvoucher"){
    $createquotationid = $_SESSION["edit_createquotationaid"];
    $aid = $_POST["voucheraid"];
    $projectid = $_POST["eprojectid"];
    $name = $_POST["ename"];
    $dt = $_POST["edt"];
    $new_filename = "";
    $hid_fileupload = $_POST["hid_fileupload"];

    //File Upload
    // PDF file ကို စစ်ဆေးပြီး upload လုပ်ခြင်း
    if(isset($_FILES['fileupload']) && $_FILES['fileupload']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['fileupload']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = $_FILES['fileupload']['tmp_name'];
        $valid_pdf_extensions = array("pdf", "PDF","docx","DOCX","doc","DOC","XLSX","xlsx","xls","XLS");

        if(in_array($extension, $valid_pdf_extensions)) {
            $new_filename = date("YmdHis").$extension; // ပုံနဲ့ နာမည်မတူအောင် ပြောင်းထား
            $new_path = root . "upload/files/" . $new_filename; // PDF အတွက် folder သီးသန့်ထား            
            if(move_uploaded_file($file, $new_path)){
                if($hid_fileupload != ""){
                    unlink(root. "upload/files/" . $hid_fileupload);
                }
            }
            
        }
    }
    $data = [
        "ProjectID" => $projectid,
        "Name" => $name,
        "Date" => $dt,
        "CompanyPdf" => $new_filename
    ]; 
    $where = [
        "AID" => $aid
    ]; 
    $result = updateData_Fun("tblquotationvoucher",$data,$where);
    if($result){
        save_log($_SESSION["naiip_username"]." သည် Quotation Voucher အားပြင်ဆင်သွားသည်။");
        echo 1;
    }
    else{
        echo 0;
    }
}

?>