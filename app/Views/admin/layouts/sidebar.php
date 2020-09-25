<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?= env('APP_TITLE'); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/<?= $user_login->avatar ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $user_login->username ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item has-treeview menu-open"> -->
          <li class="nav-item has-treeview">
            <a href="/dashboard" class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= isset($yesMerk) ? 'menu-open' : '' ?>">
            <a href="/merk" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Merk
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/merk" class="nav-link <?= $title == 'Merk' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Merk</p>
                </a>
              </li>
              <?php foreach($merk as $m) :  ?>
              <li class="nav-item">
                <a href="/merk/<?= $m['id'] ?>" class="nav-link <?= $title == ucfirst($m['nama_merk']) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?= $m['nama_merk'] ?></p>
                </a>
              </li>
              <?php endforeach ?>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= isset($yesKategori) ? 'menu-open' : '' ?>">
            <a href="/kategori" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Kategori
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/kategori" class="nav-link <?= $title == 'Kategori' ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Kategori</p>
                </a>
              </li>
              <?php foreach($kategori as $k) :  ?>
              <li class="nav-item">
                <a href="/kategori/<?= $k['id'] ?>" class="nav-link <?= $title == ucfirst($k['nama_kategori']) ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?= $k['nama_kategori'] ?></p>
                </a>
              </li>
              <?php endforeach ?>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="/sepatu" class="nav-link <?= $title == 'Sepatu' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-socks"></i>
              <p>
                Sepatu
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>
          <!-- <li class="nav-item has-treeview menu-close">
            <a href="/sepatu" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Log Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview"> -->
              <li class="nav-item has-treeview ">
                <a href="/sepatumasuk" class="nav-link <?= $title == 'Sepatu Masuk' ? 'active' : '' ?>">
                  <i class="fas fa-sign-in-alt nav-icon"></i>
                  <p>Sepatu Masuk</p>
                </a>
              </li>
            <!-- </ul>
            <ul class="nav nav-treeview"> -->
              <li class="nav-item has-treeview">
                <a href="/sepatukeluar" class="nav-link <?= $title == 'Sepatu Keluar' ? 'active' : '' ?>">
                  <i class="fas fa-sign-out-alt nav-icon"></i>
                  <p>Sepatu Keluar</p>
                </a>
              </li>
            <!-- </ul>
          </li> -->
            <li class="nav-item has-treeview">
              <a href="/detailsepatu" class="nav-link <?= $title == 'Detail Sepatu' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-socks"></i>
                <p>
                  Detail Sepatu
                  <!-- <i class="right fas fa-angle-left"></i> -->
                </p>
              </a>
            </li>
          <?php if($user_login->id_role == 1) : ?>
            <li class="nav-item">
              <a href="/user" class="nav-link <?= $title == 'User' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                  User
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
          <?php endif ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>