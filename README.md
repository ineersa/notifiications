Yii2 Notification events test 
=============================

Basic starting platform with simple user functions(auth, registration, password change etc..)
and RBAC.

  

DIRECTORY STRUCTURE
-------------------

Contains modules:

      admin/          admin module for users/articles/notifications managment
      main/           main module for users 
      user/           contains functionality for user



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.
MySQL database.

INSTALLATION
------------

### Make migrations via
```php
    php yii migrate/up
```

### Init RBAC
```php
    php yii rbac/init
```

### Assign roles
```php
    php yii roles/assign
```
Also revoke available.

### User management available via console:
```php
    php yii users/create
    ...
```
See actions of `app\commands\UserController.php`

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

EVENTS SYSTEM EXPLANATION
-------------------------

### Attach event to your model:
```php
    //include events traits
    
    use EventsTrait;
    use EventsHandlersTrait;
    ...
    
    //init handlers (for example in init function), you can overwrite them if needed
    public function init()
    {
        parent::init();
        $this->initArticleHandlers($this);//you can init only specific events or all
    }
    
    //trigger event where you need it
    //you need to pass appropriate model for event
    $event = $this->getArticleEvent($this);
    $this->trigger($event::ARTICLE_CREATED,$event);
```

### Adding new event class:

    *   Create new event class which implements EventInterface
    *   Add new event to EventsTrait
    *   Create handler init in EventsHandlersTrait
    *   Append events available to admin/notifications/_form dropdownList
    
### Adding new event to existing classes:
    
    ```php
        //add constant
        const ARTICLE_CREATED = 'articleCreated';
        
        //add to eevents array
        public static function getEvents()
        {
            return [
                self::ARTICLE_CREATED => self::ARTICLE_CREATED,
                self::ARTICLE_UPDATED => self::ARTICLE_UPDATED
            ];
        }
    ```
After that you can create notification for event and attach to your models.

### Adding new handling type for event:

    ```php 
        //append Notifications
        static $_types = [
                1 => 'email',
                2 => 'browser'
        ];
        ...
        
    ```
Add new type to handling function in `EventsHandlersTrait`:
    
    ```php
        ...
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
        ...

    ```
    
### Adding tokens:
    
Overwrite `getTokens()` and `getTokensForView()` functions in your model.

TESTING
-------------------------

    @TODO