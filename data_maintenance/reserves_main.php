<?php
require_once "../database/database.php";

$reserves = getAllReserves();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Page</title>
</head>

<body>

    <h1>AOL Database</h1>
    <h2>Revervations Page</h2>

    <h3>Revervations List</h3>

    <?php
    $reservationsBySid = [];
    foreach ($reserves as $reserve) {
        $reservationsBySid[$reserve['sid']][] = $reserve;
    }

    foreach ($reservationsBySid as $sid => $reservations):
        ?>
        <h4>Reservations for SID:
            <?= $sid ?>
        </h4>

        <table>
            <tr>
                <td>BID</th>
                <td>Date of Reservations</th>
            </tr>
            <?php foreach ($reservations as $reserve): ?>
                <tr>
                    <td>
                        <?= $reserve['bid']; ?>
                    </td>
                    <td>
                        <?= $reserve['days']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <h3>Reservations Update Menu</h3>
    <ul type="1">
        <li><a href="reservations/reserves_insert.php">Insert</a></li>
        <li><a href="reservations/reserves_update.php">Update</a></li>
        <li><a href="reservations/reserves_delete.php">Delete</a></li>
    </ul>

    <br><br>
    <a href="data_main.html">Back to Data Maintenance Page</a>

</body>

</html>