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
        <th>Имя</th>
        <th>Телефон</th>
        <th>Email</th>
    </tr>

    <tr>
        <td>Имя -</td>
        <td> {{  $cart['name'] }}</td>
    <tr>
    <tr>
        <td>Телефон -</td>
        <td> {{  $cart['phone'] }}</td>
    <tr>
    <tr>
        <td>Email -</td>
        <td> {{  $cart['email'] }}</td>
    <tr>

     @foreach($cart as $carts):

        <tr>
            <td> {{  $carts['title'] }} -</td>
            <td> {{  $carts['quantity'] }}</td>
            <td> {{  $carts['color'] }}</td>
            <td> {{  $carts['price'] }}</td>
        <tr>

     @endforeach;


</table>

</body>
</html>
