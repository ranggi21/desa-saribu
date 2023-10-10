<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <!-- Sidebar Header -->
        <?= $this->include('web/layouts/sidebar_header'); ?>

        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3" id="avatar-sidebar">
                    <img src="<?= base_url('media/photos/pesona_saribu.png'); ?>" alt="" srcset="">
                </div>
                <?php if (logged_in()) : ?>
                    <div class="p-2 text-center">
                        <?php if (!empty(user()->first_name)) : ?>
                            Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span>
                        <?php else : ?>
                            Hello, <span class="fw-bold">@<?= user()->username; ?></span>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">
                    <li class="sidebar-item">
                        <a href="<?= base_url('web'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span> Home</span>
                        </a>
                    </li>

                    <!-- DASHBOARD -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'dashboard') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/'); ?>" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i><span> Dashboard</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Manage RG-->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'rumahGadang') ? 'active' : '' ?> has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-campground"></i><span>RG Menu</span>
                            </a>

                            <ul class="submenu <?= ($uri1 == 'event') ? 'active' : '' ?>">
                                <!-- List Package -->
                                <li class="submenu-item" id="rg-list">
                                    <a href="<?= base_url('dashboard/rumahGadang'); ?>" class="sidebar-link">
                                        <i class="fa-solid fa-campground"></i><span> Rumah Gadang </span>
                                    </a>
                                </li>
                                <!-- List Package -->
                                <li class="submenu-item" id="rgf-list">
                                    <a href="<?= base_url('dashboard/facility'); ?>" class="sidebar-link">
                                        <i class="fa-solid fa-house-circle-check"></i><span> RG Facility</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Tourism Package-->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'package') ? 'active' : '' ?> has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-bullhorn"></i><span>TP Menu</span>
                            </a>

                            <ul class="submenu <?= ($uri1 == 'event') ? 'active' : '' ?>">
                                <!-- List Package -->
                                <li class="submenu-item" id="tp-list">
                                    <a href="<?= base_url('dashboard/package'); ?>" class="sidebar-link">
                                        <i class="fa-solid fa-location-dot"></i><span> Tourism Package</span>
                                    </a>
                                </li>
                                <!-- List Package Day -->
                                <li class="submenu-item" id="s-list">
                                    <a href="<?= base_url('dashboard/service'); ?>" class="sidebar-link">
                                        <i class="fa-solid fa-location-dot"></i><span> TP Service</span>
                                    </a>
                                </li>
                                <!-- List Package Day -->
                                <li class="submenu-item" id="pd-list">
                                    <a href="<?= base_url('dashboard/packageDay'); ?>" class="sidebar-link">
                                        <i class="fa-solid fa-location-dot"></i><span> TP Day</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>


                    <!-- Manage UP -->
                    <!-- <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'uniquePlace') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/uniquePlace'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-location-dot"></i><span>Unique Place</span>
                            </a>
                        </li>
                     <?php endif; ?> -->

                    <!-- Manage EV -->
                    <?php if (in_groups(['users'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'event') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/event'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-bullhorn"></i><span> Event</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Recommendation -->
                    <?php if (in_groups(['users'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'recommendation') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/recommendation'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-star"></i><span> Recommendation</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Users -->
                    <?php if (in_groups(['users'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'users') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/users'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-users"></i><span> Users</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>