<?php
declare(strict_types=1);

namespace App\Test\Fixture;


use Cake\TestSuite\Fixture\TestFixture;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * ColsFixture
 */
class ColsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'project_id' => 1,
                'view_id' => 1,
                'type_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'visible' => 1,
                'pos' => 1,
                'task_count' => 1,
                'created' => '2026-02-18 14:10:08',
                'modified' => '2026-02-18 14:10:08',
            ],
        ];
        parent::init();
    }
}
