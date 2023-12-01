<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Support Ticket</title>
</head>
<body>
    <div>
        <h3>Support query from {{ env('APP_NAME') }}</h3>
    </div>

    <div>
        <p style="margin: 0;">Requester Name: {{ auth()->user()->name }}</p>
        <p style="margin: 0;">Requester Contact: {{ auth()->user()->contact }}</p>
        <p style="margin: 0;">Requester Email: {{ $email }}</p>
        <br>
        <p style="margin: 0;">Message:</p>
        <p style="margin: 0;"><b>{!! $mailMessage !!}</b></p>
    </div>

    <p style="color: red"> ----- This is a system generated email. Please DO NOT reply. ----- </p>
</body>
</html>
