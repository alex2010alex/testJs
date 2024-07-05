<?php

use Aliaksei\Test\Messages\Message;
use Aliaksei\Test\Localization\Message as LocalizationMessage;
use Aliaksei\Test\Personal\User;
use Aliaksei\Test\Personal\Profile;
use Aliaksei\Test\Request;
use Aliaksei\Test\Helpers\Location;
use Aliaksei\Test\DB\CRUD\Delete;

$deleteRequest = new Delete();

$request = Request::GetInstance();

User::StopIfNotAutorized();

if (($id = $request->get('id')) && Profile::IsOwner($id) && $deleteRequest->from('Profile')->where('profile_id', $id)->and()->where('user_id', User::GetId())->execute()) {
    Message::Add(LocalizationMessage::Get('RECORD_SUCCESS_DELETE'));
} else {
    Message::Add(LocalizationMessage::Get('RECORD_FAIL_DELETE'));
}

Location::Redirect('/');
?>
