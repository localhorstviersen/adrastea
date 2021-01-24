<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('general.create') ?></h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/role/create') ?>">
                <div class="form-group">
                    <label for="name"><?= lang('role.form.name.name') ?></label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required>
                    <small id="nameHelp" class="form-text text-muted"><?= lang('role.form.name.help') ?></small>
                </div>

                <?php foreach ($this->data['globalRights'] as $key => $value): ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="globalRight[<?= $key ?>]"
                               name="globalRight[<?= $key ?>]">
                        <label class="custom-control-label" for="globalRight[<?= $key ?>]"><?= $value ?></label>
                    </div>
                <?php endforeach; ?>

                <br>
                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= base_url('admin/role') ?>"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>
<?= $this->endSection() ?>