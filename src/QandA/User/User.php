<?php

namespace Anax\QandA\User;

use Anax\Database\Database;
use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    protected $tableName = "User";


    public $id;
    public $acronym;
    public $displayname;
    public $password;
    public $img;
    public $created;
    public $active;
    public $bio;

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($acronym, $password)
    {
        $this->find("acronym", $acronym);
        return password_verify($password, $this->password);
    }

    public function validateUser($acronym)
    {

        // $this->find("acronym", $acronym);
        if ($this->find("acronym", $acronym)) {
            return ture;
        } else {
            return false;
        }
    }

    public function getUserId() : int
    {
        return $this->id;
    }

    public function getUserAcronym()
    {
        return $this->acronym;
    }

    public function getUserDisplayName()
    {
        return $this->displayname;
    }

    public function getUserCreated()
    {
        return $this->created;
    }

    public function getUserBio()
    {
        return $this->bio;
    }

    public function getUserLastActive()
    {
        return $this->active;
    }

    public function getTodayDate()
    {
        date_default_timezone_set("Europe/Stockholm");
        return date("Y-m-d h:i:sa");
    }

    public function getImg($acronym) : string
    {
        $acroImg = \md5(\strtolower(\trim($acronym)));

        return "http://www.gravatar.com/avatar/" . $acroImg . "?d=retro&s=" . 45;
    }
}
