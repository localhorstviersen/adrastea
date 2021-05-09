<?php


namespace App\Controllers\Project\Admin;

use App\Models\Project\Ticket\Field;
use App\Models\Project\Ticket\Types;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;
use Config\Services;

/**
 * Class TicketFields
 *
 * @package App\Controllers\Project\Admin
 * @author  Lars Riße <me@elyday.net>
 */
class TicketFields extends AdminCoreController
{
    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.admin.ticketFields.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketFields';
        $this->global['table'] = $this->createTicketFieldsTable();

        return view('pages/project/admin/ticketFields/index', $this->global);
    }

    public function create(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketFieldsRules');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);

                return redirect()->to(
                    site_url(
                        sprintf(
                            'project/%d/admin/ticketFields/create',
                            $this->project->id
                        )
                    )
                );
            }

            $foundField = Field::getFieldByProjectIdAndIdentification(
                $projectId,
                $this->request->getPost(
                    'identification'
                )
            );

            if ($foundField instanceof Field) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang(
                        'project.form.ticketFields.identification.validation.existsAlready'
                    )
                );

                return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields/create', $this->project->id)));
            }

            $ticketTypeIds = $this->request->getPost('ticketTypes');
            $ticketTypes = (new Types())->whereIn('id', $ticketTypeIds)->findAll();

            if (count($ticketTypes) !== count($ticketTypeIds)) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.form.ticketFields.ticketType.validation.in_list')
                );

                return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields/create', $this->project->id)));
            }

            $model = new Field();
            $data = [
                'projectId' => $this->project->id,
                'identification' => $this->request->getPost('identification'),
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'type' => $this->request->getPost('type'),
                'definition' => null,
                'required' => $this->request->getPost('required'),
            ];

            if (in_array($data['type'], Field::fieldTypesWithDefinition(), true)) {
                if (!$this->request->getPost('definition') === null || empty($this->request->getPost('definition'))) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.required')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                $definition = $this->request->getPost('definition');

                if (in_array($data['type'], Field::fieldSelectTypes(), true)
                    && preg_match('/^(([\w\s,]*)([;]?))*$/', $definition) === false) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.regex_match')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                if (!in_array($data['type'], Field::fieldSelectTypes(), true)
                    && substr_count($definition, '%s') !== 1) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.moreThanOne')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                if (in_array($data['type'], Field::fieldSelectTypes(), true)
                    && substr($definition, -1) === ';') {
                    $definition = substr_replace($definition, '', -1);
                }

                $data['definition'] = $definition;
            }

            $fieldId = $model->insert($data);
            /** @var Field $field */
            $field = (new Field())->find($fieldId);
            $field->storeTypeRelations($ticketTypeIds);

            $this->session->setFlashdata(
                'successForm',
                lang(
                    'project.form.ticketFields.create.success'
                )
            );

            return redirect()->to(
                site_url(
                    'project/' . $this->project->id . '/admin/ticketFields'
                )
            );
        }

        $this->global['title'] = lang(
            'project.title.admin.ticketFields.title',
            ['name' => $this->project->name]
        );
        $this->global['projectAdminPage'] = 'ticketFields';

        return view('pages/project/admin/ticketFields/create', $this->global);
    }

    public function edit(int $projectId, int $fieldId)
    {
        $requestValid = $this->isRequestValidWithFieldId($projectId, $fieldId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title.admin.ticketFields.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketFields';

        $typeRelations = $this->global['field']->getTypeRelations();
        $typeRelationIds = [];
        foreach ($typeRelations as $typeRelation) {
            $typeRelationIds[] = $typeRelation->typeId;
        }
        $this->global['typeRelationIds'] = $typeRelationIds;

        if ($this->isPost()) {
            $validation = Services::validation();
            $validation->setRuleGroup('projectTicketFieldsRulesWithoutFieldType');

            if (!$validation->withRequest($this->request)->run()) {
                $errors = implode('<br>', $validation->getErrors());
                $this->session->setFlashdata('errorForm', $errors);

                return redirect()->to(
                    site_url(
                        sprintf(
                            'project/%d/admin/ticketFields/edit/%d',
                            $this->project->id,
                            $fieldId
                        )
                    )
                );
            }

            if (!array_key_exists($this->global['field']->type, Field::getTypes())) {
                $this->session->setFlashdata('errorForm', lang('project.form.ticketFields.type.validation.in_list'));

                return redirect()->to(
                    site_url(
                        sprintf(
                            'project/%d/admin/ticketFields/edit/%d',
                            $this->project->id,
                            $fieldId
                        )
                    )
                );
            }

            $foundField =
                Field::getFieldByProjectIdAndIdentification($projectId, $this->request->getPost('identification'));

            if ($this->global['field']->identification !== $this->request->getPost('identification') &&
                $foundField instanceof Field) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.form.ticketFields.identification.validation.existsAlready')
                );

                return redirect()->to(
                    site_url(
                        sprintf(
                            'project/%d/admin/ticketFields/edit/%d',
                            $this->project->id,
                            $fieldId
                        )
                    )
                );
            }

            $ticketTypeIds = $this->request->getPost('ticketTypes');
            $ticketTypes = (new Types())->whereIn('id', $ticketTypeIds)->findAll();

            if (count($ticketTypes) !== count($ticketTypeIds)) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('project.form.ticketFields.ticketType.validation.in_list')
                );

                return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields/create', $this->project->id)));
            }

            $model = new Field();
            $data = [
                'identification' => $this->request->getPost('identification'),
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'definition' => null,
                'type' => $this->global['field']->type,
                'required' => $this->request->getPost('required'),
            ];

            if (in_array($data['type'], Field::fieldTypesWithDefinition(), true)) {
                if (!$this->request->getPost('definition') === null || empty($this->request->getPost('definition'))) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.required')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                $definition = $this->request->getPost('definition');

                if (in_array($data['type'], Field::fieldSelectTypes(), true)
                    && preg_match('/^(([\w\s,]*)([;]?))*$/', $definition) === false) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.regex_match')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                if (!in_array($data['type'], Field::fieldSelectTypes(), true)
                    && substr_count($definition, '%s') !== 1) {
                    $this->session->setFlashdata(
                        'errorForm',
                        lang('project.form.ticketFields.definition.validation.moreThanOne')
                    );

                    return redirect()->to(
                        site_url(
                            sprintf(
                                'project/%d/admin/ticketFields/create',
                                $this->project->id
                            )
                        )
                    );
                }

                if (in_array($data['type'], Field::fieldSelectTypes(), true)
                    && substr($definition, -1) === ';') {
                    $definition = substr_replace($definition, '', -1);
                }

                $data['definition'] = $definition;
            }

            if (in_array($data['type'], Field::fieldTypesWithDefinition(), true)) {
                $definition = $this->request->getPost('definition');
                if (substr($definition, -1) === ';') {
                    $definition = substr_replace($definition, '', -1);
                }
                $data['definition'] = $definition;
            }

            $model->update($fieldId, $data);
            $this->global['field']->clearTypeRelations();
            $this->global['field']->storeTypeRelations($ticketTypeIds);

            $this->session->setFlashdata('successForm', lang('project.form.ticketFields.edit.success'));

            return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields', $this->project->id)));
        }

        return view('pages/project/admin/ticketFields/edit', $this->global);
    }

    public function delete(int $projectId, int $fieldId)
    {
        $requestValid = $this->isRequestValidWithFieldId($projectId, $fieldId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ($this->global['field']->isSystemField()) {
            $this->session->setFlashdata('errorForm', lang('project.form.ticketFields.delete.systemField'));

            return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields', $this->project->id)));
        }

        if ($this->isPost()) {
            $model = new Field();
            $model->delete($fieldId);

            $this->session->setFlashdata('successForm', lang('project.form.ticketFields.delete.success'));

            return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields', $this->project->id)));
        }

        $this->global['title'] = lang('project.title.admin.ticketFields.title', ['name' => $this->project->name]);
        $this->global['projectAdminPage'] = 'ticketFields';

        return view('pages/project/admin/ticketFields/delete', $this->global);
    }

    /**
     * @return string
     */
    private function createTicketFieldsTable(): string
    {
        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="ticketFieldsTable" width="100%" cellspacing="0">',
        ];

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('project.table.ticketFields.name'),
                lang('project.table.ticketFields.ticketType'),
                lang('project.table.ticketFields.type'),
                lang('project.table.ticketFields.systemField'),
                lang('project.table.ticketFields.required'),
                '',
            ]
        );

        $fields = $this->project->getFields();

        foreach ($fields as $field) {
            $editUrl = sprintf(
                '<a href="%s"><i class="fas fa-pencil-alt"></i></a>',
                site_url(
                    sprintf(
                        'project/%d/admin/ticketFields/edit/%d',
                        $this->project->id,
                        $field->id
                    )
                )
            );

            $deleteUrl = '';

            if (!$field->isSystemField()) {
                $deleteUrl = sprintf(
                    '<a href="%s"><i class="fas fa-trash-alt"></i></a>',
                    site_url(
                        sprintf(
                            'project/%d/admin/ticketFields/delete/%d',
                            $this->project->id,
                            $field->id
                        )
                    )
                );
            }

            $assignedTypes = $field->getAssignedTypes();
            $assignedTypeNames = [];

            foreach ($assignedTypes as $assignedType) {
                $assignedTypeNames[] = $assignedType->name;
            }

            $table->addRow(
                [
                    $field->name,
                    empty($assignedTypeNames) ? 'Alle' : implode(', ', $assignedTypeNames),
                    Field::getTypes()[$field->type],
                    $field->isSystemField()
                        ? lang('general.yes')
                        : lang(
                        'general.no'
                    ),
                    $field->isRequired()
                        ? lang('general.yes')
                        : lang(
                        'general.no'
                    ),
                    sprintf('%s %s', $editUrl, $deleteUrl),
                ]
            );
        }

        return $table->generate();
    }

    /**
     * @param int $projectId
     * @param int $fieldId
     *
     * @return RedirectResponse|null
     */
    private function isRequestValidWithFieldId(int $projectId, int $fieldId): ?RedirectResponse
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $model = new Field();
        $this->global['field'] = $model->find($fieldId);

        if (!$this->global['field'] instanceof Field) {
            $this->session->setFlashdata('errorForm', lang('project.ticketFields.notFound'));

            return redirect()->to(site_url(sprintf('project/%d/admin/ticketFields', $this->project->id)));
        }

        return null;
    }
}