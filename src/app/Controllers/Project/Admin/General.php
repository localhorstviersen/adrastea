<?php


namespace App\Controllers\Project\Admin;

/**
 * Class Admin
 *
 * @package App\Controllers\Project
 * @author  Lars Riße <me@elyday.net>
 */
class General extends AdminCoreController
{
    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.admin.general.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'general';

        return view('pages/project/admin/general', $this->global);
    }
}