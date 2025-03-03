<?php
    require_once "../../database/database.php";

    if (isset($_POST["add"])) {
        $errorMessage = createBoats($_POST);
    
        if ($errorMessage !== null) {
            echo '<script>alert("' . $errorMessage . '");</script>';
        } else if ($errorMessage == null) {
            echo '<script>alert("Boat added successfully"); window.location.href = "../boats_main.php";</script>';
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
    <h2>Boats Insert Page</h2>

    <form action="" method="post">
        <label for="sid">BID:</label><br>
        <input type="text" id="bid" name="bid"><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>

        <label for="color">Color:</label><br>
        <input type="text" id="color" name="color"><br>

        <input type="submit" value="Submit" name="add">
    </form>

    <br><br>
    <a href="../boats_main.php">Back to Boats Maintenance Page</a>

</body>
</html>