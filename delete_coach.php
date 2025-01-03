<?php
include 'db.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM coaches WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Coach deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

