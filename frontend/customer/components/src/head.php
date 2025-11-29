<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Cakeaway Admin Panel" />
    <meta name="author" content="Cakeaway" />

    <title><?php echo isset($pageTitle) ? $pageTitle : 'Cakeaway'; ?></title>

    <link rel="icon" type="image/png" href="/software_engineering/backend/public/storage/item/cakeaway.icon.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="components/css/styles.css" rel="stylesheet">

    <style>
        body {
            /* Top Padding: Menu=115px, Others=70px */
            padding-top: <?php echo isset($paddingTop) ? $paddingTop : '70px'; ?>;

            /* Bottom Padding: Cart=140px, Others=90px */
            padding-bottom: <?php echo isset($paddingBottom) ? $paddingBottom : '90px'; ?>;
        }
    </style>
</head>