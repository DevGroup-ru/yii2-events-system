<?php

use DevGroup\EventsSystem\models\Event;
use DevGroup\EventsSystem\models\EventHandler;
use DevGroup\EventsSystem\models\EventGroup;
use DevGroup\EventsSystem\models\EventEventHandler;
use yii\db\Migration;
use yii\base\Application;
use yii\base\View;

class m160718_115323_init extends Migration
{
    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;
        $this->createTable(
            EventGroup::tableName(),
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(100)->notNull(),
                'description' => $this->text()->null(),
                'owner_class_name' => $this->string(255)->notNull()->defaultValue('yii\web\Application'),
            ],
            $tableOptions
        );
        $this->createTable(
            Event::tableName(),
            [
                'id' => $this->primaryKey(),
                'event_group_id' => $this->integer()->notNull(),
                'name' => $this->string(100)->notNull(),
                'description' => $this->text()->null(),
                'event_class_name' => $this->string(255)->notNull()->defaultValue('yii\base\Event'),
                'execution_point' => $this->string(255)->notNull(),
            ],
            $tableOptions
        );
        $this->addForeignKey(
            'fk-event-event_group_id-event_group-id',
            Event::tableName(),
            'event_group_id',
            EventGroup::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createTable(
            EventHandler::tableName(),
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(100)->notNull(),
                'description' => $this->text()->null(),
                'class_name' => $this->string(255)->notNull(),
            ],
            $tableOptions
        );
        $this->createTable(
            EventEventHandler::tableName(),
            [
                'id' => $this->primaryKey(),
                'event_id' => $this->integer()->notNull(),
                'event_handler_id' => $this->integer()->notNull(),
                'method' => $this->string(255)->notNull(),
                'packed_json_params' => $this->text()->null(),
                'is_active' => $this->boolean()->defaultValue(true),
                'is_system' => $this->boolean()->defaultValue(false),
                'sort_order' => $this->integer()->notNull()->defaultValue(0),
            ],
            $tableOptions
        );
        $this->addForeignKey(
            'fk-event_event_handler-event_id-event-id',
            EventEventHandler::tableName(),
            'event_id',
            Event::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-event_event_handler-event_handler_id-event_handler-id',
            EventEventHandler::tableName(),
            'event_handler_id',
            EventHandler::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
        // data
        // Web application
        $this->insert(
            EventGroup::tableName(),
            [
                'name' => 'Web application',
                'description' => '',
                'owner_class_name' => 'yii\web\Application',
            ]
        );
        $lastInsertId = $this->db->lastInsertID;
        $this->batchInsert(
            Event::tableName(),
            ['event_group_id', 'name', 'description', 'event_class_name', 'execution_point'],
            [
                [$lastInsertId, 'Before request', '', 'yii\base\Event', Application::EVENT_BEFORE_REQUEST],
                [$lastInsertId, 'Before action', '', 'yii\base\ViewEvent', Application::EVENT_BEFORE_ACTION],
                [$lastInsertId, 'After action', '', 'yii\base\ViewEvent', Application::EVENT_AFTER_ACTION],
                [$lastInsertId, 'After request', '', 'yii\base\Event', Application::EVENT_AFTER_REQUEST],
            ]
        );
        // Console application
        $this->insert(
            EventGroup::tableName(),
            [
                'name' => 'Console application',
                'description' => '',
                'owner_class_name' => 'yii\console\Application',
            ]
        );
        $lastInsertId = $this->db->lastInsertID;
        $this->batchInsert(
            Event::tableName(),
            ['event_group_id', 'name', 'description', 'event_class_name', 'execution_point'],
            [
                [$lastInsertId, 'Before request', '', 'yii\base\Event', Application::EVENT_BEFORE_REQUEST],
                [$lastInsertId, 'Before action', '', 'yii\base\ViewEvent', Application::EVENT_BEFORE_ACTION],
                [$lastInsertId, 'After action', '', 'yii\base\ViewEvent', Application::EVENT_AFTER_ACTION],
                [$lastInsertId, 'After request', '', 'yii\base\Event', Application::EVENT_AFTER_REQUEST],
            ]
        );
        // Web rendering
        $this->insert(
            EventGroup::tableName(),
            [
                'name' => 'Web rendering',
                'description' => '',
                'owner_class_name' => 'yii\web\View',
            ]
        );
        $lastInsertId = $this->db->lastInsertID;
        $this->batchInsert(
            Event::tableName(),
            ['event_group_id', 'name', 'description', 'event_class_name', 'execution_point'],
            [
                [$lastInsertId, 'Before render', '', 'yii\base\ViewEvent', View::EVENT_BEFORE_RENDER],
                [$lastInsertId, 'Begin page', '', 'yii\base\ViewEvent', View::EVENT_BEGIN_PAGE],
                [$lastInsertId, 'End page', '', 'yii\base\ViewEvent', View::EVENT_END_PAGE],
                [$lastInsertId, 'After render', '', 'yii\base\ViewEvent', View::EVENT_AFTER_RENDER],
            ]
        );
        // Console rendering
        $this->insert(
            EventGroup::tableName(),
            [
                'name' => 'Console rendering',
                'description' => '',
                'owner_class_name' => 'yii\console\View',
            ]
        );
        $lastInsertId = $this->db->lastInsertID;
        $this->batchInsert(
            Event::tableName(),
            ['event_group_id', 'name', 'description', 'event_class_name', 'execution_point'],
            [
                [$lastInsertId, 'Before render', '', 'yii\base\ViewEvent', View::EVENT_BEFORE_RENDER],
                [$lastInsertId, 'Begin page', '', 'yii\base\ViewEvent', View::EVENT_BEGIN_PAGE],
                [$lastInsertId, 'End page', '', 'yii\base\ViewEvent', View::EVENT_END_PAGE],
                [$lastInsertId, 'After render', '', 'yii\base\ViewEvent', View::EVENT_AFTER_RENDER],
            ]
        );
        // test data
        $this->insert(
            EventHandler::tableName(),
            [
                'name' => 'Pagination',
                'class_name' => 'DevGroup\EventsSystem\handlers\Pagination',
                'description' => '',
            ]
        );
        $this->insert(
            EventEventHandler::tableName(),
            [
                'event_id' => 12,
                'event_handler_id' => $this->db->lastInsertID,
                'method' => 'updateTitle',
                'packed_json_params' => '{}',
            ]
        );
    }

    public function down()
    {
        $this->dropTable(EventEventHandler::tableName());
        $this->dropTable(EventHandler::tableName());
        $this->dropTable(Event::tableName());
        $this->dropTable(EventGroup::tableName());
    }
}
