<?php

namespace Anax\QandA\Forum\CrudForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\QandA\Forum\QuestionComment;

class CreateCommentQuestionForm extends FormModel
{
    public function __construct(ContainerInterface $di, $questionid)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "comment" => [
                    "type"        => "text",
                ],

                "hidden" => [
                    "type"        => "hidden",
                    "value"       => "$questionid",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Send",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    public function callbackSubmit()
    {
        $comment = $this->form->value("comment");
        $questionid = $this->form->value("hidden");
        $session = $this->di->get("session");
        $userID = $session->get("UserID");
        $userdatabase = $this->di->get("userdatabase");
        $userdatabase->updateRep($userID);


        $questioncomment = new QuestionComment();
        $questioncomment->setDb($this->di->get("dbqb"));
        $questioncomment->questionid = $questionid;
        $questioncomment->created = $questioncomment->getTodayDate();
        $questioncomment->comment = $comment;
        $questioncomment->userid = $userID;
        $questioncomment->save();

        $this->form->addOutput("Comment is created.");
        return true;
    }
}
