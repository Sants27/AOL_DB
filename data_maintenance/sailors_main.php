<?php
    require_once "../database/database.php";

    $sailors = getAllSailors();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sailors Page</title>
</head>
<body>

    <h1>AOL Database</h1>
    <h2>Sailors Page</h2>

    <h3>Sailors List</h3>

    <table>
        <tr>
            <th>SID</th>
            <th>Name</th>
            <th>Rating</th>
            <th>Age</th>
        </tr>
        <?php foreach ($sailors as $sailor): ?>
        <tr>
            <td><?php echo $sailor['sid']; ?></td>
            <td><?php echo $sailor['sname']; ?></td>
            <td><?php echo $sailor['rating']; ?></td>
            <td><?php echo $sailor['age']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Sailors Update Menu</h3>
    <ul type="1">
        <li><a href="sailors/sailors_insert.php">Insert</a></li>
        <li><a href="sailors/sailors_update.php">Update</a></li>
        <li><a href="sailors/sailors_delete.php">Delete</a></li>
    </ul>

    <br><br>
    <a href="data_main.html">Back to Data Maintenance Page</a>

</body>
</html>