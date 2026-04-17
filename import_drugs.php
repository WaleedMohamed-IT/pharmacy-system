<?php
// الاتصال بقاعدة البيانات
include 'db_connection.php';

// استدعاء ملف الهيدر (يحتوي على الروابط والستايل)
include 'header.php';

// استدعاء مكتبة PhpSpreadsheet
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// معالجة رفع ملف الإكسيل واستيراد البيانات
if (isset($_POST['import'])) {
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] == 0) {
        $fileName = $_FILES['excel_file']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($fileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            // تخطي أول صف (العناوين)
            for ($i = 1; $i < count($sheetData); $i++) {
                $id = $sheetData[$i][0];
                $drug_name = $sheetData[$i][1];
                $drug_type = $sheetData[$i][2];
                $stock = $sheetData[$i][3];

                $query = "INSERT INTO drugs (id, drug_name, drug_type, stock)
                          VALUES ('$id', '$drug_name', '$drug_type', '$stock')
                          ON DUPLICATE KEY UPDATE
                          drug_name='$drug_name', drug_type='$drug_type', stock='$stock'";

                mysqli_query($conn, $query);
            }

            echo "<div class='alert alert-success mt-3'>
                    <i class='fa-solid fa-check'></i> تم استيراد البيانات بنجاح!
                  </div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger mt-3'>
                    <i class='fa-solid fa-xmark'></i> حدث خطأ أثناء قراءة الملف: " . $e->getMessage() . "
                  </div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>
                <i class='fa-solid fa-xmark'></i> لم يتم رفع أي ملف أو حدث خطأ أثناء الرفع.
              </div>";
    }
}
?>

<h1 class="mb-4"><i class="fa-solid fa-file-import"></i> استيراد بيانات الأدوية</h1>

<!-- نموذج رفع ملف الإكسيل -->
<form method="POST" enctype="multipart/form-data" class="mb-3">
    <div class="mb-3">
        <label for="excel_file" class="form-label">اختر ملف الإكسيل:</label>
        <input type="file" name="excel_file" id="excel_file" class="form-control" required>
    </div>
    <button type="submit" name="import" class="btn btn-primary">
        <i class="fa-solid fa-upload"></i> استيراد
    </button>
</form>

<?php
// استدعاء ملف الفوتر (يغلق الصفحة ويوفر سكريبتات)
include 'footer.php';
?>
