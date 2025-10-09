<?php
include('../config.php');

$action = $_POST["action"];

if($action == 'show'){
    $aid = $_SESSION["quotationaid"];
    $sql="SELECT q.*,c.Title AS title,g.Name AS categoryname FROM tblquotation q,tblcreatequotation c,
    tblcategory g WHERE q.CreatequotationID=c.AID AND q.CategoryID=g.AID AND q.AID='{$aid}' ORDER BY q.AID DESC";
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
            <th>WebsiteLink</th>
            <th>Remark</th>
            <th>Date</th>
            <th width="10%;" class="text-center">Action</th>           
        </tr>
        </thead>
        <tbody>
        ';
        
        while($row = mysqli_fetch_array($result)){
            $no=$no+1;
            $out.="<tr>
                <td>{$no}</td>
                <td>{$row["title"]}</td>  
                <td>{$row["categoryname"]}</td>  
                <td>{$row["ItemName"]}</td>  
                <td>{$row["Specification"]}</td>  
                <td>".number_format($row["Qty"])."</td>  
                <td>{$row["WebsiteLink"]}</td>  
                <td>{$row["Remark"]}</td>  
                <td>".enDate($row["Date"])."</td>  
                <td class='text-center'>
                    <div class='dropdown dropleft'>
                    <a data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-h text-primary' style='font-size:22px;cursor:pointer;'></i>
                    </a>
                        <div class='dropdown-menu'>
                            <a href='#' id='btnedit' class='dropdown-item'
                                data-aid='{$row['AID']}'>
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

?>