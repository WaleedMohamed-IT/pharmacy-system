const express = require("express");
const bodyParser = require("body-parser");
const { Pool } = require("pg");

const app = express();
const port = process.env.PORT || 8080;

// إعداد الاتصال بقاعدة البيانات PostgreSQL
const pool = new Pool({
  connectionString: process.env.DATABASE_URL,
  ssl: { rejectUnauthorized: false }
});

// Middleware
app.use(bodyParser.json());
app.use(express.static("public"));

// Route رئيسي
app.get("/", (req, res) => {
  res.sendFile(__dirname + "/public/index.html");
});

// -------------------- الأدوية --------------------

// إضافة دواء جديد
app.post("/addMedicine", async (req, res) => {
  try {
    // تحويل القيم للتأكد من النوع الصحيح
    const name = req.body.name?.toString() || "";
    const qty = parseInt(req.body.qty) || 0;
    const price = req.body.price?.toString() || "";

    await pool.query(
      "INSERT INTO medicines (name, quantity, price) VALUES ($1, $2, $3)",
      [name, qty, price]
    );

    res.json({ success: true, message: "تم إضافة الدواء بنجاح!" });
  } catch (err) {
    console.error("خطأ أثناء إضافة الدواء:", err.message);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء إضافة الدواء" });
  }
});

// جلب قائمة الأدوية
app.get("/medicines", async (req, res) => {
  try {
    const result = await pool.query("SELECT * FROM medicines");
    res.json(result.rows);
  } catch (err) {
    console.error(err);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء جلب الأدوية" });
  }
});

// -------------------- المستخدمين --------------------

// تسجيل مستخدم جديد
app.post("/register", async (req, res) => {
  const { username, email, password } = req.body;
  try {
    await pool.query(
      "INSERT INTO users (username, email, password) VALUES ($1, $2, $3)",
      [username, email, password]
    );
    res.json({ success: true, message: "تم تسجيل المستخدم بنجاح!" });
  } catch (err) {
    console.error("خطأ أثناء تسجيل المستخدم:", err.message);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء تسجيل المستخدم" });
  }
});

// جلب قائمة المستخدمين
app.get("/users", async (req, res) => {
  try {
    const result = await pool.query("SELECT id, username, email FROM users");
    res.json(result.rows);
  } catch (err) {
    console.error(err);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء جلب المستخدمين" });
  }
});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});


