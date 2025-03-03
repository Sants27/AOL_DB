<?php
require_once "../../database/database.php";

$sailors = getAllSailors();
$boats = getAllBoats();
$info = [];

if (isset($_POST["check"])) {
    $conn = connectToDB();

    try {
        $reserve = $_POST["sid"];
        $stmt = $conn->prepare("SELECT * FROM reserves WHERE sid = ?");
        $stmt->execute([$reserve]);

        if ($stmt) {
            $info = $stmt->fetchAll();

            closeConnection();
        } else {
            throw new Exception("Error: Boat with the following id does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }

}

if (isset($_POST["save"])) {
    $errorMessage = updateReservations($_POST);

    if ($errorMessage !== null) {
        echo '<script>alert("' . $errorMessage . '");</script>';
    } else if ($errorMessage == null) {
        echo '<script>alert("Reservations updated successfully"); window.location.href = "../reserves_main.php";</script>';
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
    <h2>Reservations Update Page</h2>

    <form action="" method="post">
        <label for="sid">Select a SID:</label><br>
        <select id="sid" name="sid" required>
            <?php foreach ($sailors as $sailor): ?>
                <option value="<?= $sailor['sid'] ?>">
                    <?= $sailor['sid'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Check" name="check">
    </form>

    <h3>Reservations under Sailor ID:</h3>

    <?php if ($info): ?>
        <div>
            <?php foreach ($info as $index => $reservation): ?>
                <p>BID:
                    <?= $reservation['bid'] ?>, Date:
                    <?= $reservation['days'] ?>
                    <button onclick="document.getElementById('editForm<?= $index ?>').style.display='block'">Edit</button>
                </p>

                <div id="editForm<?= $index ?>" style="display: none;">
                    <form action="reserves_update.php" method="post">
                        <input type="hidden" name="sid" value="<?= $reservation['sid'] ?>">
                        <input type="hidden" name="old_bid" value="<?= $reservation['bid'] ?>">
                        <input type="hidden" name="old_date" value="<?= $reservation['days'] ?>">
                        <label for="bid">BID:</label>
                        <select id="bid" name="new_bid">
                            <?php foreach ($boats as $boat): ?>
                                <option value="<?= $boat['bid'] ?>" <?= $boat['bid'] == $reservation['bid'] ? 'selected' : '' ?>>
                                    <?= $boat['bid'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="new_date" value="<?= $reservation['days'] ?>">
                        <input type="submit" value="Save" name="save">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <div>
            <p>No reservation found.</p>
        </div>
    <?php endif; ?>

    <br><br>
    <a href="../reserves_main.php">Back to Reservations Maintenance Page</a>

</body>

</html>