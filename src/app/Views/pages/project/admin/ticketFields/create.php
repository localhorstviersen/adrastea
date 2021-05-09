<?= $this->extend('layouts/project/layoutAdmin') ?>

<?= $this->section('projectBodyAdmin') ?>
    <a href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketFields') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>

    <br><br>

    <form method="post"
          action="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketFields/create') ?>">
        <div class="form-group">
            <label for="identification"><?= lang('project.form.ticketFields.identification.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="identification" name="identification" aria-describedby="identificationHelp"
                   required>
            <small id="identificationHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.identification.help') ?></small>
        </div>

        <div class="form-group">
            <label for="name"><?= lang('project.form.ticketFields.name.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                   required>
            <small id="nameHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.name.help') ?></small>
        </div>

        <div class="form-group">
            <label for="type"><?= lang('project.form.ticketFields.type.name') ?></label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelp" required>
                <?php foreach (\App\Models\Project\Ticket\Field::getTypes() as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <small id="typeHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.type.help') ?></small>
        </div>

        <div class="form-group">
            <label for="description"><?= lang('project.form.ticketFields.description.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="description" name="description"
                   aria-describedby="descriptionHelp" required>
            <small id="descriptionHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.description.help') ?></small>
        </div>

        <div class="form-group">
            <label for="required"><?= lang('project.form.ticketFields.required.name') ?></label>
            <select class="form-control" id="required" name="required" aria-describedby="requiredHelp" required>
                <option value="0"><?= lang('general.no') ?></option>
                <option value="1"><?= lang('general.yes') ?></option>
            </select>
            <small id="requiredHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.required.help') ?></small>
        </div>

        <br>
        <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
    </form>
<?= $this->endSection() ?>