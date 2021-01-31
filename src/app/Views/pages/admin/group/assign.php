<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('group.title.assign.titleSub') ?></h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('admin/group/assign/' . $this->data['group']->sId) ?>">
                <?php foreach ($this->data['roles'] as $role): ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="role[<?= $role->id ?>]"
                               name="role[<?= $role->id ?>]" <?php if ($role->active): ?> checked <?php endif; ?>>
                        <label class="custom-control-label" for="role[<?= $role->id ?>]"><?= $role->name ?></label>
                    </div>
                <?php endforeach; ?>

                <br>
                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= site_url('admin/group') ?>"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>
<?= $this->endSection() ?>