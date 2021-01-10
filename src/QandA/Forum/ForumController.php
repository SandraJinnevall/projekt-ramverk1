<?php

namespace Anax\QandA\Forum;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\QandA\Forum\CrudForm\CreateQuestionForm;
use Anax\QandA\Forum\CrudForm\CreateTagForm;
use Anax\QandA\Forum\CrudForm\CreateCommentQuestionForm;
use Anax\QandA\Forum\CrudForm\CreateQuestionAnswerForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class ForumController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $questiondatabase = $this->di->get("questiondatabase");
        $questions = $questiondatabase->getNewestQuestions();

        if (!is_array($questions)) {
            $questions = array($questions);
        }

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->getMostPopularTags();

        $userdatabase = $this->di->get("userdatabase");
        $user = $userdatabase->getMostActive();

        if (!is_array($tags)) {
            $tags = array($tags);
        }

        if (!is_array($user)) {
            $user = array($user);
        }

        $page->add("forum/startpage", [
            "tags" => $tags,
            "questions" => $questions,
            "user" => $user
        ]);

        return $page->render([
            "title" => "Start",
        ]);
    }

    public function questionsActionGet() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $questiondatabase = $this->di->get("questiondatabase");
        $questions = $questiondatabase->getAll();

        if (!is_array($questions)) {
            $questions = array($questions);
        }

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();

        if (!is_array($tags)) {
            $tags = array($tags);
        }
        $message = "";

        $page->add("forum/displayquestions", [
            "tags" => $tags,
            "questions" => $questions,
            "message" => $message,
            "loggedin" => $session->get("loggedin"),

        ]);

        return $page->render([
            "title" => "Frågor",
        ]);
    }

    public function questionsActionPost() : object
    {
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $userID = $session->get("UserID");

        $questiondatabase = $this->di->get("questiondatabase");

        $questions = $questiondatabase->getAll();

        if (!is_array($questions)) {
            $questions = array($questions);
        }

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();

        if (!is_array($tags)) {
            $tags = array($tags);
        }

        $message = "Din fråga är skapad!";

        $page->add("forum/displayquestions", [
            "tags" => $tags,
            "questions" => $questions,
            "message" => $message,
            "loggedin" => $session->get("loggedin"),
        ]);

        $questionTitle = \htmlentities($request->getPost("title"));
        $questionBody = \htmlentities($request->getPost("body"));
        $questionTags = "";
        foreach ($request->getPost("tags", []) as $tag) {
            $questionTags .= \htmlentities($tag) . " ";
            $tagsdatabase->updateRep($tag);
        }

        $questions = new Question();
        $questions->setDb($this->di->get("dbqb"));
        $questions->userid = $userID;
        $questions->created = $questions->getTodayDate();
        $questions->title = $questionTitle;
        $questions->question = $questionBody;
        $questions->tags = $questionTags;
        $questions->save();

        $userdatabase = $this->di->get("userdatabase");
        $userdatabase->updateRep($userID);

        header("Refresh: 0");

        return $page->render([
            "title" => "Frågor",
        ]);
    }

    public function displayquestionActionGet($id) : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $questiondatabase = $this->di->get("questiondatabase");
        $question = $questiondatabase->getAllQuestionsByUserIDAndUserInfo($id);
        if (!is_array($question)) {
            $question = array($question);
        }

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();
        if (!is_array($tags)) {
            $tags = array($tags);
        }

        $commentquestion = $this->di->get("questioncommentdatabase");
        $cquestion = $commentquestion->getAllCommentByUserIDAndUserInfo($id);
        if (!is_array($cquestion)) {
            $cquestion = array($cquestion);
        }

        $answerquestion = $this->di->get("questionanswerdatabase");
        $aquestion = $answerquestion->getAllAnswersByUserIDAndUserInfo($id);
        if (!is_array($aquestion)) {
            $aquestion = array($aquestion);
        }

        $answercomment = $this->di->get("answercommentdatabase");
        $acomment = $answercomment->getAllCommentsByUserIDAndAnswerID($id);
        if (!is_array($acomment)) {
            $acomment = array($acomment);
        }

        $page->add("forum/displayquestion", [
            "tags" => $tags,
            "question" => $question,
            "id" => $id,
            "cq" => $cquestion,
            "aq" => $aquestion,
            "ac" => $acomment,
            "loggedin" => $session->get("loggedin"),
        ]);


        return $page->render([
            "title" => "Fråga",
        ]);
    }

    public function displayquestionActionPost($id) : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $userID = $session->get("UserID");
        $request = $this->di->get("request");

        $questiondatabase = $this->di->get("questiondatabase");
        $question = $questiondatabase->getAllQuestionsByUserIDAndUserInfo($id);

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();

        $commentquestion = $this->di->get("questioncommentdatabase");
        $cquestion = $commentquestion->getAllCommentByUserIDAndUserInfo($id);

        $answerquestion = $this->di->get("questionanswerdatabase");
        $aquestion = $answerquestion->getAllAnswersByUserIDAndUserInfo($id);

        $answercomment = $this->di->get("answercommentdatabase");
        $acomment = $answercomment->getAllCommentsByUserIDAndAnswerID($id);

        $page->add("forum/displayquestion", [
            "tags" => $tags,
            "question" => $question,
            "id" => $id,
            "cq" => $cquestion,
            "aq" => $aquestion,
            "ac" => $acomment,
            "loggedin" => $session->get("loggedin"),
        ]);

        $btncomment = \htmlentities($request->getPost("btncomment"));

        if ($btncomment) {
            $comment = \htmlentities($request->getPost("comment"));
            $questioncomment = new QuestionComment();
            $questioncomment->setDb($this->di->get("dbqb"));
            $questioncomment->questionid = $id;
            $questioncomment->created = $questioncomment->getTodayDate();
            $questioncomment->comment = $comment;
            $questioncomment->userid = $userID;
            $questioncomment->save();

            $userdatabase = $this->di->get("userdatabase");
            $userdatabase->updateRep($userID);
        }

        $btnanswer = \htmlentities($request->getPost("btnanswer"));
        if ($btnanswer) {
            $answer = \htmlentities($request->getPost("answer"));
            $questionanswer = new QuestionAnswer();
            $questionanswer->setDb($this->di->get("dbqb"));
            $questionanswer->questionid = $id;
            $questionanswer->created = $questionanswer->getTodayDate();
            $questionanswer->answer = $answer;
            $questionanswer->userid = $userID;
            $questionanswer->save();

            $userdatabase = $this->di->get("userdatabase");
            $userdatabase->updateRep($userID);
        }

        foreach ($aquestion as $a) {
            $answercomment = \htmlentities($request->getPost($a->answerid));
            if ($answercomment) {
                $answerc = \htmlentities($request->getPost("comment"));
                $answerid = \htmlentities($request->getPost("id"));
                $answercomment = new AnswerComment();
                $answercomment->setDb($this->di->get("dbqb"));
                $answercomment->answerid = $answerid;
                $answercomment->created = $answercomment->getTodayDate();
                $answercomment->questionid = $id;
                $answercomment->userid = $userID;
                $answercomment->answercomment = $answerc;
                $answercomment->save();
                $userdatabase = $this->di->get("userdatabase");
                $userdatabase->updateRep($userID);
            }
        }
        header("Refresh: 0");
        return $page->render([
            "title" => "Fråga",
        ]);
    }

    public function tagsActionGet() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();

        if (!is_array($tags)) {
            $tags = array($tags);
        }

        $message = "";

        $page->add("forum/displaytags", [
            "tags" => $tags,
            "loggedin" => $session->get("loggedin"),
            "message" => $message
        ]);

        return $page->render([
            "title" => "Taggar",
        ]);
    }

    public function tagsActionPost() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $request = $this->di->get("request");

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->all();

        if (!is_array($tags)) {
            $tags = array($tags);
        }


        $tag = \htmlentities($request->getPost("tag"));
        $tagsdatabase = $this->di->get("tagsdatabase");
        $result = $tagsdatabase->checkIfExist($tag);
        if (!empty($result)) {
            $message = "Taggen finns redan";
            $page->add("forum/displaytags", [
                "tags" => $tags,
                "loggedin" => $session->get("loggedin"),
                "message" => $message
            ]);
            return $page->render([
                "title" => "Taggar",
            ]);
        }

        $newtag = new Tags();
        $newtag->setDb($this->di->get("dbqb"));
        $newtag->tag = $tag;
        $newtag->created = $newtag->getTodayDate();
        $newtag->reputation = 1;
        $newtag->save();

        $message = "";

        $page->add("forum/displaytags", [
            "tags" => $tags,
            "loggedin" => $session->get("loggedin"),
            "message" => $message
        ]);

        header("Refresh: 0");
        return $page->render([
            "title" => "Taggar",
        ]);
    }

    public function displayquestionswithtagAction($id) : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $tagsdatabase = $this->di->get("tagsdatabase");
        $tags = $tagsdatabase->getAllByID($id);

        $questiondatabase = $this->di->get("questiondatabase");
        $questions = $questiondatabase->getAll();

        if (!is_array($tags)) {
            $tags = array($tags);
        }

        if (!is_array($questions)) {
            $questions = array($questions);
        }

        $questionWithTag=array();
        foreach ($tags as $t) {
            foreach ($questions as $q) {
                // print_r($questions);
                $tag = explode(" ", $q->tags);
                $length = count($tag);
                // print_r(count($tag));
                for ($x = 0; $x < $length; $x++) {
                    // print_r($t->tag);
                    if ($tag[$x] == $t->tag) {
                        array_push($questionWithTag, $q);
                    }
                }
            }
        }
        // print_r($questionWithTag);

        $page->add("forum/displayquestionswithtag", [
            "tags" => $tags,
            "questions" => $questions,
            // "tag" => $tag,
            "questionWithTag" => $questionWithTag,
            "id" => $id,
            "loggedin" => $session->get("loggedin"),

        ]);

        return $page->render([
            "title" => "Tag",
        ]);
    }
}
