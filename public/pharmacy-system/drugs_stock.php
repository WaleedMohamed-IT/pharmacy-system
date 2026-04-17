<?php
// الاتصال بقاعدة البيانات
include 'db_connection.php';

// قراءة بيانات الأدوية من ملف الإكسيل أو قاعدة البيانات
// (الكود اللي عندك بالفعل لعرض الأدوية)
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الأدوية والمخزون</title>

    <!-- ✅ إضافة مكتبة Bootstrap للستايل -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- ✅ إضافة مكتبة FontAwesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- ✅ إضافة ملف CSS خاص بك (لو عايز تنسيقات مخصصة) -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="container mt-4">

    <h1 class="mb-4"><i class="fa-solid fa-pills"></i> قائمة الأدوية والمخزون</h1>

    <!-- مثال على البوكسات اللي فوق -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="alert alert-primary">
                <i class="fa-solid fa-capsules"></i> عدد الأدوية: 424
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success">
                <i class="fa-solid fa-boxes-stacked"></i> إجمالي المخزون: 440665
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
            <!-- هنا بيتكرر الكود اللي بيعرض الأدوية من قاعدة البيانات -->
            <tr>
                <td>5</td>
                <td>Acyclovir 250mg - Vial - [Acliglotir]</td>
                <td>Vial</td>
                <td>600</td>
                <td><button class="btn btn-success"><i class="fa-solid fa-rotate"></i> تحديث</button></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
