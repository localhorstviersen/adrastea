<?php


namespace App\Controllers\Project;


use App\Controllers\CoreController;
use App\Models\Project;
use App\Models\ProjectRoleRights;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Start
 *
 * @package App\Controllers\Project
 * @author  Lars Riße <me@elyday.net>
 */
class Start extends CoreController
{
    private ?Project $project = null;

    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.start', ['name' => $this->project->name]);

        return view('pages/project/start', $this->global);
    }

    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new Project;
            $this->project = $this->global['project'] =
                $projectModel->find($modelId) instanceof Project ? $projectModel->find($modelId) : null;

            if (!$this->global['project'] instanceof Project) {
                $this->session->setFlashdata('errorForm', lang('project.notFound'));
                return redirect()->to(base_url('project'));
            }

            if (!$this->user->hasProjectRight($this->project, ProjectRoleRights::RIGHT_PROJECT_VIEW)) {
                $this->session->setFlashdata('errorForm', lang('project.noMemberOfProject'));
                return redirect()->to(base_url('project'));
            }
        }

        return null;
    }
}