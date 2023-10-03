<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\ValidatorService;


//this is an array of factory function
//The key name for each item (TemplateEngine::class) acts as an ID for the dependency

return [
    TemplateEngine::class => fn () => new TemplateEngine(PATHS::VIEW),
    ValidatorService::class => fn () => new ValidatorService()

];
