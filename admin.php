<link rel="stylesheet" href="style.css">
<script defer src="script_admin.js"></script>
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

if (isset($_GET['action']) && $_GET['action'] == 'fetch_stats') {
    header('Content-Type: application/json');
    echo json_encode(getLanguageStats());
    exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
?>

<button id="Button_Stats", class="Button_Stats">Посмотреть статистику ответов</button>
<button id="Button_Change", class="Button_Change">Редактировать пользователя</button>

<div id="Popup" class="Popup">
    <div id="Stats" class="Stats">
        
    </div>
</div>
