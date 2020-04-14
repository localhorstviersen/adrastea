<?php


namespace App\Controllers;


use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;
use function foo\func;

/**
 * Class Project
 *
 * @package App\Controllers
 */
class Project extends CoreController
{
    public function index()
    {
        $requestValid = $this->isRequestValid();

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang('project.title');

        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="projects" width="100%" cellspacing="0">'
        ];

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('project.table.name'),
                lang('project.table.description')
            ]
        );

        $projects = $this->user->getProjects();

        /** @var \App\Models\Project $project */
        foreach ($projects as $project) {
            $nameStr = '<a href="' . base_url('project/' . $project->id . '/view') . '">' . $project->name . '</a>';
            $table->addRow(
                [
                    $nameStr,
                    $project->description
                ]
            );
        }

        $this->global['table'] = $table->generate();

        return view('pages/project/index', $this->global);
    }

    public function view(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = $this->global['project']->name;

        return view('pages/project/view', $this->global);
    }

    /**
     * @inheritDoc
     */
    protected function isRequestValid(?string $modelId = null): ?RedirectResponse
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new \App\Models\Project;
            $this->global['project'] = $projectModel->find($modelId);

            if (!$this->global['project'] instanceof \App\Models\Project) {
                $this->session->setFlashdata('errorForm', lang('project.notFound'));
                return redirect()->to(base_url('project'));
            }

            $projects = array_filter(
                $this->user->getProjects(),
                function (\App\Models\Project $project) {
                    return $project->id === $this->global['project']->id;
                }
            );

            if (empty($projects) || count($projects) > 1) {
                $this->session->setFlashdata('errorForm', lang('project.noMemberOfProject'));
                return redirect()->to(base_url('project'));
            }
        }

        return null;
    }
}