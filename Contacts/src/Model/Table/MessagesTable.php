<?php

namespace Vamshop\Contacts\Model\Table;

use Cake\Validation\Validator;
use Vamshop\Core\Model\Table\VamshopTable;

/**
 * Message
 *
 * @category Model
 * @package  Vamshop.Contacts.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.vamshop.com
 */
class MessagesTable extends VamshopTable
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->entityClass('Vamshop/Contacts.Message');
        $this->belongsTo('Contacts', [
            'className' => 'Vamshop/Contacts.Contacts',
            'foreignKey' => 'contact_id',
        ]);
        $this->addBehavior('CounterCache', [
            'Contacts' => ['message_count']
        ]);

        $this->addBehavior('Vamshop/Core.BulkProcess', [
            'actionsMap' => [
                'read' => 'bulkRead',
                'unread' => 'bulkUnread',
            ],
        ]);
        $this->addBehavior('Vamshop/Core.Trackable');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'updated' => 'always'
                ]
            ]
        ]);

        $this->searchManager()
            ->value('contact_id')
            ->add('created', 'Vamshop/Core.Date', [
                'field' => 'Messages.created'
            ])
            ->add('search', 'Search.Like', [
                'field' => [
                    'Messages.name', 'Messages.email', 'Messages.title',
                    'Messages.body',
                ],
                'before' => true,
                'after' => true,
            ])
            ->value('status', [
                'field' => $this->aliasField('status'),
            ]);
    }

    public function validationDefault(Validator $validator)
    {
        $notBlankMessage = __d('vamshop', 'This field cannot be left blank.');
        $validator->notBlank('name', $notBlankMessage);
        $validator->email('email', __d('vamshop', 'Please provide a valid email address.'));
        $validator->notBlank('title', $notBlankMessage);
        $validator->notBlank('body', $notBlankMessage);
        return $validator;
    }

/**
 * Mark messages as read in bulk
 *
 * @param array $ids Array of Message Ids
 * @return boolean True if successful, false otherwise
 */
    public function bulkRead($ids)
    {
        return $this->updateAll(
            ['status' => 1],
            [$this->aliasField('id') . ' IN' => $ids]
        );
    }

/**
 * Mark messages as Unread in bulk
 *
 * @param array $ids Array of Message Ids
 * @return boolean True if successful, false otherwise
 */
    public function bulkUnread($ids)
    {
        return $this->updateAll(
            ['status' => 0],
            [$this->aliasField('id') . ' IN' => $ids]
        );
    }
}
