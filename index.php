<?php
$statusFile = 'status.txt';
$default    = 'off';

// 1. Если пришёл запрос на изменение статуса → меняем файл и отвечаем текстом
if (isset($_GET['status']) && in_array($_GET['status'], ['on', 'off'])) {
    file_put_contents($statusFile, $_GET['status']);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Status changed to " . $_GET['status'];
    exit;
}

// 2. Иначе читаем текущий статус и отдаём HTML-страницу
$status = file_exists($statusFile) ? trim(file_get_contents($statusFile)) : $default;
if (!in_array($status, ['on', 'off'])) $status = $default;

$color = $status === 'on' ? '#2ecc71' : '#e74c3c';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Server Status</title>
    <style>
        body { font-family: system-ui, sans-serif; text-align: center; margin-top: 15vh; background: #f8f9fa; }
        h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        .status { color: <?= $color ?>; font-weight: bold; }
        code { background: #e9ecef; padding: 6px 12px; border-radius: 6px; font-size: 1rem; }
    </style>
</head>
<body>
    <h1>Status: <span class="status"><?= $status ?></span></h1>
    <p>Команда для консоли:</p>
    <code>curl "http://localhost:8000/?status=on"</code>
</body>
</html>