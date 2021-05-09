<?php


namespace App\Controllers\Project;


use App\Controllers\CoreController;
use App\Libraries\TicketFields\TicketFieldManager;
use App\Models\Project;
use App\Models\Project\Ticket;
use App\Models\ProjectRoleRights;
use App\Models\User;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\Table;

/**
 * Class Backlog
 *
 * @package App\Controllers\Project
 * @author  Lars Riße <me@elyday.net>
 */
class Backlog extends CoreController
{
    protected ?Project $project = null;
    protected ?Ticket $ticket = null;

    public function index(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        $this->global['title'] = lang(
            'project.title.backlog',
            ['name' => $this->project->name]
        );
        $this->global['backlogTable'] = $this->createBacklogTable();

        return view('pages/project/backlog/index', $this->global);
    }

    public function createTicket(int $projectId)
    {
        $requestValid = $this->isRequestValid($projectId);

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ( ! $this->user->hasProjectRight(
            $this->project,
            ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE
        )
        ) {
            $this->session->setFlashdata('errorForm', lang('project.noRight'));

            return redirect()->to(
                site_url('project/'.$projectId.'/backlog')
            );
        }

        $this->global['title'] = lang(
            'backlog.title.ticket.create',
            [
                'projectName' => $this->project->name,
            ]
        );

        $manager = new TicketFieldManager();
        $manager->initialize($this->project->getFields());

        if ($this->isPost()) {
            $manager->hydrate($this->request->getPost());

            if ( ! $manager->validate()) {
                $errors = implode('<br>', $manager->getErrors());
                $this->session->setFlashdata('errorForm', $errors);

                return redirect()->to(
                    site_url(
                        sprintf('project/%d/backlog/create', $projectId)
                    )
                );
            }

            $ticketModel = new Ticket();
            $ticketId = $ticketModel->insert(
                [
                    'projectId' => $projectId,
                    'userSId' => $this->user->sId,
                ]
            );

            $manager->storeTicketFieldDataToDatabase($ticketId);
            $this->session->setFlashdata(
                'successForm',
                lang(
                    'backlog.form.ticket.create.success'
                )
            );

            return redirect()->to(
                site_url(sprintf('project/%d/backlog', $projectId))
            );
        }

        $this->global['fields'] = $manager->getFields();

        return view('pages/project/backlog/createTicket', $this->global);
    }

    /**
     * @param  int  $projectId
     * @param  int  $ticketId
     *
     * @return RedirectResponse|string
     * @throws \ReflectionException
     */
    public function editTicket(int $projectId, int $ticketId)
    {
        $requestValid = $this->isRequestWithProjectAndTicketValid(
            $projectId,
            $ticketId
        );

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ( ! $this->user->hasProjectRight(
            $this->project,
            ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE
        )
        ) {
            $this->session->setFlashdata('errorForm', lang('project.noRight'));

            return redirect()->to(
                site_url(sprintf('project/%d/backlog', $projectId))
            );
        }

        $this->global['title'] = lang(
            'backlog.title.ticket.edit',
            [
                'projectName' => $this->project->name,
                'ticketTitle' => $this->ticket->getFieldValue('title'),
            ]
        );

        $manager = new TicketFieldManager();
        $manager->initialize($this->project->getFields());
        $manager->hydrateFromTicket($this->ticket);

        if ($this->isPost()) {
            $manager->hydrate($this->request->getPost());

            if ( ! $manager->validate()) {
                $errors = implode('<br>', $manager->getErrors());
                $this->session->setFlashdata('errorForm', $errors);

                return redirect()->to(
                    site_url(
                        sprintf(
                            'project/%d/backlog/edit/%d',
                            $projectId,
                            $ticketId
                        )
                    )
                );
            }

            $manager->storeTicketFieldDataToDatabase($ticketId);
            $this->session->setFlashdata(
                'successForm',
                lang(
                    'backlog.form.ticket.edit.success'
                )
            );

            return redirect()->to(
                site_url(sprintf('project/%d/backlog', $projectId))
            );
        }

        $this->global['fields'] = $manager->getFields();

        return view('pages/project/backlog/editTicket', $this->global);
    }

