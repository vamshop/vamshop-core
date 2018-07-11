<?php

namespace Vamshop\Blocks\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;

/**
 * Region
 *
 * @category Blocks.Model
 * @package  Vamshop.Blocks.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class RegionsTable extends VamshopTable
{

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'id',
        'title',
        'alias',
    ];

    /**
     * Find methods
     */
    public $findMethods = [
        'active' => true,
    ];

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('vamshop', 'Title cannot be empty.'))
            ->notBlank('alias', __d('vamshop', 'Alias cannot be empty.'));
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
        $this->entityClass('Vamshop/Blocks.Region');
        $this->addAssociations([
            'hasMany' => [
                'Blocks' => [
                    'className' => 'Vamshop/Blocks.Blocks',
                    'foreignKey' => 'region_id',
                    'dependent' => false,
                    'limit' => 3,
                ],
            ],
        ]);

        $this->addBehavior('Search.Search');
//        $this->addBehavior('Vamshop.Cached', [
//            'groups' => [
//                'blocks',
//            ],
//        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always',
                ],
            ],
        ]);
        $this->addBehavior('Vamshop/Core.Trackable');
        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->add('title', 'Search.Like', [
                'field' => $this->aliasField('title'),
                'before' => true,
                'after' => true,
            ]);
    }

    /**
     * Find Regions currently in use
     */
    public function findActive(Query $query)
    {
        return $query->where([
            'block_count >' => 0,
        ]);
    }
}
