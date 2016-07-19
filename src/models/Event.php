<?php

namespace DevGroup\EventsSystem\models;

use DevGroup\EventsSystem\traits\ListData;
use Yii;

/**
 * This is the model class for table "{{%devgroup_event}}".
 *
 * @property integer $id
 * @property integer $event_group_id
 * @property string $name
 * @property string $description
 * @property string $event_class_name
 * @property string $execution_point
 */
class Event extends \yii\db\ActiveRecord
{
    use ListData;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%devgroup_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_group_id', 'name', 'execution_point'], 'required'],
            [['event_group_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['event_class_name', 'execution_point'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_group_id' => Yii::t('app', 'Event group'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'event_class_name' => Yii::t('app', 'Event class name'),
            'execution_point' => Yii::t('app', 'Execution point'),
        ];
    }
}
