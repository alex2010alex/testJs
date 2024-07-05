<?php

namespace Aliaksei\Test\Page;

use Aliaksei\Test\Config;
use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Seo\Seo;
use Aliaksei\Test\Helpers\Interfaces\Renderable;

class Base extends Seo implements Renderable
{
    protected string $pageName;

    protected array $config;

    public function __construct(string $name = '') {
        $this->pageName = $name;
        $this->config = Config::Get('view');
    }
    
    public function setPageName(string $name): self
    {
        $this->pageName = $name;

        return $this;
    }

    public function render()
    {
        if (empty($this->pageName)) {
            throw new Exception(Message::Get('EMPTY_PAGE_NAME'));
        }

        require $this->config['common'] . 'header.php';
        require $this->config['standart'] . $this->pageName . '.php';
        require $this->config['common'] . 'footer.php';
    }
}