<?php

namespace DevGroup\EventsSystem\models;

use DevGroup\EventsSystem\helpers\EventHelper;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
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
 *
 * @property Event $event
 */
class EventEventHandler extends \yii\db\ActiveRecord
{
    use TagDependencyTrait;

    public function behaviors()
    {
        return [
            'tagDependency' => [
                'class' => 'DevGroup\TagDependencyHelper\CacheableActiveRecord',
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
            [['event_id'], 'exist', 'targetClass' => Event::className(), 'targetAttribute' => 'id'],
            [['event_handler_id'], 'exist', 'targetClass' => EventHandler::className(), 'targetAttribute' => 'id'],
            [['sort_order'], 'integer'],
            [['packed_json_params'], 'string'],
            [['is_active'], 'boolean'],
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
            'packed_json_params' => EventHelper::t('Params'),
            'is_active' => EventHelper::t('Active'),
            'is_system' => EventHelper::t('System'),
            'sort_order' => EventHelper::t('Sort order'),
        ];
    }

    /**
     * @param $params
     * @param $eventIds
     * @return ActiveDataProvider
     */
    public function search($params, $eventIds)
    {
        $this->load($params);
        $query = static::find()->where(['event_id' => $eventIds]);
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

    /**
     * @return string
     */
    public function getEventName()
    {
        return Event::getNameById($this->event_id);
    }

    /**
     * @return string
     */
    public function getEventHandlerName()
    {
        return EventHandler::getNameById($this->event_handler_id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
