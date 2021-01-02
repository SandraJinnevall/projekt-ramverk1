<?php

namespace Anax\QandA\Forum;

use Anax\Database\Database;
use Anax\TextFilter\TextFilter;
use Anax\QandA\Forum\Tags;

class TagsDatabase
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


    public function all() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT tagid, tag, created, reputation
              FROM Tags
            ;
        ");

        return $data;
    }

    public function checkIfExist($tag) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT tagid, tag, created, reputation
              FROM Tags
              WHERE tag = ?
             ;
         ", [$tag]);

        return $data;
    }

    public function getAllByID($id) : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT tagid, tag, created, reputation
              FROM Tags
              WHERE tagid = ?
             ;
         ", [$id]);

        return $data;
    }

    public function getNewestTags() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT tagid, tag, reputation
              FROM Tags
              ORDER BY created DESC
              LIMIT 3
            ;
        ");

        return $data;
    }

    public function updateRep($tagname)
    {
        $this->db->connect()->execute("
            UPDATE Tags
               SET reputation = reputation + 1
             WHERE tag = ?
        ", [$tagname]);
    }

    public function getMostPopularTags() : array
    {
        $data = $this->db->connect()->executeFetchAll("
            SELECT tagid, tag, reputation
              FROM Tags
              ORDER BY reputation DESC
              LIMIT 3
            ;
        ");
        return $data;
    }
}
