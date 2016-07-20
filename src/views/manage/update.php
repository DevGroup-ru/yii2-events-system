<?php

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var DevGroup\EventsSystem\models\EventEventHandler $model
 * @var yii\web\View $this
 */

$this->title = EventHelper::t($model->isNewRecord ? 'Create' : 'Update');
$this->params['breadcrumbs'][] = ['label' => EventHelper::t('Event handlers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-event-handler-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="event-event-handler-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'event_id')->dropDownList(\DevGroup\EventsSystem\models\Event::dropDownList()) ?>
        <?= $form->field($model, 'event_handler_id')->dropDownList(\DevGroup\EventsSystem\models\EventHandler::dropDownList()) ?>
        <?= $form->field($model, 'method')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <?= $form->field($model, 'sort_order')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton($this->title, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
