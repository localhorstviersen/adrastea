<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
<a href="<?= base_url('project') ?>"
   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
</a>
<?= $this->endSection() ?>
