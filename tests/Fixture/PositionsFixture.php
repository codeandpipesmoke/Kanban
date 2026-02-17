<?php
declare(strict_types=1);

namespace App\Test\Fixture;


use Cake\TestSuite\Fixture\TestFixture;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * PositionsFixture
 */
class PositionsFixture extends TestFixture
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
                'id' => '17f4f598-7611-4af5-87d5-59b611637fb5',
                'name' => 'Lorem ipsum dolor sit amet',
                'visible' => 1,
                'pos' => 1,
                'task_count' => 1,
                'created' => '2026-02-17 08:26:19',
                'modified' => '2026-02-17 08:26:19',
            ],
        ];
        parent::init();
    }
}
