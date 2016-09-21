<?php

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var integer $eventGroupId
 * @var boolean $hasAccess
 * @var DevGroup\EventsSystem\models\EventEventHandler $model
 * @var yii\web\View $this
 */

\DevGroup\EventsSystem\assets\EventFormAsset::register($this);
if (!$model->isNewRecord) {
    $js = <<<JS
jQuery('#eventeventhandler-event_handler_id').find('option').each(function () {
    if (jQuery(this).attr('value') == '{$model->event_handler_id}') {
        jQuery(this).prop('selected', 'selected');
        jQuery('#eventeventhandler-event_handler_id').change();
    }
});
jQuery('#eventeventhandler-method').find('option').each(function () {
    if (jQuery(this).attr('value') == '{$model->method}') {
        jQuery(this).prop('selected', 'selected');
    }
});
JS;
    $this->registerJs($js);
}
$this->title = EventHelper::t($model->isNewRecord ? 'Create' : 'Update');
$this->params['breadcrumbs'][] = ['label' => EventHelper::t('Event handlers'), 'url' => ['index', 'eventGroupId' => $eventGroupId]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <?= $form->field($model, 'event_id')->dropDownList(\DevGroup\EventsSystem\models\Event::dropDownListForGroup($eventGroupId)) ?>
                <?= $form->field($model, 'event_handler_id')->dropDownList([]) ?>
                <?= $form->field($model, 'method')->dropDownList([]) ?>
                <?= $form->field($model, 'is_active')->checkbox() ?>
                <?= $form->field($model, 'sort_order')->textInput() ?>
            </div>
            <div class="col-xs-12 col-md-6">
                <?= $form->field($model, 'packed_json_params')->widget('devgroup\jsoneditor\Jsoneditor') ?>
                <?= Html::textarea('phpDoc', null, ['id' => 'php-doc', 'class' => 'form-control', 'rows' => 5]) ?>
            </div>
        </div>
    </div>
    <?php if ($hasAccess) : ?>
    <div class="box-footer">
        <div class="form-group pull-right">
            <?= Html::submitButton($this->title, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php ActiveForm::end(); ?>
