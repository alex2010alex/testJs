<?php

use Aliaksei\Test\Messages\SingleMessage;

?>

<?php if ($messages = SingleMessage::GetInstance()->getAll()): ?>
    <div class="form-messages">
        <?php foreach ($messages as $globalMessage): ?>
            <div class="form-message"><?=$globalMessage?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>