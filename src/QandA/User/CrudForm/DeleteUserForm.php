<?php

namespace Anax\QandA\User\CrudForm;

use Anax\QandA\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class DeleteUserForm extends FormModel
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
                    "value" => "Delete",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    public function callbackSubmit()
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");

        $userID = $session->get("UserID");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $userID);
        $user->delete();

        $session->set("loggedin", false);
        return $response->redirect("user/login");
    }
}
