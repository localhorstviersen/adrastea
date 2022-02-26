<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $this->data['title'] ?></h6>
    </div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="<?= site_url(sprintf('project/%d/backlog/view/%d/attach', $this->data['project']->id, $this->data['ticket']->id)) ?>">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="files" name="files[]" multiple/>
                <label class="custom-file-label" for="files"><?= lang('backlog.attachments.form.files') ?></label>
            </div>

            <br><br>
            <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
<a href="<?= site_url(sprintf('project/%s/backlog/view/%s', $this->data['project']->id, $this->data['ticket']->id)) ?>"
   class="btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
</a>
<?= $this->endSection() ?>
