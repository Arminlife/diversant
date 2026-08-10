#!/usr/bin/env bash
# Дзеркалить білд Bun-проєкту у тему: slidstvo/build/ → тема/diversanty/
# Використання:  bash parts/diversanty/sync-assets.sh /абсолютний/шлях/до/slidstvo
set -euo pipefail

SRC="${1:-}"
if [[ -z "$SRC" ]]; then
	echo "Вкажіть шлях до Bun-проєкту slidstvo, напр.:"
	echo "  bash parts/diversanty/sync-assets.sh ~/Documents/slidstvo"
	exit 1
fi

BUILD="$SRC/build"
if [[ ! -d "$BUILD" ]]; then
	echo "Не знайдено $BUILD — спершу зроби 'bun run build' у проєкті."
	exit 1
fi

# Тека теми = два рівні вгору від цього скрипта (parts/diversanty → тема)
THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
DEST="$THEME_DIR/diversanty"

mkdir -p "$DEST"
rsync -a --delete \
	--exclude '*.html' \
	"$BUILD/" "$DEST/"

echo "OK: $BUILD → $DEST"
echo "Оновлено: css/app.css, js/app.js, fonts/, images/, static/"
