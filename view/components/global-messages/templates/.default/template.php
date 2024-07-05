<?php

use Aliaksei\Test\Helpers\Session;

?>

<?php if ($messages = Session::Get('globalMessages')): ?>
    <div class="global-messages">
        <?php foreach ($messages as $message): ?>
            <div class="global-message"><?=$message?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>