<link rel="stylesheet" href="style.css">
<?php

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
  include('credentials.php');
  $db = new PDO('mysql:host=localhost;dbname=u67447', $GLOBALS['user'], $GLOBALS['pass'],
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $stmt = $db->prepare("select id from Applications where login = ? and pass = ?");
  $stmt->execute([$_POST['login'], substr(md5($_POST['pass']),0,7)]);
  $row_count = $stmt->rowCount();
  if ($row_count <= 0) {
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
