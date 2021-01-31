<?= $this->include('includes/topbar') ?>
<?= $this->include('includes/sidebar') ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->data['projectAdminPage'] === 'general'): ?>active<?php endif; ?>"
                       href="<?= site_url('project/' . $this->data['project']->id . '/admin/general') ?>">
                        <?= lang('project.title.admin.general.short') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->data['projectAdminPage'] === 'ticketType'): ?>active<?php endif; ?>"
                       href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketType') ?>">
                        <?= lang('project.title.admin.ticketTypes.short') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->data['projectAdminPage'] === 'ticketStatus'): ?>active<?php endif; ?>"
                       href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketStatus') ?>">
                        <?= lang('project.title.admin.ticketStatus.short') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->data['projectAdminPage'] === 'ticketFields'): ?>active<?php endif; ?>"
                       href="<?= site_url('project/' . $this->data['project']->id . '/admin/ticketFields') ?>">
                        <?= lang('project.title.admin.ticketFields.short') ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane active">
                    <?= $this->renderSection('projectBodyAdmin') ?>
                </div>
            </div>

            <style>
                .tab-pane {
                    border-left: 1px solid #ddd;
                    border-right: 1px solid #ddd;
                    border-bottom: 1px solid #ddd;
                    border-radius: 0px 0px 5px 5px;
                    padding: 10px;
                }

                .nav-tabs {
                    margin-bottom: 0;
                }
            </style>
        </div>
    </div>
<?= $this->endSection() ?>