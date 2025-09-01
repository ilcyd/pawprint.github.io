<?php
include 'includes/session.php';

function generateRowByCategory($from, $to, $conn){
    $contents = '';
    $query = "SELECT category.name AS category_name, 
                     SUM(details.quantity) AS total_quantity
              FROM sales 
              LEFT JOIN details ON sales.id = details.sales_id 
              LEFT JOIN products ON details.product_id = products.id
              LEFT JOIN category ON products.category_id = category.id
              WHERE sales.sales_date BETWEEN '$from' AND '$to'
              GROUP BY category.name";
    $result = mysqli_query($conn, $query);

    $total = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $contents .= '
        <tr>
            <td>'.$row['category_name'].'</td>
            <td>'.$row['total_quantity'].'</td>
        </tr>
        ';
        $total += $row['total_quantity'];
    }

    $contents .= '
    <tr>
        <td><b>Total</b></td>
        <td><b>'.$total.'</b></td>
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
    $pdf->SetTitle('Sales Report by Category: '.$from_title.' - '.$to_title);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
        <h2 align="center">Ipil Pet Doctors</h2>
        <h4 align="center">SALES REPORT BY CATEGORY</h4>
        <h4 align="center">'.$from_title." - ".$to_title.'</h4>
        <table border="1" cellspacing="0" cellpadding="3">  
            <tr>  
                <th width="60%"><b>Category</b></th>
                <th width="40%"><b>Total Quantity</b></th>
            </tr>
    ';  
    $content .= generateRowByCategory($from, $to, $conn);  
    $content .= '</table>';  
    $pdf->writeHTML($content);  
    $pdf->Output('sales_by_category.pdf', 'I');

    mysqli_close($conn);

} else {
    $_SESSION['error'] = 'Need date range to provide sales print';
    header('location: sales_category.php');
}
?>
