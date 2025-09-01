<?php
include 'includes/session.php';
include 'includes/format.php';

function generateRow($from, $to, $conn) {
    $contents = '';
    
    // Prepare sales query
    $stmt = $conn->prepare("
        SELECT s.id AS sales_id, s.pay_id, s.sales_date, u.firstname, u.lastname,
               GROUP_CONCAT(p.name SEPARATOR ', ') AS product_names,
               SUM(d.quantity * p.price) AS total_amount
        FROM sales s
        LEFT JOIN users u ON u.id = s.user_id 
        LEFT JOIN details d ON d.sales_id = s.id
        LEFT JOIN products p ON p.id = d.product_id
        WHERE s.sales_date BETWEEN ? AND ? 
        GROUP BY s.id, u.firstname, u.lastname
        ORDER BY s.sales_date DESC
    ");
    $stmt->bind_param('ss', $from, $to);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalSales = 0;

    while ($row = $result->fetch_assoc()) {
        $amount = isset($row['total_amount']) ? $row['total_amount'] : 0;
        $totalSales += $amount;

        $contents .= '
            <tr>
                <td>' . date('Y-m-d', strtotime($row['sales_date'])) . '</td>
                <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                <td>' . $row['pay_id'] . '</td>
                <td>' . ($row['product_names'] ?: 'N/A') . '</td>
                <td align="right">&#8369; ' . number_format($amount, 2) . '</td>
            </tr>
        ';
    }

    $contents .= '
        <tr>
            <td colspan="3" align="right"><b>Total Sales</b></td>
            <td></td>
            <td align="right"><b>&#8369; ' . number_format($totalSales, 2) . '</b></td>
        </tr>
    ';

    // Prepare transactions query
    $stmt_transactions = $conn->prepare("
        SELECT t.transaction_id, t.date_created, s.service_name, s.price, 
               u.firstname AS owner_firstname, u.lastname AS owner_lastname 
        FROM transactions t
        LEFT JOIN services s ON s.service_id = t.service_id
        LEFT JOIN users u ON u.id = t.owner_id
        WHERE t.date_created BETWEEN ? AND ?
        ORDER BY t.date_created DESC
    ");
    $stmt_transactions->bind_param('ss', $from, $to);
    $stmt_transactions->execute();
    $result_transactions = $stmt_transactions->get_result();
    $totalTransactions = 0;

    while ($transaction = $result_transactions->fetch_assoc()) {
        $transactionAmount = isset($transaction['price']) ? $transaction['price'] : 0;
        $totalTransactions += $transactionAmount;

        $contents .= '
            <tr>
                <td>' . date('Y-m-d', strtotime($transaction['date_created'])) . '</td>
                <td>' . $transaction['owner_firstname'] . ' ' . $transaction['owner_lastname'] . '</td>
                <td>' . $transaction['transaction_id'] . '</td>
                <td>' . $transaction['service_name'] . '</td>
                <td align="right">&#8369; ' . number_format($transactionAmount, 2) . '</td>
            </tr>
        ';
    }

    $contents .= '
        <tr>
            <td colspan="3" align="right"><b>Total Transactions</b></td>
            <td></td>
            <td align="right"><b>&#8369; ' . number_format($totalTransactions, 2) . '</b></td>
        </tr>
    ';

    return $contents;
}

if (isset($_POST['print'])) {
    $ex = explode(' - ', $_POST['date_range']);
    $from = date('Y-m-d', strtotime($ex[0]));
    $to = date('Y-m-d', strtotime($ex[1]));
    $from_title = date('Y-m-d', strtotime($ex[0]));
    $to_title = date('Y-m-d', strtotime($ex[1]));

    require_once('../tcpdf/tcpdf.php');
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Sales Report: ' . $from_title . ' - ' . $to_title);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('dejavusans', '', 11);
    $pdf->AddPage();

    $content = '';
    $content .= '
        <h2 align="center">Ipil Pet Doctors</h2>
        <h4 align="center">SALES AND TRANSACTIONS REPORT</h4>
        <h4 align="center">' . $from_title . " - " . $to_title . '</h4>
        <table border="1" cellspacing="0" cellpadding="3">  
            <tr>  
                <th width="15%" align="center"><b>Date</b></th>
                <th width="20%" align="center"><b>Customer Name</b></th>
                <th width="40%" align="center"><b>Transaction ID</b></th>
                <th width="15%" align="center"><b>Services/Items</b></th> 
                <th width="15%" align="center"><b>Amount</b></th>  
            </tr>  
    ';
    
    $content .= generateRow($from, $to, $conn);
    $content .= '</table>';
    $pdf->writeHTML($content);
    $pdf->Output('sales_report_' . date('Ymd') . '.pdf', 'I');

} else {
    $_SESSION['error'] = 'Need date range to provide sales print';
    header('location: sales.php');
}
?>
