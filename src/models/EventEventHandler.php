<?php

namespace DevGroup\EventsSystem\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%devgroup_event_event_handler}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $event_handler_id
 * @property string $method
 * @property string $params
 * @property boolean $is_active
 * @property boolean $is_system
 * @property integer $sort_order
 */
class EventEventHandler extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%devgroup_event_event_handler}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'event_handler_id', 'method'], 'required'],
            [['event_id', 'event_handler_id', 'is_active', 'sort_order'], 'integer'],
            [['params'], 'string'],
            [['is_system'], 'boolean', 'on' => 'search'],
            [['method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event'),
            'event_handler_id' => Yii::t('app', 'Event handler'),
            'method' => Yii::t('app', 'Method'),
            'params' => Yii::t('app', 'Params'),
            'is_active' => Yii::t('app', 'Active'),
            'sort_order' => Yii::t('app', 'Sort order'),
        ];
    }

    public function search($params)
    {
        $this->load($params);
        $query = static::find();
        $partialAttributes = ['method'];
        foreach ($this->attributes as $key => $value) {
            if (in_array($key, $partialAttributes)) {
                $query->andFilterWhere(['like', $key, $value]);
            } else {
                $query->andFilterWhere([$key => $value]);
            }
        }
        return new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );
    }

    public function getEventName()
    {
        return Event::getNameById($this->event_id);
    }

    public function getEventHandlerName()
    {
        return EventHandler::getNameById($this->event_handler_id);
    }
}
