<?php

namespace Vamshop\Taxonomy\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;

class TypesTable extends VamshopTable
{

/**
 * Display fields for this model
 *
 * @var array
 */
    protected $_displayFields = [
        'title' => [
            'url' => [
                'prefix' => false,
                'plugin' => 'Vamshop/Nodes',
                'controller' => 'Nodes',
                'action' => 'index',
                'named' => [
                    'alias' => 'type'
                ],
            ]
        ],
        'description',
    ];

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always'
                ]
            ]
        ]);
        $this->addBehavior('Vamshop/Core.Url', [
            'url' => [
                'plugin' => 'Vamshop/Nodes',
                'controller' => 'Nodes',
                'action' => 'index'
            ],
            'fields' => [
                'type' => 'alias'
            ]
        ]);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Vamshop/Core.Cached', [
            'groups' => ['nodes', 'taxonomy']
        ]);
        $this->addBehavior('Vamshop/Core.Trackable');
        $this->belongsToMany('Vamshop/Taxonomy.Vocabularies', [
            'joinTable' => 'types_vocabularies',
        ]);
    }

    /**
     * @param \Cake\Validation\Validator $validator Validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->notBlank('title', __d('vamshop', 'Title cannot be empty.'));
        $validator->notBlank('alias', __d('vamshop', 'Alias cannot be empty.'));
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(
            ['alias'],
            __d('vamshop', 'That alias is already taken.')
        ));
        return $rules;
    }

    /**
     * Get a list of relevant types for given plugin
     */
    public function pluginTypes($plugin = null)
    {
        if ($plugin === null) {
            $conditions = [];
        } elseif ($plugin) {
            $conditions = ['plugin' => $plugin];
        } else {
            $conditions = [
                'OR' => [
                    'plugin LIKE' => '',
                    'plugin' => null,
                ],
            ];
        }
        return $this->find('list', compact('conditions'));
    }

    protected function _initializeSchema(TableSchema $table)
    {
        $table->columnType('params', 'params');
        return parent::_initializeSchema($table);
    }

}
