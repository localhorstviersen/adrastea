<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('general.create') ?></h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('admin/project/create') ?>">
                <div class="form-group">
                    <label for="name"><?= lang('admin.project.form.name.name') ?></label>
                    <input type="text" maxlength="50" class="form-control" id="name" name="name" aria-describedby="nameHelp" required>
                    <small id="nameHelp" class="form-text text-muted"><?= lang('admin.project.form.name.help') ?></small>
                </div>

                <div class="form-group">
                    <label for="description"><?= lang('admin.project.form.description.name') ?></label>
                    <input type="text" maxlength="500" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" required>
                    <small id="descriptionHelp" class="form-text text-muted"><?= lang('admin.project.form.description.help') ?></small>
                </div>

                <br>
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