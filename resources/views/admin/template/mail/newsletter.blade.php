<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Newsletter from {{config('app.name') ?? "Alumni"}}</title>
</head>
<body>
    <div>
        <h3>Newsletter from {{config('app.name') ?? "Alumni"}}</h3>
    </div>

    <div>
        <p style="margin: 0;">Dear {{$name}},</p>
        {!! $news !!}
    </div>

    <p style="color: red"> ----- This is a system generated email. Please DO NOT reply. ----- </p>
</body>
</html>
