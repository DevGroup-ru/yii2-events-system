<?php

use yii\db\Migration;

class m160830_104544_events_system_create_permissions extends Migration
{
    const ADMIN_ROLE_NAME = 'EventsSystemAdministrator';

    protected $permissions = [
        'events-system-view-handler' => 'You can see handlers list and an event handler details',
        'events-system-create-handler' => 'You can add a new handler for event',
        'events-system-edit-handler' => 'You can edit an existing event handler',
        'events-system-delete-handler' => 'You can delete an event handler',
        'events-system-change-handler-activity' => 'You can change an event handler activity',
    ];

    protected function error($message)
    {
        $length = strlen($message);
        echo "\n" . str_repeat('=', $length) . "\n" . $message . "\n" . str_repeat('=', $length) . "\n\n";
    }

    public function up()
    {
        $auth = Yii::$app->authManager;
        if ($auth === null) {
            $this->error('Please configure AuthManager before');
            return false;
        }
        try {
            $role = $auth->createRole(self::ADMIN_ROLE_NAME);
            $role->description = '';
            $auth->add($role);
            foreach ($this->permissions as $name => $description) {
                $permission = $auth->createPermission($name);
                $permission->description = $description;
                $auth->add($permission);
                $auth->addChild($role, $permission);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
        return true;
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        if ($auth !== null) {
            $role = $auth->getRole(self::ADMIN_ROLE_NAME);
            if ($role !== null) {
                $auth->remove($role);
                foreach ($this->permissions as $name => $description) {
                    $permission = $auth->getPermission($name);
                    if ($permission === null) {
                        continue;
                    }
                    $auth->remove($permission);
                }
            }
        }
    }
}
