<link rel="stylesheet" href="style.css">
<?php
require 'db.php';
$statsData = getLanguageStats(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика ответов</title>
</head>
<body>
    <h1>Статистика ответов</h1>
    <table>
        <tr>
            <th>Язык программирования</th>
            <th>Количество использований</th>
        </tr>
        <?php foreach ($statsData as $row): ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->count; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
