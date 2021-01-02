<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\Forum\AnswerComment;

use Anax\QandA\User\User;
use Anax\QandA\User\UserDatabase;

class AnswerCommentDatabase
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
            SELECT answercommentid, answerid, userid, answercomment, created, questionid
              FROM AnswerComment
            ;
        ");

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT answercommentid, answerid, userid, answercomment, created, questionid
              FROM AnswerComment
              WHERE answercommentid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllCommentsByAnswerID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT answercommentid, answerid, userid, answercomment, created, questionid
              FROM AnswerComment
              WHERE answerid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllCommentsByUserIDAndAnswerID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT ac.answercommentid,
                   ac.answerid,
                   ac.userid,
                   ac.answercomment,
                   ac.questionid,
                   ac.created,
                   u.id,
                   u.displayname
              FROM AnswerComment AS ac
              INNER JOIN User AS u
                ON u.id = ac.userid
             WHERE ac.questionid = ?
            ;
        ", [$id]);

        return $data;
    }

    public function getCommentAnswers($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT ac.answercommentid,
                   ac.answerid,
                   ac.userid,
                   ac.answercomment,
                   ac.questionid,
                   ac.created,
                   q.questionid,
                   q.title
              FROM AnswerComment AS ac
              INNER JOIN Question AS q
                ON q.questionid = ac.questionid
             WHERE ac.userid = ?
            ;
        ", [$id]);
        return $data;
    }
}
