<?php

namespace DevGroup\EventsSystem\traits;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ListData
 *
 * @mixin ActiveRecord
 * @package DevGroup\EventsSystem\traits
 */
trait ListData
{
    /**
     * @var bool whether is the list already loaded
     */
    protected static $listIsFilled = false;

    /**
     * @param string|callable $attributeName
     * @return array
     */
    public static function dropDownList($attributeName = 'name')
    {
        $list = ArrayHelper::map(
            self::$listIsFilled === true ? static::getMap() : static::find()->asArray(true)->all(),
            'id',
            $attributeName
        );
        self::$listIsFilled = true;
        return $list;
    }

    /**
     * Get the record name by id.
     * @param integer $id
     * @param string $attributeName
     * @return string
     */
    public static function getNameById($id, $attributeName = 'name')
    {
        $model = static::getById($id);
        return empty($model[$attributeName]) === false ? $model[$attributeName] : \Yii::t('app', 'Unknown');
    }

    /**
     * Preload data.
     * This method loads all models to identity map as array of attributes
     */
    public static function preloadData()
    {
        static::find()->asArray(true)->all();
        self::$listIsFilled = true;
    }
}
