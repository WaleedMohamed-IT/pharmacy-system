<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تحديث المخزون لو الفورم اتبعت
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_stock"])) {
    $id = intval($_POST["id"]);
    $new_stock = intval($_POST["stock"]);
    $sql_update = "UPDATE drugs SET stock=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ii", $new_stock, $id);
    $stmt->execute();
    echo "<p style='color:green;text-align:center;'>تم تحديث المخزون بنجاح 🎉</p>";
}

// إحصائيات عامة
$sql_stats = "SELECT COUNT(*) AS total_drugs, SUM(stock) AS total_stock, SUM(CASE WHEN stock <= 5 THEN 1 ELSE 0 END) AS low_stock_count FROM drugs";
$stats_result = $conn->query($sql_stats);
$stats = $stats_result->fetch_assoc();

// البحث + الفلترة
$search = "";
$filter_type = "";
if (isset($_GET["search"]) || isset($_GET["filter_type"])) {
    $search = $_GET["search"] ?? "";
    $filter_type = $_GET["filter_type"] ?? "";

    $sql = "SELECT * FROM drugs WHERE (drug_name LIKE ? OR drug_type LIKE ?)";
    if (!empty($filter_type)) {
        $sql .= " AND drug_type = ?";
    }

    $stmt = $conn->prepare($sql);
    $like = "%".$search."%";

    if (!empty($filter_type)) {
        $stmt->bind_param("sss", $like, $like, $filter_type);
    } else {
        $stmt->bind_param("ss", $like, $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM drugs";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الأدوية والمخزون</title>
    <style>
        body { font-family: Tahoma, Arial; background:#f4f6f9; margin:20px; }
        h1 { text-align:center; color:#2c3e50; }
        .dashboard { display:flex; justify-content:center; gap:20px; margin-bottom:20px; }
        .card { background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); text-align:center; width:200px; }
        .card h2 { margin:0; font-size:24px; color:#3498db; }
        .card p { margin:5px 0 0; color:#555; }
        .low-stock { background-color:#f8d7da; color:#721c24; font-weight:bold; }
        .medium-stock { background-color:#fff3cd; color:#856404; }
        .good-stock { background-color:#d4edda; color:#155724; }
        table { width:90%; margin:auto; border-collapse:collapse; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding:12px; text-align:center; border-bottom:1px solid #ddd; }
        th { background:#3498db; color:white; }
        tr:hover { background:#f1f1f1; }
        form { margin:0; }
        input[type=number] { width:60px; }
        input[type=submit] { background:#27ae60; color:white; border:none; padding:5px 10px; cursor:pointer; }
        input[type=submit]:hover { background:#219150; }
        .search-box { text-align:center; margin-bottom:20px; }
        .search-box input[type=text], .search-box select { padding:8px; margin-right:10px; }
        .search-box input[type=submit] { padding:8px 12px; background:#3498db; color:white; border:none; cursor:pointer; }
        .search-box input[type=submit]:hover { background:#2980b9; }
        .export-buttons { text-align:center; margin-bottom:20px; }
        .export-buttons a { padding:10px 15px; color:white; text-decoration:none; margin-right:10px; border-radius:5px; }
        .excel-btn { background:#3498db; }
        .pdf-btn { background:#e74c3c; }
    </style>
</head>
<body>
    <h1>قائمة الأدوية والمخزون</h1>

    <!-- لوحة الإحصائيات -->
    <div class="dashboard">
        <div class="card">
            <h2><?php echo $stats["total_drugs"]; ?></h2>
            <p>عدد الأدوية</p>
        </div>
        <div class="card">
            <h2><?php echo $stats["total_stock"]; ?></h2>
            <p>إجمالي المخزون</p>
        </div>
        <div class="card">
            <h2><?php echo $stats["low_stock_count"]; ?></h2>
            <p>أدوية قربت تخلص</p>
        </div>
    </div>

    <!-- أزرار التصدير -->
    <div class="export-buttons">
        <a href="export_excel.php" class="excel-btn">تصدير إلى Excel</a>
        <a href="export_pdf.php" class="pdf-btn">تصدير إلى PDF</a>
    </div>

    <!-- مربع البحث + الفلترة -->
    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="ابحث عن دواء..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="filter_type">
                <option value="">-- اختر نوع الدواء --</option>
                <option value="Tab" <?php if($filter_type=="Tab") echo "selected"; ?>>أقراص</option>
                <option value="Amp" <?php if($filter_type=="Amp") echo "selected"; ?>>حقن</option>
                <option value="Tube" <?php if($filter_type=="Tube") echo "selected"; ?>>أنابيب</option>
                <option value="Bottle" <?php if($filter_type=="Bottle") echo "selected"; ?>>زجاجات</option>
            </select>
            <input type="submit" value="بحث / فلترة">
        </form>
    </div>

    <!-- جدول الأدوية -->
    <table>
        <tr>
            <th>ID</th>
            <th>اسم الدواء</th>
            <th>نوع الدواء</th>
            <th>المخزون</th>
            <th>تحديث</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $stock_class = "";
                if ($row["stock"] <= 5) {
                    $stock_class = "low-stock";
                } elseif ($row["stock"] <= 20) {
                    $stock_class = "medium-stock";
                } else {
                    $stock_class = "good-stock";
                }

                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["drug_name"] . "</td>";
                echo "<td>" . $row["drug_type"] . "</td>";
                echo "<td class='$stock_class'>" . $row["stock"] . "</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <input type='number' name='stock' value='" . $row["stock"] . "'>
                            <input type='submit' name='update_stock' value='تحديث'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>لا توجد بيانات</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
