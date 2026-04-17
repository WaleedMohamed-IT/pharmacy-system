<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$sql = "SELECT * FROM drugs";
$result = $conn->query($sql);

$html = "<h2 style='text-align:center;'>تقرير الأدوية والمخزون</h2>";
$html .= "<table border='1' width='100%' style='border-collapse:collapse;text-align:center;'>";
$html .= "<tr><th>ID</th><th>اسم الدواء</th><th>نوع الدواء</th><th>المخزون</th></tr>";

while($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>".$row['id']."</td>
                <td>".$row['drug_name']."</td>
                <td>".$row['drug_type']."</td>
                <td>".$row['stock']."</td>
              </tr>";
}
$html .= "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("drugs_report.pdf", array("Attachment" => true));
exit;
?>
