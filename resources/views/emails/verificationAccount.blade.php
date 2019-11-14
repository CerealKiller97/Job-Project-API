<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verification mail</h2>
<a href="{{ getenv('FRONTEND_URL') }}/auth/verification?token={{ $token }}">Verify account</a>
</body>
</html>
