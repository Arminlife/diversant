# Диверсанти — WPBakery-віджети

Набір WPBakery-елементів для спецпроєкту «Диверсанти». Кожен елемент віддає **ту саму BEM-розмітку**, що й pug-верстка в Bun-проєкті (`slidstvo/src/pug/blocks/diversanty-*`). **Стилів у PHP немає** — усе тягнеться з білда (`app.css` / `app.js`), тож правки SCSS/JS підхоплюються ре-синком ассетів, PHP чіпати не треба.

## Файли
- `inc/wpbakery-diversanty.php` — реєстрація елементів (`vc_map`), шорткоди, enqueue ассетів, body-class, інтро.
- `parts/diversanty/*.php` — шаблони розмітки блоків: `head`, `lead`, `comics`, `game`, `figures`, `mosaic`, `intro`.

## Елементи (категорія «Диверсанти» в редакторі)
| Елемент | base | Параметри | Дані у проді |
|---|---|---|---|
| Шапка + кредити | `diversanty_head` | Заголовок, Кредити (WYSIWYG) | single-header / ACF |
| Лід (текст + телефон) | `diversanty_lead` | Заголовок, Текст, Скрін чату | ACF |
| Комікс-слайдер | `diversanty_comics` | Назва, Підпис, Кадри (галерея) | медіатека |
| Гра | `diversanty_game` | Заголовок, URL JSON | `static/diversanty-game.json` / CPT |
| Фігурки | `diversanty_figures` | Текст, К-сть (демо) | CPT (вироки) |
| Мозаїка матеріалів | `diversanty_mosaic` | Заголовок, Матеріали (пошук) | пости/спецпроєкти |

Без заповнених даних блоки рендеряться з **демо-фолбеками** (для фази верстки).

## Інтеграція (разово)
1. **Підключити** у `functions.php`:
   ```php
   require_once( 'inc/wpbakery-diversanty.php' );
   ```
2. **Залити ассети** білда в тему (дзеркало `build/` → `diversanty/`):
   ```bash
   bash parts/diversanty/sync-assets.sh /абсолютний/шлях/до/slidstvo
   # або вручну:
   rsync -a /шлях/slidstvo/build/ wp-content/themes/<тема>/diversanty/
   ```
   Повторювати **після кожного** `bun run build` — enqueue має `filemtime`-cache-busting, тож нова версія підхопиться сама.
3. **Пост спецпроєкту** (CPT `special-projects`):
   - ACF-прапорець **`is_map_project` = так** → блоки виводяться на всю ширину (це вже реалізовано в `single-special-projects.php` для `custom_wpbakery_blocks`);
   - додати блоки диверсантів через WPBakery у потрібному порядку.
4. **Інтро перед хедером** (fullpage) — через стандартний хук `wp_body_open`.
   Якщо `header.php` ще не викликає його, додати **один рядок** одразу після `<body ...>`:
   ```php
   <?php wp_body_open(); ?>
   ```
   (стандарт WP 5.2+, розмітку хедера не змінює). Вимкнути інтро на пості можна ACF-прапорцем `diversanty_no_intro`.

## «Я ще правлю стилі» — робочий цикл
Стилі та JS лишаються в Bun-проєкті як **джерело правди**. Щоб оновити на WP:
```
1) правиш SCSS/JS у slidstvo/src
2) bun run build
3) bash parts/diversanty/sync-assets.sh /шлях/до/slidstvo   ← дзеркалить build → тема/diversanty
4) refresh сторінки (кеш ламається через filemtime)
```
Розмітку блоків (класи/data-атрибути) міняти не треба — вона стабільна.

## Відомі точки для доопрацювання (у проді)
- **Гра**: `components/diversanty-game.js` наразі фетчить `./static/diversanty-game.json`. У шаблоні вже є `data-game-src` + `window.diversantyData.gameSrc` — варто навчити компонент читати цей шлях (1 рядок), щоб JSON брався з теми.
- **Фігурки/Гра/Мозаїка**: реальні дані підключаються з CPT замість демо-фолбеків.
- **Картинки лід/чат**: у проді — з медіатеки (параметр `attach_image`), демо — з дзеркала білда.
