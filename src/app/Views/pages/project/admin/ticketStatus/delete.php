<?= $this->extend('layouts/project/layoutAdmin') ?>

<?= $this->section('projectBodyAdmin') ?>
    <a href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketStatus') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>

    <br><br>

    <form method="post" action="<?= site_url(
        'project/' . $this->data['project']->id . '/admin/ticketStatus/delete/' . $this->data['ticketStatus']->id
    ) ?>">
        <div class="form-group">
            <label for="name"><?= lang('project.form.ticketStatus.name.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                   value="<?= $this->data['ticketStatus']->name ?>" disabled>
            <small id="nameHelp" class="form-text text-muted"><?= lang('project.form.ticketStatus.name.help') ?></small>
        </div>

        <br>
        <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.delete') ?>">
    </form>
<?= $this->endSection() ?>