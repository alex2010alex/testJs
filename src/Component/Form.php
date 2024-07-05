<?php

namespace Aliaksei\Test\Component;

use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Form\Builder as FormBuilder;

class Form extends Base
{
    protected ?FormBuilder $builder;

    public function __construct(
        string $name,
        string $componentDir,
        string $template
    ) {
        parent::__construct(
            $name,
            $componentDir,
            $template
        );

        $this->builder = new FormBuilder(
            $componentDir, 
            $this->template
        );
    }
}