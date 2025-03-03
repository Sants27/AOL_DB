<?php
    require_once "../../database/database.php";

    if (isset($_POST["delete"])) {
        $errorMessage = deleteSailors($_POST);
    
        if ($errorMessage !== null) {
            echo '<script>alert("' . $errorMessage . '");</script>';
        } else if ($errorMessage == null) {
            echo '<script>alert("Sailor deleted successfully"); window.location.href = "../sailors_main.php";</script>';
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
    <h2>Sailors Delete Page</h2>

    <form action="" method="post">
        <label for="sid">SID:</label><br>
        <input type="text" id="sid" name="sid" required><br>

        <input type="submit" value="Delete" name="delete">
    </form>

    <br><br>
    <a href="../sailors_main.php">Back to Sailors Maintenance Page</a>

</body>
</html>