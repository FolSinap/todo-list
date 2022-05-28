<?php $session = Core\Session::start() ?>
<form method="post" action="/tasks/create">
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('username') as $error) { ?>
                <div class="text-danger"><?= $error ?></div>
        <?php } ?>
        <label for="username" class="form-label">Username</label>
        <input class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('email') as $error) { ?>
            <div class="text-danger"><?= $error ?></div>
        <?php } ?>
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
    </div>
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('body') as $error) { ?>
            <div class="text-danger"><?= $error ?></div>
        <?php } ?>
        <label class="form-label" for="body">Body</label>
        <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
