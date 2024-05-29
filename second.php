<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <style>
        /* Basic CSS for styling the table */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Reviews</h2>

<?php  
    // Підключення до бази даних
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ca3olha";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Перевірка, чи була форма відправлена
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Отримання даних з форми
        $userid = $_POST['user_id'];
        $meditatitle = $_POST['medita_title']; 
        $mediatype = $_POST['media_type']; 
        $review = $_POST['review_text']; 

        // Підготовка SQL-запиту з використанням підготовлених інструкцій
        $sql = "INSERT INTO review (user_id, medita_title, media_type, review_text) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $userid, $meditatitle, $mediatype, $review);

        if ($stmt->execute()) {
            echo "Your review has been successfully submitted!<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $stmt->error;
        }

        $stmt->close();
    }

    // Виведення даних у вигляді таблиці
    $sql = "SELECT * FROM review";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Review ID</th><th>User ID</th><th>Media Title</th><th>Media Type</th><th>Review</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['review_id']."</td>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['medita_title']."</td>";
            echo "<td>".$row['media_type']."</td>";
            echo "<td>".$row['review_text']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>You have no reviews.</p>";
    }

    $conn->close();
?>
</body>
</html>