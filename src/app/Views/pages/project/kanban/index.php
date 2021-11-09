<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= lang('project.title.kanban', ['name'=> $this->data['project']->name]) ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="kanbanBoard"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
<link rel="stylesheet" href="/assets/css/jkanban.min.css">
<script src="/assets/js/jkanban.min.js"></script>

<script type="application/javascript">
    let KanbanBoard = new jKanban({
        element: "#kanbanBoard",
        gutter: "10px",
        widthBoard: "450px",
        responsivePercentage: true,
        dragItems: <?= $this->data['user']->hasProjectRight($this->data['project'], \App\Models\ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE) ? 'true' : 'false' ?>,
        dragBoards: false,
        click: function (el) {
            let ticketId = el.getAttribute('data-eid').split('-')[1];

            console.log(ticketId);
            window.open(
                '<?= site_url(sprintf('/project/%d/backlog/view/', $this->data['project']->id)) ?>' + ticketId,
                '_blank'
            );
        },
        dropEl: function (el, target, source, sibling) {
            let statusId = target.parentElement.getAttribute('data-id').split('-')[1];
            let ticketId = el.getAttribute('data-eid').split('-')[1];

            $.post(
                '<?= site_url(sprintf('project/%d/kanban/updateTicketStatus', $this->data['project']->id)) ?>',
                {ticketId: ticketId, newStatusId: statusId},
                function (data) {
                    if (data.error == null) {
                        Toast.fire({icon: 'success', title: 'Das Ticket wurde erfolgreich verschoben.'});
                    } else {
                        switch (data.error) {
                            case 'no_project':
                            case 'no_ticket':
                            case 'no_status':
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Das Ticket konnte aufgrund eines Fehlers nicht verschoben werden. Bitte die Seite neuladen.'
                                });
                                break;
                            case 'no_permission':
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Dir fehlen die Berechtigungen zum Verschieben eines Tickets. Bitte die Seite neuladen.'
                                });
                        }
                    }
                },
                'json'
            );
        },
        itemAddOptions: {
            enabled: false
        },
        boards: [
            <?php foreach ($this->data['status'] as $status): ?>
            {
                id: "board-<?= $status->id ?>",
                title: "<?= $status->name ?>",
                item: [
                    <?php foreach ($status->getTickets() as $ticket): ?>
                    {
                        id: "item-<?= $ticket->id ?>",
                        title: "<?= $ticket->getFieldValue('title') ?>"
                    },
                    <?php endforeach; ?>
                ]
            },
            <?php endforeach; ?>
        ]
    });

    KanbanBoard.add
</script>
<?= $this->endSection() ?>
