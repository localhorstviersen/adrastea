<?php


namespace App\Controllers\Project\Admin;


use App\Models\Project\Ticket\Types;
use CodeIgniter\View\Table;
use Config\Services;

/**
 * Class TicketType
 *
 * @package App\Controllers\Project\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class TicketType extends AdminCoreController
{
    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.admin.ticketTypes.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketType';
        $this->global['ticketTypeTable'] = $this->createTicketTypeTable();

        return view('pages/project/admin/ticketType/index', $this->global);
    }

    public function create(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketTypeRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(base_url('project/' . $this->project->id . '/admin/ticketType/create'));
            }

            $ticketTypesModel = new Types();
            $data = [
                'projectId' => $this->project->id,
                'name' => $this->request->getPost('name')
            ];
            $ticketTypesModel->insert($data);

            $this->session->setFlashdata('successForm', lang('project.form.ticketType.create.success'));
            return redirect()->to(base_url('project/' . $this->project->id . '/admin/ticketType'));
        }

        $this->global['title'] = lang('project.title.admin.ticketTypes.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketType';

        return view('pages/project/admin/ticketType/create', $this->global);
    }

    public function edit(int $projectId, int $ticketTypeId)
    {
        $requestValid = $this->isRequestValidWithTypeId($projectId, $ticketTypeId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketTypeRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);
                return redirect()->to(
                    base_url('project/' . $this->project->id . '/admin/ticketType/edit/' . $ticketTypeId)
                );
            }

            $ticketTypesModel = new Types();
            $data = [
                'name' => $this->request->getPost('name')
            ];
            $ticketTypesModel->update($ticketTypeId, $data);

            $this->session->setFlashdata('successForm', lang('project.form.ticketType.edit.success'));
            return redirect()->to(base_url('project/' . $this->project->id . '/admin/ticketType'));
        }

        $this->global['title'] = lang('project.title.admin.ticketTypes.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketType';

        return view('pages/project/admin/ticketType/edit', $this->global);
    }

    public function delete(int $projectId, int $ticketTypeId)
    {
        $requestValid = $this->isRequestValidWithTypeId($projectId, $ticketTypeId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $ticketTypesModel = new Types();
            $ticketTypesModel->delete($ticketTypeId);

            $this->session->setFlashdata('successForm', lang('project.form.ticketType.delete.success'));
            return redirect()->to(base_url('project/' . $this->project->id . '/admin/ticketType'));
        }

        $this->global['title'] = lang('project.title.admin.ticketTypes.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketType';

        return view('pages/project/admin/ticketType/delete', $this->global);
    }

    private function isRequestValidWithTypeId(int $projectId, int $ticketTypeId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $ticketTypesModel = new Types();
        $this->global['ticketType'] = $ticketTypesModel->find($ticketTypeId);

        if (!$this->global['ticketType'] instanceof Types) {
            $this->session->setFlashdata('errorForm', lang('project.ticketType.notFound'));
            return redirect()->to(base_url('project/' . $this->project->id . '/admin/ticketType'));
        }

        return null;
    }

    /**
     * @return string
     */
    private function createTicketTypeTable(): string
    {
        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="ticketTypeTable" width="100%" cellspacing="0">'
        ];

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('project.table.name'),
                ''
            ]
        );

        $types = $this->project->getTicketTypes();

        foreach ($types as $type) {
            $editUrl = sprintf(
                '<a href="%s"><i class="fas fa-pencil-alt"></i></a>',
                base_url(
                    sprintf(
                        'project/%d/admin/ticketType/edit/%d',
                        $this->project->id,
                        $type->id
                    )
                )
            );

            $deleteUrl = sprintf(
                '<a href="%s"><i class="fas fa-trash-alt"></i></a>',
                base_url(
                    sprintf(
                        'project/%d/admin/ticketType/delete/%d',
                        $this->project->id,
                        $type->id
                    )
                )
            );

            $table->addRow(
                [
                    $type->name,
                    sprintf('%s %s', $editUrl, $deleteUrl)
                ]
            );
        }

        return $table->generate();
    }
}