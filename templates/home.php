<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">email</th>
        <th scope="col">body</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task) {?>
    <tr>
        <th scope="row"><?= $task->id?></th>
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
                <a class="page-link" href="/?page=<?=$page - 1?>">Previous</a>
            </li>
            <li class="page-item <?php if(!$nextPageExists) echo 'disabled';?>">
                <a class="page-link" href="/?page=<?=$page + 1?>">Next</a>
            </li>
    </ul>
</nav>
