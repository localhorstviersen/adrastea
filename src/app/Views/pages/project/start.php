<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('project.title.start', ['name'=> $this->data['project']->name]) ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <p>Lorem ipsum</p>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>