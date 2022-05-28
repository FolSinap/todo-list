<?php

namespace Core\Controllers;

use Core\Models\Task;
use Core\RedirectResponse;
use Core\Response;
use Core\Session;
use Core\Validation\Rules\EmailRule;
use Core\Validation\Rules\NotEmptyRule;
use Core\Validation\Validator;

class TaskController extends Controller
{
    protected const TASKS_PER_PAGE = 3;

    public function index(): Response
    {
        $request = $this->app->request();
        $page = $request->get('page') ?? 1;
        $nextPageExists = false;
        $tasks = (new Task($this->app->pdo()))->getForPage($page, self::TASKS_PER_PAGE, $nextPageExists);

        return $this->render('home', ['tasks' => $tasks, 'nextPageExists' => $nextPageExists, 'page' => $page]);
    }

    public function create(): Response
    {
        return $this->render('create_task');
    }

    public function store(): RedirectResponse
    {
        $notEmptyRule = new NotEmptyRule();
        $validator = new Validator([
            'email' => [new EmailRule(), $notEmptyRule],
            'username' => [$notEmptyRule],
            'body' => [$notEmptyRule],
        ]);
        $request = $this->app->request();

        if (!$validator->validate($request->getAll())) {
            return $this->redirect('/tasks/create');
        }

        $task = Task::new([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'body' => $request->get('body'),
            'is_done' => false,
        ]);
        $task->insert();
        Session::start()->set('success', 'Task has been created successfully!');

        return $this->redirect('/');
    }
}
