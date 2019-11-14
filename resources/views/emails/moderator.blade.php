<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>New job!</h2>

    <h1>{{ $job['title']  }}</h1>

    <p>{{ $job['description'] }}</p>

    <a href="http://localhost/job-project/public/index.php/job-offers/{{ $job['id'] }}/approve">Approve</a>
    <a href="http://localhost/job-project/public/index.php/job-offers/{{ $job['id'] }}/spam">Mark as spam</a>
</body>
</html>
