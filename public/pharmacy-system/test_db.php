<?php
include 'db_connection.php';

if ($conn) {
    echo "✅ الاتصال بقاعدة البيانات ناجح!";
} else {
    echo "❌ فشل الاتصال بقاعدة البيانات!";
}
?>
