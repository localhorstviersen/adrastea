<?php


namespace App\Models;


use CodeIgniter\Model;

/**
 * Class ProjectRoleRights
 *
 * @package App\Models
 * @author  Lars Riße <me@elyday.net>
 *
 * @property int    $id
 * @property int    $projectId
 * @property int    $roleId
 * @property string $right
 */
class ProjectRoleRights extends Model
{
    public const RIGHT_PROJECT_VIEW = 'view';
    public const RIGHT_PROJECT_TICKET_ONLY_OWN_VIEW = 'ticket.view.onlyOwn';
    public const RIGHT_PROJECT_TICKET_MANAGE = 'ticket.manage';
    public const RIGHT_PROJECT_TICKET_DELETE = 'ticket.delete';
    public const RIGHT_PROJECT_ADMIN = 'admin';

    protected $table = 'project_role_rights';
    protected $returnType = ProjectRoleRights::class;
    protected $allowedFields = ['projectId', 'roleId', 'right'];

    /**
     * This method will return all global rights.
     *
     * @return array
     */
    public static function getAllProjectRights(): array
    {
        return [
            self::RIGHT_PROJECT_VIEW => lang('right.project.' . self::RIGHT_PROJECT_VIEW),
            self::RIGHT_PROJECT_TICKET_ONLY_OWN_VIEW => lang('right.project.' . self::RIGHT_PROJECT_TICKET_ONLY_OWN_VIEW),
            self::RIGHT_PROJECT_TICKET_MANAGE => lang('right.project.' . self::RIGHT_PROJECT_TICKET_MANAGE),
            self::RIGHT_PROJECT_TICKET_DELETE => lang('right.project.' . self::RIGHT_PROJECT_TICKET_DELETE),
            self::RIGHT_PROJECT_ADMIN => lang('right.project.' . self::RIGHT_PROJECT_ADMIN),
        ];
    }
}