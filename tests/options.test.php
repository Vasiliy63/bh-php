<?php

use BEM\BH;

class optionsTestJsAttr extends PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function setupBhInstance()
    {
        $this->bh = new BH();
    }

    public function test_it_should_use_onclick_and_js_format_as_default()
    {
        $this->assertEquals(
            '<div class="button i-bem" onclick="return {&quot;button&quot;:{}}"></div>',
            $this->bh->apply(['block' => 'button', 'js' => true]));
    }

    public function test_it_should_return_current_options()
    {
        $this->bh->setOptions(['foo' => 'bar']);
        $this->assertEquals(
            ['foo' => 'bar'],
            $this->bh->getOptions());
    }

    public function test_it_should_use_js_format_as_default_and_use_jsAttrName_option()
    {
        $this->bh->setOptions([
            'jsAttrName' => 'ondblclick'
        ]);
        $this->assertEquals(
            '<div class="button i-bem" ondblclick="return {&quot;button&quot;:{}}"></div>',
            $this->bh->apply(['block' => 'button', 'js' => true]));
    }

    public function test_it_should_use_onclick_as_default_and_use_jsAttrScheme_option()
    {
        $this->bh->setOptions([
            'jsAttrScheme' => 'json'
        ]);
        $this->assertEquals(
            '<div class="button i-bem" onclick="{&quot;button&quot;:{}}"></div>',
            $this->bh->apply(['block' => 'button', 'js' => true]));
    }

    public function test_it_should_use_jsAttrName_and_jsAttrScheme_options_()
    {
        $this->bh->setOptions([
            'jsAttrName' => 'data-bem',
            'jsAttrScheme' => 'json'
        ]);
        $this->assertEquals(
            '<div class="button i-bem" data-bem="{&quot;button&quot;:{}}"></div>',
            $this->bh->apply(['block' => 'button', 'js' => true]));
    }

    public function test_it_should_use_jsCls_option()
    {
        $this->bh->setOptions([ 'jsCls' => 'js' ]);
        $this->assertEquals(
            '<div class="button js" onclick="return {&quot;button&quot;:{}}"></div>',
            $this->bh->apply([ 'block' => 'button', 'js' => true ])
        );
    }

    public function test_it_should_use_empty_jsCls_option()
    {
        $this->bh->setOptions([ 'jsCls' => false ]);
        $this->assertEquals(
            '<div class="button" onclick="return {&quot;button&quot;:{}}"></div>',
            $this->bh->apply([ 'block' => 'button', 'js' => true ])
        );
    }

    public function test_it_should_use_jsElem_option()
    {
        $this->bh->setOptions([ 'jsElem' => false ]);
        $this->assertEquals(
           '<div class="button__box" onclick="return {&quot;button__box&quot;:{}}"></div>',
            $this->bh->apply([ 'block' => 'button', 'elem' => 'box', 'js' => true ])
        );
    }

    public function test_it_should_use_jsElem_option_for_mixed_element()
    {
        $this->bh->setOptions([ 'jsElem' => false ]);
        $this->assertEquals(
            '<div class="button__box icon__wrap" onclick="return {&quot;icon__wrap&quot;:{}}"></div>',
            $this->bh->apply([ 'block' => 'button', 'elem' => 'box', 'mix' => [ 'block' => 'icon', 'elem' => 'wrap', 'js' => true ] ])
        );
    }

    public function test_it_should_use_clsNobaseMods_options()
    {
        $this->bh->setOptions([ 'clsNobaseMods' => true ]);
        $this->assertEquals(
            '<div class="button _disabled _theme_new clearfix button__box _pick_left">' .
                '<div class="button__control _disabled"></div>' .
            '</div>',
            $this->bh->apply([
                'block' => 'button',
                'mods' => [ 'disabled' => true, 'theme' => 'new' ],
                'mix' => [
                    [ 'block' => 'clearfix' ],
                    [ 'elem' => 'box', 'elemMods' => [ 'pick' => 'left' ] ]
                ],
                'content' => [
                    'elem' => 'control',
                    'elemMods' => [ 'disabled' => true ]
                ]
            ])
        );
    }
}
