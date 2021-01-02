<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class QuestionAnswer extends ActiveRecordModel
{
    protected $tableName = "QuestionAnswer";


    public $answerid;
    public $questionid;
    public $answer;
    public $created;
    public $userid;

    public function getquestioncommentid() : int
    {
        return $this->answerid;
    }

    public function getquestionid()
    {
        return $this->questionid;
    }

    public function getcomment()
    {
        return $this->answer;
    }

    public function getcreated()
    {
        return $this->created;
    }

    public function getuserid()
    {
        return $this->userid;
    }

    public function getTodayDate()
    {
        date_default_timezone_set("Europe/Stockholm");
        return date("Y-m-d h:i:sa");
    }
}
