<?php

namespace Anax\QandA\User;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\User\User;

class UserDatabase
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

    public function getAll()
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT id, acronym, displayname, img, bio, created, active, reputation
              FROM User
            ;
        ");

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT id, acronym, displayname, img, bio, created, active, reputation
              FROM User
              WHERE id = ?
             ;
         ", [$id]);

        return $data;
    }

    public function updateRep($id)
    {
        $this->db->connect()->execute("
            UPDATE User
               SET reputation = reputation + 1
             WHERE id = ?
        ", [$id]);
    }

    public function getIDbyacronym($acronym) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT id
              FROM User
              WHERE acronym = ?
             ;
         ", [$acronym]);

        return $data;
    }


    public function getName()
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT displayname
              FROM User
            ;
        ");

        return $data;
    }

    public function getImg()
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT img
              FROM User
            ;
        ");

        return $data;
    }

    public function getMostActive() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT id, acronym, displayname, img, bio, created, active, reputation
              FROM User
              ORDER BY reputation DESC
              LIMIT 3
            ;
        ");

        return $data;
    }
}
