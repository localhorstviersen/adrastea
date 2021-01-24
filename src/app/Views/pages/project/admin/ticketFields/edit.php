<?= $this->extend('layouts/project/layoutAdmin') ?>

<?= $this->section('projectBodyAdmin') ?>
    <a href="<?= base_url('project/' . $this->data['project']->id . '/admin/ticketFields') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>

    <br><br>

    <form method="post" action="<?= base_url(
        'project/' . $this->data['project']->id . '/admin/ticketFields/edit/' . $this->data['field']->id
    ) ?>">
        <div class="form-group">
            <label for="identification"><?= lang('project.form.ticketFields.identification.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="identification" name="identification" aria-describedby="identificationHelp"
                   value="<?= $this->data['field']->identification ?>" required>
            <small id="identificationHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.identification.help') ?></small>
        </div>

        <div class="form-group">
            <label for="name"><?= lang('project.form.ticketFields.name.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                   value="<?= $this->data['field']->name ?>" required>
            <small id="nameHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.name.help') ?></small>
        </div>

        <div class="form-group">
            <label for="type"><?= lang('project.form.ticketFields.type.name') ?></label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelp" required>
                <?php foreach (\App\Models\Project\Ticket\Field::getTypes() as $key => $value): ?>
                    <option value="<?= $key ?>" <?= $this->data['field']->type === $key ? 'selected'
                        : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <small id="typeHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.type.help') ?></small>
        </div>

        <div class="form-group">
            <label for="description"><?= lang('project.form.ticketFields.description.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="description" name="description"
                   aria-describedby="descriptionHelp" value="<?= $this->data['field']->description ?>" required>
            <small id="descriptionHelp" class="form-text text-muted"><?= lang(
                    'project.form.ticketFields.description.help'
                ) ?></small>
        </div>

        <br>
        <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
    </form>
<?= $this->endSection() ?>