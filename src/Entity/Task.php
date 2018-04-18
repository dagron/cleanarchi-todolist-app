<?php
namespace App\Entity;


use TodoList\Domain\AbstractTask;
use TodoList\Domain\TodoListInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="todolist_task")
 */
class Task extends AbstractTask
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Task title cannot be empty")
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="TodoList", inversedBy="tasks")
     * @ORM\JoinColumn(name="todolist_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotBlank(message="A Task should be in a TodoList")
     *
     * @var TodoList
     */
    protected $todolist;

    /**
     * @ORM\Column(type="boolean", name="is_done", options={"default": false})
     *
     * @var bool
     */
    protected $done = false;

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param TodoListInterface $todolist
     */
    public function setTodolist(TodoListInterface $todolist): void
    {
        $this->todolist = $todolist;
    }

    /**
     * @param bool $done
     */
    public function setDone(bool $done): void
    {
        $this->done = $done;
    }
}