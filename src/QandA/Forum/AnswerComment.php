<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class AnswerComment extends ActiveRecordModel
{
    protected $tableName = "AnswerComment";


    public $answercommentid;
    public $answerid;
    public $userid;
    public $questionid;
    public $answercomment;
    public $created;

    public function getTodayDate()
    {
        date_default_timezone_set("Europe/Stockholm");
        return date("Y-m-d h:i:sa");
    }
}
