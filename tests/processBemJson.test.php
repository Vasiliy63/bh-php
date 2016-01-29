<?php

use BEM\BH;
use BEM\Json;
use BEM\JsonCollection;

// Standard:
//   EN - https://en.bem.info/technology/bemjson/v2/bemjson/
//   RU - http://ru.bem.info/technology/bemjson/

class processBemJsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function setupBhInstance()
    {
        $this->bh = new BH();
    }

    public function test_it_should_create_empty_block_mods()
    {
        $this->assertEquals(
            new Json([
                'block' => 'button',
                'mods' => []
            ]),
            $this->bh->processBemJson([
                'block' => 'button'
            ])
        );
    }

    public function test_it_should_create_empty_elem_mods()
    {
        $this->assertEquals(
            new Json([
                'block' => 'button',
                'mods' => null,
                'elem' => 'control',
                'elemMods' => []
            ]),
            $this->bh->processBemJson([
                'block' => 'button',
                'elem' => 'control'
            ])
        );
    }

    public function test_it_should_inherit_block_mods()
    {
        $this->assertEquals(
            JsonCollection::normalize([
                'block' => 'button',
                'mods' => [ 'disabled' => true ],
                'content' => [
                    'block' => 'button',
                    'mods' => [ 'disabled' => true ],
                    'elem' => 'inner',
                    'elemMods' => []
                ]
            ])[0],
            $this->bh->processBemJson([
                'block' => 'button',
                'mods' => [ 'disabled' => true ],
                'content' => [ 'elem' => 'inner' ]
            ])
        );
    }

    public function test_it_should_use_elemMods_instead_of_mods_if_collision()
    {
        $this->assertEquals(
            JsonCollection::normalize([
                'block' => 'button',
                'mods' => [ 'valid' => true ],
                'elem' => 'inner',
                'elemMods' => [ 'disabled' => 'yes' ]
            ])[0],
            $this->bh->processBemJson([
                'block' => 'button',
                'mods' => [ 'valid' => true ],
                'elem' => 'inner',
                'elemMods' => [ 'disabled' => 'yes' ]
            ])
        );
    }
}
