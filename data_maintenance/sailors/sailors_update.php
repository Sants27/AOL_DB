<?php
    require_once "../../database/database.php";

    if (isset($_POST["update"])) {
        $errorMessage = updateSailors($_POST);
    
        if ($errorMessage !== null) {
            echo '<script>alert("' . $errorMessage . '");</script>';
        } else if ($errorMessage == null) {
            echo '<script>alert("Sailor updated successfully"); window.location.href = "../sailors_main.php";</script>';
        }
    }

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
    <h2>Sailors Update Page</h2>

    <form action="" method="post">
    <label for="sid">SID:</label><br>
    <input type="text" id="sid" name="sid" required><br>

    <label for="name">New Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="rating">New Rating:</label><br>
    <input type="number" id="rating" name="rating"><br>

    <label for="age">New Age:</label><br>
    <input type="number" id="age" name="age"><br>

    <input type="submit" value="Update" name="update">
</form>

    <br><br>
    <a href="../sailors_main.php">Back to Sailors Maintenance Page</a>

</body>
</html>