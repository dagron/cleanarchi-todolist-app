<?php

namespace App\Controller;

use App\Entity\TodoList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TodoList\Domain\Exception\TodoListNotFoundException;
use TodoList\Domain\Request\CreateListRequest;
use TodoList\Domain\Request\DeleteListRequest;
use TodoList\Domain\Request\ListListsRequest;
use TodoList\Domain\Request\ViewListRequest;
use TodoList\Domain\UseCase\CreateListUseCase;
use TodoList\Domain\UseCase\DeleteListUseCase;
use TodoList\Domain\UseCase\ListListsUseCase;
use TodoList\Domain\UseCase\ViewListUseCase;

/**
 * Class ListController
 * @package App\Controller
 */
class ListController extends Controller
{
    /**
     * Shows all TodoLists
     *
     * @Route("/list", name="list_all")
     * @param ListListsUseCase $listListsUseCase
     * @return JsonResponse
     */
    public function all(ListListsUseCase $listListsUseCase)
    {
        $lists = $listListsUseCase->execute(new ListListsRequest());

        return new JsonResponse($lists->getTodoLists(), 200);
    }

    /**
     * Creates a new TodoList
     *
     * @Route("/list/create", name="list_create", methods={"POST"})
     * @param Request $request
     * @param CreateListUseCase $createListUseCase
     * @return Response
     */
    public function create(Request $request, CreateListUseCase $createListUseCase)
    {
        $form = $this->createFormBuilder(new TodoList(), [
            'method' => 'POST',
            'block_name' => ''
        ])
            ->add('title', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        // @todo block_name problem? :(
        $form->submit($request->request->all());

        // json pre-formatting
        $data = ['success' => false, 'errors' => [], 'list' => null];

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors(true, true) as $err) {
                $data['errors'][] = $err->getMessage();
            }

            return new JsonResponse($data, 417); // expectation failed
        }

        try {
            $todolist = $form->getData();
            $createResponse = $createListUseCase->execute(new CreateListRequest($todolist->getTitle()));
            $data['success'] = true;
            $data['list'] = $createResponse->getTodoList();
        } catch(\Exception $exp) {
            $data['errors'][] = $exp->getMessage();
            return new JsonResponse($data, 417); // server error
        }

        return new JsonResponse($data, 200);
    }

    /**
     * Shows one TodoList
     *
     * @Route("/list/{id}", name="list_one", requirements={"id": "[0-9]+"})
     * @param int $id
     * @param ViewListUseCase $viewListUseCase
     * @return Response
     */
    public function one(int $id, ViewListUseCase $viewListUseCase)
    {
        $request = new ViewListRequest($id);

        try {
            $response = $viewListUseCase->execute($request);
        } catch(TodoListNotFoundException $exp) {
            return new JsonResponse(['success' => false, 'error' => $exp->getMessage()], 404);
        } catch(\Exception $exp) {
            return new JsonResponse(['success' => false, 'error' => $exp->getMessage()], 500);
        }

        return new JsonResponse(['success' => false, 'list' => $response->getTodoList()], 200);
    }


    /**
     * Deletes a list
     *
     * @Route("/list/{id}/delete", name="list_delete", requirements={"id": "[0-9]+"})
     * @param int $id
     * @param DeleteListUseCase $deleteListUseCase
     * @return Response
     */
    public function delete(int $id, DeleteListUseCase $deleteListUseCase)
    {
        $request = new DeleteListRequest($id);

        try {
            $response = $deleteListUseCase->execute($request);
        } catch(TodoListNotFoundException $exp) {
            return new JsonResponse(['success' => false, 'error' => $exp->getMessage()], 404);
        } catch(\Exception $exp) {
            return new JsonResponse(['success' => false, 'error' => $exp->getMessage()], 500);
        }

        return new JsonResponse(['success' => true, 'list' => $response->getTodoList()], 200);
    }
}
