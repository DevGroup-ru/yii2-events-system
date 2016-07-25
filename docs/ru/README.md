Система событий для Yii2
========================

Это расширение для управления событиями приложения на Yii framework 2 через административный раздел. Оно поддерживает группировку событий по классам, добавление произвольных событий, их обработчиков и удобное управление ими без необходимости правок кода.


Установка
---------

Предпочтительный путь установки осуществляется через [composer](http://getcomposer.org/download/).

Выполните

```
php composer.phar require --prefer-dist devgroup/yii2-events-system "*"
```

или добавьте

```
"devgroup/yii2-events-system": "*"
```

в секцию require вашего файла `composer.json`.

После этого необходимо применить миграции. Просто выполните `./yii migrate --migrationPath=@DevGroup/EventsSystem/migrations` в директории вашего приложения.


Настройка
---------

Для управления событиями через административный раздел необходимо указать в конфигурационном файле `config/web.php` модуль `DevGroup\EventsSystem\Module`.

```php
    // ...
    'modules' => [
        // ...
        'event' => [
            'class' => 'DevGroup\EventsSystem\Module',
            'manageControllerBehaviors' => [
                'access' => [
                    'class' => 'yii\filters\AccessControl',
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' =>[
                    'class' => 'yii\filters\VerbFilter',
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ]
            ],
        ],
        // ...
    ],
    // ...
```

После этого для всех авторизованных пользователей будет доступен роут `http://example.com/event/manage/index` для управления событиями. Сменить права доступа к экшену можно через свойство `manageControllerBehaviors` модуля `DevGroup\EventsSystem\Module`.


Дополнительно
-------------

- [Структура БД](structure.md)
- [Создание своих групп, событий и обработчиков](custom-events-example.md)
