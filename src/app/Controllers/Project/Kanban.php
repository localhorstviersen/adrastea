<?php


namespace App\Controllers\Project;


use App\Controllers\CoreController;
use App\Models\Project;
use App\Models\ProjectRoleRights;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Kanban
 *
 * @package App\Controllers\Project
 * @author  Lars Riße <me@elyday.net>
 */
class Kanban extends CoreController
{
    protected ?Project $project = null;

    public function index(int $projectId)
    {
        $isRequestValid = $this->isRequestValid($projectId);

        if ($isRequestValid !== null) {
            return $isRequestValid;
        }

        $this->global['title'] = lang(
            'project.title.kanban',
            ['name' => $this->project->name]
        );

        $this->global['status'] = $this->project->getTicketStatus();

        return view('pages/project/kanban/index', $this->global);
    }

    protected function isRequestValid(
        ?string $modelId = null
    ): ?RedirectResponse {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new Project;
            $this->project = $this->global['project'] = $projectModel->find($modelId) instanceof
            Project ? $projectModel->find($modelId) : null;

            if (!$this->project instanceof Project) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.notFound')
                );

                return redirect()->to(base_url('/'));
            }

            if (!$this->user->hasProjectRight(
                $this->project,
                ProjectRoleRights::RIGHT_PROJECT_VIEW
            )
            ) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.noMemberOfProject')
                );

                return redirect()->to(base_url('/'));
            }
        }

        return null;
    }
}