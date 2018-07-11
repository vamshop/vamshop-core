<?php

namespace Vamshop\Taxonomy\Model\Table;

use Vamshop\Core\Model\Table\VamshopTable;

/**
 * ModelTaxonomies
 *
 * @category Taxonomy.Model
 * @package  Vamshop.Taxonomy.Model
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ModelTaxonomiesTable extends VamshopTable
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table('model_taxonomies');
    }

}
