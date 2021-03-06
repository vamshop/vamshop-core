<?php

namespace Vamshop\Blocks\Model\Table;

use Cake\Cache\Cache;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;
use Vamshop\Core\Status;

/**
 * Block
 *
 * @category Blocks.Model
 * @package  Vamshop.Blocks.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class BlocksTable extends VamshopTable
{

    /**
     * Find methods
     */
    public $findMethods = [
        'published' => true,
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
        $this->entityClass('Vamshop/Blocks.Block');

        $this->belongsTo('Regions', [
            'className' => 'Vamshop/Blocks.Regions',
            'foreignKey' => 'region_id',
            'counterCache' => true,
            'counterScope' => ['Blocks.status >=' => Status::PUBLISHED],
        ]);

        $this->addBehavior('CounterCache', [
            'Regions' => ['block_count'],
        ]);
        $this->addBehavior('Vamshop/Core.Publishable');
        $this->addBehavior('Vamshop/Core.Visibility');
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
            'scope' => ['region_id'],
        ]);
        $this->addBehavior('Vamshop/Core.Cached', [
            'groups' => [
                'blocks',
            ],
        ]);

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
            ->value('region_id')
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => $this->aliasField('title')
            ]);
    }

    protected function _initializeSchema(TableSchema $table)
    {
        $table->columnType('visibility_roles', 'encoded');
        $table->columnType('visibility_paths', 'encoded');
        $table->columnType('params', 'params');

        return parent::_initializeSchema($table);
    }

    public function afterSave()
    {
        Cache::clear(false, 'vamshop_blocks');
    }

    public function findPublished(Query $query, array $options = [])
    {
        $options += ['roleId' => null];

        return $query->andWhere([
            $this->aliasField('status') . ' IN' => $this->status($options['roleId']),
        ]);
    }

    /**
     * Find Published blocks
     *
     * Query options:
     * - status Status
     * - regionId Region Id
     * - roleId Role Id
     * - cacheKey Cache key (optional)
     */
    public function findRegionPublished(Query $query, array $options = [])
    {
        $options += [
            'regionId' => null,
        ];

        return $query
            ->find('published', $options)
            ->find('byAccess', $options)
            ->where([
                'region_id IN' => $options['regionId']
            ]);
    }
}
