<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\Forum\Question;

use Anax\QandA\User\User;
use Anax\QandA\User\UserDatabase;

class QuestionDatabase
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
            SELECT questionid, userid, title, question, tags, created
              FROM Question
            ;
        ");

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questionid, userid, title, question, tags, created
              FROM Question
              WHERE questionid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllQuestionsByUserID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questionid, userid, title, question, tags, created
              FROM Question
              WHERE userid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllQuestionsByUserIDAndUserInfo($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT q.questionid,
                   q.userid,
                   q.title,
                   q.question,
                   q.tags,
                   q.created,
                   u.id,
                   u.displayname,
                   u.img,
                   u.reputation
              FROM Question AS q
              INNER JOIN User AS u
                ON u.id = q.userid
             WHERE q.questionid = ?
            ;
        ", [$id]);

        return $data;
    }

    public function getTitle() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT title
              FROM Question
            ;
        ");

        return $data;
    }

    public function getID() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questionid
              FROM Question
            ;
        ");

        return $data;
    }


    public function getNewestQuestions() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questionid, title
              FROM Question
              ORDER BY created DESC
              LIMIT 3
            ;
        ");

        return $data;
    }
}
