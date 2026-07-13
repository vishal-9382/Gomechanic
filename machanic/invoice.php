<?php
include('./machanicheader.php');
require '../database.php';
session_start();

$user_id = $_SESSION["user_id"];

// Fetch completed job details **excluding hours_worked**
$query = "SELECT jobs.job_id, jobs.job_date, jobs.work_status,
                 professional.mechanic_Fullname, professional.mechanic_address, professional.rate_per_hour,
                 cities.city_name, city_area.area_name
          FROM jobs
          INNER JOIN professional ON professional.mechanic_id = jobs.job_machanic
          INNER JOIN city_area ON city_area.area_id = professional.machanic_city_area
          INNER JOIN cities ON cities.city_id = professional.mechanic_city
          WHERE jobs.user_id = '$user_id' AND jobs.work_status = 'Completed'";

$results = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
        }
        .print-btn, .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #008CBA;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            border: none;
            cursor: pointer;
        }
        .print-btn:hover, .submit-btn:hover {
            background-color: #005f73;
        }
        input[type="number"] {
            width: 60px;
            padding: 5px;
            text-align: center;
        }
    </style>
    <script>
        function calculateTotal(jobId, ratePerHour) {
            let hoursWorked = document.getElementById("hours_" + jobId).value;
            if (hoursWorked < 0) {
                alert("Hours worked cannot be negative!");
                document.getElementById("hours_" + jobId).value = 0;
                hoursWorked = 0;
            }
            let totalCost = hoursWorked * ratePerHour;
            document.getElementById("total_" + jobId).innerText = "$" + totalCost.toFixed(2);

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let totalCostElements = document.querySelectorAll("[id^='total_']");
            let grandTotal = 0;
            totalCostElements.forEach(element => {
                grandTotal += parseFloat(element.innerText.replace("$", "")) || 0;
            });
            document.getElementById("grandTotal").innerText = "$" + grandTotal.toFixed(2);
        }
    </script>
</head>
<body>

<div class="invoice-box">
    <h2>Invoice</h2>
    <form action="process_invoice.php" method="POST">
        <table>
            <tr>
                <th>S.No</th>
                <th>Mechanic Name</th>
                <th>Mechanic Address</th>
                <th>Job Date</th>
                <th>Hours Worked</th>
                <th>Rate Per Hour ($)</th>
                <th>Total Cost ($)</th>
            </tr>

            <?php
            $sno = 1;
            $totalCost = 0;

            if ($results && mysqli_num_rows($results) > 0) {
                while ($row = mysqli_fetch_assoc($results)) {
                    $jobId = $row['job_id'];
                    $mechanic = htmlspecialchars($row['mechanic_Fullname']);
                    $address = htmlspecialchars($row['mechanic_address'] . ', ' . $row['area_name'] . ', ' . $row['city_name']);
                    $date = $row['job_date'];
                    $ratePerHour = $row['rate_per_hour'];
                    ?>

                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td><?php echo $mechanic; ?></td>
                        <td><?php echo $address; ?></td>
                        <td><?php echo $date; ?></td>
                        <td>
                            <input type="number" name="hours_worked[<?php echo $jobId; ?>]" id="hours_<?php echo $jobId; ?>" 
                                   min="0" value="0" onchange="calculateTotal(<?php echo $jobId; ?>, <?php echo $ratePerHour; ?>)">
                        </td>
                        <td>$<?php echo number_format($ratePerHour, 2, '.', ''); ?></td>
                        <td id="total_<?php echo $jobId; ?>">$0.00</td>
                    </tr>

            <?php }
            } else {
                echo "<tr><td colspan='7'>No completed jobs found.</td></tr>";
            }
            ?>

            <tr>
                <td colspan="6" class="total">Total Amount</td>
                <td class="total" id="grandTotal">$0.00</td>
            </tr>
        </table>

        <button type="submit" class="submit-btn">Submit Invoice</button>
    </form>

    <a href="#" class="print-btn" onclick="window.print()">Print Invoice</a>
</div>

</body>
</html>

<?php include('footer.php'); ?>
