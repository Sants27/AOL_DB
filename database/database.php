<?php

session_start();
$conn = "";
$stmt = "";

function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "aol";
    $dataSourceName = "mysql:host=" . $servername . ";dbname=" . $dbName;
    try {
        $conn = new PDO($dataSourceName, $username, $password);
        return $conn;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

function closeConnection()
{
    $conn = null;
    $stmt = null;
}

connectToDB();

function getAllSailors()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT * FROM sailors");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    closeConnection();
    return $result;
}

function getAllBoats()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT * FROM boats");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    closeConnection();
    return $result;
}

function getAllReserves()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT * FROM reserves");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    closeConnection();
    return $result;
}

function countAllSailors()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT COUNT(*) as total FROM sailors");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    closeConnection();
    return $result['total'];
}

function countAllBoats()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT COUNT(*) as total FROM boats");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    closeConnection();
    return $result['total'];
}

function getAverageSailorRating()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT AVG(rating) as averageRating FROM sailors");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    closeConnection();
    $averageRating = $result['averageRating'];
    return number_format($averageRating, 2);
}

function getAverageSailorAge()
{
    $conn = connectToDB();
    $stmt = $conn->query("SELECT AVG(age) as averageAge FROM sailors");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    closeConnection();
    $averageAge = $result['averageAge'];
    return number_format($averageAge, 2);
}

