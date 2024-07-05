<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aliaksei Levin</title>

    <link rel="stylesheet" href="/css/main.css" />
    <script src="/js/form.js"></script>
</head>
<body>
    <header>
        <?php \Aliaksei\Test\Component\Base::GetComponent('personal')->render(); ?>
    </header>
    <?php \Aliaksei\Test\Component\Base::GetComponent('global-messages')->render(); ?>