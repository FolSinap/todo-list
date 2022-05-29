<?php $session = Core\Session::start() ?>
<form method="post" action="/login">
    <?php if($session->has('login_error')) {?>
            <div class="text-danger"><?= $session->get('login_error') ?></div>
        <?php $session->unset('login_error');} ?>
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('username') as $error) { ?>
            <div class="text-danger"><?= htmlspecialchars($error) ?></div>
        <?php } ?>
        <label for="username" class="form-label">Username</label>
        <input class="form-control" name="username" id="username">
    </div>
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('password') as $error) { ?>
            <div class="text-danger"><?= htmlspecialchars($error) ?></div>
        <?php } ?>
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
