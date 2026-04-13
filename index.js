const express = require("express");
const session = require("express-session");
const cors = require("cors");
const path = require("path");

const app = express();
app.use(cors());
app.use(express.json());

// إعداد الـ Session
app.use(session({
  secret: "pharmacy-secret",
  resave: false,
  saveUninitialized: true
}));

// عرض الملفات الثابتة من مجلد public
app.use(express.static(path.join(__dirname, "public")));

// عرض الصفحة الرئيسية (index.html داخل public)
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public", "index.html"));
});

// تسجيل الدخول
app.post("/login", (req, res) => {
  const { username, password } = req.body;
  if (username === "admin" && password === "1234") {
    req.session.user = username;
    res.json({ message: "✅ تم تسجيل الدخول بنجاح" });
  } else {
    res.status(401).json({ error: "❌ اسم المستخدم أو كلمة المرور غير صحيحة" });
  }
});

// تسجيل الخروج
app.post("/logout", (req, res) => {
  req.session.destroy(err => {
    if (err) return res.status(500).json({ error: "❌ فشل تسجيل الخروج" });
    res.json({ message: "✅ تم تسجيل الخروج بنجاح" });
  });
});

// حماية أي مسار يتطلب تسجيل دخول
app.get("/protected", (req, res) => {
  if (req.session.user) {
    res.json({ message: `مرحباً ${req.session.user}` });
  } else {
    res.status(401).json({ error: "❌ يجب تسجيل الدخول أولاً" });
  }
});

// تشغيل السيرفر
app.listen(process.env.PORT || 8080, () => {
  console.log("✅ Server running on port " + (process.env.PORT || 8080));
});



