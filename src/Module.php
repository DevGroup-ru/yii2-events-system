<?php

namespace DevGroup\EventsSystem;

/**
 * Class Module
 * @package DevGroup\EventsSystem
 */
class Module extends \yii\base\Module
{
    /**
     * Behaviors list. You can change it in your application configuration file.
     * @var array of behavior definitions
     */
    public $manageControllerBehaviors = [
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
    ];
}
