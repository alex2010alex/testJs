<?php

namespace Aliaksei\Test\Personal;

use Aliaksei\Test\Helpers\Session;
use Aliaksei\Test\DB\CRUD\Insert;
use Aliaksei\Test\DB\CRUD\Select;
use Aliaksei\Test\DB\CRUD\Update;
use Aliaksei\Test\Messages\Message;
use Aliaksei\Test\Localization\Message as LocalizationMessage;
use Aliaksei\Test\Helpers\Location;
use Aliaksei\Test\Messages\SingleMessage;

class Profile
{
    public static function Add(
        string $firstName,
        string $lastName,
        string $email,
        string $headline,
        string $summary,
    ): void {
        $dbRequest = new Insert();

        if ($dbRequest->set([
            'user_id' => User::GetId(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'headline' => $headline,
            'summary' => $summary,
        ])->to('Profile')->execute()) {
            Message::Add(LocalizationMessage::Get('PROFILE_SUCCESS_ADD'));

            Location::Redirect('/');
        } else {
            SingleMessage::GetInstance()->add(LocalizationMessage::Get('PROFILE_ERROR_ADD'));
        }
    }

    public static function Update(
        string $profileId,
        string $firstName,
        string $lastName,
        string $email,
        string $headline,
        string $summary,
    ): void {
        $dbRequest = new Update();

        if ($dbRequest->set([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'headline' => $headline,
            'summary' => $summary,
        ])->to('Profile')->where('user_id', User::GetId())->and()->where('profile_id', $profileId)->execute()) {
            Message::Add(LocalizationMessage::Get('PROFILE_SUCCESS_UPDATE'));

            Location::Redirect('/');
        } else {
            SingleMessage::GetInstance()->add(LocalizationMessage::Get('PROFILE_ERROR_UPDATE'));
        }
    }

    public static function IsOwner(string $profileId): bool
    {
        $dbRequest = new Select();

        return $dbRequest->select(['user_id'])->where('user_id', User::GetId())->and()->where('profile_id', $profileId)->from('Profile')->execute() ? true: false;
    }
}