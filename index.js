const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;
// مسارات API
app.get('/medicines', (req, res) => {
  res.json([
    { name: 'Paracetamol', price: 10, quantity: 50 },
    { name: 'Amoxicillin', price: 20, quantity: 30 }
  ]);
});

app.get('/users', (req, res) => {
  res.json([
    { name: 'Walid', email: 'walid@example.com' },
    { name: 'Sara', email: 'sara@example.com' }
  ]);
});

// تقديم ملف index.html عند فتح الرابط الرئيسي
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});