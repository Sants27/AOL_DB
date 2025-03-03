<?php
    require_once "../database/database.php";

    $totalSailors = countAllSailors();
    $totalBoats = countAllBoats();
    $avgRating = getAverageSailorRating();
    $avgAge = getAverageSailorAge();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
</head>
<body>
    
    <h1>AOL Database</h1>
    <h2>Report Page</h2>

    <table>
        <tr>
            <th>Sailors Total</th>
            <th>Boats Total</th>
            <th>Sailors Average Rating</th>
            <th>Sailors Average Age</th>
        </tr>
        <tr>
            <td><?= $totalSailors ?></td>
            <td><?= $totalBoats ?></td>
            <td><?= $avgRating ?></td>
            <td><?= $avgAge ?></td>
        </tr>
    </table>

    <br><br>
    <a href="../index.html">Back to Main Page</a>
    

</body>
</html>