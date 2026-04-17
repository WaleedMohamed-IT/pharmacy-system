<?php
$servername = "localhost";   // اسم السيرفر
$username = "root";          // اسم المستخدم (افتراضي في XAMPP)
$password = "";              // كلمة السر (افتراضي فاضية في XAMPP)
$dbname = "pharmacy_db";     // اسم قاعدة البيانات (هننشئها في MySQL)

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>
