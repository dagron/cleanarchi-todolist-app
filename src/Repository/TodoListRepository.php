<?php
namespace App\Repository;




use App\Entity\TodoList;
use Doctrine\ORM\EntityManagerInterface;
use TodoList\Domain\Exception\TodoListCreationException;
use TodoList\Domain\Exception\TodoListDeletionException;
use TodoList\Domain\Exception\TodoListNotFoundException;
use TodoList\Domain\Repository\TodoListRepositoryInterface;
use TodoList\Domain\TodoListInterface;

class TodoListRepository implements TodoListRepositoryInterface
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

    /**
     * @param string $title
     * @return TodoListInterface
     */
    public function factory(string $title): TodoListInterface
    {
        $todolist = new TodoList();
        $todolist->setTitle($title);

        return $todolist;
    }

    /**
     * @param TodoListInterface $todoList
     * @return bool
     * @throws TodoListCreationException
     */
    public function save(TodoListInterface $todoList): bool
    {
        try {
            $this->em->persist($todoList);
            $this->em->flush();
        } catch(\Exception $exp) {
            throw TodoListCreationException::factory('Unable to create todolist', $exp);
        }

        return true;
    }

    /**
     * @param TodoListInterface $todoList
     * @return bool
     * @throws TodoListDeletionException
     */
    public function delete(TodoListInterface $todoList): bool
    {
        try {
            $this->em->detach($todoList);
            $this->em->flush();
        } catch(\Exception $exp) {
            throw TodoListDeletionException::factory($todoList, 'Unable to delete todolist', $exp);
        }

        return true;
    }

    public function findByTitle(string $title): TodoListInterface
    {
        // TODO: Implement findByTitle() method.
    }

    /**
     * @param int $todoListId
     * @return TodoListInterface
     * @throws TodoListNotFoundException
     */
    public function findById(int $todoListId): TodoListInterface
    {
        $todolist = $this->em->find(TodoList::class, $todoListId);
        if (null === $todolist) {
            throw TodoListNotFoundException::factoryById($todoListId);
        }

        return $todolist;
    }

    /**
     * @return TodoList[]|array|TodoListInterface[]
     */
    public function findAll()
    {
        return $this->em->getRepository(TodoList::class)->findAll();
    }
}