<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
      
      <span class="brand-text font-weight-light">SLLS<span class="text-primary">Admin</span></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php if($pg==1){echo 'active';}?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                Dashboard
                </p>
            </a>
            </li>
            <li class="nav-item">
                <a href="clients.php" class="nav-link <?php if($pg==2){echo 'active';}?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                    Clients
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="lawyers.php" class="nav-link <?php if($pg==3){echo 'active';}?>">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>
                    Lawyers
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="cases.php" class="nav-link <?php if($pg==4){echo 'active';}?>">
                    <i class="nav-icon fas fa-school"></i>
                    <p>
                    Cases
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link <?php if($pg==5){echo 'active';}?>">
                    <i class="nav-icon fas fa-archive"></i>
                    <p>
                    Case Archives
                    </p>
                </a>
            </li>
                    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>