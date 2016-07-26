<?php

namespace DevGroup\EventsSystem\handlers;

use Yii;
use yii\web\Application;

/**
 * Class Pagination
 * @package DevGroup\EventsSystem\handlers
 */
class Pagination
{
    /**
     * @param \yii\base\ViewEvent $event
     */
    public static function updateTitle(\yii\base\ViewEvent $event)
    {
        if (Yii::$app instanceof Application === true && Yii::$app->request->get('page') !== null) {
            Yii::$app->view->title .= Yii::t(
                'app',
                ' - Page {page}',
                ['page' => (int) Yii::$app->request->get('page')]
            );
        }
    }
}
