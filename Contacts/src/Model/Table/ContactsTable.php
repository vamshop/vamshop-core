<?php

namespace Vamshop\Contacts\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;

/**
 * Contact
 *
 * @category Model
 * @package  Vamshop.Contacts.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ContactsTable extends VamshopTable
{

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('vamshop', 'Title cannot be empty.'))
            ->notBlank('alias',  __d('vamshop', 'Alias cannot be empty.'))
            ->email('email', __d('vamshop', 'Not a valid email address.'));
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules
            ->add($rules->isUnique( ['alias'],
                __d('vamshop', 'That alias is already taken')
            ));
        return $rules;
    }

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->displayField('title');
        $this->entityClass('Vamshop/Contacts.Contact');
        $this->hasMany('Messages', [
            'className' => 'Vamshop/Contacts.Messages',
            'foreignKey' => 'contact_id',
            'dependent' => false,
            'limit' => '3',
        ]);
        $this->addBehavior('Vamshop/Core.Cached', [
            'groups' => ['contacts']
        ]);
        $this->addBehavior('Vamshop/Core.Trackable');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always',
                ],
            ],
        ]);
        $this->addBehavior('Search.Search');
    }

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'title',
        'alias',
        'email',
    ];
}
