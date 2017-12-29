<?php

namespace MyFinancesBundle\Controller;

use MyFinancesBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

abstract class AbstractCrudController extends AbstractController
{
    /**
     * @var string $entityName
     */
    protected $entityName;

    /**
     * @var string $formName
     */
    protected $formName;

    public function __construct()
    {
        parent::__construct();

        $this->entityName = sprintf('\MyFinancesBundle\Entity\%s', $this->class);
        $this->formName   = sprintf('\MyFinancesBundle\Form\%sType', $this->class);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function showIndex($id)
    {
        $result = $this->getManager()->findById($id);

        if (!$result) {
            return new JsonResponse(['error' => sprintf('Not found with %d', $id)], JsonResponse::HTTP_NOT_FOUND);
        }

        $result = $this->serializer()->toArray($result);

        return new JsonResponse(['result' => $result]);
    }

    /**
     * @Route("/", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function indexAction()
    {   
        $results = $this->getManager()->findAll();
        $results = $this->serializer()->toArray($results);

        return new JsonResponse(['results' => $results]);
    }

    /**
     * @Route("/", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function newAction(Request $request)
    {
        $entity = new $this->entityName();
        $form   = $this->createForm(new $this->formName(), $entity);
   
        $form->submit($this->getPost($request));

        if ($form->isValid()) {
            $this->getManager()->persist($entity);
            $result = $this->serializer()->toArray($entity);

            return new JsonResponse(['result' => $result]);
        }

        return new JsonResponse(['errors' => $this->parseErrors($form)]);
    }

    /**
     * @Route("/{id}", methods={"PATCH"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function editAction(Request $request, $id)
    {
        $entity = $this->getManager()->findById($id);
        $form   = $this->createForm(new $this->formName(), $entity);

        $data = array_replace($this->serializer()->toArray($entity), $this->getPost($request));
        unset($data['id']);
        unset($data['total']);

        $form->submit($data);

        if ($form->isValid()) {
            $this->getManager()->persist($entity);
            $result = $this->serializer()->toArray($entity);

            return new JsonResponse(['result' => $result]);
        }

        return new JsonResponse(['errors' => $this->parseErrors($form)]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function removeAction($id)
    {
        $entity = $this->getManager()->findById($id);
        $this->getManager()->remove($entity);

        return new JsonResponse(['result' => $this->serializer()->toArray($entity)]);
    }

    /**
     * @param Form $form
     *
     * @return array
     */
    private function parseErrors(Form $form)
    {
        $errors = array_filter(explode('.' . PHP_EOL, $form->getErrorsAsString()));

        return array_map(function($error) {
            return str_replace([PHP_EOL, '    '], ' ', $error);
        }, $errors);
    }

    /**
     * @return Serializer
     */
    private function serializer()
    {
        return $this->get('my_finances.serializer');
    }
}
