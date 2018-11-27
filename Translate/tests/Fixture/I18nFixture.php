<?php

namespace Vamshop\Translate\Test\Fixture;

use Vamshop\Core\TestSuite\VamshopTestFixture;

class I18nFixture extends VamshopTestFixture
{

    public $name = 'I18n';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'locale' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 6],
        'model' => ['type' => 'string', 'null' => false, 'default' => null],
        'foreign_key' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 10],
        'field' => ['type' => 'string', 'null' => false, 'default' => null],
        'content' => ['type' => 'text', 'null' => true, 'default' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
            'locale' => ['type' => 'unique', 'columns' => ['locale', 'model', 'foreign_key', 'field']],
        ]
    ];

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
    ];
        parent::init();
    }
}
