<?php

namespace Vamshop\Users\Model\Table;

use Vamshop\Core\Model\Table\VamshopTable;

class RolesTable extends VamshopTable
{

    const ROLE_REGISTERED = 2;

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'title',
        'alias',
    ];

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Acl.Acl', [
            'className' => 'Vamshop/Core.VamshopAcl',
            'type' => 'requester'
        ]);
        $this->addBehavior('Search.Search');
    }
}
