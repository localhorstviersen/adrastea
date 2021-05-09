<?= $this->section('sidebar') ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('home') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= env('app.site.title') ?></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php if(\Config\Services::uri()->getSegment(1) === 'home'): ?>active<?php endif; ?>">
        <a class="nav-link" href="<?= site_url('home') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Deine Projeke</div>

    <?php foreach ($this->data['user']->getProjects() as $project): ?>
        <li class="nav-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id): ?>active<?php endif; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#project-<?= $project->id ?>" aria-expanded="true"
               aria-controls="collapseTwo">
                <i class="fas fa-fw fa-users"></i>
                <span><?= $project->name ?></span>
            </a>
            <div id="project-<?= $project->id ?>" class="collapse <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id): ?>show<?php endif; ?>"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id && $this->data['segments'][2] === 'start'): ?>active<?php endif; ?>" href="<?= site_url('project/' . $project->id . '/start') ?>">Start</a>
                    <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id && $this->data['segments'][2] === 'backlog'): ?>active<?php endif; ?>" href="<?= site_url('project/' . $project->id . '/backlog') ?>">Backlog</a>
                    <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id && $this->data['segments'][2] === 'kanban'): ?>active<?php endif; ?>" href="<?= site_url('project/' . $project->id . '/kanban') ?>">Kanban</a>

                    <?php if ($this->data['user']->hasProjectRight($project, \App\Models\ProjectRoleRights::RIGHT_PROJECT_ADMIN)): ?>
                        <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'project' && $this->data['segments'][1] === $project->id && $this->data['segments'][2] === 'admin'): ?>active<?php endif; ?>" href="<?= site_url('project/' . $project->id . '/admin/general') ?>">Admin</a>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>

    <?php if ($this->data['user']->hasRight(\App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN)): ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Administration</div>

        <?php if ($this->data['user']->hasRight(\App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_PROJECT_MANAGE)): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#projectManagement"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Projektverwaltung</span>
                </a>
                <div id="projectManagement" class="collapse <?php if($this->data['inProjectManagement']): ?>show<?php endif; ?>" aria-labelledby="headingTwo"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Projektverwaltung:</h6>

                        <a class="collapse-item <?php if (!empty($this->data['segments']) && $this->data['segments'][0] === 'admin' && $this->data['segments'][1] === 'project'): ?>active<?php endif; ?>" href="<?= site_url('admin/project') ?>">Projekte</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>

        <?php if ($this->data['user']->hasOneRight(
            \App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_GROUP,
            \App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_USER,
            \App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_ROLE
        )): ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userManagement"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Benutzerverwaltung</span>
                </a>
                <div id="userManagement" class="collapse <?php if($this->data['inUserManagement']): ?>show<?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Benutzerverwaltung:</h6>

                        <?php if ($this->data['user']->hasRight(\App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_GROUP)): ?>
                            <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'admin' && $this->data['segments'][1] === 'group'): ?>active<?php endif; ?>" href="<?= site_url('admin/group') ?>">Gruppen</a>
                        <?php endif; ?>

                        <?php if ($this->data['user']->hasRight(\App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_USER)): ?>
                            <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'admin' && $this->data['segments'][1] === 'user'): ?>active<?php endif; ?>" href="<?= site_url('admin/user') ?>">Benutzer</a>
                        <?php endif; ?>

                        <?php if ($this->data['user']->hasRight(\App\Models\Roles\Rights::RIGHT_GLOBAL_ADMIN_ROLE)): ?>
                            <a class="collapse-item <?php if(!empty($this->data['segments']) && $this->data['segments'][0] === 'admin' && $this->data['segments'][1] === 'role'): ?>active<?php endif; ?>" href="<?= site_url('admin/role') ?>">Benutzerrollen</a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<?= $this->endSection() ?>
