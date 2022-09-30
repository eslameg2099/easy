<!DOCTYPE html>
<html>
<head>
    <title>Tatweer.com</title>
</head>
<body>
  <h1>{{ $details['title'] }}</h1>
    <a href="{{url('https://tatweer.test.d.deli.work/api/verification/verify/'.$details['code'])}}">
    
                      اضغط هنا
                    </a>
    
    <p>Thank you {{ $details['user'] }} for use Tatweer.com  </p>
</body>
</html>