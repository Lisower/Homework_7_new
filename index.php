<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    
    $messages[] = 'Спасибо, результаты сохранены.';
    
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  
  $errors['FIO_empty'] = !empty($_COOKIE['FIO_empty']);
  $errors['FIO_error'] = !empty($_COOKIE['FIO_error']);
  
  $errors['phone_number_empty'] = !empty($_COOKIE['phone_number_empty']);
  $errors['phone_number_error'] = !empty($_COOKIE['phone_number_error']);
  
  $errors['e_mail_empty'] = !empty($_COOKIE['e_mail_empty']);
  $errors['e_mail_error'] = !empty($_COOKIE['e_mail_error']);
  
  $errors['birthday_empty'] = !empty($_COOKIE['birthday_empty']);
  $errors['birthday_error'] = !empty($_COOKIE['birthday_error']);
  
  $errors['sex_empty'] = !empty($_COOKIE['sex_empty']);
  $errors['sex_error'] = !empty($_COOKIE['sex_error']);
  
  $errors['favourite_languages'] = !empty($_COOKIE['favourite_languages']);

  $errors['biography_long'] = !empty($_COOKIE['biography_long']);
  $errors['biography_error'] = !empty($_COOKIE['biography_error']);
  
  $errors['check_empty'] = !empty($_COOKIE['check_empty']);

  if ($errors['FIO_empty']) {
    setcookie('FIO_empty', '', 100000);
    setcookie('FIO_value', '', 100000);
    $messages[] = '<div class="error">Заполните имя!</div>';
  }
  if ($errors['FIO_error'] && !$errors['FIO_empty']) {
    setcookie('FIO_error', '', 100000);
    setcookie('FIO_value', '', 100000);
    $messages[] = '<div class="error">Недопустимое имя! Допустимые символы: буквы английского и русского алфавитов</div>';
  }
  
  if ($errors['phone_number_empty']) {
    setcookie('phone_number_empty', '', 100000);
    setcookie('phone_number_value', '', 100000);
    $messages[] = '<div class="error">Введите номер телефона!</div>';
  }
   if ($errors['phone_number_error'] && !$errors['phone_number_empty']) {
    setcookie('phone_number_error', '', 100000);
    setcookie('phone_number_value', '', 100000);
    $messages[] = '<div class="error">Недопустимый номер телефона! Допустимые символы: цифры 0-9</div>';
  }
  
  if ($errors['e_mail_empty']) {
    setcookie('e_mail_empty', '', 100000);
    setcookie('e_mail_value', '', 100000);
    $messages[] = '<div class="error">Введите почту!</div>';
  }
  if ($errors['e_mail_error'] && !$errors['e_mail_empty']) {
    setcookie('e_mail_error', '', 100000);
    setcookie('e_mail_value', '', 100000);
    $messages[] = '<div class="error">Недопустимая почта! Формат почты: example@example.com</div>';
  }

  if ($errors['birthday_empty']) {
    setcookie('birthday_empty', '', 100000);
    setcookie('birthday_value', '', 100000);
    $messages[] = '<div class="error">Выберите день рождения!</div>';
  }
  if ($errors['birthday_error'] && !$errors['birthday_empty']) {
    setcookie('birthday_error', '', 100000);
    setcookie('birthday_value', '', 100000);
    $messages[] = '<div class="error">Недопустимый день рождения! День рождения должен быть датой!</div>';
  }

  if ($errors['sex_empty']) {
    setcookie('sex_empty', '', 100000);
    setcookie('sex_value', '', 100000);
    $messages[] = '<div class="error">Выберите пол!</div>';
  }
  if ($errors['sex_error'] && !$errors['sex_empty']) {
    setcookie('sex_error', '', 100000);
    setcookie('sex_value', '', 100000);
    $messages[] = '<div class="error">Недопустимый пол! Выберите пол: М или Ж</div>';
  }

  if ($errors['biography_long']) {
    setcookie('biography_long', '', 100000);
    setcookie('biography_value', '', 100000);
    $messages[] = '<div class="error">Биография слишком длинна! Допустимо использовать не более 500 символов!</div>';
  }
  if ($errors['biography_error'] && !$errors['biography_long']) {
    setcookie('biography_error', '', 100000);
    setcookie('biography_value', '', 100000);
    $messages[] = '<div class="error">В биографии использованы недопустимы символы! Допустимы только буквы, цифры и знаки препинания!</div>';
  }

  if ($errors['check_empty']) {
    setcookie('check_empty', '', 100000);
    setcookie('check_value', '', 100000);
    $messages[] = '<div class="error">Согласие не отмечено! Поставьте галочку!</div>';
  }

  $values = array();
  $values['FIO'] = empty($_COOKIE['FIO_value']) ? '' : $_COOKIE['FIO_value'];
  $values['phone_number'] = empty($_COOKIE['phone_number_value']) ? '' : $_COOKIE['phone_number_value'];
  $values['e_mail'] = empty($_COOKIE['e_mail_value']) ? '' : $_COOKIE['e_mail_value'];
  $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : $_COOKIE['birthday_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];

  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
      include('credentials.php');
      $db = new PDO('mysql:host=localhost;dbname=u67447', $GLOBALS['user'], $GLOBALS['pass'],
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      
      try {
        $stmt = $db->prepare("select FIO, phone_number, e_mail, birthday, sex, biography where login = ? and pass = ?");
          $stmt->execute([$_SESSION['login'], $_SESSION['pass']]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $values['FIO'] = $result['FIO'];
          $values['phone_number'] = $result['phone_number'];
          $values['e_mail'] = $result['e_mail'];
          $values['birthday'] = $result['birthday'];
          $values['sex'] = $result['sex'];
          $values['biography'] = $result['biography'];
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
    
      $values['FIO'] = empty($_COOKIE['FIO_value']) ? '' : $_COOKIE['FIO_value'];
      $values['phone_number'] = empty($_COOKIE['phone_number_value']) ? '' : $_COOKIE['phone_number_value'];
      $values['e_mail'] = empty($_COOKIE['e_mail_value']) ? '' : $_COOKIE['e_mail_value'];
      $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : $_COOKIE['birthday_value'];
      $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
      $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
      $values['check'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];
    
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }
  
  include('form.php');
}

else {
  
  $errors = FALSE;
  
  if (empty($_POST['FIO'])) {
    setcookie('FIO_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!preg_match('/^[a-zA-ZйцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ]+$/', $_POST['FIO'])) {
    setcookie('FIO_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  
  if (empty($_POST['phone_number'])) {
    setcookie('phone_number_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!is_numeric($_POST['phone_number']) || !preg_match('/^\d+$/', $_POST['phone_number'])) {
    setcookie('phone_number_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  if (empty($_POST['e_mail'])) {
    setcookie('e_mail_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/', $_POST['e_mail'])) {
    setcookie('e_mail_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  if (empty($_POST['birthday'])) {
    setcookie('birthday_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (strtotime($_POST['birthday']) === false) {
    setcookie('birthday_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  if (empty($_POST['sex'])) {
    setcookie('sex_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!preg_match('/^[МЖ]+$/', $_POST['sex'])) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  if (strlen($_POST['biography']) > 500) {
    setcookie('biography_long', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (!preg_match('/^[a-zA-ZйцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ0-9.,?! ]+$/', $_POST['biography']) && !empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }

  if (empty($_POST['check'])) {
    setcookie('check_empty', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  
  setcookie('FIO_value', $_POST['FIO'], time() + 30 * 24 * 60 * 60);
  setcookie('phone_number_value', $_POST['phone_number'], time() + 30 * 24 * 60 * 60);
  setcookie('e_mail_value', $_POST['e_mail'], time() + 30 * 24 * 60 * 60);
  setcookie('birthday_value', $_POST['birthday'], time() + 30 * 24 * 60 * 60);
  setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
  setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {

    setcookie('FIO_empty', '', 100000);
    setcookie('FIO_error', '', 100000);
    
    setcookie('phone_number_empty', '', 100000);
    setcookie('phone_number_error', '', 100000);

    setcookie('e_mail_empty', '', 100000);
    setcookie('e_mail_error', '', 100000);

    setcookie('birthday_empty', '', 100000);
    setcookie('birthday_error', '', 100000);

    setcookie('sex_empty', '', 100000);
    setcookie('sex_error', '', 100000);

    setcookie('biography_long', '', 100000);
    setcookie('biography_error', '', 100000);

    setcookie('check_empty', '', 100000);

  }

  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    include('credentials.php');
    $db = new PDO('mysql:host=localhost;dbname=u67447', $GLOBALS['user'], $GLOBALS['pass'],
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    try {
      $stmt = $db->prepare(
        "update Applications SET FIO = ?, phone_number = ?, e_mail = ?, birthday = ?, sex = ?, biography = ? where login = ? and pass = ?");
      $stmt->execute([$_POST['FIO'],$_POST['phone_number'],$_POST['e_mail'],$_POST['birthday'],$_POST['sex'],$_POST['biography'],
                     $_SESSION['login'], $_SESSION['pass']]);
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  else {
    
    $login = substr(md5($_COOKIE[session_name()].uniqid().rand()),0,7);
    $password = substr(md5(uniqid().rand().$_COOKIE[session_name()].rand().$login),0,7);
    
    setcookie('login', $login);
    setcookie('pass', $password);

    include('credentials.php');
    $db = new PDO('mysql:host=localhost;dbname=u67447', $GLOBALS['user'], $GLOBALS['pass'],
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    try {
      $stmt = $db->prepare(
        "INSERT INTO Applications SET FIO = ?, phone_number = ?, e_mail = ?, birthday = ?, sex = ?, biography = ?, login = ?, pass = ?");
      $stmt->execute([$_POST['FIO'],$_POST['phone_number'],$_POST['e_mail'],$_POST['birthday'],$_POST['sex'],$_POST['biography'],
                     $login, substr(md5($password),0,7)]);
      $application_id = $db->lastInsertId();
      $stmt = $db->prepare("INSERT INTO Application_languages (application_id, language_id) VALUES (?, ?)");
      foreach ($_POST['favourite_languages'] as $language_id) {
          $stmt->execute([$application_id, $language_id]); 
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }

  setcookie('save', '1');

  header('Location: ./');
}
