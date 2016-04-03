<?php

namespace app\traits;

use app\events\ArticleEvent;
use app\events\EventInterface;
use app\events\UserEvent;
use app\modules\admin\models\Notifications;
use yii\base\Component;
use yii\base\Event;

trait EventsHandlersTrait
{

    /**
     * @param $object Component
     */
    protected function initUserHandlers($object)
    {
        $userNotifications = Notifications::getUserEventsNotifications();
        foreach($userNotifications as $userNotification){
            $object->on($userNotification->event, function ($e) use ($userNotification){
                /**
                 * @var $e UserEvent
                 */
                foreach($userNotification->type as $type){
                    $this->handle($e,$userNotification,$type);
                }
            });
        }
    }

    /**
     * @param $event UserEvent|ArticleEvent
     * @param $notification Notifications
     * @param $type
     * @return mixed
     */
    protected function handle($event,$notification,$type)
    {
        if (array_key_exists($type,Notifications::$_types)){
            switch(Notifications::$_types[$type]){
                case 'email':
                    $notification->sendEmailNotification($event->getModel(),$event->getTokens());
                    break;
                case 'browser':
                    $notification->addToBrowserQuery($event->getModel(),$event->getTokens());
                    break;
                default:
                    $event->handled = true;
                    break;
            }
        } else {
            return $event->handled = true;
        }
    }
}