<?php

namespace Anax\QandA\User\CrudForm;

use Anax\QandA\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

class CreateUserForm extends FormModel
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
                "legend" => "Skapa en användare",
            ],
            [
                "email" => [
                    "type"        => "text",
                ],

                "lösenord" => [
                    "type"        => "password",
                ],

                "lösenord-igen" => [
                    "type"        => "password",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skapa",
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
        // Get values from the submitted form
        $acronym       = $this->form->value("email");
        $password      = $this->form->value("lösenord");
        $passwordAgain = $this->form->value("lösenord-igen");

        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Lösernordet matchar inte");
            return false;
        }

        $username = "User".rand();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        if ($user->verifyPassword($acronym, $password)) {
            $this->form->addOutput("Användare finns redan");
            return false;
        }

        $user->acronym = $acronym;
        $user->displayname = $username;
        $user->setPassword($password);
        $user->img = $user->getImg($acronym);
        $user->created = $user->getTodayDate();
        $user->reputation = 1;
        $user->save();
        $this->form->addOutput("Grattis! Du kan nu logga in med din nya användare!");
        return true;
    }
}
