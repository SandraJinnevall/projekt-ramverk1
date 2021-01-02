<?php

namespace Anax\QandA\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\QandA\User\CrudForm\UserLoginForm;
use Anax\QandA\User\CrudForm\CreateUserForm;
use Anax\QandA\User\CrudForm\LogoutUserForm;
use Anax\QandA\User\CrudForm\InfoUserForm;
use Anax\QandA\User\CrudForm\UpdateUserForm;
use Anax\QandA\User\CrudForm\DeleteUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        if ($session->get("loggedin") === false) {
            return $response->redirect("user/login");
        } else {
            return $response->redirect("user/loggedin");
        }
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $session = $this->di->get("session");
        $response = $this->di->get("response");

        if ($session->get("loggedin") === true) {
            return $response->redirect("user/loggedin");
        } else {
            $page = $this->di->get("page");
            $form = new UserLoginForm($this->di);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Logga in",
            ]);
        }
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        if ($session->get("loggedin") === false) {
            $form = new CreateUserForm($this->di);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Skapa en användare",
            ]);
        } else {
            return $this->di->get("response")->redirect("user/loggedin");
        }
    }

    public function logoutAction() : object
    {
        $page = $this->di->get("page");
        $form = new LogoutUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Logga ut",
        ]);
    }

    public function updateAction() : object
    {
        $session = $this->di->get("session");
        if ($session->get("loggedin") === true) {
            $page = $this->di->get("page");
            $form = new UpdateUserForm($this->di);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Uppdatera",
            ]);
        } else {
            return $this->di->get("response")->redirect("user/login");
        }
    }

    public function loggedinAction() : object
    {
        $session = $this->di->get("session");
        if ($session->get("loggedin") === true) {
            $page = $this->di->get("page");
            $userID = $session->get("UserID");

            $userdatabase = $this->di->get("userdatabase");
            $user = $userdatabase->getAllByID($userID);

            $questiondatabase = $this->di->get("questiondatabase");
            $question = $questiondatabase->getAllQuestionsByUserID($userID);

            $qadatabase = $this->di->get("questionanswerdatabase");
            $questionanswer = $qadatabase->getAnswerdQuestion($userID);
            $qarray = array();
            foreach ($questionanswer as $aqq) {
                if (!in_array($aqq->questionid, array_column($qarray, 'questionid'))) {
                    $new2 = array('questionid' => $aqq->questionid, 'title' => $aqq->title);
                    array_push($qarray, $new2);
                }
            }

            $qcdatabase = $this->di->get("questioncommentdatabase");
            $questioncomment = $qcdatabase->getCommentQuestion($userID);
            $qcarray = array();
            foreach ($questioncomment as $aq) {
                if (!in_array($aq->questionid, array_column($qcarray, 'questionid'))) {
                    $new1 = array('questionid' => $aq->questionid, 'title' => $aq->title);
                    array_push($qcarray, $new1);
                }
            }

            $answercdatabase = $this->di->get("answercommentdatabase");
            $answercomment = $answercdatabase->getCommentAnswers($userID);
            $acarray = array();
            foreach ($answercomment as $aa) {
                if (!in_array($aa->questionid, array_column($acarray, 'questionid'))) {
                    $new = array('questionid' => $aa->questionid, 'title' => $aa->title);
                    array_push($acarray, $new);
                }
            }
            $page->add("forum/displayUserInfo", [
                "userid" => $userID,
                "question" => $question,
                "user" => $user,
                "questionanswer" => $qarray,
                "questioncomment" => $qcarray,
                "answercomment" => $acarray
            ]);

            return $page->render([
                "title" => "Inloggad",
            ]);
        } else {
            $session->set("loggedin", false);
            return $this->di->get("response")->redirect("user/login");
        }
    }


    public function usersAction() : object
    {
        $page = $this->di->get("page");
        $userdatabase = $this->di->get("userdatabase");
        $users = $userdatabase->getAll();

        if (!is_array($users)) {
            $users = array($users);
        }

        $page->add("forum/displayusers", [
            "users" => $users
        ]);
        return $page->render([
            "title" => "Användare",
        ]);
    }

    public function displayuserAction($id) : object
    {
        $page = $this->di->get("page");

        $userdatabase = $this->di->get("userdatabase");
        $user = $userdatabase->getAllByID($id);

        $questiondatabase = $this->di->get("questiondatabase");
        $question = $questiondatabase->getAllQuestionsByUserID($id);

        $questionadatabase = $this->di->get("questionanswerdatabase");
        $questionanswer = $questionadatabase->getAnswerdQuestion($id);
        $qarray = array();
        foreach ($questionanswer as $aqq) {
            if (!in_array($aqq->questionid, array_column($qarray, 'questionid'))) {
                $new2 = array('questionid' => $aqq->questionid, 'title' => $aqq->title);
                array_push($qarray, $new2);
            }
        }

        $questioncdatabase = $this->di->get("questioncommentdatabase");
        $questioncomment = $questioncdatabase->getCommentQuestion($id);
        $qcarray = array();
        foreach ($questioncomment as $aq) {
            if (!in_array($aq->questionid, array_column($qcarray, 'questionid'))) {
                $new1 = array('questionid' => $aq->questionid, 'title' => $aq->title);
                array_push($qcarray, $new1);
            }
        }

        $answercdatabase = $this->di->get("answercommentdatabase");
        $answercomment = $answercdatabase->getCommentAnswers($id);
        $acarray = array();
        foreach ($answercomment as $aa) {
            if (!in_array($aa->questionid, array_column($acarray, 'questionid'))) {
                $new = array('questionid' => $aa->questionid, 'title' => $aa->title);
                array_push($acarray, $new);
            }
        }

        $page->add("forum/displayuser", [
            "user" => $user,
            "question" => $question,
            "questionanswer" => $qarray,
            "questioncomment" => $qcarray,
            "answercomment" => $acarray
        ]);

        return $page->render([
            "title" => "Användare",
        ]);
    }

    public function displayaboutAction()
    {
        $page = $this->di->get("page");

        $page->add("forum/displayabout");

        return $page->render([
            "title" => "Om",
        ]);
    }
}
