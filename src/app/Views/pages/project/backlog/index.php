<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('project.title.backlog', ['name'=> $this->data['project']->name]) ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= $this->data['backlogTable'] ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
<?php if ($this->data['user']->hasProjectRight(
    $this->data['project'],
    \App\Models\ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE
)): ?>
    <div class="dropdown">
        <a class="btn btn-sm btn-primary shadow-sm dropdown-toggle" href="#" role="button" id="createTicketDropdown"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus fa-sm text-white-50"></i> <?= lang('general.create') ?>
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <?php foreach ($this->data['ticketTypes'] as $key => $value): ?>
                <a class="dropdown-item" href="<?= site_url(sprintf('project/%d/backlog/create/%d', $this->data['project']->id, $key)) ?>"><?= $value ?></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
    <script type="application/javascript">
        $(document).ready(function () {
            $('#backlogTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                }
            });
        });
    </script>
<?= $this->endSection() ?>