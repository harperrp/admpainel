<?php

/**
 * Lê uma variável de ambiente e aplica fallback.
 */
function env_value(string $key, $default = null) {
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    return ($value === false || $value === null || $value === '') ? $default : $value;
}

return [
  'db_host' => env_value('DB_HOST', 'localhost'),
  'db_port' => env_value('DB_PORT', '3306'),
  'db_name' => env_value('DB_NAME', 'camaravgp'),
  'db_user' => env_value('DB_USER', 'usercamara'),
  'db_pass' => env_value('DB_PASS', ''),
  'session_name' => env_value('SESSION_NAME', 'camaravp_admin'),
];