    public function viewTicket(int $projectId, int $ticketId)
    {
        $requestValid = $this->isRequestWithProjectAndTicketValid(
            $projectId,
            $ticketId
        );

        if ($requestValid !== null) {
            return $requestValid;
        }

        if ( ! $this->user->hasProjectRight(
            $this->project,
            ProjectRoleRights::RIGHT_PROJECT_VIEW
        )
        ) {
            $this->session->setFlashdata('errorForm', lang('project.noRight'));

            return redirect()->to(
                site_url(sprintf('project/%d/backlog', $projectId))
            );
        }

        $this->global['title'] = lang(
            'backlog.title.ticket.view',
            [
                'projectName' => $this->project->name,
                'ticketTitle' => $this->ticket->getFieldValue('title'),
            ]
        );


        $manager = new TicketFieldManager();
        $manager->initialize($this->project->getFields(), true);
        $manager->hydrateFromTicket($this->ticket);
        $this->global['fields'] = $manager->getFields();

        return view('pages/project/backlog/viewTicket', $this->global);
    }

    /** @inheritDoc */
    protected function isRequestValid(
        ?string $modelId = null
    ): ?RedirectResponse {
        if ( ! $this->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }

        if ($modelId !== null) {
            $projectModel = new Project;
            $this->project
                =
            $this->global['project'] = $projectModel->find($modelId) instanceof
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

    /**
     * @param  int|null  $projectId
     * @param  int|null  $ticketId
     *
     * @return RedirectResponse|null
     */
    private function isRequestWithProjectAndTicketValid(
        ?int $projectId,
        ?int $ticketId
    ): ?RedirectResponse {
        $isRequestValid = $this->isRequestValid($projectId);

        if ($isRequestValid !== null) {
            return $isRequestValid;
        }

        if ($ticketId !== null) {
            $ticketModel = new Ticket();
            $this->ticket
                =
            $this->global['ticket'] = $ticketModel->find($ticketId) instanceof
            Ticket ? $ticketModel->find($ticketId) : null;

            if ( ! $this->ticket instanceof Ticket) {
                $this->session->setFlashdata(
                    'errorForm',
                    lang('backlog.ticket.notFound')
                );

                return redirect()->to(
                    site_url(sprintf('project/%d/backlog', $projectId))
                );
            }
        }

        return null;
    }

    /**
     * @return string
     */
    private function createBacklogTable(): string
    {
        $customSettings = [
            'table_open' => '<table class="table table-bordered" id="backlogTable" style="width: 100%;">',
        ];

        $table = new Table($customSettings);
        $table->setHeading(
            [
                lang('project.backlog.table.id'),
                lang('project.backlog.table.title'),
                lang('project.backlog.table.status'),
                lang('project.backlog.table.assigned'),
                lang('project.backlog.table.reporter'),
                '',
            ]
        );

        $tickets = $this->project->getTickets();

        foreach ($tickets as $ticket) {
            $viewUrl = site_url(
                sprintf(
                    'project/%d/backlog/view/%d',
                    $ticket->projectId,
                    $ticket->id
                )
            );

            $editUrl = $this->user->hasProjectRight(
                $this->project,
                ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE
            ) ? sprintf(
                '<a href="%s"><i class="fa fa-pencil-alt"></i></a>',
                site_url(
                    sprintf(
                        'project/%d/backlog/edit/%d',
                        $ticket->projectId,
                        $ticket->id
                    )
                )
            ) : '';

            $table->addRow(
                [
                    $ticket->id,
                    sprintf(
                        '<a href="%s">%s</a>',
                        $viewUrl,
                        $ticket->getFieldValue('title')
                    ),
                    Ticket\Status::getNameById($ticket->getFieldValue('status')),
                    User::getFullNameBySId($ticket->getFieldValue('assign')),
                    User::getFullNameBySId($ticket->getFieldValue('reporter')),
                    sprintf('%s', $editUrl),
                ]
            );
        }

        return $table->generate();
    }
}