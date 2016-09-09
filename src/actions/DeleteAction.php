<?php

namespace DevGroup\EventsSystem\actions;

use yii\base\Action;

/**
 * Class DeleteAction
 * @property \DevGroup\EventsSystem\controllers\HandlersManageController $controller
 * @package DevGroup\EventsSystem\actions
 */
class DeleteAction extends Action
{
    /**
     * Deletes an existing EventEventHandler model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function run($id)
    {
        $model = $this->controller->findModel($id);
        if ($model->is_system) {
            \Yii::$app->session->setFlash('warning', \Yii::t('app', 'You cannot update or delete system handlers'));
        } else {
            $model->delete();
        }
        return $this->controller->redirect(['index']);
    }
}
