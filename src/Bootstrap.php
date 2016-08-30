<?php

namespace DevGroup\EventsSystem;

use DevGroup\EventsSystem\helpers\EventHelper;
use yii\base\Application;
use yii\base\Event;
use yii\helpers\Html;

/**
 * Class Bootstrap
 * @package DevGroup\EventsSystem
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\base\Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->i18n->translations['devgroup.events-system'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@DevGroup/EventsSystem/messages',
        ];
        $error = [];
        try {
            foreach (EventHelper::getActiveHandlersList() as $handler) {
                Event::on($handler['class'], $handler['name'], $handler['callable'], $handler['data']);
            }
        } catch (\yii\db\Exception $e) {
            $error = [
                'message' => '`DevGroup\EventsSystem` extension is not fully installed yet.',
                'hint' => 'Please run the `./yii migrate --migrationPath=@DevGroup/EventsSystem/migrations` command from your application directory to finish the installation process.',
            ];
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getCode(),
                'hint' => $e->getMessage(),
            ];
        }
        if (empty($error) === false) {
            if ($app instanceof \yii\console\Application) {
                $app->on(Application::EVENT_BEFORE_ACTION, function ($event) use ($app, $error) {
                    $app->controller->stdout(PHP_EOL . str_repeat('=', 80) . PHP_EOL . PHP_EOL);
                    $app->controller->stderr($error['message'] . PHP_EOL);
                    $app->controller->stdout($error['hint'] . PHP_EOL);
                    $app->controller->stdout(PHP_EOL . str_repeat('=', 80) . PHP_EOL);
                });
            } elseif ($app instanceof \yii\web\Application && YII_DEBUG === true) {
                $app->session->setFlash(
                    'warning',
                    Html::tag('h4', $error['message']) . Html::tag('p', $error['hint'])
                );
            }
        }
    }
}
