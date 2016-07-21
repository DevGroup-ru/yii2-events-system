<?php

namespace DevGroup\EventsSystem\models;

use DevGroup\EventsSystem\helpers\EventHelper;
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
    public function behaviors()
    {
        return [
            'packedJsonAttributes' => [
                'class' => 'DevGroup\DataStructure\behaviors\PackedJsonAttributes',
            ],
        ];
    }

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
            'id' => EventHelper::t('ID'),
            'event_id' => EventHelper::t('Event'),
            'event_handler_id' => EventHelper::t('Event handler'),
            'method' => EventHelper::t('Method'),
            'params' => EventHelper::t('Params'),
            'is_active' => EventHelper::t('Active'),
            'is_system' => EventHelper::t('System'),
            'sort_order' => EventHelper::t('Sort order'),
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
                'sort' => [
                    'attributes' => [
                        'event_id' => [
                            'asc' => ['event_id' => SORT_ASC, 'sort_order' => SORT_ASC],
                            'desc' => ['event_id' => SORT_DESC, 'sort_order' => SORT_ASC],
                        ],
                        'event_handler_id',
                        'method',
                        'is_active',
                        'is_system',
                        'sort_order',
                    ],
                    'defaultOrder' => [
                        'event_id' => SORT_ASC,
                    ],
                ],
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
