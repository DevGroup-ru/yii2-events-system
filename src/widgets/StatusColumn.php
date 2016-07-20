<?php

namespace DevGroup\EventsSystem\widgets;

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;

class StatusColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    public $format = 'raw';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->filter)) {
            $this->filter = [
                0 => EventHelper::t('No'),
                1 => EventHelper::t('Yes'),
            ];
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return $model->{$this->attribute} == 1
            ? Html::tag('span', EventHelper::t('Yes'), ['class' => 'label label-success'])
            : Html::tag('span', EventHelper::t('No'), ['class' => 'label label-danger']);
    }
}
