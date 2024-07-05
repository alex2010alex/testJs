<?php

use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Personal\User;

User::StopIfNotAutorized();

$this->builder->add(
    'log',
    []
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
        'value' => 'Add'
    ]
)->checkRequest([
    'Aliaksei\Test\Personal\Profile::Add',
    [
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