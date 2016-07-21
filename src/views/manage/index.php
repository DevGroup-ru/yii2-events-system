<?php

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var DevGroup\EventsSystem\models\EventEventHandler $model
 * @var yii\web\View $this
 */

$this->title = EventHelper::t('Event handlers');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-event-handler-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(EventHelper::t('Create'), ['update'], ['class' => 'btn btn-success']) ?>
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
                        'filter' => \DevGroup\EventsSystem\models\Event::dropDownListWithGroup(),
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
