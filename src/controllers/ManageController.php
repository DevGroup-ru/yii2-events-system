<?php

namespace DevGroup\EventsSystem\controllers;

use DevGroup\EventsSystem\models\EventEventHandler;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ManageController implements the CRUD actions for EventEventHandler model.
 */
class ManageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return $this->module->manageControllerBehaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'update' => [
                'class' => 'DevGroup\EventsSystem\actions\UpdateAction',
            ],
            'index' => [
                'class' => 'DevGroup\EventsSystem\actions\ListAction',
            ],
            'delete' => [
                'class' => 'DevGroup\EventsSystem\actions\DeleteAction',
            ],
        ];
    }

    /**
     * Finds the EventEventHandler model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventEventHandler the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = EventEventHandler::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
