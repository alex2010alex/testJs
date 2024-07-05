<?php

namespace Aliaksei\Test\Form;

use Aliaksei\Test\Helpers\Interfaces\Renderable;

class Builder extends Checker implements Renderable
{
    protected array $elements = [];

    protected string $method = 'post';

    protected string $action;
    
    protected string $componentDir;
    
    protected string $template;

    protected string $sharedElementPath;

    protected string $elementPath;

    protected string $formId = 'FORM_REQUEST';

    public function __construct(
        string $componentDir,
        string $template
    ) {
        $this->componentDir = $componentDir;
        $this->template = $template;

        $this->sharedElementPath = $this->componentDir . '/shared_elements/#TYPE#.php';
        $this->elementPath = $this->componentDir . $this->template . '/elements/#TYPE#.php'; 

        $this->action = $_SERVER['REQUEST_URI'];
    }

    public function getId(): string
    {
        return $this->formId;
    }

    public function add(string $type, array $attributes, bool $required = false, array $checkers = []): self
    {
        $this->elements[] = [
            'type' => $type,
            'attributes' => $attributes,
            'required' => $required,
            'checkers' => $checkers
        ];

        return $this;
    }

    public function getAll(): array
    {
        return $this->elements;
    }

    public function method(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function action(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function render(bool $return = false)
    {
        ob_start();

        echo '<form id="' . $this->getId() . '" action="' . $this->getAction() . '" method="' . $this->getMethod() . '">';

        $this->add(
            'hidden',
            [
                'name' => $this->getId(),
                'value' => 'Y'
            ]
        );
        
        foreach ($this->getAll() as $element) {
            $this->loadElement($element);
        }

        echo '</form>';

        $result = ob_get_contents();
        ob_end_clean();

        if ($return) {
            return $result;
        }

        echo $result;
    }

    protected function loadElement(array $element): void
    {
        $sharedElementPath = str_ireplace('#TYPE#', $element['type'], $this->sharedElementPath);
        $elementPath = str_ireplace('#TYPE#', $element['type'], $this->elementPath);

        require file_exists($sharedElementPath) ? $sharedElementPath: $elementPath;
    }
}