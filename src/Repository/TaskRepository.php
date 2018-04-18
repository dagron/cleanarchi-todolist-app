<?php
namespace App\Repository;


use Doctrine\ORM\EntityManagerInterface;
use TodoList\Domain\Exception\TaskCreationException;
use TodoList\Domain\Exception\TaskDeletionException;
use TodoList\Domain\Exception\TaskNotFoundException;
use TodoList\Domain\Repository\TaskRepositoryInterface;
use TodoList\Domain\TaskInterface;
use TodoList\Domain\TodoListInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * TodoListRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function factory(string $title, TodoListInterface $todoList, bool $done = false): TaskInterface
    {
        // TODO: Implement factory() method.
    }

    public function findById(int $taskId): TaskInterface
    {
        // TODO: Implement findById() method.
    }

    public function save(TaskInterface $task): bool
    {
        // TODO: Implement save() method.
    }

    public function delete(TaskInterface $task): bool
    {
        // TODO: Implement delete() method.
    }
}