function createSailors($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM sailors WHERE sid = ?");
        $stmt->execute([$data["sid"]]);
        $sailor = $stmt->fetch();

        if ($sailor) {
            throw new Exception("Error: Sailor with the following SID already exists.");
        }

        $stmt = $conn->prepare("INSERT INTO sailors (sid, sname, rating, age) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data["sid"],
            $data["name"],
            $data["rating"],
            $data["age"],
        ]);

        closeConnection();
        return null;
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function createBoats($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM boats WHERE bid = ?");
        $stmt->execute([$data["bid"]]);
        $boat = $stmt->fetch();

        if ($boat) {
            throw new Exception("Error: Boat with the following BID already exists.");
        }

        $stmt = $conn->prepare("INSERT INTO boats (bid, bname, color) VALUES (?, ?, ?)");
        $stmt->execute([
            $data["bid"],
            $data["name"],
            $data["color"],
        ]);

        closeConnection();
        return null;
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

// function createReservations($data)
// {
//     $conn = connectToDB();

//     try {
//         $stmt = $conn->prepare("SELECT * FROM reserves WHERE days = ?");
//         $stmt->execute([$data["date"]]);
//         if ($stmt->rowCount() > 0) {
//             $stmt = $conn->prepare("SELECT * FROM reserves WHERE sid = ? AND days = ?");
//             $stmt->execute([$data["sid"], $data["date"]]);
//             if($stmt->rowCount() > 0){
//                 closeConnection();
//                 throw new Exception("Error: The same SID has already reserved a boat on this date.");
//             }

//             $stmt = $conn->prepare("SELECT * FROM reserves WHERE bid = ? AND days = ?");
//             $stmt->execute([$data["bid"], $data["date"]]);
//             if($stmt->rowCount() > 0){
//                 closeConnection();
//                 throw new Exception("Error: The boat has already been reserved on this date.");
//             }
//         }

//         $stmt = $conn->prepare("INSERT INTO reserves (sid, bid, days) VALUES (?, ?, ?)");
//         $stmt->execute([
//             $data["sid"],
//             $data["bid"],
//             $data["date"],
//         ]);

//         closeConnection();
//         return null; 

//     } catch (Exception $e) {
//         closeConnection();
//         return $e->getMessage();
//     }
// }

function createReservations($data)
{
    $conn = connectToDB();

    try {
        // Convert the date to the desired format
        $date = DateTime::createFromFormat('Y-m-d', $data["date"]);
        if (!$date) {
            throw new Exception('Invalid date format. Expected format is Y-m-d.');
        }
        $formattedDate = $date->format('d/m/y');

        $stmt = $conn->prepare("SELECT * FROM reserves WHERE days = ?");
        $stmt->execute([$formattedDate]);
        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("SELECT * FROM reserves WHERE sid = ? AND days = ?");
            $stmt->execute([$data["sid"], $formattedDate]);
            if ($stmt->rowCount() > 0) {
                closeConnection();
                throw new Exception("Error: The same SID has already reserved a boat on this date.");
            }

            $stmt = $conn->prepare("SELECT * FROM reserves WHERE bid = ? AND days = ?");
            $stmt->execute([$data["bid"], $formattedDate]);
            if ($stmt->rowCount() > 0) {
                closeConnection();
                throw new Exception("Error: The boat has already been reserved on this date.");
            }
        }

        $stmt = $conn->prepare("INSERT INTO reserves (sid, bid, days) VALUES (?, ?, ?)");
        $stmt->execute([
            $data["sid"],
            $data["bid"],
            $formattedDate,
        ]);

        closeConnection();
        return null;
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function deleteSailors($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM sailors WHERE sid = ?");
        $stmt->execute([$data["sid"]]);
        $sailor = $stmt->fetch();

        if ($sailor) {
            $stmt = $conn->prepare("DELETE FROM sailors WHERE sid = ?");
            $stmt->execute([
                $data["sid"],
            ]);

            closeConnection();
            return null;
        } else {
            throw new Exception("Error: Sailor with the following id does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function deleteBoats($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM boats WHERE bid = ?");
        $stmt->execute([$data["bid"]]);
        $boat = $stmt->fetch();

        if ($boat) {
            $stmt = $conn->prepare("DELETE FROM boats WHERE bid = ?");
            $stmt->execute([
                $data["bid"],
            ]);

            closeConnection();
            return null;
        } else {
            throw new Exception("Error: Boat with the following id does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function deleteReservations($data)
{
    $conn = connectToDB();

    try {
        // Convert the date to the desired format
        $date = DateTime::createFromFormat('Y-m-d', $data["date"]);
        if (!$date) {
            throw new Exception('Invalid date format. Expected format is Y-m-d.');
        }
        $formattedDate = $date->format('d/m/y');

        $stmt = $conn->prepare("SELECT * FROM reserves WHERE sid = ? AND days = ?");
        $stmt->execute([$data["sid"], $formattedDate]);
        $reserve = $stmt->fetch();

        if ($reserve) {
            $stmt = $conn->prepare("DELETE FROM reserves WHERE sid = ? AND days = ?");
            $stmt->execute([
                $data["sid"],
                $formattedDate,
            ]);

            closeConnection();
            return null;
        } else {
            throw new Exception("Error: Reservation with the following option does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function updateSailors($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM sailors WHERE sid = ?");
        $stmt->execute([$data["sid"]]);
        $sailor = $stmt->fetch();

        if ($sailor) {
            $stmt = $conn->prepare("UPDATE sailors SET sname = ?, rating = ?, age = ? WHERE sid = ?");
            $stmt->execute([
                $data["name"],
                $data["rating"],
                $data["age"],
                $data["sid"],
            ]);

            closeConnection();
            return null;
        } else {
            throw new Exception("Error: Sailor with the following id does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function updateBoats($data)
{
    $conn = connectToDB();

    try {
        $stmt = $conn->prepare("SELECT * FROM boats WHERE bid = ?");
        $stmt->execute([$data["bid"]]);
        $boat = $stmt->fetch();

        if ($boat) {
            $stmt = $conn->prepare("UPDATE boats SET bname = ?, color = ? WHERE bid = ?");
            $stmt->execute([
                $data["name"],
                $data["color"],
                $data["bid"],
            ]);

            closeConnection();
            return null;
        } else {
            throw new Exception("Error: Boat with the following id does not exist.");
        }
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}

function updateReservations($data)
{
    $conn = connectToDB();

    try {
        $date = DateTime::createFromFormat('Y-m-d', $data["new_date"]);
        if (!$date) {
            throw new Exception('Invalid date format. Expected format is Y-m-d.');
        }
        $formattedDate = $date->format('d/m/y');

        $stmt = $conn->prepare("SELECT * FROM reserves WHERE sid = ? AND days = ?");
        $stmt->execute([$data["sid"], $formattedDate]);
        $reservation = $stmt->fetch();

        if ($reservation) {
            throw new Exception("Error: This SID has already reserved a boat on this date.");
        }
        $stmt = $conn->prepare("SELECT * FROM reserves WHERE bid = ? AND days = ?");
        $stmt->execute([$data["new_bid"], $formattedDate]);
        $reservation = $stmt->fetch();

        if ($reservation) {
            throw new Exception("Error: Reservations with the following option has already exist.");
        }

        $stmt = $conn->prepare("DELETE FROM reserves WHERE sid = ? AND bid = ? AND days = ?");
        $stmt->execute([
            $data["sid"],
            $data["old_bid"],
            $data["old_date"],
        ]);

        $stmt = $conn->prepare("INSERT INTO reserves (sid, bid, days) VALUES(?, ?, ?)");
        $stmt->execute([
            $data["sid"],
            $data["new_bid"],
            $formattedDate,
        ]);

        closeConnection();
        return null;
    } catch (Exception $e) {
        closeConnection();
        return $e->getMessage();
    }
}