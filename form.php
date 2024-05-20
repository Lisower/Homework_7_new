<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <title>ФОРМА</title>
  </head>
  
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>

    <button id="Button">Открыть форму</button>

        <div id="Popup" class="Popup">
            <button id="Exit_Form" class="Exit_Form">X</button>
            <form id="Form" action="" method="POST">
                <h1>Форма</h1>

                <label>
                    ФИО<br>
                    <input name="FIO"
                    placeholder="Введите Ваше ФИО"
                    <?php if ($errors['FIO_empty'] || $errors['FIO_error']) {print 'class="error"';} ?> value="<?php print $values['FIO']; ?>"
                    >
                </label><br>

                <label>
                Номер телефона<br>
                <input name="phone_number"
                    type="tel"
                    placeholder="Введите Ваш номер телефона"
                    <?php if ($errors['phone_number_empty'] || $errors['phone_number_error']) {print 'class="error"';} ?> value="<?php print $values['phone_number']; ?>"
                    >
                </label><br>

                <label>
                Почта e-mail<br>
                <input name="e_mail"
                    type="email"
                    placeholder="Введите Вашу почту"
                    <?php if ($errors['e_mail_empty'] || $errors['e_mail_error']) {print 'class="error"';} ?> value="<?php print $values['e_mail']; ?>"
                    >
                </label><br>

                <label>
                    Дата рождения<br>
                    <input name="birthday"
                    type="date"
                    <?php if ($errors['birthday_empty'] || $errors['birthday_error']) {print 'class="error"';} ?> value="<?php print $values['birthday']; ?>"
                    >
                </label><br>
                
                Пол<br>
                <label <?php if ($errors['sex_empty'] || $errors['sex_error']) {print 'class="error"';} ?>>
                  <input type="radio" name="sex" value="М" <?php if ($values['sex'] === "М") {print 'checked="checked"';} ?>>
                М</label>
                <label <?php if ($errors['sex_empty'] || $errors['sex_error']) {print 'class="error"';} ?>>
                  <input type="radio" name="sex" value="Ж" <?php if ($values['sex'] === "Ж") {print 'checked="checked"';} ?>>
                Ж</label><br>

                <label>
                    Любимый язык программирования<br>
                    <select name="favourite_languages[]"
                        multiple="multiple">
                        <option value="1">Pascal</option>
                        <option value="2">C</option>
                        <option value="3">C++</option>
                        <option value="4">JavaScript</option>
                        <option value="5">PHP</option>
                        <option value="6">Python</option>
                        <option value="7">Java</option>
                        <option value="8">Haskel</option>
                        <option value="9">Clojure</option>
                        <option value="10">Prolog</option>
                        <option value="11">Scala</option>
                    </select>
                </label><br>

                <label>
                    Биография<br>
                    <textarea name="biography" placeholder="Напишите Вашу биографию" <?php if ($errors['biography_long'] || $errors['biography_error']) {print 'class="error"';} ?> value="<?php print $values['biography']; ?>"></textarea>
                </label><br>

                <label <?php if ($errors['check_empty']) {print 'class="error"';} ?>>
                  <input type="checkbox" name="check" <?php if ($values['check'] === "on") {print 'checked="checked"';} ?>>
                    С контрактом ознакомлен
                </label><br>

                <input type="submit" value="Сохранить">
            </form>
        </div>
  </body>
</html>
