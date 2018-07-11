<?php

$this->extend('/Common/admin_index');
$this->Vamshop->adminScript(array('Nodes.admin'));

$this->Html
	->add(__d('vamshop', 'Content'), array(
		'admin' => true,
		'plugin' => 'nodes',
		'controller' => 'nodes',
		'action' => 'index',
	));

if (isset($type) && $this->request->query):
	$typeUrl = '/' . $this->request->url;
	$typeUrl .= '?' . http_build_query($this->request->query);
	$this->Breadcrumbs->add($type['Type']['title'], $typeUrl);
endif;

$this->set('showActions', false);

$this->append('search', $this->element('admin/nodes_search'));

$this->append('form-start', $this->Form->create(
	'Node',
	array(
		'url' => array('controller' => 'nodes', 'action' => 'process'),
		'class' => 'form-inline'
	)
));

$this->start('table-heading');
	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Form->checkbox('checkAll'),
		__d('vamshop', 'Id'),
		__d('vamshop', 'Title'),
		__d('vamshop', 'Type'),
		__d('vamshop', 'User'),
		__d('vamshop', 'Status'),
		''
	));
	echo $this->Html->tag('thead', $tableHeaders);
$this->end();

$this->append('table-body');
?>
<tbody>
<?php foreach ($nodes as $node): ?>
	<tr>
		<td><?php echo $this->Form->checkbox('Node.' . $node['Node']['id'] . '.id', array('class' => 'row-select')); ?></td>
		<td><?php echo $node['Node']['id']; ?></td>
		<td class="level-<?php echo $node['Node']['depth']; ?>">
			<span>
			<?php
				echo $this->Html->link($node['Node']['title'], array(
					'admin' => false,
					'controller' => 'nodes',
					'action' => 'view',
					'type' => $node['Node']['type'],
					'slug' => $node['Node']['slug']
				));
			?>
			</span>

			<?php if ($node['Node']['promote'] == 1): ?>
			<span class="badge badge-info"><?php echo __d('vamshop', 'promoted'); ?></span>
			<?php endif ?>

			<?php if ($node['Node']['status'] == VamshopStatus::PREVIEW): ?>
			<span class="badge badge-warning"><?php echo __d('vamshop', 'preview'); ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php echo $node['Node']['type']; ?>
		</td>
		<td>
			<?php echo $node['User']['username']; ?>
		</td>
		<td>
			<?php
				echo $this->element('admin/toggle', array(
					'id' => $node['Node']['id'],
					'status' => (int)$node['Node']['status'],
				));
			?>
		</td>
		<td>
			<div class="item-actions">
			<?php
				echo $this->Vamshop->adminRowActions($node['Node']['id']);

				echo $this->Vamshop->adminRowAction('',
					array('controller' => 'nodes', 'action' => 'moveup', $node['Node']['id']),
					array('icon' => $this->Theme->getIcon('move-up'), 'tooltip' => __d('vamshop', 'Move up'),
				));
				echo $this->Vamshop->adminRowAction('',
					array('controller' => 'nodes', 'action' => 'movedown', $node['Node']['id']),
					array('icon' => $this->Theme->getIcon('move-down'), 'tooltip' => __d('vamshop', 'Move down'),
				));
				echo ' ' . $this->Vamshop->adminRowAction('',
					array('action' => 'edit', $node['Node']['id']),
					array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('vamshop', 'Edit this item'))
				);
				echo ' ' . $this->Vamshop->adminRowAction('',
					'#Node' . $node['Node']['id'] . 'Id',
					array(
						'icon' => $this->Theme->getIcon('delete'),
						'class' => 'delete',
						'tooltip' => __d('vamshop', 'Remove this item'),
						'rowAction' => 'delete',
					),
					__d('vamshop', 'Are you sure?')
				);
			?>
			</div>
		</td>
	</tr>
<?php endforeach ?>
</tbody>
<?php
$this->end();

$this->start('bulk-action');
	echo $this->Form->input('Node.action', array(
		'label' => __d('vamshop', 'Applying to selected'),
		'div' => 'input inline',
		'options' => array(
			'publish' => __d('vamshop', 'Publish'),
			'unpublish' => __d('vamshop', 'Unpublish'),
			'promote' => __d('vamshop', 'Promote'),
			'unpromote' => __d('vamshop', 'Unpromote'),
			'delete' => __d('vamshop', 'Delete'),
			'copy' => array(
				'value' => 'copy',
				'name' => __d('vamshop', 'Copy'),
				'hidden' => true,
			),
		),
		'empty' => true,
	));

	$jsVarName = uniqid('confirmMessage_');
	$button = $this->Form->button(__d('vamshop', 'Submit'), array(
		'type' => 'button',
		'class' => 'bulk-process',
		'data-relatedElement' => '#' . $this->Form->domId('Node.action'),
		'data-confirmMessage' => $jsVarName,
	));
	echo $this->Html->div('controls', $button);
	$this->Js->set($jsVarName, __d('vamshop', '%s selected items?'));
	$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();

$this->append('paging', ' ');

$this->append('form-end', $this->Form->end());
