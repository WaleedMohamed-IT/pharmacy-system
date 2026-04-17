<?php
// إعداد بيانات الاتصال بقاعدة البيانات
$servername = "localhost";   // اسم السيرفر
$username   = "root";        // اسم المستخدم
$password   = "";            // كلمة المرور (افتراضيًا فاضية في XAMPP)
$dbname     = "pharmacy";    // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("<div style='color:red; font-weight:bold;'>
        فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error() . "
    </div>");
} else {
    // لو الاتصال ناجح ممكن تطبع رسالة للتأكد أثناء التطوير
    // echo "<div style='color:green;'>تم الاتصال بقاعدة البيانات بنجاح</div>";
}
?>
