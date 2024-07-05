<?php
use Aliaksei\Test\Localization\Message;

$this->builder->add(
    'log',
    []
)->add(
    'text',
    [
        'name' => 'name'
    ],
    true,
    [
        [
            '(\w){3,25}',
            Message::Get('LOGIN_ERROR')
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
    'password',
    [
        'name' => 'password'
    ],
    true,
    [
        [
            '(.){6,24}',
            Message::Get('PASSWORD_ERROR')
        ]
    ]
)->add(
    'submit',
    [
        'value' => 'Registr'
    ]
)->checkRequest([
    'Aliaksei\Test\Personal\User::Add',
    [
        'name',
        'email',
        'password'
    ]
])->render();
?>

<script>
new Form({
    'formId': '#<?=$this->builder->getId()?>',
    'elementsConfig': JSON.parse('<?=addcslashes(json_encode($this->builder->getAll()), '\\')?>')
});
</script>