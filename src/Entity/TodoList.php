<?php
namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use TodoList\Domain\AbstractTodoList;
use TodoList\Domain\TaskInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TodoList
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="todolist_list")
 */
class TodoList extends AbstractTodoList
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
     * @Assert\NotBlank(message="Title cannot be empty")
     *
     * @var string
     */
    protected $title = "";

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="todolist", cascade={"persist", "remove", "refresh"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     *
     * @var Task[]
     */
    protected $tasks;

    /**
     * TodoList constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function addTask(TaskInterface $task): void
    {
        $this->tasks->add($task);
    }

    public function removeTask(TaskInterface $task): void
    {
        $this->tasks->removeElement($task);
    }

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
     * @param Task[] $tasks
     */
    public function setTasks(array $tasks): void
    {
        $this->tasks = $tasks;
    }
}