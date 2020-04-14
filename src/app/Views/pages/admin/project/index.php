<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('general.overview') ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?= $this->data['table'] ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= base_url('admin/project/create') ?>"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> <?= lang('general.create') ?>
    </a>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
    <script type="application/javascript">
        $(document).ready(function () {
            $('#projects').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                }
            });
        });
    </script>
<?= $this->endSection() ?>