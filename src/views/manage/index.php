<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var DevGroup\EventsSystem\models\EventEventHandler $model
 * @var yii\web\View $this
 */

$this->title = Yii::t('app', 'Event handlers');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-event-handler-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'event_id',
                        'filter' => \DevGroup\EventsSystem\models\Event::dropDownList(),
                        'value' => function ($model, $key, $index, $column) {
                            return $model->eventName;
                        }
                    ],
                    [
                        'attribute' => 'event_handler_id',
                        'filter' => \DevGroup\EventsSystem\models\EventHandler::dropDownList(),
                        'value' => function ($model, $key, $index, $column) {
                            return $model->eventHandlerName;
                        }
                    ],
                    'method',
                    [
                        'attribute' => 'is_active',
                        'filter' => [0 => Yii::t('app', 'No'), 1 => Yii::t('app', 'Yes')],
                    ],
                    [
                        'attribute' => 'is_system',
                        'filter' => [0 => Yii::t('app', 'No'), 1 => Yii::t('app', 'Yes')],
                    ],
                    [
                        'attribute' => 'sort_order',
                        'filter' => false,
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                    ],
                ],
                'filterModel' => $model,
            ]
        )
        ?>
    <?php Pjax::end(); ?>
</div>
