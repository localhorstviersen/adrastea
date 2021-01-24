<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <?= $this->data['backlogTable'] ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <?php if ($this->data['user']->hasProjectRight($this->data['project'], \App\Models\ProjectRoleRights::RIGHT_PROJECT_TICKET_MANAGE)): ?>
        <a href="<?= base_url('project/' . $this->data['project']->id . '/backlog/create') ?>"
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> <?= lang('general.create') ?>
        </a>
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