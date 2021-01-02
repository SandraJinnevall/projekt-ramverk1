<?php

/**
 * Configuration file for database service.
 */

return [
    // Services to add to the container.
    "services" => [
        "db" => [
            "shared" => true,
            "callback" => function () {
                $db = new \Anax\Database\Database();

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("database");

                // Set the database configuration
                $connection = $config["config"] ?? [];
                $db->setOptions($connection);

                return $db;
            }
        ],
    ],
];
