const { Pool } = require('pg')

// إعداد الاتصال بقاعدة البيانات
const pool = new Pool({
  user: 'postgres',       // اسم المستخدم الافتراضي
  host: 'localhost',      // السيرفر المحلي
  database: 'pharmacy',   // اسم قاعدة البيانات التي أنشأتها
  password: '1234',       // كلمة المرور التي اخترتها وقت التثبيت
  port: 5432,             // المنفذ الافتراضي لـ PostgreSQL
})

module.exports = pool