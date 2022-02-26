<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $this->data['title'] ?></h6>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach ($this->data['fields'] as $key => $field): ?>
                <?php
                if ($key === 'description') {
                    continue;
                }
                ?>
                <div class="col-lg-6 col-xl-4">
                    <?= $field->display() ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <?= $this->data['fields']['description']->display() ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Anhänge</h6>
        <?php if($this->data['user']->hasProjectRight($this->data['project'], \App\Models\ProjectRoleRights::RIGHT_PROJECT_TICKET_ATTACH_FILES)): ?>
            <a href="<?= site_url(sprintf('project/%s/backlog/view/%s/attach', $this->data['project']->id, $this->data['ticket']->id)) ?>" class="btn btn-sm btn-primary">Anhang hinzufügen</a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?= $this->data['attachmentTable'] ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= site_url('project/' . $this->data['project']->id . '/backlog') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>
<?= $this->endSection() ?>