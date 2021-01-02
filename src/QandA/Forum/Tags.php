<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class Tags extends ActiveRecordModel
{
    protected $tableName = "Tags";


    public $tagid;
    public $tag;
    public $created;

    public function getTagID() : int
    {
        return $this->tagid;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function getTodayDate()
    {
        date_default_timezone_set("Europe/Stockholm");
        return date("Y-m-d h:i:sa");
    }
}
