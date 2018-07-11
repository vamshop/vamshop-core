<?php

namespace Croogo\Taxonomy\Model\Table;

use Croogo\Core\Model\Table\CroogoTable;

/**
 * ModelTaxonomies
 *
 * @category Taxonomy.Model
 * @package  Croogo.Taxonomy.Model
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class ModelTaxonomiesTable extends CroogoTable
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table('model_taxonomies');
    }

}
