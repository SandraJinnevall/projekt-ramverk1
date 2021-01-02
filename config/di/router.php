<?php

/**
 * Configuration file to create router as $di service.
 */

return [
    "services" => [
        "router" => [
            "shared" => true,
            "callback" => function () {
                $router = new \Anax\Route\Router();
                $router->setDI($this);

                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("router");

                // Set DEVELOPMENT/PRODUCTION mode, if defined
                $mode = $config["config"]["mode"] ?? null;
                if (isset($mode)) {
                    $router->setMode($mode);
                } else if (defined("ANAX_PRODUCTION")) {
                    $router->setMode(\Anax\Route\Router::PRODUCTION);
                }

                // Add routes from configuration file/dir
                $file = null;
                try {
                    $file = $config["file"] ?? null;
                    $items = $config["config"] ?? [];
                    if (!empty($items)) {
                        $router->addRoutes($items);
                    }

                    foreach ($config["items"] ?? [] as $routes) {
                        $file = $routes["file"];
                        $items = $routes["config"] ?? [];
                        $router->addRoutes($items);
                    }
                } catch (Exception $e) {
                    throw new Exception(
                        "Configuration file: '$file'. "
                        . $e->getMessage()
                    );
                }

                return $router;
            }
        ],
    ],
];
