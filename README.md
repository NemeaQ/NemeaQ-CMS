# NemeaQ-CMS
Ядро системы управления контентом для NemeaQ проектов.

---

### Простой пример подключения Apache

.htaccess:

    RewriteEngine On
    RewriteBase "/"
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L,QSA]

index.php:

    <?php
    const _USE_NQ_CMS = TRUE;
    require 'engine/main.php';
---
Минимальная структура файлов и каталогов необходимая для корректной работы:

    ROOT
    |- engine/
    |- content/
    |  |- controllers/
    |  |- models/
    |  |- views/
    |  |- config.php
    |- index.php



https://hanriel.ru/

Copyright (c) 2021 NemeaQ