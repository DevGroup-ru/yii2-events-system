<?php

namespace DevGroup\EventsSystem\models;

use DevGroup\EventsSystem\traits\ListData;
use Yii;

/**
 * This is the model class for table "{{%devgroup_event_handler}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $class_name
 */
class EventHandler extends \yii\db\ActiveRecord
{
    use ListData;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%devgroup_event_handler}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class_name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['class_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'class_name' => Yii::t('app', 'Class name'),
        ];
    }
}
