<?php

namespace Code\Controller;


use Code\DB\Connection;
use Code\Entity\Product;
use Code\View\View;

class  ProductController
{
    public function index($id)
    {
        //$id = (int) $id;

        $pdo = Connection::getInstance();

       // $view = new View('site/single.phtml');

        var_dump((new Product($pdo))->where(['category_id '  => 2 ]));

        //return $view->render();
    }
}