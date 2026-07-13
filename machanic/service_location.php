<?php
include('adminheader.php'); // Include the header (e.g., navigation)

require_once('db_connection.php'); // Include your DB connection file

// Query to count mechanics by city
$sql = "SELECT c.city_name, COUNT(p.mechanic_id) AS mechanic_count
        FROM cities c
        LEFT JOIN professional p ON c.city_id = p.mechanic_city
        GROUP BY c.city_name";

$result = $conn->query($sql);

?>

<!-- Main Container -->
<div class="service-location-container">
    <h2>City-wise Mechanic Count</h2>

    <!-- Table to display the data -->
    <table class="mechanic-table">
        <thead>
            <tr>
                <th>City Name</th>
                <th>Number of Mechanics</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if any results are returned from the query
            if ($result->num_rows > 0) {
                // Output data for each city
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['city_name'] . "</td>
                            <td>" . $row['mechanic_count'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php'); // Include the footer (e.g., footer content)
?>

<!-- CSS Styling -->
<style>
    /* Main Container */
    .service-location-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 32px;
        margin-bottom: 20px;
        font-family: 'Arial', sans-serif;
    }

    /* Table Styling */
    .mechanic-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Arial', sans-serif;
    }

    .mechanic-table th,
    .mechanic-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .mechanic-table th {
        background-color: #4CAF50;
        color: white;
        font-size: 18px;
    }

    .mechanic-table td {
        font-size: 16px;
        background-color: #fff;
    }

    .mechanic-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .mechanic-table tr:hover {
        background-color: #ddd;
    }

    /* Responsiveness */
    @media screen and (max-width: 768px) {
        .service-location-container {
            padding: 20px;
        }

        .mechanic-table th,
        .mechanic-table td {
            padding: 8px;
        }

        h2 {
            font-size: 28px;
        }
    }
</style>
