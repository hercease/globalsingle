<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
    <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
            <!-- ======= Menu collapse Icon ===== -->
            <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                <i class="ti ti-menu-2"></i>
            </a>
            </li>
            <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                <i class="ti ti-menu-2"></i>
            </a>
            </li>
        </ul>
    </div>
    <!-- [Mobile Media Block end] -->
    <div class="ms-auto">
    <ul class="list-unstyled">
        <li class="dropdown pc-h-item header-user-profile">
        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
            <img src="<?php echo $rootUrl ?>/public/assets/images/user/<?php echo $userInfo['avatar']; ?>" alt="user-image" class="user-avtar">
            <span><?php echo $userInfo['username']; ?></span>
        </a>
        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-header">
            <div class="d-flex mb-1">
                <div class="flex-shrink-0">
                <img src="<?php echo $rootUrl ?>/public/assets/images/user/<?php echo $userInfo['avatar']; ?>" alt="user-image" class="user-avtar wid-35">
                </div>
                <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 text-capitalize"><?php echo $userInfo['username']; ?></h6>
                <span>Stage <?php echo $userInfo['stage']; ?></span>
                </div>
                <a href="logout" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
            </div>
            </div>
        </div>
        </li>
    </ul>
    </div>
 </div>
</header>