<?php

namespace Anax\QandA\User\CrudForm;

use Anax\QandA\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $session = $this->di->get("session");
        $userAcronym = $session->get("UserAcronym");
        $displayname = $session->get("DisplayName");
        $bio = $session->get("UserBio");
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Uppdatera din info",
            ],
            [
                "acronym" => [
                    "type"        => "text",
                    "placeholder" => "$userAcronym",
                ],

                "displaynamn" => [
                    "type"        => "text",
                    "placeholder" => "$displayname",
                ],

                "lösernord" => [
                    "type"        => "password",
                    "placeholder" => "***********",
                ],

                "lösernord-igen" => [
                    "type"        => "password",
                    "placeholder" => "***********",
                    // "validation" => [
                    //     "match" => "password"
                    // ],
                ],

                "bio" => [
                    "type"        => "text",
                    "placeholder" => "$bio",
                    "maxlength"   => "60",
                    // "placeholder" => "",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Uppdatera",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "button" => [
                    "type" => "submit",
                    "value" => "Radera mig från QandA",
                    "callback" => [$this, "callbackSubmitDelete"]
                ],
            ]
        );
    }

    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("acronym");
        $displayname   = $this->form->value("displaynamn");
        $password      = $this->form->value("lösernord");
        $passwordAgain = $this->form->value("lösernord-igen");
        $bio           = $this->form->value("bio");

        $session = $this->di->get("session");
        $userID = $session->get("UserID");

        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Lösernordet matchar inte.");
            return false;
        }
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $userID);
        if ($acronym !== "") {
            $user->acronym = $acronym;
            $session->set("UserAcronym", $user->getUserAcronym());
        }
        if ($displayname !== "") {
            $user->displayname = $displayname;
            $session->set("DisplayName", $user->getUserDisplayName());
        }
        if ($bio !== "") {
            $user->bio = $bio;
            $session->set("UserBio", $user->getUserBio());
        }
        if ($password !== "") {
            $user->setPassword($password);
        }
        $user->save();


        $this->form->addOutput("Din profil är nu uppdaterad!");
        return true;
    }

    public function callbackSubmitDelete()
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
