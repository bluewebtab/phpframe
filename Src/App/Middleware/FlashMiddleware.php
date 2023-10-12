<?php


declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;



class FlashMiddleware implements MiddlewareInterface
{

    public function __construct(private TemplateEngine $view)
    {
    }

    public function process(callable $next)
    {
        // '??': It returns its first operand if it exists and is not NULL; otherwise it returns its second operand.
        //made an 'errors' variable
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []);



        //unset is defined by php and it can destroy variables or specific items in an array.
        unset($_SESSION['errors']);
        $this->view->addGlobal('oldFormData', $_SESSION['oldFormData'] ?? []);

        unset($_SESSION['oldFormData']);
        $next();
    }
}
