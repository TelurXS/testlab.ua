<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= Config\TITLE ?></title>
        <link rel="stylesheet" href="/Resources/Css/styles.css">
    </head>
    <body>
        <div class="wrapper">
            <?php require_once Config\HEADER?>
            <?php require_once Config\NAVIGATION?>

            <main>
                <?php require_once $page ?>
            </main>
            
            <?php require_once Config\FOOTER?>
        </div>
    </body>
</html>