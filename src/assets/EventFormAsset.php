<?php

namespace DevGroup\EventsSystem\assets;

use yii\web\AssetBundle;

/**
 * Class EventFormAsset
 * @package DevGroup\EventsSystem\assets
 */
class EventFormAsset extends AssetBundle
{
    /** @inheritdoc */
    public $sourcePath = '@DevGroup/EventsSystem/assets/eventForm';

    /** @inheritdoc */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /** @inheritdoc */
    public $js = [
        'scripts.js',
    ];

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        // @todo Cache it
        $events = \DevGroup\EventsSystem\models\Event::find()->select(['id', 'name', 'event_class_name'])->indexBy('id')->asArray(true)->all();
        $js = 'eventsList = ' . \yii\helpers\Json::encode($events) . ";\n";
        $eventHandlers = \DevGroup\EventsSystem\models\EventHandler::find()->asArray()->all();
        $handlersList = [];
        foreach ($eventHandlers as $eventHandler) {
            $rClass = new \ReflectionClass($eventHandler['class_name']);
            foreach ($rClass->getMethods() as $rMethod) {
                $rParameters = $rMethod->getParameters();
                if (isset($rParameters[0]) && $rParameters[0]->getClass() !== null) {
                    $handlersList[] = [
                        'id' => $eventHandler['id'],
                        'name' => $eventHandler['name'],
                        'methodName' => $rMethod->getName(),
                        'eventClassName' => $rParameters[0]->getClass()->getName(),
                    ];
                }
            }
        }
        $js .= 'handlersList = ' . \yii\helpers\Json::encode($handlersList) . ';';
        $view->registerJs($js, \yii\web\View::POS_BEGIN);
        parent::register($view);
    }
}
