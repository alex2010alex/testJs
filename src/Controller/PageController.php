<?php

namespace Aliaksei\Test\Controller;

use Aliaksei\Test\Page\Base as BasePage;
use Aliaksei\Test\Config;
use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Helpers\ClassManegment\Search;

class PageController
{
    private static ?array $Config = null;

    public static function GetPageController(string $name): BasePage
    {
        if (is_null(static::$Config)) {
            static::$Config = Config::Get('controller');
        }
        
        if ($controllerInformation = Search::ClassExists(
            static::$Config['standart'],
            'Controller',
            $name
        )) {
            return new $controllerInformation['className']($name);
        }

        throw new \Exception(Message::Get('CONTROLLER_NOT_FOUND'));
    }
}