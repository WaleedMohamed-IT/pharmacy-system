<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// جلب البيانات من جدول drugs
$sql = "SELECT * FROM drugs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الأدوية</title>
    <style>
        body {
            font-family: Tahoma, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>قائمة الأدوية</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>اسم الدواء</th>
            <th>نوع الدواء</th>
            <th>السعر</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["drug_name"] . "</td>";
                echo "<td>" . $row["drug_type"] . "</td>";
                echo "<td>" . $row["drug_price"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>لا توجد بيانات</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
