<?php
namespace app\events;

use yii\db\BaseActiveRecord;

interface EventInterface
{
    /**
     * Return model for current event
     * @return null|BaseActiveRecord
     */
    public function getModel();

    /**
     * Return available tokens for current event
     * @return array
     */
    public function getTokens();
}
