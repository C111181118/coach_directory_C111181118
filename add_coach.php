<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $expertise = $_POST["expertise"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $sql = "INSERT INTO coaches (name, expertise, phone, email) VALUES ('$name', '$expertise', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Coach added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<form method="POST" action="">
    Name: <input type="text" name="name"><br>
    Expertise: <input type="text" name="expertise"><br>
    Phone: <input type="text" name="phone"><br>
    Email: <input type="text" name="email"><br>
    <button type="submit">Add Coach</button>
</form>
