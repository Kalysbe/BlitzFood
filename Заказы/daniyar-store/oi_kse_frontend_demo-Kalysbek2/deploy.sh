#!/usr/bin/env sh

# остановить публикацию при ошибках
set -e

# сборка
npm run build

# переход в каталог сборки
cd dist

#копирование
# rsync -arv -O --delete ./ gettigrinnn@192.168.0.38:/var/www/staging.kse.kg/

#возврат
cd -

