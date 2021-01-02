<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\Forum\QuestionAnswer;

use Anax\QandA\User\User;
use Anax\QandA\User\UserDatabase;

class QuestionAnswerDatabase
{
    /**
     * Database connection
     *
     * @var Database
     */
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT answerid, questionid, answer, created, userid
              FROM QuestionAnswer
            ;
        ");

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT answerid, questionid, answer, created, userid
              FROM QuestionAnswer
              WHERE answerid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllAnswersByQuestionID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT answerid, questionid, answer, created, userid
              FROM QuestionAnswer
              WHERE questionid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllAnswersByUserIDAndUserInfo($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT q.answerid,
                   q.questionid,
                   q.answer,
                   q.created,
                   q.userid,
                   u.id,
                   u.displayname,
                   u.img,
                   u.reputation
              FROM QuestionAnswer AS q
              INNER JOIN User AS u
                ON u.id = q.userid
             WHERE q.questionid = ?
            ;
        ", [$id]);

        return $data;
    }

    public function getAnswerdQuestion($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT qa.answerid,
                   qa.questionid,
                   qa.answer,
                   qa.created,
                   qa.userid,
                   q.questionid,
                   q.title
              FROM QuestionAnswer AS qa
              INNER JOIN Question AS q
                ON q.questionid = qa.questionid
             WHERE qa.userid = ?
            ;
        ", [$id]);
        return $data;
    }
}
