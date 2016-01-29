<?php

use BEM\BH;

class tagTest extends PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public function setupBhInstance()
    {
        $this->bh = new BH();
    }

    public function test_it_should_return_html_tag()
    {
        $this->bh->match('button', function ($ctx) {
            $this->assertEquals(
                'button',
                $ctx->tag()
            );
        });
        $this->bh->apply(['block' => 'button', 'tag' => 'button']);
    }

    public function test_it_should_set_empty_tag()
    {
        $this->bh->match('link', function ($ctx) {
            $ctx->tag('');
        });
        $this->bh->match('button', function ($ctx) {
            $ctx->tag(false);
        });
        $this->assertEquals(
            'link',
            $this->bh->apply(['block' => 'button', 'content' => ['block' => 'link', 'content' => 'link']])
        );
    }

    public function test_it_should_set_html_tag()
    {
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('button');
        });
        $this->assertEquals(
            '<button class="button"></button>',
            $this->bh->apply(['block' => 'button'])
        );
    }

    public function test_it_should_not_override_user_tag()
    {
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('button');
        });
        $this->assertEquals(
            '<a class="button"></a>',
            $this->bh->apply(['block' => 'button', 'tag' => 'a'])
        );
    }

    public function test_it_should_not_override_later_declarations()
    {
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('input');
        });
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('button');
        });
        $this->assertEquals(
            '<button class="button"></button>',
            $this->bh->apply(['block' => 'button'])
        );
    }

    public function test_it_should_override_later_declarations_with_force_flag()
    {
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('input', true);
        });
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('button');
        });
        $this->assertEquals(
            '<input class="button"/>',
            $this->bh->apply(['block' => 'button'])
        );
    }

    public function test_it_should_override_user_declarations_with_force_flag()
    {
        $this->bh->match('button', function ($ctx) {
            $ctx->tag('button', true);
        });
        $this->assertEquals(
            '<button class="button"></button>',
            $this->bh->apply(['block' => 'button', 'tag' => 'a'])
        );
    }
}
