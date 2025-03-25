<?php

namespace core;

class EnvLoader {
    /**
     * Loads environment variables from a .env file
     * 
     * @param string $path Path to the .env file
     */
    public static function load($path = __DIR__ . '/../.env') {
        // Verify if the file exists
        if (!file_exists($path)) {
            throw new \RuntimeException("El archivo .env no existe en: " . $path);
        }

        // Read the file line by line
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignore comments (lines starting with #)
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Split name and value
            list($name, $value) = self::splitEnvLine($line);

            // Define the environment variable (if not already defined)
            if (!isset($_ENV[$name]) && !getenv($name)) {
                $_ENV[$name] = $value;
                putenv("$name=$value");
            }
        }
    }

    /**
     * Processes a line from the .env file and returns [name, value]
     */
    private static function splitEnvLine($line) {
        // Remove spaces around the =
        $line = trim($line);
        $parts = explode('=', $line, 2);

        if (count($parts) !== 2) {
            throw new \RuntimeException("Formato inválido en .env: " . $line);
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        // Remove quotes if they exist (for values like "password")
        if (preg_match('/^"(.*)"$/', $value, $matches) || preg_match('/^\'(.*)\'$/', $value, $matches)) {
            $value = $matches[1];
        }

        return [$name, $value];
    }
}