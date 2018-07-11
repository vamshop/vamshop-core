<?php

namespace Vamshop\Nodes\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Vamshop\Acl\Traits\RowLevelAclTrait;

/**
 * @property string type Type of node
 * @property \Vamshop\Core\Link url
 */
class Node extends Entity
{

    use RowLevelAclTrait;

    use TranslateTrait;

}
