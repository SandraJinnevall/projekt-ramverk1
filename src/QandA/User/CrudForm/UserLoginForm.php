<?php

namespace Anax\QandA\User\CrudForm;

use Anax\QandA\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "id" => __CLASS__,
                "legend" => "Logga in"
            ],
            [
                "email" => [
                    "type"        => "text",
                    // "description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "lösenord" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "button" => [
                    "type" => "submit",
                    "value" => "Skapa användare",
                    "callback" => [$this, "callbackCreate"]
                ],
            ]
        );
    }


    public function callbackCreate()
    {
        return $this->di->get("response")->redirect("user/create");
    }

    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("email");
        $password      = $this->form->value("lösenord");

        $session = $this->di->get("session");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        if ($user->verifyPassword($acronym, $password)) {
            $res = $user->verifyPassword($acronym, $password);
            $user->find("id", $this->form->value("id"));
            $user->active = $user->getTodayDate();
            $user->save();

            if (!$res) {
                $this->form->rememberValues();
                $this->form->addOutput("Användare eller lösenord matchar inte.");
                return false;
            }

            $session->set("loggedin", true);
            $session->set("UserID", $user->getUserId());
            $session->set("UserBio", $user->getUserBio());

            return $this->di->get("response")->redirect("user/loggedin");
        }
        $this->form->addOutput("Användaren finns inte");
        return false;
    }
}
