<?php

use Aliaksei\Test\Localization\Message;
use Aliaksei\Test\Personal\User;

?>

<div class="profile-list">
    <div class="profile-list__item">
        <div class="profile-list__item-column">
            First Name
        </div>
        <div class="profile-list__item-column">
            Last Name
        </div>
        <div class="profile-list__item-column">
            E-mail
        </div>
        <div class="profile-list__item-column">
            HeadLine
        </div>
        <div class="profile-list__item-column">
            Summary
        </div>
        <div class="profile-list__item-column">
            
        </div>
        <div class="profile-list__item-column">
            
        </div>
    </div>
    <?php if (empty($this->profiles)): ?>
        <?=Message::Get('PROFILES_NOT_FOUND')?>
    <?php else: ?>
        <?php foreach ($this->profiles as $profile): ?>
            <div class="profile-list__item">
                <?php foreach ($profile as $key => $value): ?>
                    <?php if (in_array($key, ['user_id', 'profile_id'])) { continue; } ?>
                    <div class="profile-list__item-column">
                        <?=$value?>
                    </div>
                <?php endforeach; ?>
                <?php if (User::Autorized() && $profile['user_id'] === User::GetId()): ?>
                    <div class="profile-list__item-column">
                        <a href="/edit?id=<?=$profile['profile_id']?>">edit</a>
                    </div>
                    <div class="profile-list__item-column">
                        <a href="/delete?id=<?=$profile['profile_id']?>">remove</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>