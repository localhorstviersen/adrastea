<?php


namespace App\Controllers\Project\Admin;

use App\Models\Project\Ticket\Status;
use CodeIgniter\View\Table;
use Config\Services;

/**
 * Class TicketStatus
 *
 * @package App\Controllers\Project\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class TicketStatus extends AdminCoreController
{
    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.admin.ticketStatus.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketStatus';
        $this->global['ticketStatusTable'] = $this->createTicketStatusTable();

        return view('pages/project/admin/ticketStatus/index', $this->global);
    }

    public function create(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketStatusRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(site_url('project/' . $this->project->id . '/admin/ticketStatus/create'));
            }

            $ticketStatusModel = new Status();
            $data = [
                'projectId' => $this->project->id,
                'name' => $this->request->getPost('name'),
                'priority' => $this->request->getPost('priority')
            ];
            $ticketStatusModel->insert($data);

            $this->session->setFlashdata('successForm', lang('project.form.ticketStatus.create.success'));
            return redirect()->to(site_url('project/' . $this->project->id . '/admin/ticketStatus'));
        }

        $this->global['title'] = lang('project.title.admin.ticketStatus.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketStatus';

        return view('pages/project/admin/ticketStatus/create', $this->global);
    }

    public function edit(int $projectId, int $ticketStatusId)
    {
        $requestValid = $this->isRequestValidWithStatusId($projectId, $ticketStatusId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketStatusRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(
                    site_url('project/' . $this->project->id . '/admin/ticketStatus/edit/' . $ticketStatusId)
                );
            }

            $ticketStatusModel = new Status();
            $data = [
                'name' => $this->request->getPost('name'),
                'priority' => $this->request->getPost('priority')
            ];
            $ticketStatusModel->update($ticketStatusId, $data);

            $this->session->setFlashdata('successForm', lang('project.form.ticketStatus.edit.success'));
            return redirect()->to(site_url('project/' . $this->project->id . '/admin/ticketStatus'));
        }

        $this->global['title'] = lang('project.title.admin.ticketStatus.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketStatus';

        return view('pages/project/admin/ticketStatus/edit', $this->global);
    }

    public function delete(int $projectId, int $ticketStatusId)
    {
        $requestValid = $this->isRequestValidWithStatusId($projectId, $ticketStatusId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $ticketStatusModel = new Status();
            $ticketStatusModel->delete($ticketStatusId);

            $this->session->setFlashdata('successForm', lang('project.form.ticketStatus.delete.success'));
            return redirect()->to(site_url('project/' . $this->project->id . '/admin/ticketStatus'));
        }

        $this->global['title'] = lang('project.title.admin.ticketStatus.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketStatus';

        return view('pages/project/admin/ticketStatus/delete', $this->global);
    }

    private function isRequestValidWithStatusId(int $projectId, int $ticketStatusId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $ticketStatusModel = new Status();
        $this->global['ticketStatus'] = $ticketStatusModel->find($ticketStatusId);

        if (!$this->global['ticketStatus'] instanceof Status) {
            $this->session->setFlashdata('errorForm', lang('project.ticketStatus.notFound'));
            return redirect()->to(site_url('project/' . $this->project->id . '/admin/ticketStatus'));
        }

        return null;
    }

    private function createTicketStatusTable(): string
    {
        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="ticketStatusTable" width="100%" cellspacing="0">'
        ];

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('project.table.name'),
                lang('project.table.ticketStatus.priority'),
                ''
            ]
        );

        $status = $this->project->getTicketStatus();

        foreach ($status as $state) {
            $editUrl = sprintf(
                '<a href="%s"><i class="fas fa-pencil-alt"></i></a>',
                site_url(
                    sprintf(
                        'project/%d/admin/ticketStatus/edit/%d',
                        $this->project->id,
                        $state->id
                    )
                )
            );

            $deleteUrl = sprintf(
                '<a href="%s"><i class="fas fa-trash-alt"></i></a>',
                site_url(
                    sprintf(
                        'project/%d/admin/ticketStatus/delete/%d',
                        $this->project->id,
                        $state->id
                    )
                )
            );

            $table->addRow(
                [
                    $state->name,
                    $state->priority,
                    sprintf('%s %s', $editUrl, $deleteUrl)
                ]
            );
        }

        return $table->generate();
    }
}