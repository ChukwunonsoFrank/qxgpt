<?php

namespace App\Pulse\Storage;

use Laravel\Pulse\Storage\DatabaseStorage as BaseDatabaseStorage;

class DatabaseStorage extends BaseDatabaseStorage
{
    /**
     * Determine whether a manually generated key hash is required.
     *
     * MySQL 8.0.32+ disallows md5() in generated columns, so on MySQL/MariaDB
     * we populate the key_hash column from the application instead of relying
     * on a virtual generated column expression.
     */
    protected function requiresManualKeyHash(): bool
    {
        return in_array(
            $this->connection()->getDriverName(),
            ['sqlite', 'mysql', 'mariadb'],
            true,
        );
    }
}
