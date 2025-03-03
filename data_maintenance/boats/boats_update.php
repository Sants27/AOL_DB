<?php
    require_once "../../database/database.php";

    if (isset($_POST["update"])) {
        $errorMessage = updateBoats($_POST);
    
        if ($errorMessage !== null) {
            echo '<script>alert("' . $errorMessage . '");</script>';
        } else if ($errorMessage == null) {
            echo '<script>alert("Boat updated successfully"); window.location.href = "../boats_main.php";</script>';
        }
    }

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
    <h2>Boats Update Page</h2>

    <form action="" method="post">
    <label for="bid">BID:</label><br>
    <input type="text" id="bid" name="bid" required><br>

    <label for="name">New Name:</label><br>
    <input type="text" id="name" name="name"><br>

    <label for="color">New Color:</label><br>
    <input type="text" id="color" name="color"><br>

    <input type="submit" value="Update" name="update">
</form>

    <br><br>
    <a href="../boats_main.php">Back to Boats Maintenance Page</a>

</body>
</html>