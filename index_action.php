<?php 
include("config.php");

$action=$_POST["action"];

if($action=="login"){
      $username=$_POST["username"];
      $password=$_POST["password"];    

      $sql="select * from tbluser where UserName='{$username}' and Password='{$password}'";
      $result = mysqli_query($con,$sql);  
      if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $_SESSION["naiip_userid"] =$row['AID'];
            $_SESSION["naiip_username"] =$row['UserName'];                  
            $_SESSION["naiip_usertype"] =$row['UserType'];
            $_SESSION["naiip_userpassword"] =$row['Password']; 

            // $sql1="select * from tblsetting limit 1";
            // $result1 = mysqli_query($con,$sql1);
            // $row1 = mysqli_fetch_array($result1);

            // $_SESSION["shopname"] =$row1['ShopName'];
            // $_SESSION["shopaddress"] =$row1['Address'];                  
            // $_SESSION["shopphno"] =$row1['PhoneNo'];
            // $_SESSION["shopemail"] =$row1['Email']; 
            
            save_log($row['UserName']." Login ဝင်သွားသည်");
            echo 1;
      }else{
            session_unset();
            echo 0;
      }
}

if($action=="logout"){   
      save_log($_SESSION['naiip_username']."Logout လုပ်သွားသည်");
      // session_unset();
      kill_all_session();
      echo 1;
}

if($action=="today"){  
    $dt = date("Y-m-d");
      $sql="select sum(Total) as stotal from tblvoucher 
      where Date(Date)=Date('$dt')";
      $result = mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);

      $sql="select sum(TotalAmt) as stotal 
      from tblordervoucher where Status=1 and Date(Date)=Date('$dt')";
      $result = mysqli_query($con,$sql);
      $roww = mysqli_fetch_array($result);

      $sql="select Sum(s.Qty*r.PurchasePrice) as rtotal 
      from tblsale s,tblremain r 
      where r.AID=s.RemainID and Date(s.Date)=Date('$dt')";
      $result = mysqli_query($con,$sql);       
      $row1 = mysqli_fetch_array($result);

      $sql="select Sum(s.Qty*r.PurchasePrice) as rtotal 
      from tblordersale s,tblremain r 
      where r.AID=s.RemainID and s.Status=1 and Date(s.Date)=Date('$dt')";
      $result = mysqli_query($con,$sql);       
      $row11 = mysqli_fetch_array($result);

      $sql="select Sum(Amount) as etotal from tblexpense where Date(Date)=Date('$dt')";
      $result = mysqli_query($con,$sql);
      $row2 = mysqli_fetch_array($result);

      $profit=($row['stotal']+$roww['stotal'])-($row1['rtotal']+$row11['rtotal']+$row2['etotal']);

      $out="";
      $out.="
      <h5 class='text-center'>ယနေ့အရောင်း</h5>
      <hr> 
      <table class='table table-bordered text-sm' frame=hsides rules=rows width='100%'>
            <tr>
                  <td>အရောင်းစုစုပေါင်း</td>
                  <td class='text-right txtr'>".number_format($row['stotal']+$roww['stotal'])." MMK</td>

            </tr>
            <tr>
                  <td>အဝယ်စုစုပေါင်း </td>
                  <td class='text-right txtr'>".number_format($row1['rtotal']+$row11['rtotal'])." MMK</td>

            </tr>
            <tr>
                  <td>အသုံးစရိတ်စုစုပေါင်း </td>
                  <td class='text-right txtr'>".number_format($row2['etotal'])." MMK</td>

            </tr>
            <tr>
                  <td>အမြတ်စုစုပေါင်း </td>
                  <td class='text-right txtr'>".number_format($profit)." MMK</td>

            </tr>
      </table>
      ";
      echo $out;
}





?>