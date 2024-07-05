<?php

namespace Aliaksei\Test\Form;

use Aliaksei\Test\Request;
use Aliaksei\Test\Messages\Message;
use Aliaksei\Test\Localization\Message as LocalizationMessage;
use Aliaksei\Test\DB\CRUD\Select;
use Aliaksei\Test\Messages\SingleMessage;

class Checker
{
    protected ?bool $checked = null;

    public function checkRequest(array $callback = []): self 
    {
        $request = Request::GetInstance();
        
        if ($request->post($this->getId())) {
            $checked = [];

            foreach ($this->elements as &$element) {
                if (!isset($element['attributes']['name'])) {
                    continue;
                }

                $elementName = $element['attributes']['name'];
                $elementValue = $element['attributes']['value'] = $request->post($elementName);

                if ($element['required'] && empty($elementValue)) {
                    SingleMessage::GetInstance()->add(str_ireplace('#NAME#', $elementName, LocalizationMessage::Get('EMPTY_FIELD')));

                    $checked[] = false;
                }

                if (!empty($element['checkers'])) {
                    foreach ($element['checkers'] as $checker) {
                        if (!preg_match(static::PrepareRegex($checker[0]), $elementValue)) {
                            SingleMessage::GetInstance()->add($checker[1]);

                            $checked[] = false;
                        } else {
                            $checked[] = true;
                        }
                    }
                }
            }

            $this->checked($this->checkArray($checked));

            if ($this->isChecked() && !empty($callback)) {
                $params = [];
                
                if (!empty($callback[1])) {
                    $params = array_map(function ($item) use($request) {
                        return $request->post($item);
                    }, $callback[1]);
                }

                $callback[0](...$params);
            }
        }

        return $this;
    }

    public function fill(string $id): self
    {
        $request = Request::GetInstance();
        $dbRequest = new Select();

        if ($profile = $dbRequest->select(['*'])->where('profile_id', $id)->from('Profile')->execute()) {
            $profile = $profile[0];
            
            foreach ($this->elements as &$element) {
                if (!isset($element['attributes']['name'])) {
                    continue;
                }

                $elementName = $element['attributes']['name'];

                if (array_key_exists($elementName, $profile)) {
                    $element['attributes']['value'] = $profile[$elementName];
                }
            }
        }
        
        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function checkArray(array $array): bool
    {
        if (count(array_unique($array)) === 1) {  
            return current($array);
        }

        return false;
    }

    protected function checked(bool $checked = true): self
    {
        $this->checked = $checked;

        return $this;
    }

    protected static function PrepareRegex(string $regex): string
    {
        return '/' . $regex . '/m';
    }
}