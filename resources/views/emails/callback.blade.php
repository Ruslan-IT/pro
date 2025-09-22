<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Заявка на обратный звонок</title>
</head>
<body>
<h2>Новая заявка на обратный звонок</h2>

<p><strong>Имя:</strong> {{ $data['name'] }}</p>
<p><strong>Телефон:</strong> {{ $data['phone'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] ?? 'Не указан' }}</p>
<p><strong>Дата и время:</strong> {{ now()->format('d.m.Y H:i') }}</p>

<hr>
<p>Это письмо было отправлено автоматически с сайта MVGifts.</p>
</body>
</html>
