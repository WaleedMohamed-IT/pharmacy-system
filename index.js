// استدعاء المكتبات
const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 8080;

// جعل المجلد الحالي متاح كـ static files
app.use(express.static(path.join(__dirname)));

// عند الدخول على الرابط الرئيسي "/" يعرض index.html
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

// تشغيل السيرفر
app.listen(PORT, () => {
  console.log(`🚀 Server is running on http://localhost:${PORT}`);
});