<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= lang('backlog.title.ticket.create', ['projectName'=> $this->data['project']->name]) ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form method="post" action="<?= site_url(sprintf('project/%d/backlog/create/%d', $this->data['project']->id, $this->data['ticketTypeId'])) ?>">
                <?php foreach ($this->data['fields'] as $field): ?>
                    <?= $field->display() ?>
                <?php endforeach; ?>

                <br>
                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('general.save') ?>">
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('titleButtons') ?>
    <a href="<?= site_url('project/' . $this->data['project']->id . '/backlog') ?>"
       class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?= lang('general.back') ?>
    </a>
<?= $this->endSection() ?>