// استدعاء المكتبات
const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 8080;

// تحديد مجلد ثابت (public) لعرض الملفات
app.use(express.static(path.join(__dirname, 'public')));

// عند الدخول على الرابط الرئيسي "/" يعرض index.html من مجلد public
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// تشغيل السيرفر
app.listen(PORT, () => {
  console.log(`🚀 Server is running on http://localhost:${PORT}`);
});