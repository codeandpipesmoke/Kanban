<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateInitialSchema extends BaseMigration
{
    public function change(): void
    {
        // Colors table
        $this->table('colors')
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('color', 'string', ['limit' => 20, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('task_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['name'])
            ->addIndex(['pos'])
            ->create();

        // Cols table
        $this->table('cols')
            ->addColumn('project_id', 'integer', ['null' => false])
            ->addColumn('view_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('type_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 250, 'null' => false])
            ->addColumn('status', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('task_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['name'])
            ->addIndex(['view_id'])
            ->addIndex(['project_id'])
            ->addIndex(['visible'])
            ->addIndex(['type_id'])
            ->create();

        // Projects table
        $this->table('projects')
            ->addColumn('name', 'string', ['limit' => 2048, 'null' => false])
            ->addColumn('project', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('col_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->create();

        // Tags table
        $this->table('tags')
            ->addColumn('name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('task_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['name'])
            ->create();

        // Tags_tasks jointable
        $this->table('tags_tasks')
            ->addColumn('tag_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('task_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('pos', 'integer', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['tag_id'])
            ->addIndex(['task_id'])
            ->create();

        // Tasks table
        $this->table('tasks')
            ->addColumn('col_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('color_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 1000, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('priority', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('deleted', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('tag_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['name'])
            ->addIndex(['priority'])
            ->addIndex(['visible'])
            ->addIndex(['deleted'])
            ->addIndex(['pos'])
            ->addIndex(['color_id'])
            ->create();

        // Types table
        $this->table('types')
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->create();

        // Views table
        $this->table('views')
            ->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('visible', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('pos', 'integer', ['default' => 1000, 'null' => false])
            ->addColumn('col_count', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['name'])
            ->create();
    }
}
?>
