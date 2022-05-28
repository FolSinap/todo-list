<?php

namespace Core\Controllers;

use Core\Models\Task;
use Core\Response;

class TaskController extends Controller
{
    protected const TASKS_PER_PAGE = 3;

    public function index(): Response
    {
        $request = $this->app->request();
        $page = $request->get('page') ?? 1;
        $tasks = (new Task($this->app->pdo()))->getForPage($page, self::TASKS_PER_PAGE);

        return $this->render('home', ['tasks' => $tasks]);
    }
}
