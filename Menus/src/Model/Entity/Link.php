<?php

namespace Vamshop\Menus\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Vamshop\Acl\Traits\RowLevelAclTrait;

class Link extends Entity
{

    use RowLevelAclTrait;

    use TranslateTrait;

}
