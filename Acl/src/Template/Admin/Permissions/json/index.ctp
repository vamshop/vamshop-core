<?php

$this->loadHelper('Vamshop/Core.Vamshop');
if (isset($this->request->query['urls'])) {
    foreach ($permissions as $acoId => &$aco) {
        $aco[key($aco)]['url'] = array(
            'up' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'moveup', $acoId, 'up'),
                array('icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'))
            ),
            'down' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'movedown', $acoId, 'down'),
                array('icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down'))
            ),
            'edit' => $this->Html->link('',
                array('controller' => 'Actions', 'action' => 'edit', $acoId),
                array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item'))
            ),
            'del' => $this->Vamshop->adminRowAction('',
                array('controller' => 'Actions', 'action' => 'delete', $acoId),
                array('icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('vamshop', 'Remove this item')),
                __d('vamshop', 'Are you sure?')
            ),
        );
    }
}
echo json_encode(compact('aros', 'permissions', 'level'));
