<?php

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $eventsList
 * @var DevGroup\EventsSystem\models\EventEventHandler $model
 * @var array $tabs
 * @var yii\web\View $this
 */

$this->title = EventHelper::t('Event handlers');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box">
    <div class="box-body">
        <?=
        \yii\bootstrap\Tabs::widget(
            [
                'items' => $tabs,
            ]
        )
        ?>
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'event_id',
                        'filter' => $eventsList,
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
                        'class' => 'DevGroup\EventsSystem\widgets\StatusColumn',
                        'attribute' => 'is_active',
                    ],
                    [
                        'attribute' => 'is_system',
                        'class' => 'DevGroup\EventsSystem\widgets\StatusColumn',
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
    <?php if (Yii::$app->user->can('events-system-create-handler')) : ?>
    <div class="box-footer">
        <div class="pull-right">
            <?= Html::a(EventHelper::t('Create'), ['update'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php endif; ?>
</div>
