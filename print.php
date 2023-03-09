<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container pt-5">
<h5 class='text-success'>Customer details</h5>
<table class='table table-bordered'>
    <thead>
    <tr>
<th>Invoice No</th>
<th>Invoice Date</th>
<th>Customer Name</th>
<th>Address</th>
<th>City</th>
<th>Grand Total</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
include 'conn.php';
$sql="SELECT * FROM `invoice`";
$result=mysqli_query($con,$sql);
if($result){
    while( $row=mysqli_fetch_assoc($result)){  
        $SID  =$row['SID'];
     $INVOICE_NO =$row['INVOICE_NO'];
     $INVOICE_DATE =date("d-m-y",strtotime($row['INVOICE_DATE']));
     $CNAME =$row['CNAME'];
     $CADDRESS =$row['CADDRESS'];
     $CCITY =$row['CCITY'];
     $GRAND_TOTAL =$row['GRAND_TOTAL']; 
     echo '<tr>
     <th scope="row">'.$INVOICE_NO.'</th>
     <td>'.$INVOICE_DATE.'</td>
     <td>'.$CNAME.'</td>
     <td>'.$CADDRESS.'</td>
     <td>'.$CCITY.'</td>
     <td>'.$GRAND_TOTAL.'</td>
     <td><button class="btn btn-primary" ><a href="pdf.php?pdfid='.$SID .'" class="text-light">INVOICE</a></button></td>
   </tr>';
  
 } 
 }
 else{
     echo "unsuccessful<br>";
 }
?>
</tbody>
</table>
<button class="btn btn-success float-right" ><a href="index.php" class="text-light">Back</a></button>
    </div>
</body>
</html>