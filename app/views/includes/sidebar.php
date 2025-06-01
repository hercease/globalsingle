<nav class="pc-sidebar pc-trigger">
  <div class="navbar-wrapper" style="display: block;">
    <div class="m-header">
      <a href="/" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img width="100" src="<?php echo $rootUrl ?>/public/assets/images/logo_new.png" class="img-fluid" alt="logo">
      </a>
    </div>
    <div class="navbar-content pc-trigger active simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: -10px 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 10px 0px;">
      <ul class="pc-navbar" style="display: block;">
        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <?php if($userInfo['admin_access'] > 0){ ?>

          <li class="pc-item pc-caption">
            <label>Admin</label>
            <i class="ti ti-dashboard"></i>
          </li>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/statistics" class="pc-link">
              <span class="pc-micon"><i class="ti ti-activity"></i></span>
              <span class="pc-mtext">Home</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/allusers" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">All users</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/vendor_requests" class="pc-link">
              <span class="pc-micon"><i class="ti ti-user"></i></span>
              <span class="pc-mtext">Vendor Requests</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/all_wallets" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wallet"></i></span>
              <span class="pc-mtext">All wallets</span>
            </a>
          </li>

        <?php } ?>

        <li class="pc-item pc-caption">
          <label>Profile</label>
          <i class="ti ti-dashboard"></i>
        </li>

        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/profile" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user"></i></span>
            <span class="pc-mtext">Profile Account</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Finance</label>
          <i class="ti ti-news"></i>
        </li>

        <li class="pc-item">
          <a href="#" class="pc-link">
            <span class="pc-micon"><i class="ti ti-transaction-dollar"></i></span>
            <span class="pc-mtext">Global Fund Transfer</span>
          </a>
        </li>

        <li class="pc-item">
          <a href="#" class="pc-link">
            <span class="pc-micon"><i class="ti ti-users-group"></i></span>
            <span class="pc-mtext">Crypto Escrow</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Transactions</label>
          <i class="ti ti-news"></i>
        </li>

        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/transaction_history" class="pc-link">
            <span class="pc-micon"><i class="ti ti-clock"></i></span>
            <span class="pc-mtext">Transaction History</span>
          </a>
        </li>

        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/wallet_transfer" class="pc-link">
            <span class="pc-micon"><i class="ti ti-exchange"></i></span>
            <span class="pc-mtext">Wallet Transfer</span>
          </a>
        </li>

        <?php if($userInfo['vendor_access'] === 0){ ?>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/vendors" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wallet"></i></span>
              <span class="pc-mtext">Buy Reg wallet</span>
            </a>
          </li>

        <?php } else { ?>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/generate_reg_pin" class="pc-link">
              <span class="pc-micon"><i class="ti ti-exchange"></i></span>
              <span class="pc-mtext">Generate Reg PIN</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="<?php echo $rootUrl ?>/fund_wallet" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wallet"></i></span>
              <span class="pc-mtext">Fund wallet</span>
            </a>
          </li>

        <?php } ?>
        
        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/withdrawal" class="pc-link">
            <span class="pc-micon"><i class="ti ti-arrow-bar-to-down"></i></span>
            <span class="pc-mtext">Withdraw Funds</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Chats</label>
          <i class="ti ti-news"></i>
        </li>

        <li class="pc-item">
          <a href="<?php echo $rootUrl ?>/my_chats" class="pc-link">
            <span class="pc-micon"><i class="ti ti-message"></i></span>
            <span class="pc-mtext">My Chats</span>
          </a>
        </li>

        <li class="pc-item">
          <a href="#" class="pc-link">
            <span class="pc-micon"><i class="ti ti-message"></i></span>
            <span class="pc-mtext">Chat Room</span>
          </a>
        </li>


        <li class="pc-item pc-caption">
          <label>Promotion</label>
          <i class="ti ti-news"></i>
        </li>

        <li class="pc-item">
          <a href="become_a_vendor" class="pc-link">
            <span class="pc-micon"><i class="ti ti-help"></i></span>
            <span class="pc-mtext">Become A vendor</span>
          </a>
        </li>

      </ul>
  </div>
</nav>