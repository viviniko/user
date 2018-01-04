<?php

namespace Viviniko\User\Console\Commands;

use Viviniko\Support\Console\CreateMigrationCommand;

class UserTableCommand extends CreateMigrationCommand
{
    /**
     * @var string
     */
    protected $name = 'user:table';

    /**
     * @var string
     */
    protected $description = 'Create a migration for the user service table';

    /**
     * @var string
     */
    protected $stub = __DIR__.'/stubs/user.stub';

    /**
     * @var string
     */
    protected $migration = 'create_user_table';
}
