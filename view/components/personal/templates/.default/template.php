<?php

use Aliaksei\Test\Personal\User;
use Aliaksei\Test\Helpers\Session;

?>

<div class="personal">
    <a href="/">Main Page</a>
    <?php if (User::Autorized()): ?>
        <a href="/add">Add</a>
        <a href="/logout">Logout</a>
    <?php else: ?>
        <a href="/login">Login</a>
        <a href="/registretion">Registration</a>
    <?php endif; ?>
</div>

<style>
.personal {
    display: flex;
    flex-direction: row;
    gap: 10px;
    margin: auto;
    width: fit-content;
    width: -moz-fit-content;
}
</style>