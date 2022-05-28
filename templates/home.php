<?php $session = Core\Session::start() ?>
<?php if($session->has('success')) {?>
    <div class="text-success"><?= $session->get('success') ?></div>
<?php $session->unset('success');} ?>
<table class="table">
    <thead>
    <tr>
        <th scope="col"><a href="/?page=<?= $page ?>&sort=id&direct=<?= $direct === 'ASC' ? 'DESC' : 'ASC' ?>">#</a></th>
        <th scope="col">Username</th>
        <th scope="col">email</th>
        <th scope="col">body</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task) {?>
    <tr>
        <td><?= $task->id()?></td>
        <td><?= $task->username?></td>
        <td><?= $task->email?></td>
        <td><?= $task->body ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<nav>
    <ul class="pagination justify-content-center">
            <li class="page-item <?php if($page <= 1) echo 'disabled';?>">
                <a class="page-link" href="/?<?='page=' . ($page - 1) . "&sort=$sort&direct=$direct"?>">Previous</a>
            </li>
            <li class="page-item <?php if(!$nextPageExists) echo 'disabled';?>">
                <a class="page-link" href="/?<?='page=' . ($page + 1). "&sort=$sort&direct=$direct"?>">Next</a>
            </li>
    </ul>
</nav>
