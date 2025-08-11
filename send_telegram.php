<?php
// Конфигурация
$botToken = '7833807400:AAEoEzyox_zj3AhiHDNC3Lxv636lnvdrJI8';  // вставь свой токен бота
$chatId = '6932321713';                // вставь свой chat_id

// Получаем JSON из POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Нет данных']);
    exit;
}

$secret = $data['secret'] ?? '';
if ($secret !== 'REPLACE_WITH_SECRET_KEY') {
    echo json_encode(['status' => 'error', 'message' => 'Неверный секрет']);
    exit;
}

$fullName = $data['fullName'] ?? '';
$phone = $data['phone'] ?? '';
$telegram = $data['telegram'] ?? '';
$date = $data['date'] ?? '';
$time = $data['time'] ?? '';

if (!$fullName || !$phone || !$date || !$time) {
    echo json_encode(['status' => 'error', 'message' => 'Заполните все поля']);
    exit;
}

$message = "Новая заявка:\n"
         . "Имя: $fullName\n"
         . "Телефон: $phone\n"
         . "Telegram: $telegram\n"
         . "Дата: $date\n"
         . "Время: $time";

$url = "https://api.telegram.org/bot$botToken/sendMessage";

$postFields = [
    'chat_id' => $chatId,
    'text' => $message,
];

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка отправки']);
}
?>
