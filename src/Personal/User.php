<?php

namespace Aliaksei\Test\Personal;

use Aliaksei\Test\Helpers\Session;
use Aliaksei\Test\DB\CRUD\Insert;
use Aliaksei\Test\DB\CRUD\Select;
use Aliaksei\Test\Messages\Message;
use Aliaksei\Test\Localization\Message as LocalizationMessage;
use Aliaksei\Test\Helpers\Location;
use Aliaksei\Test\Config;
use Aliaksei\Test\Messages\SingleMessage;

class User
{
    protected const STORAGE_USER_AUTORIZED = 'USER_AUTORIZED';

    public static function Autorized(): bool
    {
        return (bool) Session::Get(self::STORAGE_USER_AUTORIZED);
    }

    public static function Authenticate(string $login, string $passwd): void
    {
        if (!static::Exist($login)) {
            SingleMessage::GetInstance()->add(str_ireplace('#NAME#', $login, LocalizationMessage::Get('USER_NOT_FOUND')));
        } else if ($user = (new Select())->select(['user_id'])->from('users')->where('email', $login)->and()->where('password', static::Hash($passwd))->execute()) {
            static::Autorize($user[0]['user_id']);
            Message::Add(LocalizationMessage::Get('SUCCESS_LOGIN'));

            Location::Redirect('/');
        } else {
            SingleMessage::GetInstance()->add(LocalizationMessage::Get('FAIL_AUTORIZE'));
        }
    }

    public static function LogOut(): void
    {
        Session::Remove(self::STORAGE_USER_AUTORIZED);

        Message::Add(LocalizationMessage::Get('SUCCESS_LOGOUT'));

        Location::Redirect('/');
    }

    public static function GetId()
    {
        return Session::Get(self::STORAGE_USER_AUTORIZED);
    }

    public static function Add(
        string $name,
        string $email,
        string $passwd 
    ): void {
        if (static::Exist($email)) {
            SingleMessage::GetInstance()->add(str_ireplace('#NAME#', $email, LocalizationMessage::Get('EMAIL_EXIST')));

            return;
        }

        $dbRequest = new Insert();

        if ($dbRequest->set([
            'name' => $name,
            'email' => $email,
            'password' => static::Hash($passwd)
        ])->to('users')->execute()) {
            Message::Add(LocalizationMessage::Get('SUCCESS_REGISTRATION'));

            Location::Redirect('/');
        }
    }

    public static function Exist(string $login): bool
    {
        return !empty((new Select())->select(['*'])->from('users')->where('email', $login)->execute());
    }

    public static function StopIfNotAutorized(): void
    {
        if (!static::Autorized()) {
            Message::Add(LocalizationMessage::Get('NOT_AUTORIZED'));

            Location::Redirect('/');
        }
    }

    public static function Hash(string $passwd): string
    {
        $dbConfig = Config::Get('db');
        
        return md5($dbConfig['salt'] . $passwd);
    }

    private static function Autorize($userId)
    {
        Session::Set(self::STORAGE_USER_AUTORIZED, $userId);
    }
}