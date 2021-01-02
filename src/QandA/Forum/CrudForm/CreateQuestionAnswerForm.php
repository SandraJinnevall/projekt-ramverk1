<?php

namespace Anax\QandA\Forum\CrudForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\QandA\Forum\QuestionAnswer;

class CreateQuestionAnswerForm extends FormModel
{
    public function __construct(ContainerInterface $di, $questionid)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "answer" => [
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
        $answer = $this->form->value("answer");
        $questionid = $this->form->value("hidden");
        $session = $this->di->get("session");
        $userID = $session->get("UserID");
        $userdatabase = $this->di->get("userdatabase");
        $userdatabase->updateRep($userID);

        $questionanswer = new QuestionAnswer();
        $questionanswer->setDb($this->di->get("dbqb"));
        $questionanswer->questionid = $questionid;
        $questionanswer->created = $questionanswer->getTodayDate();
        $questionanswer->answer = $answer;
        $questionanswer->userid = $userID;
        $questionanswer->save();


        $this->form->addOutput("Answer is created.");
        return true;
    }
}
