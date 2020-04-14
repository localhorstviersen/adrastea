<?php


namespace App\Models;


use CodeIgniter\Model;

/**
 * Class Projects
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 */
class Project extends Model
{
    protected $table = 'projects';
    protected $returnType = Project::class;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
}