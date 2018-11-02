<?php

namespace Vamshop\Nodes\Controller\Api\V10;

use Vamshop\Core\Controller\Api\AppController;

/**
 * Nodes Controller
 */
class NodesController extends AppController
{

    public function lookup()
    {
        return $this->Crud->execute();
    }

    public function add()
    {
        return $this->Crud->execute();
    }

    public function edit()
    {
        return $this->Crud->execute();
    }

    public function index()
    {
        return $this->Crud->execute();
    }
    
    public function delete()
    {
        return $this->Crud->execute();
    }
    
    public function view()
    {
        return $this->Crud->execute();
    }

    public function getName()
    {
    }

}
