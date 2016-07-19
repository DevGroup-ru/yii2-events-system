<?php

namespace DevGroup\EventsSystem\handlers;

use Yii;

/**
 * Class Pagination
 * @package DevGroup\EventsSystem\handlers
 */
class Pagination
{
    /**
     * @param \yii\base\ViewEvent $event
     */
    public static function updateTitle($event)
    {
        if (Yii::$app->request->get('page') !== null) {
            Yii::$app->view->title .= Yii::t(
                'app',
                ' - Page {page}',
                ['page' => (int) Yii::$app->request->get('page')]
            );
        }
    }
}