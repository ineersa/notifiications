<?php

namespace app\traits;

use app\events\UserEvent;
use yii\base\Component;

trait EventsHandlersTrait
{

    /**
     * @param $object Component
     */
    protected function initUserHandlers($object)
    {
        $object->on(UserEvent::USER_BLOCKED, function ($e){
            /**
             * @var $e UserEvent
             */
            _d($e->getUser()->id);
        });
    }
}