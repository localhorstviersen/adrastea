<?= $this->extend('layouts/project/layoutAdmin') ?>

<?= $this->section('projectBodyAdmin') ?>
    <a href="<?= base_url('project/' . $this->data['project']->id . '/admin/ticketType/create') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> <?= lang('general.create') ?>
    </a>
    <br><br>
<?= $this->data['ticketTypeTable'] ?>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
    <script type="application/javascript">
        $(document).ready(function () {
            $('#ticketTypeTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                }
            });
        });
    </script>
<?= $this->endSection() ?>