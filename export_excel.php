<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'اسم الدواء');
$sheet->setCellValue('C1', 'نوع الدواء');
$sheet->setCellValue('D1', 'المخزون');

$rowNum = 2;
while($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A'.$rowNum, $row['id']);
    $sheet->setCellValue('B'.$rowNum, $row['drug_name']);
    $sheet->setCellValue('C'.$rowNum, $row['drug_type']);
    $sheet->setCellValue('D'.$rowNum, $row['stock']);
    $rowNum++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="drugs_report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'اسم الدواء');
$sheet->setCellValue('C1', 'نوع الدواء');
$sheet->setCellValue('D1', 'المخزون');

$rowNum = 2;
while($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A'.$rowNum, $row['id']);
    $sheet->setCellValue('B'.$rowNum, $row['drug_name']);
    $sheet->setCellValue('C'.$rowNum, $row['drug_type']);
    $sheet->setCellValue('D'.$rowNum, $row['stock']);
    $rowNum++;
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="drugs_report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
