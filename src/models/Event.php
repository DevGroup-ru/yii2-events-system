<?php

namespace DevGroup\EventsSystem\models;

use DevGroup\EventsSystem\helpers\EventHelper;
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
            'id' => EventHelper::t('ID'),
            'event_group_id' => EventHelper::t('Event group'),
            'name' => EventHelper::t('Name'),
            'description' => EventHelper::t('Description'),
            'event_class_name' => EventHelper::t('Event class name'),
            'execution_point' => EventHelper::t('Execution point'),
        ];
    }
}
