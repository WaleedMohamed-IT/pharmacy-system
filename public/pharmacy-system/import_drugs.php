<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تحميل ملف Excel
$spreadsheet = IOFactory::load("drugs.xlsx");
$sheet = $spreadsheet->getActiveSheet();

// قراءة الصفوف وإدخالها في جدول drugs
foreach ($sheet->getRowIterator(2) as $row) { // يبدأ من الصف الثاني لتجاهل العناوين
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);

    $data = [];
    foreach ($cellIterator as $cell) {
        $data[] = $cell->getValue();
    }

    // الأعمدة بالترتيب: DrugID, DrugName, Unit, Stock
    $drug_name = $data[1] ?? '';     
    $unit      = $data[2] ?? '';     
    $stock     = is_numeric($data[3]) ? $data[3] : 0; 

    $sql = "INSERT INTO drugs (drug_name, drug_type, stock) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $drug_name, $unit, $stock);
    $stmt->execute();
}

echo "تم استيراد الأدوية والمخزون بنجاح 🎉";
$conn->close();
?>
