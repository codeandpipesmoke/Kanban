<?php
declare(strict_types=1);

namespace App\Test\Fixture;


use Cake\TestSuite\Fixture\TestFixture;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * StatusesFixture
 */
class StatusesFixture extends TestFixture
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
                'status' => 'Lorem ipsum dolor sit amet',
                'visible' => 1,
                'pos' => 1,
                'task_count' => 1,
                'col_count' => 1,
                'created' => '2026-02-17 13:43:20',
                'modified' => '2026-02-17 13:43:20',
            ],
        ];
        parent::init();
    }
}
