<?php


namespace App\Controllers\Project\Admin;

use App\Controllers\CoreController;
use App\Models\Project;
use App\Models\ProjectRoleRights;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class AdminCoreController
 *
 * @package App\Controllers\Project\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class AdminCoreController extends CoreController
{
    protected ?Project $project = null;

    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new Project;
            $this->project = $this->global['project'] =
                $projectModel->find($modelId) instanceof Project ? $projectModel->find($modelId) : null;

            if (!$this->global['project'] instanceof Project) {
                $this->session->setFlashdata('errorForm', lang('project.notFound'));
                return redirect()->to(site_url('project'));
            }

            if (!$this->user->hasProjectRight($this->project, ProjectRoleRights::RIGHT_PROJECT_VIEW)) {
                $this->session->setFlashdata('errorForm', lang('project.noMemberOfProject'));
                return redirect()->to(site_url('project'));
            }

            if (!$this->user->hasProjectRight($this->project, ProjectRoleRights::RIGHT_PROJECT_ADMIN)) {
                $this->session->setFlashdata('errorForm', lang('project.noRight'));
                return redirect()->to(site_url('project/' . $modelId . '/start'));
            }
        }

        return null;
    }
}