<?php

use BEM\BH;

class bhApplyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function setupBhInstance()
    {
        $this->bh = new BH();
    }

    public function test_it_should_return_empty_string_on_null_bemjson()
    {
        $this->assertEquals('', $this->bh->apply(null));
    }

    public function test_it_should_return_empty_string_on_falsy_template_result()
    {
        $this->bh->match('link', function ($ctx, $json) {
            if (empty($json->url)) {
                return false;
            }
        });
        $this->assertEquals(
            '',
            $this->bh->apply(['block' => 'link']));
    }
}
