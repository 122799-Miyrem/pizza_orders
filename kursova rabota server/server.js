const express = require('express');
const fs = require('fs');
const path = require('path');
const app = express();
const PORT = 3000;

// Middleware за обработка на JSON и статични файлове
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// Път до JSON файла за съхранение на поръчки
const ordersFile = path.join(__dirname, 'data', 'orders.json');

// Проверка дали файлът съществува, ако не – създаване на празен масив
if (!fs.existsSync(ordersFile)) {
    fs.writeFileSync(ordersFile, '[]');
}

// **GET** - Извличане на всички поръчки
app.get('/api/orders', (req, res) => {
    const orders = JSON.parse(fs.readFileSync(ordersFile));
    res.json(orders);
});

// **POST** - Добавяне на нова поръчка
app.post('/api/orders', (req, res) => {
    const newOrder = req.body;
    let orders = JSON.parse(fs.readFileSync(ordersFile));

    // Валидация: Проверка за задължителни полета
    if (!newOrder.name || !newOrder.address || !newOrder.phone || !newOrder.pizza || !newOrder.quantity) {
        return res.status(400).json({ error: 'Всички полета са задължителни!' });
    }

    // Добавяне на новата поръчка
    orders.push({ ...newOrder, id: Date.now() });
    fs.writeFileSync(ordersFile, JSON.stringify(orders, null, 2));

    res.status(201).json({ message: 'Поръчката е приета!', order: newOrder });
});

// Старт на сървъра
app.listen(PORT, () => {
    console.log(`Сървърът стартира на http://localhost:${PORT}`);
});
