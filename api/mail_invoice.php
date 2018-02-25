<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");


include('dbconfig.php');
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);
// $email = $request->email;
// $body = $request->body;
$email = 'greatguyharshit@gmail.com';

// $count = count($request) - 1;
$date = $request[0];
$invoice = $request[1];
$customer = $request[2];
$contact = $request[3];
$total = $request[4];
$shippingcharge = $request[5];
$adjustment = $request[6];
$adjustmentvalue = $request[7];
// $from = $request[8];
// $sendto = $request[9];
// $cc = $request[10];
$finaltotal = $total + $shippingcharge + $adjustmentvalue;
$tableData = '';




for ($i = 8; $i <= sizeof($request) - 1; $i++) {
    $gst = $request[$i]["item_tax"]/2;
$tableData = $tableData.
    '<tr>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content00">
            '.$request[$i]["item_name"].'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content01">
            '.$request[$i]["item_quantity"].'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content02">
            '.$request[$i]["item_rate"].'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content03">
            '.$request[$i]["item_discount"].'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content04">
            '.$gst.'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content05">
            '.$gst.'
        </td>
        <td valign="top" style = "border-top:1px solid #DDDDDD;border-bottom:0;color:#202020;font-family:Helvetica;font-size:12px;font-weight:bold;line-height:150%;text-align:left;" mc:edit="data_table_content06">
            '.$request[$i]["item_amount"].'
        </td>
    </tr>';
}



// for($i = 0; $i< count($request)-1; $i++) {
//     // $item_timestamp = $request[$i]['current_time'];
//     $item_invoice_number = $request[$i]["item_invoice_number"];
//     $item_salesperson = $request[$i]["item_salesperson"];
//     $item_additional_salesperson = $request[$i]["item_additional_salesperson"];
//     $item_customer_name = $request[$i]["item_customer_name"];
//     $item_customer_contact = $request[$i]["item_customer_contact"];
//     $item_name = $request[$i]["item_name"];
//     $item_type = $request[$i]["item_type"];
//     $item_sku = $request[$i]["item_sku"];
//     $item_quantity = $request[$i]["item_quantity"];
//     $item_rate = $request[$i]["item_rate"];
//     $item_discount = $request[$i]["item_discount"];
//     $item_discount_type = $request[$i]["item_discount_type"];
//     $item_min_sellingprice = $request[$i]["item_min_sellingprice"];
//     $item_purchasingprice = $request[$i]["item_purchasingprice"];
//     $item_tax = $request[$i]["item_tax"];
//     $item_tax_type = $request[$i]["item_tax_type"];
//     $item_amount = $request[$i]["item_amount"];
//     $item_invoice_amount = $request[$i]["item_invoice_amount"];
//     $item_invoice_edited = 0;
//     $item_invoice_shippingcharge = $request[$i]["item_invoice_shippingcharge"];
//     $item_invoice_adjustments = $request[$i]["item_invoice_adjustments"];
//     $item_invoice_adjustments_name = $request[$i]["item_invoice_adjustments_name"];
//     $sql = "INSERT INTO transaction_wh001 (item_invoice_number, item_salesperson, item_additional_salesperson,item_customer_name,item_customer_contact, item_name, item_type, item_sku, item_quantity, item_rate, item_discount, item_discount_type, item_min_sellingprice, item_purchasingprice, item_tax, item_tax_type, item_amount, item_transaction, item_destination,item_invoice_amount,item_invoice_edited,item_invoice_shippingcharge,item_invoice_adjustments,item_invoice_adjustments_name) VALUES ('$item_invoice_number', '$item_salesperson', '$item_additional_salesperson','$item_customer_name','$item_customer_contact', '$item_name', '$item_type', '$item_sku', '$item_quantity', '$item_rate', '$item_discount', '$item_discount_type', '$item_min_sellingprice', '$item_purchasingprice', '$item_tax', '$item_tax_type', '$item_amount', 'sold', 'customer','$item_invoice_amount','$item_invoice_edited','$item_invoice_shippingcharge','$item_invoice_adjustments','$item_invoice_adjustments_name')";
//     mysqli_query($conn, $sql);
// }




require 'PHPMailer/PHPMailerAutoload.php';


$mail = new PHPMailer;

if(!$mail->ValidateAddress($email)) {
	echo 'Invalid Email Address';
	exit;
}

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'greatguyharshit@gmail.com';
$mail->Password = 'mulchandan';
$mail->SMTPSecure = 'tls';
$mail->SMTPDebug = 2;
$mail->Port = 587; // 465 or 587
$mail->isHTML(true);


