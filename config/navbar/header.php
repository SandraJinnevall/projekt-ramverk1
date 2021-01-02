<?php

/**
 * Supply the basis for the navbar as an array.
 */

global $di;
$loggedIn = $di->get("session")->get("loggedin");
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Start",
            "url" => "../htdocs/",
            "title" => "QandA",
        ],
        [
            "text" => "Frågor",
            "url" => "questions",
            "title" => "Frågor",
        ],
        [
            "text" => "Taggar",
            "url" => "tags",
            "title" => "Taggar",
        ],
        [
            "text" => "Alla Användare",
            "url" => "user/users",
            "title" => "Display all users",
        ],
        [
            "text" => $loggedIn ? "Min sida" : "Logga in",
            "url" => "user",
            "title" => "Min sida",
            "submenu" => $loggedIn ? [
                "items" => [
                    [
                        "text" => "Logga ut",
                        "url" => "user/logout",
                        "title" => "Logga ut"
                    ]
                ]
            ] : [
                "items" => [
                    [
                        "text" => "Skapa en användare",
                        "url" => "user/create",
                        "title" => "Skapa en användare"
                    ]
                ]
            ]
        ],
        [
            "text" => "Om",
            "url" => "user/displayabout",
            "title" => "Om",
        ],
    ],
];
