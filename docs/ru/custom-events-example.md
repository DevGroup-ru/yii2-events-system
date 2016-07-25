Пример добавления собственных групп, событий и обработчиков
===========================================================

Пусть у нас есть модуль пользователей `VendorNamespace\AwesomeUsersExtension\Module` и нам необходимо добавить вызов событий при логине, логауте, регистрации и авторизации через социальные сети.

Добавим в него необходимые константы

```php
const EVENT_AFTER_LOGIN = 'users.user.afterLogin';
const EVENT_AFTER_LOGOUT = 'users.user.afterLogout';
const EVENT_AFTER_SIGNUP = 'users.user.afterSignup';
const EVENT_AFTER_SN_LOGIN = 'users.user.afterSNLogin';
```

Создадим класс события в котором добавим поле userId содержащее идентификатор пользовтеля (В принципе эту информацию можно передать через поле `data` стандартного события `yii\base\Event`, но лучше создать отдельное событие для облегчения дальнейшей рабочы через административный отдел, т.к. список доступных обработчиков формируется также по классу события)

```php
namespace VendorNamespace\AwesomeUsersExtension\events;

class UserEvent extends \yii\base\Event
{
    public $userId;
}
```

В нужных местах укажем вызов этих событий

```php
$event = new VendorNamespace\AwesomeUsersExtension\events\UserEvent;
$event->sender = Yii::$app->getModule('user');
$event->userId = Yii::$app->user->id;
Yii::$app->getModule('user')->trigger(VendorNamespace\AwesomeUsersExtension\Module::EVENT_AFTER_LOGIN, $event);
```

Создадим обработчик отсылающий письмо после регистрации

```php

namespace VendorNamespace\AwesomeUsersExtension\handlers;

class UserEventHandler
{
    public static function sendEmailAfterSignup(VendorNamespace\AwesomeUsersExtension\events\UserEvent $event)
    {
        $user = VendorNamespace\AwesomeUsersExtension\models\User::findOne($event->userId); // Получение модели пользователя можно вынести в само событие
        Yii::$app->mail->compose()
            ->setTo($user->email)
            ->setSubject('Спасибо за регистрацию!')
            ->setTextBody('...')
            ->send();
    }
}

```

Теперь добавим миграцию, которая создаст необходимые записи в БД
```php
use DevGroup\EventsSystem\models\Event;
use DevGroup\EventsSystem\models\EventHandler;
use DevGroup\EventsSystem\models\EventGroup;
use DevGroup\EventsSystem\models\EventEventHandler;
use VendorNamespace\AwesomeUsersExtension\Module;
use yii\db\Migration;
use yii\base\Application;
use yii\base\View;

class m160718_115323_init extends Migration
{
    public function up()
    {
        $this->insert(
            EventGroup::tableName(),
            [
                'name' => 'users module',
                'description' => '',
                'owner_class_name' => 'VendorNamespace\AwesomeUsersExtension\Module',
            ]
        );
        $groupId = $this->db->lastInsertID;
        $this->batchInsert(
            Event::tableName(),
            ['event_group_id', 'name', 'description', 'event_class_name', 'execution_point'],
            [
                [$groupId, 'After sign up', '', 'VendorNamespace\AwesomeUsersExtension\events\UserEvent', Module::EVENT_AFTER_SIGNUP],
                [$groupId, 'After login', '', 'VendorNamespace\AwesomeUsersExtension\events\UserEvent', Module::EVENT_AFTER_LOGIN],
                [$groupId, 'After logout', '', 'VendorNamespace\AwesomeUsersExtension\events\UserEvent', Module::EVENT_AFTER_LOGOUT],
                [$groupId, 'After social network login', '', 'VendorNamespace\AwesomeUsersExtension\events\UserEvent', Module::EVENT_AFTER_SN_LOGIN],
            ]
        );
        $eventId = $this->db->lastInsertID;
        $this->insert(
            EventHandler::tableName(),
            [
                'name' => 'User handler',
                'class_name' => 'VendorNamespace\AwesomeUsersExtension\handlers\UserEventHandler',
                'description' => '',
            ]
        );
        $habdlerId = $this->db->lastInsertID;
        $this->insert(
            EventEventHandler::tableName(),
            [
                'event_id' => $eventId,
                'event_handler_id' => $habdlerId,
                'method' => 'sendEmailAfterSignup',
                'packed_json_params' => '{}',
            ]
        );
    }
    public function down()
    {
        // Revert the migration
    }
}
```

Вот и все. Теперь можно упразлять событиями через административный отдел.