$mail-> setFrom('greatguyharshit@gmail.com');
$mail-> addAddress($request[9]);     // Add a recipient

                                  // Set email format to HTML
$mail-> addCC($request[10]);


$mail->Subject = 'Goyal Enterprise | Sales Order';
$mail->Body = '<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <!-- Facebook sharing information tags -->
        <meta property="og:title" content="*|MC:SUBJECT|*" />
        
        <title>*|MC:SUBJECT|*</title>
		<style type="text/css">
			/* Client-specific Styles */
			#outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
			body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
			body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

			/* Reset Styles */
			body{margin:0; padding:0;}
			img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
			table td{border-collapse:collapse;}
			#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

			/* Template Styles */

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: COMMON PAGE ELEMENTS /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Page
			* @section background color
			* @tip Set the background color for your email. You may want to choose one that matches your companys branding.
			* @theme page
			*/
			body, #backgroundTable{
				/*@editable*/ background-color:#FAFAFA;
			}

			/**
			* @tab Page
			* @section email border
			* @tip Set the border for your email.
			*/
			#templateContainer{
				/*@editable*/ border: 1px solid #DDDDDD;
			}

			/**
			* @tab Page
			* @section heading 1
			* @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
			* @style heading 1
			*/
			h1, .h1{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 2
			* @tip Set the styling for all second-level headings in your emails.
			* @style heading 2
			*/
			h2, .h2{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:30px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 3
			* @tip Set the styling for all third-level headings in your emails.
			* @style heading 3
			*/
			h3, .h3{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:26px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Page
			* @section heading 4
			* @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
			* @style heading 4
			*/
			h4, .h4{
				/*@editable*/ color:#202020;
				display:block;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:22px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				/*@editable*/ text-align:left;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: HEADER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Header
			* @section header style
			* @tip Set the background color and border for your emails header area.
			* @theme header
			*/
			#templateHeader{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-bottom:0;
			}

			/**
			* @tab Header
			* @section header text
			* @tip Set the styling for your emails header text. Choose a size and color that is easy to read.
			*/
			.headerContent{
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:34px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:100%;
				/*@editable*/ padding:0;
				/*@editable*/ text-align:center;
				/*@editable*/ vertical-align:middle;
			}

			/**
			* @tab Header
			* @section header link
			* @tip Set the styling for your emails header links. Choose a color that helps them stand out from your text.
			*/
			.headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			#headerImage{
				height:auto;
				max-width:600px !important;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: MAIN BODY /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Body
			* @section body style
			* @tip Set the background color for your emails body area.
			*/
			#templateContainer, .bodyContent{
				/*@editable*/ background-color:#FFFFFF;
			}

			/**
			* @tab Body
			* @section body text
			* @tip Set the styling for your emails main content text. Choose a size and color that is easy to read.
			* @theme main
			*/
			.bodyContent div{
				/*@editable*/ color:#505050;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:14px;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}

			/**
			* @tab Body
			* @section body link
			* @tip Set the styling for your emails main content links. Choose a color that helps them stand out from your text.
			*/
			.bodyContent div a:link, .bodyContent div a:visited, /* Yahoo! Mail Override */ .bodyContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			/**
			* @tab Body
			* @section data table style
			* @tip Set the background color and border for your emails data table.
			*/
			.templateDataTable{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border:1px solid #DDDDDD;
			}
			
			/**
			* @tab Body
			* @section data table heading text
			* @tip Set the styling for your emails data table text. Choose a size and color that is easy to read.
			*/
			.dataTableHeading{
				/*@editable*/ background-color:#D8E2EA;
				/*@editable*/ color:#336699;
				/*@editable*/ font-family:Helvetica;
				/*@editable*/ font-size:14px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}
		
			/**
			* @tab Body
			* @section data table heading link
			* @tip Set the styling for your emails data table links. Choose a color that helps them stand out from your text.
			*/
			.dataTableHeading a:link, .dataTableHeading a:visited, /* Yahoo! Mail Override */ .dataTableHeading a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#FFFFFF;
				/*@editable*/ font-weight:bold;
				/*@editable*/ text-decoration:underline;
			}
			
			/**
			* @tab Body
			* @section data table text
			* @tip Set the styling for your emails data table text. Choose a size and color that is easy to read.
			*/
			.dataTableContent{
				/*@editable*/ border-top:1px solid #DDDDDD;
				/*@editable*/ border-bottom:0;
				/*@editable*/ color:#202020;
				/*@editable*/ font-family:Helvetica;
				/*@editable*/ font-size:12px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ line-height:150%;
				/*@editable*/ text-align:left;
			}
		
			/**
			* @tab Body
			* @section data table link
			* @tip Set the styling for your emails data table links. Choose a color that helps them stand out from your text.
			*/
			.dataTableContent a:link, .dataTableContent a:visited, /* Yahoo! Mail Override */ .dataTableContent a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#202020;
				/*@editable*/ font-weight:bold;
				/*@editable*/ text-decoration:underline;
			}

			/**
			* @tab Body
			* @section button style
			* @tip Set the styling for your emails button. Choose a style that draws attention.
			*/
			.templateButton{
				-moz-border-radius:3px;
				-webkit-border-radius:3px;
				/*@editable*/ background-color:#336699;
				/*@editable*/ border:0;
				border-collapse:separate !important;
				border-radius:3px;
			}

			/**
			* @tab Body
			* @section button style
			* @tip Set the styling for your emails button. Choose a style that draws attention.
			*/
			.templateButton, .templateButton a:link, .templateButton a:visited, /* Yahoo! Mail Override */ .templateButton a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#FFFFFF;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:15px;
				/*@editable*/ font-weight:bold;
				/*@editable*/ letter-spacing:-.5px;
				/*@editable*/ line-height:100%;
				text-align:center;
				text-decoration:none;
			}

			.bodyContent img{
				display:inline;
				height:auto;
			}

			/* /\/\/\/\/\/\/\/\/\/\ STANDARD STYLING: FOOTER /\/\/\/\/\/\/\/\/\/\ */

			/**
			* @tab Footer
			* @section footer style
			* @tip Set the background color and top border for your emails footer area.
			* @theme footer
			*/
			#templateFooter{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border-top:0;
			}

			/**
			* @tab Footer
			* @section footer text
			* @tip Set the styling for your emails footer text. Choose a size and color that is easy to read.
			* @theme footer
			*/
			.footerContent div{
				/*@editable*/ color:#707070;
				/*@editable*/ font-family:Arial;
				/*@editable*/ font-size:12px;
				/*@editable*/ line-height:125%;
				/*@editable*/ text-align:center;
			}

			/**
			* @tab Footer
			* @section footer link
			* @tip Set the styling for your emails footer links. Choose a color that helps them stand out from your text.
			*/
			.footerContent div a:link, .footerContent div a:visited, /* Yahoo! Mail Override */ .footerContent div a .yshortcuts /* Yahoo! Mail Override */{
				/*@editable*/ color:#336699;
				/*@editable*/ font-weight:normal;
				/*@editable*/ text-decoration:underline;
			}

			.footerContent img{
				display:inline;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your emails footer utility bar.
			* @theme footer
			*/
			#utility{
				/*@editable*/ background-color:#FFFFFF;
				/*@editable*/ border:0;
			}

			/**
			* @tab Footer
			* @section utility bar style
			* @tip Set the background color and border for your emails footer utility bar.
			*/
			#utility div{
				/*@editable*/ text-align:center;
			}

			#monkeyRewards img{
				max-width:190px;
			}
		</style>
	</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top" style="padding-top:20px;">
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top">
                                
                                                <!-- // Begin Module: Standard Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                        				<td valign="top" width="280" class="leftColumnContent">
                                            
			                                                <!-- // Begin Module: Top Image with Content -->
			                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
			                                                    <tr mc:repeatable>
			                                                        <td valign="top">
			                                                            <div mc:edit="tiwc300_content00">
				                                                            <div>
				 	                                                           <h2 class="h2">Sales Order</h2>
				 	                                                        </div>
				 	                                                        <div>
				                                                               <strong>Invoice Number: #'.$invoice.'</strong>
				                                                            </div>
				                                                            <br>
				                                                            <br>
				                                                            <br>
				                                                            <br>
				                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <br>
				                                                            <div>
				                                                            	<p>Date: '.$date.'</p>
				                                                            </div>
			                                                            </div>
			                                                        </td>
			                                                    </tr>
			                                                </table>
			                                                <!-- // End Module: Top Image with Content -->
                                            
                                            			</td>
			                                        	<td valign="top" width="280" class="rightColumnContent">
			                                            
			                                                <!-- // Begin Module: Top Image with Content -->
			                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
			                                                    <tr mc:repeatable>
			                                                        <td valign="top">
			                                                           <div mc:edit="tiwc300_content01">
															                <h4>M/S Goyal Enterprise</h4>
															                <p>
															                    LF-12, B-Block, Mansarover Complex,<br> Nr. Habibganj Railway Station,<br> Bhopal 462021 <br>India<br>GSTIN 23AFEPG4029C1Z6
															                </p>
															                <p>
															                    Ph. : 0755-4204215, 9300049642<br>
															                    vidhangoyal@icloud.com<br>
															                    www.waterpurifierdealer.com
															                </p>
                                                                            <br>
                                                                            <br>
                                                                            <br>
                                                                            <p>
                                                                                Bill To: <strong>'.$customer.'</strong>
                                                                            </p>
                                                                            <p>
                                                                                Contact: '.$contact.'
                                                                            </p>
			                                                           </div>
			                                                        </td>
			                                                    </tr>
			                                                </table>
			                                                <!-- // End Module: Top Image with Content -->
			                                            
			                                            </td>
                                        			</tr>
                                        		</table>
                                        		<table border="0" cellpadding="20" cellspacing="0" style = "background-color:#FFFFFF;border:1px solid #DDDDDD;width: 100%;">

                                                              <tr width="560" style="background-color:#D8E2EA;">
                                                                <th scope="col" valign="top" style="width=30%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">Item Details</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">Qty</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">Rate</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">Discount</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">CGST</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">SGST</th>

                                                                <th scope="col" valign="top" style="width=11.66%; background-color:#D8E2EA;color:#336699;font-family:Helvetica;font-size:14px;font-weight:bold;line-height:150%;text-align:left;">Amount</th>
                                                              </tr>'.$tableData.'
                                                              
                                                          </table>
                                                        </td>
                                                    </tr>
                                                </table> 
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                	<tr>
                                                		<td valign="top" style="padding-top:0; padding-bottom:0;">
                                                		  <table border="0" cellpadding="10" cellspacing="0" width="100%" class="templateDataTable">   
                                                              <tr>
		                                                          <td valign="top" width="300" class="leftColumnContent">
		                                            
					                                                <!-- // Begin Module: Top Image with Content -->
					                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
					                                                    <tr mc:repeatable>
					                                                        <td valign="top">
					                                                            <div mc:edit="tiwc300_content00">
						                                                           
					                                                            </div>
					                                                        </td>
					                                                    </tr>
					                                                </table>
					                                                <!-- // End Module: Top Image with Content -->
		                                            
		                                            			  </td>
                                                              	  <td valign="top" width="300" class="rightColumnContent"><!-- // Begin Module: Top Image with Content -->
					                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
					                                                    <tr mc:repeatable>
					                                                        <td valign="top">
					                                                           <div mc:edit="tiwc300_content01">
																	                <p>
																	                   <span>Total:</span>
																	                   <span style="float: right;">'.$total.'</span>
																	                </p>
																	                <p>
																	                   <span>Shipping Charge:</span>
																	                   <span style="float: right;">'.$shippingcharge.'</span>
																	                </p>
																	                <p>
																	                   <span>'.$adjustment.'</span>
																	                   <span style="float: right;">'.$adjustmentvalue.'</span>
																	                </p>
																	                <p>
																	                   <span>Total:</span>
																	                   <span style="float: right;">'.$finaltotal.'</span>
																	                </p>
					                                                           </div>
					                                                        </td>
					                                                    </tr>
					                                                </table>
					                                                <!-- // End Module: Top Image with Content -->
			                                            		  </td>
                                                              </tr>
                                                          </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                                <!-- // End Module: Standard Content -->
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body  -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Footer -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter">
                                    	<tr>
                                        	<td valign="top" class="footerContent">
                                            
                                                <!-- // Begin Module: Transactional Footer -->
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div mc:edit="std_footer">
																<strong>Notes</strong>
																<div>Thanks for your business.</div>
																<div>This is a computer generated copy and does not require
																seal and signature
																</div>
																<div>This sales order is for information purpose only.</div> 
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" id="utility">
                                                            <div mc:edit="std_utility">
                                                                <em>Copyright &copy; Goyal Enterprise, All Rights Reserved
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- // End Module: Transactional Footer -->
                                            
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
    </body>';

if(!$mail->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    exit;
} else {
    echo 'Message has been sent';
}


mysqli_close($conn);
?>