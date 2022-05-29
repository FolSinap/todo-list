<?php $session = Core\Session::start() ?>
<form method="post" action="/tasks/<?= $task->id() ?>/edit">
    <div class="mb-3">
        <?php foreach (Core\Validation\Validator::flashErrors('body') as $error) { ?>
            <div class="text-danger"><?= $error ?></div>
        <?php } ?>
        <label class="form-label" for="body">Body</label>
        <textarea class="form-control" id="body" name="body" rows="3" required><?= $task->body ?></textarea>
    </div>
    <div class="mb-3 form-check">
        <?php foreach (Core\Validation\Validator::flashErrors('is_done') as $error) { ?>
            <div class="text-danger"><?= $error ?></div>
        <?php } ?>
        <input type="checkbox" class="form-check-input" name="is_done" id="is_done">
        <label class="form-check-label" for="is_done">Done!</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
