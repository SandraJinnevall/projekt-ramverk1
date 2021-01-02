<?php

namespace Anax\QandA\Forum\CrudForm;

use Anax\QandA\Forum\Tags;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

class CreateTagForm extends FormModel
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
                "tag" => [
                    "type"        => "text",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Send",
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
        $tag         = $this->form->value("tag");

        $tagsdatabase = $this->di->get("tagsdatabase");
        $result = $tagsdatabase->checkIfExist($tag);
        if (!empty($result)) {
            $this->form->addOutput("Tag already exist");
            return false;
        }

        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));
        $tags->tag = $tag;
        $tags->created = $tags->getTodayDate();
        $tags->reputation = 1;
        $tags->save();

        $this->form->addOutput("Tag is created.");
        return true;
    }
}
