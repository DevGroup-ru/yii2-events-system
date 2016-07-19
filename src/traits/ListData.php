<?php

namespace DevGroup\EventsSystem\traits;

use yii\db\ActiveRecord;

/**
 * Class ListData
 *
 * @mixin ActiveRecord
 * @package DevGroup\EventsSystem\traits
 * @todo Refactor this trait
 */
trait ListData
{
    public static function dropDownList($attributeName = 'name')
    {
        return static::find()
            ->select([$attributeName, 'id'])
            ->indexBy('id')
            ->column();
    }

    public static function getNameById($id, $attributeName = 'name')
    {
        $name = static::find()->select($attributeName)->where(['id' => $id])->asArray(true)->scalar();
        return empty($name) === false ? $name : \Yii::t('app', 'Unknown');
    }
}
