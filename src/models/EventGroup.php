<?php

namespace DevGroup\EventsSystem\models;

use Yii;

/**
 * This is the model class for table "{{%devgroup_event_group}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $owner_class_name
 */
class EventGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%devgroup_event_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['owner_class_name'], 'string', 'max' => 255],
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
            'owner_class_name' => Yii::t('app', 'Owner class name'),
        ];
    }
}
