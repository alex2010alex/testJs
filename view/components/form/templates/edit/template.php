<?php

use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Personal\User;
use Aliaksei\Test\Personal\Profile;
use Aliaksei\Test\Request;
use Aliaksei\Test\Helpers\Location;

$request = Request::GetInstance();

User::StopIfNotAutorized();

if (!($id = $request->get('id')) || !Profile::IsOwner($id)) {
    Location::Redirect('/');
}

$this->builder->add(
    'log',
    []
)->add(
    'hidden',
    [
        'name' => 'profile_id',
        'value' => $id
    ],
    true
)->add(
    'text',
    [
        'name' => 'first_name'
    ],
    true,
    [
        [
            '(\w){3,25}',
            Message::Get('FIRST_NAME_ERROR')
        ]
    ]
)->add(
    'text',
    [
        'name' => 'last_name'
    ],
    true,
    [
        [
            '(\w){3,25}',
            Message::Get('LAST_NAME_ERROR')
        ]
    ]
)->add(
    'text',
    [
        'name' => 'email'
    ],
    true,
    [
        [
            '^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$',
            Message::Get('EMAIL_ERROR')
        ]
    ]
)->add(
    'text',
    [
        'name' => 'headline'
    ],
    true,
    [
        [
            '(\w){3,25}',
            Message::Get('HEAD_LINE_ERROR')
        ]
    ]
)->add(
    'text',
    [
        'name' => 'summary'
    ],
    true,
    [
        [
            '(\w){3,25}',
            Message::Get('SUMMARY_ERROR')
        ]
    ]
)->add(
    'submit',
    [
        'value' => 'Update'
    ]
)->fill($id)->checkRequest([
    'Aliaksei\Test\Personal\Profile::Update',
    [
        'profile_id',
        'first_name',
        'last_name',
        'email',
        'headline',
        'summary'
    ]
])->render();
?>

<script>
new Form({
    'formId': '#<?=$this->builder->getId()?>',
    'elementsConfig': JSON.parse('<?=addcslashes(json_encode($this->builder->getAll()), '\\')?>')
});
</script>