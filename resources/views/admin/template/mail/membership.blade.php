<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Membership ID</title>
</head>
<body>
    <div>
        <h3>Membership ID from {{ env('APP_NAME') }}</h3>
    </div>

    <div>
        <p style="margin: 0;">Dear Sir/Madam,</p>
        <p style="margin: 0;">Your payment is successfully done and a new <b>Membership ID: {{$membership_id}} </b> is provided for further communication and transactions.</p>
        <p style="margin: 0;">Request you to keep the membership id safe for further transactions</p>
    </div>

    <p style="color: red"> ----- This is a system generated email. Please DO NOT reply. ----- </p>
</body>
</html>
