<?php
include 'db.php';

// 處理新增或編輯教練功能
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $expertise = $_POST["expertise"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    if (isset($_POST["edit_id"])) {
        // 編輯教練
        $id = $_POST["edit_id"];
        $sql = "UPDATE coaches SET name='$name', expertise='$expertise', phone='$phone', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
        } else {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
        }
    } else {
        // 新增教練
        $sql = "INSERT INTO coaches (name, expertise, phone, email) VALUES ('$name', '$expertise', '$phone', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Coach added successfully!</p>";
        } else {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
        }
    }
}

// 處理刪除教練功能
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $sql = "DELETE FROM coaches WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Coach deleted successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}

// 取得教練名單，按 ID 排序
$sql = "SELECT * FROM coaches ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Directory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(248, 250, 220);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1300px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(240, 233, 233, 0.1);
        }
        h1, h2 {
            color: #555;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color:rgb(241, 184, 190);
            color: #333;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            background-color: #007bff;
            border-radius: 4px;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
        .actions a.delete {
            background-color: #dc3545;
        }
        .actions a.delete:hover {
            background-color: #c82333;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>教練名錄管理</h1>

        <!-- 新增或編輯教練表單 -->
        <h2><?php echo isset($_GET['edit']) ? '編輯教練' : '新增教練'; ?></h2>
        <form method="POST" action="">
            <?php if (isset($_GET['edit'])): ?>
                <?php
                $edit_id = $_GET['edit'];
                $sql_edit = "SELECT * FROM coaches WHERE id=$edit_id";
                $edit_result = $conn->query($sql_edit);
                $edit_row = $edit_result->fetch_assoc();
                ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
                <input type="text" name="name" placeholder="Name" value="<?php echo $edit_row['name']; ?>" required>
                <input type="text" name="expertise" placeholder="Expertise" value="<?php echo $edit_row['expertise']; ?>">
                <input type="text" name="phone" placeholder="Phone" value="<?php echo $edit_row['phone']; ?>">
                <input type="text" name="email" placeholder="Email" value="<?php echo $edit_row['email']; ?>">
            <?php else: ?>
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="expertise" placeholder="Expertise">
                <input type="text" name="phone" placeholder="Phone">
                <input type="text" name="email" placeholder="Email">
            <?php endif; ?>
            <button type="submit"><?php echo isset($_GET['edit']) ? '更新教練' : '新增教練'; ?></button>
        </form>

        <hr>

        <!-- 顯示教練名單 -->
        <h2>教練名單</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>編號</th>
                        <th>姓名</th>
                        <th>專業領域</th>
                        <th>電話</th>
                        <th>電子郵件</th>
                        <th>編輯/刪除</th>
                    </tr>";
            
            $counter = 1;  // 編號從1開始
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $counter . "</td> <!-- 顯示計數器 -->
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["expertise"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td class='actions'>
                            <a href='?edit=" . $row["id"] . "'>編輯</a> | 
                            <a href='?delete=" . $row["id"] . "' class='delete' onclick='return confirm(\"確定刪除?\")'>刪除</a>
                        </td>
                    </tr>";
                $counter++;  // 計數器遞增
            }
            echo "</table>";
        } else {
            echo "<p>No coaches found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
