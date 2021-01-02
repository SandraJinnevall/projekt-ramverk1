<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class Question extends ActiveRecordModel
{
    protected $tableName = "Question";


    public $questionid;
    public $userid;
    public $title;
    public $question;
    public $created;

    public function getQuestionId() : int
    {
        return $this->questionid;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getGuestion()
    {
        return $this->question;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getTodayDate()
    {
        date_default_timezone_set("Europe/Stockholm");
        return date("Y-m-d h:i:sa");
    }
}
