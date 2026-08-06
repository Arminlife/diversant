<?php extract($args); ?>

<div id="partner-form" class="modalDialog">
    <div class="inner">
        <a href="#close" class="close"></a>
        <form action="<?= esc_url($_SERVER['REQUEST_URI']) ?>#partner-form" method="POST">
            <h4>Станьте нашим партнером</h4>
            <label for="p-name" class="required">Ім'я</label>
            <input type="text" name="user_name" value="<?= sanitize_text_field($_POST['user_name']) ?>" id="p-name" placeholder="Ваше ім'я" class="frm-control">
            <label for="p-lastname" class="required">Прізвище</label>
            <input id="p-lastname" name="user_surname" value="<?= sanitize_text_field($_POST['user_surname']) ?>" type="text" placeholder="Ваше прізвище" class="frm-control">
            <label for="p-mail" class="required">Електронна пошта</label>
            <input id="p-mail" name="email" value="<?= sanitize_text_field($_POST['email']) ?>" type="email" placeholder="Ваш email" class="frm-control">
            <label for="p-phone">Телефон</label>
            <input type="tel" name="number" value="<?= sanitize_text_field($_POST['number']) ?>" placeholder="Ваш контактний телефон" class="frm-control">
            <label for="offer">Пропозиція</label>
            <textarea id="offer" name="offer" placeholder="Напишіть Вашу пропозицію" class="frm-control"><?= sanitize_text_field($_POST['offer']) ?></textarea>
            <label for="p-code" class="required">
                Я людина
            </label>
            <div class="row no-gutters">
                <div class="col-sm-3 mb-2">
                    <img alt="Перевірочний код" src="<?= $image_url ?>"/>
                </div>
                <div class="col-sm">
                    <input id="p-code" name="code" type="text" placeholder="Введіть код з картинки" class="frm-control">
                    <?php if ($captcha_error): ?>
                        <div class="error">
                            Помилка. Невірний код перевірки.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <input type="hidden" name="prefix" value="<?= $captcha_prefix ?>">
            <input type="submit" value="Стати партнером">
        </form>
    </div>
</div>
<div id="partner-form-success" class="modalDialog">
    <div class="inner">
        <a href="#close" class="close"></a>
        <h4>Станьте нашим партнером</h4>
        <p>Партнерська пропозиція відправлена!</p>
        </form>
    </div>
</div>
