<link rel="stylesheet" href="style.css">
<?php
require 'db.php';
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    header('Location: ./');
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="" method="post">
  <input name="login" />
  <input name="pass" />
  <input type="submit" value="Войти" />
</form>

<?php
}

else {
  $result = db_select('Applications', 'id', 'login = ? and pass = ?', [$_POST['login'], substr(md5($_POST['pass']), 0, 7)]);
  if (empty($result)) {
      print('Пользователя с такими логином и паролем нет в базе данных!');
      exit();
  }
  
  if (!$session_started) {
    session_start();
  }

  $_SESSION['login'] = $_POST['login'];
  $_SESSION['pass'] = substr(md5($_POST['pass']),0,7);
  $_SESSION['uid'] = uniqid();

  header('Location: ./');
}
