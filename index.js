const express = require("express");
const bodyParser = require("body-parser");
const { Pool } = require("pg");

const app = express();
const port = process.env.PORT || 8080;

// الاتصال بقاعدة البيانات باستخدام DATABASE_URL من البيئة
const pool = new Pool({
  connectionString: process.env.DATABASE_URL || "postgres://username:password@host:5432/database",
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
app.post("/addMedicine", async (req, res) => {
  try {
    const name = req.body.name?.toString() || "";
    const qty = parseInt(req.body.qty) || 0;
    const price = req.body.price?.toString() || "";

    await pool.query(
      "INSERT INTO medicines (name, quantity, price) VALUES ($1, $2, $3)",
      [name, qty, price]
    );

    res.json({ success: true, message: "تم إضافة الدواء بنجاح!" });
  } catch (err) {
    console.error("خطأ أثناء إضافة الدواء:", err);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء إضافة الدواء" });
  }
});

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
app.post("/register", async (req, res) => {
  const { username, email, password } = req.body;
  try {
    await pool.query(
      "INSERT INTO users (username, email, password) VALUES ($1, $2, $3)",
      [username, email, password]
    );
    res.json({ success: true, message: "تم تسجيل المستخدم بنجاح!" });
  } catch (err) {
    console.error("خطأ أثناء تسجيل المستخدم:", err);
    res.status(500).json({ success: false, message: "حدث خطأ أثناء تسجيل المستخدم" });
  }
});

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



