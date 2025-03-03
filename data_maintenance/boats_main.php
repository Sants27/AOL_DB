<?php
    require_once "../database/database.php";

    $boats= getAllBoats();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boats Page</title>
</head>
<body>

    <h1>AOL Database</h1>
    <h2>Boats Page</h2>

    <h3>Boats List</h3>

    <table>
        <tr>
            <th>BID</th>
            <th>Name</th>
            <th>Color</th>
        </tr>
        <?php foreach ($boats as $boat): ?>
        <tr>
            <td><?php echo $boat['bid']; ?></td>
            <td><?php echo $boat['bname']; ?></td>
            <td><?php echo $boat['color']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Boats Update Menu</h3>
    <ul type="1">
        <li><a href="boats/boats_insert.php">Insert</a></li>
        <li><a href="boats/boats_update.php">Update</a></li>
        <li><a href="boats/boats_delete.php">Delete</a></li>
    </ul>

    <br><br>
    <a href="data_main.html">Back to Data Maintenance Page</a>

</body>
</html>