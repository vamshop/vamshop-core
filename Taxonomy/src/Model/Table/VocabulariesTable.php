<?php

namespace Vamshop\Taxonomy\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;

/**
 * @property TaxonomiesTable Taxonomies
 */
class VocabulariesTable extends VamshopTable
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always'
                ]
            ]
        ]);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Vamshop/Core.Cached', [
            'groups' => ['taxonomy']
        ]);
        $this->belongsToMany('Vamshop/Taxonomy.Types', [
            'joinTable' => 'types_vocabularies',
        ]);
        $this->hasMany('Vamshop/Taxonomy.Taxonomies', [
            'dependent' => true,
        ]);
    }

    /**
     * @param \Cake\Validation\Validator $validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('vamshop', 'The title cannot be empty'))
            ->notBlank('alias', __d('vamshop', 'The alias cannot be empty'));

        return parent::validationDefault($validator);
    }

    /**
     * @param \Cake\ORM\RulesChecker $rules
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(
            ['alias'],
            __d('vamshop', 'That alias is already taken')
        ));
        return parent::buildRules($rules);
    }
}
