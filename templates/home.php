<?php $session = Core\Session::start() ?>
<?php if($session->has('success')) {?>
    <div class="text-success"><?= $session->get('success') ?></div>
<?php $session->unset('success');} ?>
<table class="table">
    <thead>
    <tr>
        <th scope="col"><a href="/?page=<?= $page ?>&sort=id&direct=<?= $direct === 'ASC' ? 'DESC' : 'ASC' ?>">#</a></th>
        <th scope="col"><a href="/?page=<?= $page ?>&sort=username&direct=<?= $direct === 'ASC' ? 'DESC' : 'ASC' ?>">Username</a></th>
        <th scope="col"><a href="/?page=<?= $page ?>&sort=email&direct=<?= $direct === 'ASC' ? 'DESC' : 'ASC' ?>">email</a></th>
        <th scope="col"><a href="/?page=<?= $page ?>&sort=body&direct=<?= $direct === 'ASC' ? 'DESC' : 'ASC' ?>">body</a></th>
        <?php if (\Core\Models\User::isLoggedIn()) { ?>
            <th scope="col"></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task) {?>
    <tr>
        <td><?= $task->id()?></td>
        <td><?= $task->username?></td>
        <td><?= $task->email?></td>
        <td><?= $task->body ?></td>
        <?php if (\Core\Models\User::isLoggedIn()) { ?>
            <td>
                <a href="/tasks/<?= $task->id()?>/edit">Edit</a>
            </td>
        <?php } ?>
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
