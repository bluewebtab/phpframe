<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;


//this is an array of factory function
//The key name for each item (TemplateEngine::class) acts as an ID for the dependency

return [
    TemplateEngine::class => fn () => new TemplateEngine(PATHS::VIEW)
];
