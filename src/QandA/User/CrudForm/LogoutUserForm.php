<?php

namespace Anax\QandA\User\CrudForm;

use Anax\QandA\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class LogoutUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "submit" => [
                    "type" => "submit",
                    "value" => "Logout",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $session->set("loggedin", false);
        $session->delete("UserID");

        return $response->redirect("user/login");
    }
}
