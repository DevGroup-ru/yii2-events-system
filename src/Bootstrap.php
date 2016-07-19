<?php

namespace DevGroup\EventsSystem;

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\base\Event;

/**
 * Class Bootstrap
 * @package DevGroup\EventsSystem
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\base\Application $app the application currently running
     */
    public function bootstrap($app)
    {
        \Yii::$app->i18n->translations['events-system'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@DevGroup/EventsSystem/messages',
        ];
        foreach (EventHelper::getActiveHandlersList() as $handler) {
            Event::on($handler['class'], $handler['name'], $handler['callable'], $handler['data']);
        }
    }
}
