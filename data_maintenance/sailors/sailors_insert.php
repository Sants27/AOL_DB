<?php
    require_once "../../database/database.php";

    if (isset($_POST["add"])) {
        $errorMessage = createSailors($_POST);
    
        if ($errorMessage !== null) {
            echo '<script>alert("' . $errorMessage . '");</script>';
        } else {
            // if ($errorMessage == null) {
            echo '<script>alert("Sailor added successfully");</script>'; // window.location.href = "../sailors_main.php";
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
    <h2>Sailors Insert Page</h2>

    <form action="../sailors_insert.html" method="post">
        <label for="sid">SID:</label><br>
        <input type="text" id="sid" name="sid"><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>

        <label for="rating">Rating:</label><br>
        <input type="number" id="rating" name="rating"><br>

        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age"><br>

        <input type="submit" value="Submit" name="add">
    </form>

    <br><br>
    <a href="../data_main.html"">Back to Sailors Maintenance Page</a>

</body>
</html>