<?php
include 'db.php';

$sql = "SELECT * FROM coaches";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Expertise</th><th>Phone</th><th>Email</th><th>Actions</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["expertise"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>
                    <a href='edit_coach.php?id=" . $row["id"] . "'>Edit</a> |
                    <a href='delete_coach.php?id=" . $row["id"] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No coaches found.";
}

$conn->close();
?>
