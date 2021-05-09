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

    /**
     * @param  int  $projectId
     * @return RedirectResponse|string
     */
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

    /**
     * @param  int  $projectId
     * @return false|string
     * @throws \ReflectionException
     */
    public function updateTicketStatus(int $projectId)
    {
        $isRequestValid = $this->isRequestValid($projectId);

        if ($isRequestValid !== null) {
            return json_encode(['error' => 'no_project']);
        }

        $ticketId = $this->request->getPost('ticketId');
        $newStatusId = $this->request->getPost('newStatusId');

        if ( ! $this->user->hasProjectRight($this->project, ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE)) {
            return json_encode(['error' => 'no_permission']);
        }

        $ticket = (new Project\Ticket())->where('id', $ticketId)->where('projectId', $projectId)->first();

        if ( ! $ticket instanceof Project\Ticket) {
            return json_encode(['error' => 'no_ticket']);
        }

        $status = (new Project\Ticket\Status())->where('id', $newStatusId)->where('projectId', $projectId)->first();

        if ( ! $status instanceof Project\Ticket\Status) {
            return json_encode(['error' => 'no_status']);
        }

        /** @var Project\Ticket\Field $field */
        $field = $this->project->getField('status');
        $field->setValue($ticketId, $newStatusId);

        return json_encode(['error' => null]);
    }

    protected function isRequestValid(
        ?string $modelId = null
    ): ?RedirectResponse {
        if ( ! $this->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new Project;
            $this->project = $this->global['project'] = $projectModel->find($modelId) instanceof
            Project ? $projectModel->find($modelId) : null;

            if ( ! $this->project instanceof Project) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.notFound')
                );

                return redirect()->to(site_url('/'));
            }

            if ( ! $this->user->hasProjectRight(
                $this->project,
                ProjectRoleRights::RIGHT_PROJECT_VIEW
            )
            ) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.noMemberOfProject')
                );

                return redirect()->to(site_url('/'));
            }
        }

        return null;
    }
}