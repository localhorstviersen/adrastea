<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <p>Lorem ipsum</p>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>