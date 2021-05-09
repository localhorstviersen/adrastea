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
            <label for="ticketType"><?= lang('project.form.ticketFields.ticketType.name') ?></label>
            <select multiple class="form-control" id="ticketType" name="ticketTypes[]" aria-describedby="ticketTypeHelp">
                <?php foreach (\App\Models\Project\Ticket\Types::getTypes() as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <small id="ticketTypeHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.ticketType.help') ?></small>
        </div>

        <div class="form-group">
            <label for="type"><?= lang('project.form.ticketFields.type.name') ?></label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelp" required>
                <?php foreach (\App\Models\Project\Ticket\Field::getTypesForFieldCreation() as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
            </select>
            <small id="typeHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.type.help') ?></small>
        </div>

        <div class="form-group" id="definitionPart" style="display: none;">
            <label for="definition"><?= lang('project.form.ticketFields.definition.name') ?></label>
            <input type="text" maxlength="50" class="form-control" id="definition" name="definition" aria-describedby="definition">
            <small id="definitionHelp" class="form-text text-muted"><?= lang('project.form.ticketFields.definition.help.default') ?></small>
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

<?= $this->section('customJs') ?>
    <script type="application/javascript">
        let typeElement = document.getElementById('type');
        typeElement.addEventListener('change', onChange);

        function onChange(element) {
            let definitionPart = document.getElementById('definitionPart');
            let definitionHelp = document.getElementById('definitionHelp');
            let value = element.target.value;
            console.log(element);

            if (value === '<?= \App\Models\Project\Ticket\Field::TYPE_CHECK_BOX ?>' || value === '<?= \App\Models\Project\Ticket\Field::TYPE_RADIO_BOX ?>') {
                definitionPart.style.display = '';
                definitionHelp.innerHTML = '<?= lang('project.form.ticketFields.definition.help.selectFields') ?>';
            } else if (value === '<?= \App\Models\Project\Ticket\Field::TYPE_PREDEFINED_LINK ?>') {
                definitionPart.style.display = '';
                definitionHelp.innerHTML = '<?= lang('project.form.ticketFields.definition.help.predefinedLinkField') ?>';
            } else {
                definitionPart.style.display = 'none';
            }
        }
    </script>
<?= $this->endSection() ?>