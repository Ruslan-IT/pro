<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>Заказ</h1>

    <table>
        <tr>
            <th>Номер </th>
            <th>Наименование  </th>
            <th>Стоимость  </th>
            <th>Email  </th>
        </tr>

        @foreach($cart as $carts)
            <tr>
                <td>{{ $carts->id }}</td>
                <td>{{ $carts->name }}</td>
                <td>{{ $carts->email }}</td>
            </tr

        @endforeach

    </table>

</body>
</html>
