<?php 
  require ("fpdf/fpdf.php");
  require ("word.php");

  //customer and invoice details
  $info=[
    "customer"=>"",
    "address"=>"",
    "city"=>"",
    "invoice_no"=>"",
    "invoice_date"=>"",
    "total_amt"=>"",
    "words"=>"",
  ];

  //Select Invoice Details From Database
  
  include 'conn.php';
  $sql="SELECT * FROM `invoice` WHERE SID='{$_GET["id"]}'";
$result=mysqli_query($con,$sql);
  if($result->num_rows>0){
  $row=$result->fetch_assoc();
  
  $obj=new IndianCurrency($row["GRAND_TOTAL"]);     
      
      $info=[
            "customer"=>$row["CNAME"],
            "address"=>$row["CADDRESS"],
            "city"=>$row["CCITY"],
            "invoice_no"=>$row["INVOICE_NO"],
            "invoice_date"=>date("d-m-Y",strtotime($row["INVOICE_DATE"])),
            "total_amt"=>$row["GRAND_TOTAL"],
            "words"=> $obj->get_words(),
          ];
 } 
 
 else{
     echo "unsuccessful<br>";
 }

  //invoice Products
  $products_info=[];
  $sql="select * from invoice_products where SID='{$_GET["id"]}'";
  $res=$con->query($sql);
  $row_t= mysqli_num_rows($res);


  $sql_d="SELECT * FROM `invoice_products` WHERE SID={$_GET["id"]} AND  DISCOUNT=0";
    $result=mysqli_query($con,$sql_d);
    $row_d= mysqli_num_rows($result);
  
    $sql_g="SELECT * FROM `invoice_products` WHERE SID={$_GET["id"]} AND  GST=0";
    $result=mysqli_query($con,$sql_g);
    $row_g= mysqli_num_rows($result);
   
  if($res->num_rows>0){
	  while($row=$res->fetch_assoc()){
		   $products_info[]=[
			"name"=>$row["PNAME"],
			"price"=>$row["PRICE"],
			"qty"=>$row["QTY"],
			"amount"=>$row["AMOUNT"],
            "disc"=>$row["DISCOUNT"],
            "namount"=>$row["NET_AMOUNT"],
            "gst"=>$row["GST"],
            "famount"=>$row["FINAL_AMOUNT"],
		   ];
	  }
  }
  



  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"ABC COMPUTERS",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"West Street,",0,1);
      $this->Cell(50,7,"Salem 636002.",0,1);
      $this->Cell(50,7,"PH : 8778731770",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$products_info,$row_t,$row_d,$row_g){
     
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      $this->Cell(50,7,$info["city"],0,1);
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(100);
      $this->SetX(10);


      $x_d=35;
      $x_p=23;
      $x_q=23;
      $x_a=23;
      $x_di=23;
      $x_na=23;
      $x_g=23;
      $x_fa=25;

      $y=9;

      if($row_t==$row_d && $row_t==$row_g){
        $x_d+=$x_di+$x_g;
      }

      else if($row_t==$row_d){
          $x_d+=$x_di;
      }

      else if($row_t==$row_g){
      $x_d+=$x_g;          
      }
    
      $this->SetFont('Arial','B',12);
      $this->Cell($x_d,$y,"DESC",1,0);
      $this->Cell($x_p,$y,"PRICE",1,0,"C");
      $this->Cell($x_q,$y,"QTY",1,0,"C");
      $this->Cell($x_a,$y,"AMT",1,0,"C");

      if($row_t!=$row_d){
      $this->Cell($x_di,$y,"DISC",1,0,"C");
      }

      $this->Cell($x_na,$y,"NET_AMT",1,0,"C");

      if($row_t!=$row_g){
      $this->Cell($x_g,$y,"GST",1,0,"C");
      }

      $this->Cell($x_fa,$y,"FINAL_AMT",1,1,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell($x_d,$y,$row["name"],"LR",0);
        $this->Cell($x_p,$y,$row["price"],"R",0,"R");
        $this->Cell($x_q,$y,$row["qty"],"R",0,"C");
        $this->Cell($x_a,$y,$row["amount"],"R",0,"R");

        if($row_t!=$row_d){
          $this->Cell($x_di,$y,$row["disc"],"R",0,"R");
        }

        $this->Cell($x_na,$y,$row["namount"],"R",0,"R");

         if($row_t!=$row_g){
          $this->Cell($x_g,$y,$row["gst"],"R",0,"R");
        }
       
        
        $this->Cell($x_fa,$y,$row["famount"],"R",1,"R");
      }
   
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell($x_d,$y,"","LR",0);
        $this->Cell($x_p,$y,"","R",0,"R");
        $this->Cell($x_q,$y,"","R",0,"C");
        $this->Cell($x_a,$y,"","R",0,"C");

        if($row_t!=$row_d){
        $this->Cell($x_di,$y,"","R",0,"C");
        }

        $this->Cell($x_na,$y,"","R",0,"C");

        if($row_t!=$row_g){
        $this->Cell($x_g,$y,"","R",0,"C");
        }

        $this->Cell($x_fa,$y,"","R",1,"R");
      }
  
        //Display table total row
        $this->SetFont('Arial','B',12);
        $this->Cell(150,9,"TOTAL",1,0,"R");
        $this->Cell(48,9,$info["total_amt"],1,1,"R");
  
      
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$info["words"],0,1);
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info,$row_t,$row_d,$row_g);
  $pdf->Output();
?>