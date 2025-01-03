<?php
include 'db.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM coaches WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $expertise = $_POST["expertise"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $sql = "UPDATE coaches SET name='$name', expertise='$expertise', phone='$phone', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Coach updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    Expertise: <input type="text" name="expertise" value="<?php echo $row['expertise']; ?>"><br>
    Phone: <input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br>
    Email: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>
    <button type="submit">Update Coach</button>
</form>
