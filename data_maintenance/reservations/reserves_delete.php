<?php
require_once "../../database/database.php";

$sailors = getAllSailors();

if (isset($_POST["add"])) {
    $errorMessage = deleteReservations($_POST);

    if ($errorMessage !== null) {
        echo '<script>alert("' . $errorMessage . '");</script>';
    } else if ($errorMessage == null) {
        echo '<script>alert("Reservations deleted successfully"); window.location.href = "../reserves_main.php";</script>';
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
    <h2>Reservations Delete Page</h2>

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

        <label for="date">Date of Reservation:</label><br>
        <input type="date" id="date" name="date"><br>

        <input type="submit" value="Submit" name="add">
    </form>

    <br><br>
    <a href="../reserves_main.php">Back to Reservation Maintenance Page</a>

</body>

</html>