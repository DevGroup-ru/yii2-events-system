<?php

namespace DevGroup\EventsSystem\actions;

use DevGroup\EventsSystem\models\EventEventHandler;
use yii\base\Action;

/**
 * Class UpdateAction
 * @property \DevGroup\EventsSystem\controllers\ManageController $controller
 * @package DevGroup\EventsSystem\actions
 */
class UpdateAction extends Action
{
    /**
     * Updates an existing EventEventHandler model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function run($id = null)
    {
        if ($id === null) {
            $model = new EventEventHandler;
            $model->loadDefaultValues();
        } else {
            $model = $this->controller->findModel($id);
        }
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->controller->render(
                'update',
                [
                    'model' => $model,
                ]
            );
        }
    }
}
