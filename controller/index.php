<?php

use Aliaksei\Test\Page\Base as BasePage;
use Aliaksei\Test\DB\CRUD\Select;
use Aliaksei\Test\DB\CRUD\Insert;

class ControllerIndex extends BasePage
{
    public array $profiles = [];
    
    public function render()
    {
        $dbRequest = new Select();

        $this->profiles = $dbRequest->select([
            'user_id',
            'profile_id',
            'first_name',
            'last_name',
            'email',
            'headline',
            'summary'    
        ])->from('Profile')->execute();

        parent::render();
    }
}
