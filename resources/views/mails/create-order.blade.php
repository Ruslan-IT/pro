<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новый заказ</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .printing-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            background-color: #4CAF50;
            color: white;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h1>Новый заказ #{{ $cart->id }}</h1>

<h2>Информация о клиенте:</h2>
<p><strong>Имя:</strong> {{ $cart->name }}</p>
<p><strong>Email:</strong> {{ $cart->email }}</p>
<p><strong>Телефон:</strong> {{ $cart->phone }}</p>
<p><strong>Общая сумма:</strong> {{ number_format($cart->total_price, 2, '.', ' ') }} руб.</p>

<h2>Состав заказа:</h2>
<table>
    <tr>
        <th>Изображение</th>
        <th>Название</th>
        <th>Артикул</th>
        <th>Цвет</th>
        <th>Размер</th>
        <th>Нанесение</th>
        <th>Количество</th>
        <th>Цена за шт.</th>
        <th>Общая цена</th>
    </tr>
    @foreach($cart->items as $item)
        @php
            $pricePerUnit = $item['quantity'] > 0 ? $item['price'] / $item['quantity'] : $item['price'];
        @endphp
        <tr>
            <td>
                @if(!empty($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="product-image">
                @else
                    <span>Нет изображения</span>
                @endif
            </td>
            <td>{{ $item['title'] }}</td>
            <td>{{ $item['article'] }}</td>
            <td>{{ $item['color'] }}</td>
            <td>{{ $item['size'] }}</td>
            <td>
                @if($item['with_printing'])
                    <span class="printing-badge">Да (+{{ $item['printing_cost'] }} ₽)</span>
                @else
                    Нет
                @endif
            </td>
            <td>{{ $item['quantity'] }}</td>
            <td>{{ $item['price']  }} ₽</td>
            <td>{{ $item['price'] * $item['quantity']  }} ₽</td>

        </tr>
    @endforeach
</table>

<p><strong>Дата заказа:</strong> {{ $cart->created_at->format('d.m.Y H:i') }}</p>

</body>
</html>
