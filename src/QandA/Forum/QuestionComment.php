<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class QuestionComment extends ActiveRecordModel
{
    protected $tableName = "QuestionComment";


    public $questioncommentid;
    public $questionid;
    public $comment;
    public $created;
    public $userid;

    public function getquestioncommentid() : int
    {
        return $this->questioncommentid;
    }

    public function getquestionid()
    {
        return $this->questionid;
    }

    public function getcomment()
    {
        return $this->comment;
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
