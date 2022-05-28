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