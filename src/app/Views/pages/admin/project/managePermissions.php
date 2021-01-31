<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('general.overview') ?></h6>
        </div>
        <div class="card-body">
            <form method="post"
                  action="<?= site_url('admin/project/managePermissions/' . $this->data['project']->id) ?>">
                <div class="table-responsive">
                    <?= $this->data['table'] ?>
                </div>

                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= site_url('admin/project') ?>"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>
<?= $this->endSection() ?>