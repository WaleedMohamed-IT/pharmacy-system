<?php
// الاتصال بقاعدة البيانات
include 'db_connection.php';

// استدعاء ملف الهيدر (يحتوي على الروابط والستايل)
include 'header.php';

// جلب بيانات الأدوية من قاعدة البيانات
$query = "SELECT * FROM drugs";
$result = mysqli_query($conn, $query);
?>

<h1 class="mb-4"><i class="fa-solid fa-pills"></i> قائمة الأدوية والمخزون</h1>

<!-- مربعات الإحصائيات -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="alert alert-primary">
            <i class="fa-solid fa-capsules"></i> عدد الأدوية: 
            <?php echo mysqli_num_rows($result); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-success">
            <i class="fa-solid fa-boxes-stacked"></i> إجمالي المخزون: 
            <?php
            $total_stock = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $total_stock += $row['stock'];
            }
            echo $total_stock;
            // إعادة المؤشر للنتيجة علشان نعرض الجدول بعدين
            mysqli_data_seek($result, 0);
            ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i> أدوية قربت تخلص: 0
        </div>
    </div>
</div>

<!-- مربع البحث -->
<form method="GET" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="ابحث عن دواء">
</form>

<!-- جدول الأدوية -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>اسم الدواء</th>
            <th>نوع الدواء</th>
            <th>المخزون</th>
            <th>تحديث</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['drug_name']; ?></td>
                <td><?php echo $row['drug_type']; ?></td>
                <td><?php echo $row['stock']; ?></td>
                <td>
                    <button class="btn btn-success">
                        <i class="fa-solid fa-rotate"></i> تحديث
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
// استدعاء ملف الفوتر (يغلق الصفحة ويوفر سكريبتات)
include 'footer.php';
?>
