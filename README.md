Events system for Yii2
======================

It is a Yii2 extension for events managing via admin panel.

[![Build Status](https://travis-ci.org/DevGroup-ru/yii2-events-system.svg?branch=master)](https://travis-ci.org/DevGroup-ru/yii2-events-system)
[![codecov](https://codecov.io/gh/DevGroup-ru/yii2-events-system/branch/master/graph/badge.svg)](https://codecov.io/gh/DevGroup-ru/yii2-events-system)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist devgroup/yii2-events-system "*"
```

or add

```
"devgroup/yii2-events-system": "*"
```

to the require section of your `composer.json` file.


Setting
-------

For events managing via control panel You must set the `DevGroup\EventsSystem\Module` module at your `config/web.php` configuration file.

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

After it any authorized user can manage events at the `http://example.com/event/manage/index` route. You can change access rules for this controller. Just update the `manageControllerBehaviors` property at `DevGroup\EventsSystem\Module` module.


Extra
-----

- Database structure
- Usage examples
