<?php

namespace MyFinancesBundle\Controller;

use MyFinancesBundle\Manager\CrudManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @const string
     */
    const MANAGER = 'my_finances.%s.manager';

    /**
     * @var string $class
     */
    protected $class;

    public function __construct()
    {
        $class = explode('\\', get_class($this));
        $this->class = str_replace('Controller', '', end($class));
    }

    /**
     * @return CrudManager
     */
    protected function getManager()
    {
        return $this->get(sprintf(self::MANAGER, strtolower($this->class)));
    }

    /**
     * @param Request $request
     *
     * @return []
     */
    protected function getPost(Request $request)
    {
        $data = [];
        $params = $request->request->all();

        if ($params) {
            $data = $params;
        } else {
            $decoded = json_decode(file_get_contents('php://input'), true);

            if (!json_last_error()) {
                $data = $decoded;
            }
        }

        return $data;
    }
}
