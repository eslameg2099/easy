<!DOCTYPE html>
<html>
<head>
    <title>Easyget.com</title>
</head>

<body>
  <h1>{{ $details['title'] }}</h1>
  <h1></h1>
    <p>رقم الطلب: {{ $details['order_id'] }} , </p>
    <p> تاريخ الطلب:{{ $details['date'] }} , </p>
    <p> الاجمالي:{{ $details['total'] }}  </p>

    <p>Thank you {{ $details['user'] }} for use Easyget.com  </p>
</body>
</html>