<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Task Entity
 *
 * @property int $id
 * @property string $position_id
 * @property string $title
 * @property string|null $description
 * @property bool $priority
 * @property bool $deleted
 * @property bool $visible
 * @property int $pos
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Position $position
 */
class Task extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'position_id' => true,
        'title' => true,
        'description' => true,
        'priority' => true,
        'deleted' => true,
        'visible' => true,
        'pos' => true,
        'created' => true,
        'modified' => true,
        'position' => true,
    ];
}
