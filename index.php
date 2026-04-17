<?php
// استدعاء ملف الهيدر (يحتوي على الروابط والستايل)
include 'header.php';
?>

<h1 class="mb-4"><i class="fa-solid fa-hospital"></i> نظام إدارة الصيدلية</h1>

<!-- روابط رئيسية -->
<div class="list-group">
    <a href="drugs_stock.php" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-pills"></i> قائمة الأدوية والمخزون
    </a>
    <a href="import_drugs.php" class="list-group-item list-group-item-action">
        <i class="fa-solid fa-file-import"></i> استيراد بيانات الأدوية
    </a>
</div>

<!-- محتوى ترحيبي -->
<div class="mt-4 alert alert-info">
    <i class="fa-solid fa-circle-info"></i> مرحبًا بك في نظام إدارة الصيدلية. 
    اختر من القائمة أعلاه لعرض الأدوية أو استيراد بيانات جديدة.
</div>

<?php
// استدعاء ملف الفوتر (يغلق الصفحة ويوفر سكريبتات)
include 'footer.php';
?>
