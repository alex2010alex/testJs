<?php

use Aliaksei\Test\Request;
use Aliaksei\Test\Controller\PageController;
use Aliaksei\Test\Helpers\Assets;
use Aliaksei\Test\Messages\Message;

require '../vendor/autoload.php';

session_start();

ob_start();

$request = Request::GetInstance();
$pageName = $request->get('page');

if ($pageName && Assets::IsAsset($pageName)) {
    Assets::GetAsset($pageName);
} else {
    $controller = new PageController();

    $controller->GetPageController($pageName ? $pageName: 'index')->render();
}

Message::Clear('globalMessages');
Message::Clear('FORM_REQUEST');
