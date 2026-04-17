# نظام إدارة الصيدلية

مشروع بسيط لإدارة بيانات الأدوية والمخزون داخل الصيدلية باستخدام **PHP/MySQL** مع واجهة منظمة تعتمد على **Bootstrap** و **FontAwesome**.

---

## 📂 الملفات الأساسية
- `index.php` → الصفحة الرئيسية، تحتوي على روابط لقائمة الأدوية واستيراد البيانات.
- `drugs_stock.php` → عرض قائمة الأدوية والمخزون مع إحصائيات وجداول.
- `import_drugs.php` → استيراد بيانات الأدوية من ملف إكسيل باستخدام مكتبة PhpSpreadsheet.
- `db_connection.php` → الاتصال بقاعدة البيانات MySQL.
- `header.php` → يحتوي على روابط الستايل والمكتبات (Bootstrap + FontAwesome + style.css).
- `footer.php` → إغلاق الصفحة وإضافة سكريبتات Bootstrap.
- `style.css` → تنسيقات إضافية مخصصة للواجهة.

---

## ⚙️ المتطلبات
- **XAMPP** أو أي سيرفر محلي لتشغيل PHP/MySQL.
- قاعدة بيانات MySQL باسم `pharmacy` تحتوي على جدول `drugs` بالحقول:
  - `id` (INT, Primary Key)
  - `drug_name` (VARCHAR)
  - `drug_type` (VARCHAR)
  - `stock` (INT)

- مكتبة **PhpSpreadsheet** مثبتة عبر Composer:
  ```bash
  composer require phpoffice/phpspreadsheet
