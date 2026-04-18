<?php
// قراءة بيانات الاتصال من متغيرات البيئة الخاصة بـ Railway
$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

// إنشاء الاتصال
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// التحقق من الاتصال
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
