<?php
session_start();
include('../database.php');

if (!isset($_GET['job_id'])) {
    die("Invalid request.");
}

$jobid = $_GET['job_id'];

$query = "SELECT jobs.*, user.user_Fullname, user.user_address, user.user_city, user.user_contact, 
                 professional.mechanic_Fullname, professional.mechanic_contact, professional.rate_per_hour,
                 jobs.fixed_issue, jobs.upi_id
          FROM jobs
          INNER JOIN user ON jobs.user_id = user.user_id
          INNER JOIN professional ON jobs.job_machanic = professional.mechanic_id
          WHERE jobs.job_id = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $jobid);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    die("Job details not found.");
}

$job = $result->fetch_assoc();

$payment_success_message = "";
if (isset($_SESSION['payment_success'])) {
    $payment_success_message = $_SESSION['payment_success'];
    unset($_SESSION['payment_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Invoice #<?php echo $jobid; ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563EB;
            --text-main: #1E293B;
            --text-secondary: #64748B;
            --bg-light: #F8FAFC;
            --border-color: #E2E8F0;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            margin: 0;
            padding: 40px 20px;
            line-height: 1.5;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            position: relative;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--bg-light);
            padding-bottom: 30px;
            margin-bottom: 30px;
        }

        .logo-section h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: var(--primary);
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-section p {
            color: var(--text-secondary);
            font-size: 13px;
            margin: 0;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            margin: 0 0 8px 0;
            color: var(--text-main);
            font-weight: 700;
        }

        .invoice-details p {
            margin: 2px 0;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .invoice-details strong {
            color: var(--text-main);
        }

        .billing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .billing-col h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin: 0 0 12px 0;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 6px;
        }

        .billing-col p {
            margin: 4px 0;
            font-size: 14px;
        }

        .billing-col strong {
            font-size: 15px;
            color: var(--text-main);
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table th {
            background-color: var(--bg-light);
            color: var(--text-secondary);
            font-family: 'Outfit', sans-serif;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
        }

        .invoice-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .invoice-summary {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed var(--border-color);
        }

        .payment-info {
            max-width: 50%;
        }

        .payment-info h4 {
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0 0 8px 0;
            text-transform: uppercase;
        }

        .payment-info p {
            margin: 3px 0;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .total-amount-box {
            text-align: right;
            min-width: 250px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }

        .total-row.grand-total {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            border-top: 2px solid var(--border-color);
            padding-top: 12px;
            margin-top: 8px;
        }

        .success-banner {
            background-color: #DEF7EC;
            color: #03543F;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            text-align: center;
            font-weight: 500;
            border: 1px solid #BCF0DA;
        }

        .actions-bar {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1D4ED8;
        }

        .btn-secondary {
            background-color: #64748B;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        /* Print Override Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            .actions-bar {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <?php if ($payment_success_message): ?>
    <div class="success-banner">
        <i class="fas fa-check-circle me-1.5"></i> <?php echo htmlspecialchars($payment_success_message); ?>
    </div>
    <?php endif; ?>

    <div class="invoice-header">
        <div class="logo-section">
            <h1><i class="fas fa-screwdriver-wrench"></i> AutoMechanic</h1>
            <p>Certified Local Mechanic Finder &amp; Billing Network</p>
        </div>
        <div class="invoice-details">
            <h2>INVOICE</h2>
            <p>Invoice #: <strong><?php echo $jobid; ?></strong></p>
            <p>Date Issued: <strong><?php echo date('d M Y, h:i A', strtotime($job['job_date'])); ?></strong></p>
            <p>Work Status: <strong><?php echo htmlspecialchars($job['work_status']); ?></strong></p>
        </div>
    </div>

    <div class="billing-grid">
        <div class="billing-col">
            <h3>Billed To (Customer)</h3>
            <p><strong><?php echo htmlspecialchars($job['user_Fullname']); ?></strong></p>
            <p><?php echo htmlspecialchars($job['user_address']); ?></p>
            <p><?php echo htmlspecialchars($job['user_city']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($job['user_contact']); ?></p>
        </div>
        <div class="billing-col">
            <h3>Service Provider (Mechanic)</h3>
            <p><strong><?php echo htmlspecialchars($job['mechanic_Fullname']); ?></strong></p>
            <p>Certified Field Specialist</p>
            <p>Phone: <?php echo htmlspecialchars($job['mechanic_contact']); ?></p>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Service Description</th>
                <th style="text-align: right;">Rate / Hour</th>
                <th style="text-align: right;">Hours Worked</th>
                <th style="text-align: right; width: 150px;">Total Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Auto Repair &amp; Troubleshooting</strong>
                    <?php if (!empty($job['fixed_issue'])): ?>
                        <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                            <strong>Resolution Notes:</strong> <?php echo htmlspecialchars($job['fixed_issue']); ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td style="text-align: right;">₹<?php echo number_format($job['rate_per_hour'], 2); ?></td>
                <td style="text-align: right;"><?php echo round($job['bill_amount'] / $job['rate_per_hour'], 2); ?> hrs</td>
                <td style="text-align: right; font-weight: 500;">₹<?php echo number_format($job['bill_amount'], 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-summary">
        <div class="payment-info">
            <?php if (!empty($job['upi_id'])): ?>
                <h4>Payment Instructions</h4>
                <p>Transfer via UPI ID: <strong><?php echo htmlspecialchars($job['upi_id']); ?></strong></p>
                <p>Ensure to click Confirm Payment once the transfer completes.</p>
            <?php endif; ?>
        </div>
        <div class="total-amount-box">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₹<?php echo number_format($job['bill_amount'], 2); ?></span>
            </div>
            <div class="total-row">
                <span>Tax (0%):</span>
                <span>₹0.00</span>
            </div>
            <div class="total-row grand-total">
                <span>Grand Total:</span>
                <span>₹<?php echo number_format($job['bill_amount'], 2); ?></span>
            </div>
        </div>
    </div>

    <div class="actions-bar">
        <button class="btn btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print Invoice</button>
        <?php if ($job['job_status'] !== 'Paid'): ?>
            <form method="POST" action="process_payment.php" style="margin:0;">
                <input type="hidden" name="jobid" value="<?php echo $jobid; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-credit-card"></i> Confirm Payment</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
