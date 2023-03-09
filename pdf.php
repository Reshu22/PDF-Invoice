<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container pt-5">
<button class="btn btn-success" ><a href="print.php" class="text-light">Back</a></button>
<br><br>
<h5 class='text-success'>Invoice details</h5>
<table class='table table-bordered width: 650px'>
<tbody bordered>
<?php
   include 'conn.php';
   if(isset($_GET['pdfid'])){
    $pdfid=$_GET['pdfid'];
    $sql="SELECT * FROM `invoice_products` WHERE SID=$pdfid";
    $result=mysqli_query($con,$sql);
    if($result){
        $row= mysqli_num_rows($result);
    }
    else{
        echo "unsuccessful<br>";
    }
       $sql_d="SELECT * FROM `invoice_products` WHERE SID=$pdfid AND  DISCOUNT=0";
        $result=mysqli_query($con,$sql_d); 
        if($result){
            $row_d= mysqli_num_rows($result);
            //echo $row_d;
        }
        else{
            echo "unsuccessful<br>";
        } 


        $sql_g="SELECT * FROM `invoice_products` WHERE SID=$pdfid AND  GST=0";
        $result=mysqli_query($con,$sql_g); 
        if($result){
            $row_g= mysqli_num_rows($result);
            //echo $row_d;
        }
        else{
            echo "unsuccessful<br>";
        } 
        
   if($row==$row_d && $row==$row_g){?>
    <thead>
    <tr>
<th>Product Name</th>
<th>Price</th>
<th>Qty</th>
<th>Amount</th>
<th>Net Amount</th>
<th>Final Amount</th>
</tr>
</thead>

   <?php $sql="SELECT * FROM `invoice_products` WHERE SID=$pdfid";
    $result=mysqli_query($con,$sql);
    if($result){
        while( $row=mysqli_fetch_assoc($result)){
        
            $SID =$row['SID'];
            $PNAME =$row['PNAME'];  
         $PRICE=$row['PRICE'];
         $QTY=$row['QTY'];
         $AMOUNT=$row['AMOUNT'];
         $NET_AMOUNT=$row['NET_AMOUNT'];
         $FINAL_AMOUNT=$row['FINAL_AMOUNT'];    
         echo '<tr>   
         <td>'.$PNAME.'</td>   
         <td>'.$PRICE.'</td> 
         <td>'.$QTY.'</td>
         <td>'.$AMOUNT.'</td> 
         <td>'.$NET_AMOUNT.'</td>
         <td>'.$FINAL_AMOUNT.'</td>
       </tr>';
      
     } 
     }
     else{
         echo "unsuccessful<br>";
     }
    }

     else if($row==$row_g){?>
        <thead>
        <tr>
    <th>Product Name</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Amount</th>
    <th>Discount</th>
    <th>Net Amount</th>
    <th>Final Amount</th>
    </tr>
    </thead>
    
       <?php $sql="SELECT * FROM `invoice_products` WHERE SID=$pdfid";
        $result=mysqli_query($con,$sql);
        if($result){
            while( $row=mysqli_fetch_assoc($result)){
            
                $SID =$row['SID'];
                $PNAME =$row['PNAME'];  
             $PRICE=$row['PRICE'];
             $QTY=$row['QTY'];
             $AMOUNT=$row['AMOUNT'];
             $DISCOUNT=$row['DISCOUNT'];
             $NET_AMOUNT=$row['NET_AMOUNT'];
             $FINAL_AMOUNT=$row['FINAL_AMOUNT'];    
             echo '<tr>   
             <td>'.$PNAME.'</td>   
             <td>'.$PRICE.'</td> 
             <td>'.$QTY.'</td>
             <td>'.$AMOUNT.'</td> 
             <td>'.$DISCOUNT.'</td>
             <td>'.$NET_AMOUNT.'</td>
             <td>'.$FINAL_AMOUNT.'</td>
           </tr>';
          
         } 
         }
         else{
             echo "unsuccessful<br>";
         }


   }



   else if($row==$row_d){?>
    <thead>
    <tr>
<th>Product Name</th>
<th>Price</th>
<th>Qty</th>
<th>Amount</th>
<th>Net Amount</th>
<th>GST</th>
<th>Final Amount</th>
</tr>
</thead>

   <?php $sql="SELECT * FROM `invoice_products` WHERE SID=$pdfid";
    $result=mysqli_query($con,$sql);
    if($result){
        while( $row=mysqli_fetch_assoc($result)){
        
            $SID =$row['SID'];
            $PNAME =$row['PNAME'];  
         $PRICE=$row['PRICE'];
         $QTY=$row['QTY'];
         $AMOUNT=$row['AMOUNT'];
         $NET_AMOUNT=$row['NET_AMOUNT'];
         $GST=$row['GST'];
         $FINAL_AMOUNT=$row['FINAL_AMOUNT'];    
         echo '<tr>   
         <td>'.$PNAME.'</td>   
         <td>'.$PRICE.'</td> 
         <td>'.$QTY.'</td>
         <td>'.$AMOUNT.'</td> 
         <td>'.$NET_AMOUNT.'</td>
         <td>'.$GST.'</td>
         <td>'.$FINAL_AMOUNT.'</td>
       </tr>';
      
     } 
     }
     else{
         echo "unsuccessful<br>";
     }
}


else {?>
    <thead>
    <tr>
<th>Product Name</th>
<th>Price</th>
<th>Qty</th>
<th>Amount</th>
<th>Discount</th>
<th>Net Amount</th>
<th>GST</th>
<th>Final Amount</th>
</tr>
</thead>

   <?php $sql="SELECT * FROM `invoice_products` WHERE SID=$pdfid";
    $result=mysqli_query($con,$sql);
    if($result){
        while( $row=mysqli_fetch_assoc($result)){
        
            $SID =$row['SID'];
            $PNAME =$row['PNAME'];  
         $PRICE=$row['PRICE'];
         $QTY=$row['QTY'];
         $AMOUNT=$row['AMOUNT'];
         $DISCOUNT=$row['DISCOUNT'];
         $NET_AMOUNT=$row['NET_AMOUNT'];
         $GST=$row['GST'];
         $FINAL_AMOUNT=$row['FINAL_AMOUNT'];    
         echo '<tr>   
         <td>'.$PNAME.'</td>   
         <td>'.$PRICE.'</td> 
         <td>'.$QTY.'</td>
         <td>'.$AMOUNT.'</td>
         <td>'.$DISCOUNT.'</td> 
         <td>'.$NET_AMOUNT.'</td>
         <td>'.$GST.'</td>
         <td>'.$FINAL_AMOUNT.'</td>
       </tr>';
      
     } 
     }
     else{
         echo "unsuccessful<br>";
     }


}

   }
   ?>


</tbody>
</table>
<button class="btn btn-success float-right" ><a href="doc.php?id=<?php echo $SID ?>"  class="text-light">Print</a></button>
</div>  
</body>
</html>