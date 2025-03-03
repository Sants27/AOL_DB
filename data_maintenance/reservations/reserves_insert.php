<?php
require_once "../../database/database.php";

$sailors = getAllSailors();
$boats = getAllBoats();


if (isset($_POST["add"])) {
    $errorMessage = createReservations($_POST);

    if ($errorMessage !== null) {
        echo '<script>alert("' . $errorMessage . '");</script>';
    } else if ($errorMessage == null) {
        echo '<script>alert("Reservations added successfully"); window.location.href = "../reserves_main.php";</script>';
    }
}

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
    <h2>Reservations Insert Page</h2>

    <form action="" method="post">
        <label for="sid">SID:</label><br>
        <select id="sid" name="sid">
            <?php foreach ($sailors as $sailor): ?>
                <option value="<?= $sailor["sid"] ?>">
                    <?= $sailor['sid']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="bid">BID:</label><br>
        <select id="bid" name="bid">
            <?php foreach ($boats as $boat): ?>
                <option value="<?= $boat["bid"] ?>">
                    <?= $boat['bid']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="date">Date of Reservation:</label><br>
        <input type="date" id="date" name="date"><br>

        <input type="submit" value="Submit" name="add">
    </form>

    <br><br>
    <a href="../reserves_main.php">Back to Reservation Maintenance Page</a>

</body>

</html>