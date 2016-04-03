<?php
namespace app\events;

use app\modules\user\models\User;
use yii\base\Event;

/**
 * @property User $model
 */
class UserEvent extends Event implements EventInterface
{
    const USER_REGISTERED = 'userRegistered';
    const USER_BLOCKED = 'userBlocked';

    protected $_tokens = [
        '{user_id}' => 'id',
        '{username}' => 'username'
    ];

    /**
     * @var User
     */
    private $_user;
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }
    /**
     * @param User $form
     */
    public function setUser(User $form)
    {
        $this->_user = $form;
    }

    public function getModel()
    {
        return $this->getUser();
    }

    public function getTokens()
    {
        return $this->_tokens;
    }

    public static function getEvents()
    {
        return [
            self::USER_REGISTERED => self::USER_REGISTERED,
            self::USER_BLOCKED => self::USER_BLOCKED,
        ];
    }
}