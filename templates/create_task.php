<?php $session = Core\Session::start() ?>
<form method="post" action="/tasks/create">
    <div class="mb-3">
        <?php if($session->has('errors.username')) {?>
            <?php foreach ($session->get('errors.username') as $error) { ?>
                <div class="text-danger"><?= $error ?></div>
            <?php } ?>
            <?php $session->unset('errors.username'); ?>
        <?php } ?>
        <label for="username" class="form-label">Username</label>
        <input class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <?php if($session->has('errors.email')) {?>
            <?php foreach ($session->get('errors.email') as $error) { ?>
                <div class="text-danger"><?= $error ?></div>
            <?php } ?>
            <?php $session->unset('errors.email'); ?>
        <?php } ?>
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
    </div>
    <div class="mb-3">
        <?php if($session->has('errors.body')) {?>
            <?php foreach ($session->get('errors.body') as $error) { ?>
                <div class="text-danger"><?= $error ?></div>
            <?php } ?>
            <?php $session->unset('errors.body'); ?>
        <?php } ?>
        <label class="form-label" for="body">Body</label>
        <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
