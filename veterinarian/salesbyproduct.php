<?php
include 'includes/session.php';

function generateRowByProduct($from, $to, $conn){
    $contents = '';
    $query = "SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id WHERE sales_date BETWEEN '$from' AND '$to' ORDER BY sales_date DESC";
    $result = $conn->query($query);
    $total = 0;

    while($row = $result->fetch_assoc()){
        $salesid = $row['salesid'];
        $query_details = "SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id='$salesid'";
        $result_details = $conn->query($query_details);
        $amount = 0;

        while ($details = $result_details->fetch_assoc()) {
            $subtotal = $details['price'] * $details['quantity'];
            $amount += $subtotal;
            $contents .= '
            <tr>
                <td>'.date('M d, Y', strtotime($row['sales_date'])).'</td>
                <td>'.$details['name'].'</td>
                <td align="right">'.$details['quantity'].'</td>
                <td align="right">₱ '.number_format($subtotal, 2).'</td>
            </tr>
            ';
        }
        $total += $amount;
    }

    $contents .= '
    <tr>
        <td colspan="3" align="right"><b>Total</b></td>
        <td align="right"><b>₱ '.number_format($total, 2).'</b></td>
    </tr>
    ';
    return $contents;
}

if(isset($_POST['print'])){
    $ex = explode(' - ', $_POST['date_range']);
    $from = date('Y-m-d', strtotime($ex[0]));
    $to = date('Y-m-d', strtotime($ex[1]));
    $from_title = date('M d, Y', strtotime($ex[0]));
    $to_title = date('M d, Y', strtotime($ex[1]));

    require_once('../tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Sales Report by Product: '.$from_title.' - '.$to_title);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('dejavusans', '', 11);  // Change font to DejaVu Sans
    $pdf->AddPage();  
    $content = '';  
    $content .= '
        <h2 align="center">Ipil Pet Doctors</h2>
        <h4 align="center">SALES REPORT BY PRODUCT</h4>
        <h4 align="center">'.$from_title." - ".$to_title.'</h4>
        <table border="1" cellspacing="0" cellpadding="3">  
            <tr>  
                <th width="20%" align="center"><b>Date</b></th>
                <th width="40%" align="center"><b>Product Name</b></th>
                <th width="20%" align="center"><b>Quantity</b></th>
                <th width="20%" align="center"><b>Amount</b></th>
            </tr>
    ';  
    $content .= generateRowByProduct($from, $to, $conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content, true, false, true, false, '');  
    $pdf->Output('sales_by_product.pdf', 'I');

} else {
    $_SESSION['error'] = 'Need date range to provide sales print';
    header('location: sales_product.php');
}
?>
