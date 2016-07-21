<?php

namespace DevGroup\EventsSystem\helpers;

use DevGroup\EventsSystem\models\Event;
use DevGroup\EventsSystem\models\EventEventHandler;
use DevGroup\EventsSystem\models\EventGroup;
use DevGroup\EventsSystem\models\EventHandler;
use DevGroup\TagDependencyHelper\NamingHelper;
use Yii;
use yii\caching\TagDependency;

/**
 * Class EventHelper
 * @package DevGroup\EventsSystem\helpers
 */
class EventHelper
{
    /**
     * Gat all active handlers.
     * @return array of handlers
     */
    public static function getActiveHandlersList()
    {
        $cacheKey = 'DevGroup/EventsSystem:activeHandlersList';
        $handlers = Yii::$app->cache->get($cacheKey);
        if ($handlers === false) {
            $eventEventHandlers = EventEventHandler::find()
                ->where(['is_active' => 1])
                ->orderBy(['sort_order' => SORT_ASC])
                ->all();
            $events = Event::find()
                ->where(['id' => array_column($eventEventHandlers, 'event_id', 'event_id')])
                ->indexBy('id')
                ->asArray(true)
                ->all();
            $eventGroups = EventGroup::find()
                ->where(['id' => array_column($events, 'event_group_id', 'event_group_id')])
                ->indexBy('id')
                ->asArray(true)
                ->all();
            $eventHandlers = EventHandler::find()
                ->where(['id' => array_column($eventEventHandlers, 'event_handler_id', 'event_handler_id')])
                ->indexBy('id')
                ->asArray(true)
                ->all();
            $handlers = [];
            foreach ($eventEventHandlers as $eventEventHandler) {
                if (isset(
                        $eventHandlers[$eventEventHandler->event_handler_id],
                        $events[$eventEventHandler->event_id],
                        $eventGroups[$events[$eventEventHandler->event_id]['event_group_id']]
                    ) === false
                ) {
                    continue;
                }
                $handlers[] = [
                    'class' => $eventGroups[$events[$eventEventHandler->event_id]['event_group_id']]['owner_class_name'],
                    'name' => $events[$eventEventHandler->event_id]['execution_point'],
                    'callable' => [
                        $eventHandlers[$eventEventHandler->event_handler_id]['class_name'],
                        $eventEventHandler->method,
                    ],
                    'data' => $eventEventHandler->params,
                ];
            }
            Yii::$app->cache->set(
                $cacheKey,
                $handlers,
                86400,
                new TagDependency(
                    [
                        'tags' => [
                            NamingHelper::getCommonTag(EventGroup::className()),
                            NamingHelper::getCommonTag(Event::className()),
                            NamingHelper::getCommonTag(EventHandler::className()),
                            NamingHelper::getCommonTag(EventEventHandler::className()),
                        ],
                    ]
                )
            );
        }
        return $handlers;
    }

    /**
     * Translates a message to the specified language.
     *
     * This is a shortcut method of [[\yii\i18n\I18N::translate()]].
     *
     * The translation will be conducted according to the message category and the target language will be used.
     *
     * You can add parameters to a translation message that will be substituted with the corresponding value after
     * translation. The format for this is to use curly brackets around the parameter name as you can see in the following example:
     *
     * ```php
     * $username = 'Alexander';
     * echo \Yii::t('app', 'Hello, {username}!', ['username' => $username]);
     * ```
     *
     * Further formatting of message parameters is supported using the [PHP intl extensions](http://www.php.net/manual/en/intro.intl.php)
     * message formatter. See [[\yii\i18n\I18N::translate()]] for more details.
     *
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current
     * [[\yii\base\Application::language|application language]] will be used.
     * @return string the translated message.
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('events-system', $message, $params, $language);
    }
}
