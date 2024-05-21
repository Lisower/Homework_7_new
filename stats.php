<link rel="stylesheet" href="style.css">
<?php
require 'db.php';
$adminData = db_select('Admin', 'login, password');

if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $adminData[0]['login'] ||
    substr(md5($_SERVER['PHP_AUTH_PW']), 0, 20) != $adminData[0]['password']) {
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

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
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['count']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
