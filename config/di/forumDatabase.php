<?php

/**
 * Configuration file for forum database services.
 */

return [
    // Services to add to the container.
    "services" => [
        "tagsdatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\Forum\TagsDatabase(
                    $this->get("db")
                );
            }
        ],
        "questiondatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\Forum\QuestionDatabase(
                    $this->get("db")
                );
            }
        ],
        "userdatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\User\UserDatabase(
                    $this->get("db")
                );
            }
        ],
        "questioncommentdatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\Forum\QuestionCommentDatabase(
                    $this->get("db")
                );
            }
        ],
        "questionanswerdatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\Forum\QuestionAnswerDatabase(
                    $this->get("db")
                );
            }
        ],
        "answercommentdatabase" => [
            "shared" => true,
            "callback" => function () {
                return new Anax\QandA\Forum\AnswerCommentDatabase(
                    $this->get("db")
                );
            }
        ],
    ],
];
