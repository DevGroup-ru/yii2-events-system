<?php

namespace DevGroup\EventsSystem\actions;

use DevGroup\EventsSystem\models\EventEventHandler;
use yii\base\Action;

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
    public function run()
    {
        $model = new EventEventHandler(['scenario' => 'search']);
        return $this->controller->render(
            'index',
            [
                'dataProvider' => $model->search(\Yii::$app->request->get()),
                'model' => $model,
            ]
        );
    }
}
