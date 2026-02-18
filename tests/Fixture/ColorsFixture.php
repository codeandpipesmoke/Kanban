<?php
declare(strict_types=1);

namespace App\Test\Fixture;


use Cake\TestSuite\Fixture\TestFixture;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * ColorsFixture
 */
class ColorsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'color' => 'Lorem ipsum dolor ',
                'pos' => 1,
                'visible' => 1,
                'task_count' => 1,
                'created' => '2026-02-18 14:10:07',
                'modified' => '2026-02-18 14:10:07',
            ],
        ];
        parent::init();
    }
}
