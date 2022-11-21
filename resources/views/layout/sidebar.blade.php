        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/usuarios">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Navegación
            </div>
            <li class="nav-item">
                <a class="nav-link" href="/campus">
                    <i class="fas fa-place-of-worship"></i>
                    <span>Campus</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/edificios">
                    <i class="fas fa-building"></i>
                    <span>Edificios</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/departamentos">
                    <i class="fas fa-object-ungroup"></i>
                    <span>Departamentos</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-check-square"></i>
                    <span>Activos</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Control de activos</h6>
                        <a class="collapse-item" href="/tipoactivos">Tipos Activos</a>
                        <a class="collapse-item" href="/activo">Activo</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-map-marker-question"></i>
                    <span>Espacios</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Control del espacios</h6>
                        <a class="collapse-item" href="/tipoespacios">Tipo Espacios</a>
                        <a class="collapse-item" href="/espacioactivos">Espacio Activos</a>
                        <a class="collapse-item" href="/espacios">Espacios</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="/horarios">
                    <i class="fas fa-calendar-week"></i>
                    <span>Horarios</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/actividad">
                    <i class="fas fa-calendar-check"></i>
                    <span>Actividad</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
