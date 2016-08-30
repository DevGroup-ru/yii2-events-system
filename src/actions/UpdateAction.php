<?php

namespace DevGroup\EventsSystem\actions;

use DevGroup\EventsSystem\models\EventEventHandler;
use yii\base\Action;
use yii\web\ForbiddenHttpException;

/**
 * Class UpdateAction
 * @property \DevGroup\EventsSystem\controllers\HandlersManageController $controller
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
        $isLoaded = $model->load(\Yii::$app->request->post());
        $hasAccess = ($model->isNewRecord && \Yii::$app->user->can('events-system-create-handler'))
            || (!$model->isNewRecord && \Yii::$app->user->can('events-system-edit-handler'));
        if ($isLoaded && !$hasAccess) {
            throw new ForbiddenHttpException;
        }
        if ($isLoaded && $model->save()) {
            return $this->controller->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->controller->render(
                'update',
                [
                    'hasAccess' => $hasAccess,
                    'model' => $model,
                ]
            );
        }
    }
}
