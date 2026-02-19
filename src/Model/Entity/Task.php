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
 * @property int $col_id
 * @property int $color_id
 * @property int|null $position
 * @property string $name
 * @property string|null $description
 * @property bool $priority
 * @property bool $deleted
 * @property bool $visible
 * @property int $pos
 * @property int|null $tag_count
 * @property int $comment_count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Col $col
 * @property \App\Model\Entity\Color $color
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\Tag[] $tags
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
        'col_id' => true,
        'color_id' => true,
        'position' => true,
        'name' => true,
        'description' => true,
        'priority' => true,
        'deleted' => true,
        'visible' => true,
        'pos' => true,
        'tag_count' => true,
        'comment_count' => true,
        'created' => true,
        'modified' => true,
        'col' => true,
        'color' => true,
        'comments' => true,
        'tags' => true,
    ];
}
