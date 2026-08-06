# Загалльні інструкції

Пиши на українській мові, не використовуй російську.
Для пояснень - українська мова, для заголовків та термінології - англійська.

# Кодогенерація

Пиши чистий код, без зайвих коментарів.
Завжди використовуй цикли для ітеративного, дублючогося коду, схожого за сенсенсом контенту.

## WordPress, PHP, ACF

1. Для виводу даних в атрибути HTML, використовуй функцію `esc_attr()`.
2. Для виводу текстового контенту, використовуй функцію `wp_kses_post()`.
3. Додавай перевірку на наявність контенту перед його виводом. Приклад:

```php
<?php if (!empty($item['advantage_subtitle'])) : ?>
    <h3 class="advantages__subtitle"><?php echo esc_html($item['advantage_subtitle']); ?></h3>
<?php endif; ?>
```

4. Іконки замінюй на такий сніпет (на прикладі іконки `arrow-d-long`):

```php
	<span class="icon icon--size_mod" data-sprite-icon="arrow-d-long">
		<?php echo Utils::the_icon('arrow-d-long'); ?>
	</span>
```

5. Замінюй picture (тільки контентні, не декори і не фонові) на Picture-brick і додавай ACF поле типу "Clone" з прив'язкою до Bricks: Picture (group_61fa92dd8dcd3) з лаяутом групи. Приклад заміни:

```php
	<?php if ( !empty( $image_bg['desktop'] ) ) { ?>
		<?php Utils::the_picture($image_bg, ['class' => 'hero__bg', 'img_class' => 'hero__bg_img' ]); ?>
	<?php } ?>
```

Приклад зображеннь, для яких не потрібно додавати поля в ACF:

```php
<img class="leadership__card_bg" src="<?php echo get_template_directory_uri(); ?>/assets/images/gradient-bg.svg" alt=" ">
```

```php
	<picture class="contact__bg_image">
		<source media="(min-width: 768.5px)" srcset="./images/footer-bg.svg" type="image/svg+xml">
		<source media="(max-width: 767.5px)" srcset="./images/footer-bg-mobile.svg" type="image/svg+xml"><img
			class="contact__image_in" src="./images/footer-bg.svg" alt=" " loading="lazy">
	</picture>
```

6. Не додавай `default_value` чи будь-який placeholder в ACF полях, якщо це не потрібно. Якщо значення поля не обов'язкове, то `default_value` не потрібно.
7. Для великий repeater-типу полів створюй окремий таб в ACF поях. Зазвичай це таби "heading", "content".
8. Називай ACF поля для секції відповідно до назви самої секції. Наприклад для секції About - ключ поля заголовка "about_title".
9. Для форм використовуй шорткод CF7. Приклад:

```php
	<?php $form = get_field('form'); ?>
	<?php echo do_shortcode($form) ?>
```

10. Для статичних зображень чи ресурсів, які не потрібно виводити через ACF, використовуй `get_template_directory_uri()`. Приклад:

```php
	<picture class="contact__bg_image">
		<source media="(min-width: 768.5px)" srcset="<?php echo get_template_directory_uri() . '/assets/images/footer-bg.svg'; ?>" type="image/svg+xml">
		<source media="(max-width: 767.5px)" srcset="<?php echo get_template_directory_uri() . '/assets/images/footer-bg-mobile.svg'; ?>" type="image/svg+xml"><img
			class="contact__image_in" src="<?php echo get_template_directory_uri() . '/assets/images/footer-bg.svg'; ?>" alt=" " loading="lazy">
	</picture>
```

11. Для кожної секції додавай заголовок у вигляді Message поля в ACF. Наприклад для секції About ти додаєш першим полем в ACF блока поле з типом Message та default_value "About Section".

12. Виносити змінні, отримані з get_field на верх файлу.

13. Для description полів використовуй Wysiwyg редактор, а не текстовий. В ACF вибирай тип поля "Wysiwyg Editor".

14. Для заголовків роби ACF поле типу Text Area з rows 3 по замовчуванню.

15. Не вкладай scss селектори в інші селектори. Bad: .parent { &\*\*child {} }. Good: .parent {} .parent\_\_child {}. Виключення: модифікатори, теги без класів, after, before. Приклад мода: .feature\_\_subtitle { .feature--light & {...} }

16. Додавай приклади використання для створених pug міксинів, якщо вони не використовуються в самому коді.

17. Не використовуй tailwind-неймінг для змінних по типу $gray_200, а більш людські назви.

18. Margin/padding задаємо зверху-вниз для елементів. Margin- для зовн. відступу, padding - для внутр.

19. Не пиши інструкції для простих полів в ACF-json. Також пиши їх тільки на англ. мові.
