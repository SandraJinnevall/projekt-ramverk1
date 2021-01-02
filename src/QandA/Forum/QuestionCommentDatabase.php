<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\Forum\QuestionComment;

use Anax\QandA\User\User;
use Anax\QandA\User\UserDatabase;

class QuestionCommentDatabase
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
            SELECT questioncommentid, questionid, comment, created, userid
              FROM QuestionComment
            ;
        ");

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questioncommentid, questionid, comment, created, userid
              FROM QuestionComment
              WHERE questioncommentid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getAllCommentByQuestionID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT questioncommentid, questionid, comment, created, userid
              FROM QuestionComment
              WHERE questionid = ?
             ;
         ", [$id]);

        return $data;
    }


    public function createNewComment($questionid, $comment, $created) : int
    {
        $this->db->connect()->execute("
            INSERT INTO QuestionComment(questionid, comment, created, userid)
            VALUES (?, ?, ?, ?)
            ;
        ", [
            $questionid,
            $comment,
            $created
        ]);
    }

    public function getAllCommentByUserIDAndUserInfo($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT q.questioncommentid,
                   q.questionid,
                   q.userid,
                   q.comment,
                   q.created,
                   u.id,
                   u.displayname,
                   u.img,
                   u.reputation
              FROM QuestionComment AS q
              INNER JOIN User AS u
                ON u.id = q.userid
             WHERE q.questionid = ?
            ;
        ", [$id]);

        return $data;
    }

    public function getCommentQuestion($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT qc.questioncommentid,
                   qc.questionid,
                   qc.comment,
                   qc.userid,
                   q.questionid,
                   q.title
              FROM QuestionComment AS qc
              INNER JOIN Question AS q
                ON q.questionid = qc.questionid
             WHERE qc.userid = ?
            ;
        ", [$id]);
        return $data;
    }
}
