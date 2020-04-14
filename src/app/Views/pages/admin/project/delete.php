<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('general.delete') ?></h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/project/delete/' . $this->data['project']->id) ?>">
                <div class="form-group">
                    <label for="name"><?= lang('project.form.name') ?></label>
                    <input type="text" maxlength="50" class="form-control" id="name" name="name"
                           aria-describedby="nameHelp" value="<?= $this->data['project']->name ?>" disabled>
                    <small id="nameHelp" class="form-text text-muted"><?= lang('project.form.name.help') ?></small>
                </div>

                <div class="form-group">
                    <label for="description"><?= lang('project.form.description') ?></label>
                    <input type="text" maxlength="500" class="form-control" id="description" name="description"
                           aria-describedby="descriptionHelp" value="<?= $this->data['project']->description ?>" disabled>
                    <small id="descriptionHelp" class="form-text text-muted"><?= lang(
                            'project.form.description.help'
                        ) ?></small>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.delete') ?>">
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