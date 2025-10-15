<?php

namespace Statamic\Wikilinks;

use Statamic\Wikilinks\Modifiers\WikilinksModifier;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $modifiers = [
        WikilinksModifier::class,
    ];
}
