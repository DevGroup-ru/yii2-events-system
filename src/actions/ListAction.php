<?php

namespace DevGroup\EventsSystem\actions;

use DevGroup\EventsSystem\models\Event;
use DevGroup\EventsSystem\models\EventEventHandler;
use DevGroup\EventsSystem\models\EventGroup;
use DevGroup\EventsSystem\models\EventHandler;
use yii\base\Action;
use yii\base\Exception;

/**
 * Class ListAction
 * @property \DevGroup\EventsSystem\controllers\ManageController $controller
 * @package DevGroup\EventsSystem\actions
 */
class ListAction extends Action
{
    /**
     * Lists all EventEventHandler models.
     * @return mixed
     */
    public function run($eventGroupId = null)
    {
        $eventGroups = EventGroup::find()->asArray(true)->all();
        if (count($eventGroups) === 0) {
            throw new Exception('Event groups not found');
        }
        if ($eventGroupId === null) {
            $first = reset($eventGroups);
            $eventGroupId = $first['id'];
        }
        $tabs = [];
        foreach ($eventGroups as $eventGroup) {
            $tabs[] = [
                'label' => $eventGroup['name'],
                'url' => ['index', 'eventGroupId' => $eventGroup['id']],
                'active' => $eventGroupId == $eventGroup['id'],
            ];
        }
        $model = new EventEventHandler(['scenario' => 'search']);
        $eventsList = Event::find()
            ->select(['name', 'id'])
            ->where(['event_group_id' => $eventGroupId])
            ->indexBy('id')
            ->column();
        return $this->controller->render(
            'index',
            [
                'dataProvider' => $model->search(\Yii::$app->request->get(), array_keys($eventsList)),
                'eventGroupId' => $eventGroupId,
                'eventsList' => $eventsList,
                'model' => $model,
                'tabs' => $tabs,
            ]
        );
    }
}
