<?php

declare(strict_types=1);


namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};


class AuthController
{


    public function __construct(private TemplateEngine $view, private ValidatorService $validatorService, private UserService $userService)
    {
    }
    public function registerView()
    {

        echo $this->view->render('register.php');
    }

    //This method is going to responsible for processing the form submission request initiated by the user.
    public function register()
    {
        $this->validatorService->validateRegister($_POST);
    }
}
