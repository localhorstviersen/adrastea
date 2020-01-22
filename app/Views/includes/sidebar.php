<?= $this->section('sidebar') ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('home') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= env('app.site.title') ?></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('home') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span>
        </a>
    </li>

    <?php if ($this->data['user']->hasRight(\App\Models\RolesRights::RIGHT_GLOBAL_ADMIN)): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Administration</div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userManagement"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-users"></i>
                <span>Benutzerverwaltung</span>
            </a>
            <div id="userManagement" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Benutzerverwaltung:</h6>

                    <?php if ($this->data['user']->hasRight(\App\Models\RolesRights::RIGHT_GLOBAL_ADMIN_GROUP)): ?>
                        <a class="collapse-item" href="<?= base_url('admin/group') ?>">Gruppen</a>
                    <?php endif; ?>

                    <?php if ($this->data['user']->hasRight(\App\Models\RolesRights::RIGHT_GLOBAL_ADMIN_USER)): ?>
                        <a class="collapse-item" href="<?= base_url('admin/user') ?>">Benutzer</a>
                    <?php endif; ?>

                    <?php if ($this->data['user']->hasRight(\App\Models\RolesRights::RIGHT_GLOBAL_ADMIN_ROLE)): ?>
                        <a class="collapse-item" href="<?= base_url('admin/roles') ?>">Benutzerrollen</a>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<?= $this->endSection() ?>
