<?= $this->extend('layouts/project/layoutAdmin') ?>

<?= $this->section('projectBodyAdmin') ?>
    <a href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketType') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>

    <br><br>

    <form method="post" action="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketType/create') ?>">
        <div class="form-group">
            <label for="name"><?= lang('project.form.ticketType.name.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="name" name="name" aria-describedby="nameHelp" required>
            <small id="nameHelp" class="form-text text-muted"><?= lang('project.form.ticketType.name.help') ?></small>
        </div>

        <br>
        <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
    </form>
<?= $this->endSection() ?>