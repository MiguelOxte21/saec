<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Administrar</div>
            <a class="nav-link" href="index.php">
                <div class="nav-link-icon"><i data-feather="home"></i></div>Inicio
            </a>

            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                <div class="nav-link-icon"><i data-feather="folder"></i></div>Congreso<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="congreso/index.php">Talleres</a>
                    <a class="nav-link" href="congreso/concursos.php">Concursos</a>
                    <a class="nav-link" href="congreso/conferencias.php">Conferencias</a>
                    <a class="nav-link" href="../../SISTEMA_ENCUESTAS/administrador/index.php">Encuestas</a>
                    <a class="nav-link" href="../../certi/index.php">Certificado</a>
                     
                </nav>
            </div>

            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="nav-link-icon"><i data-feather="folder"></i></div>Personal<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                    <a class="nav-link" href="personal/instructores.php">Instructores</a>
                    <a class="nav-link" href="personal/alumnos.php">Alumnos</a>
                    <a class="nav-link" href="personal/activados.php">Activación</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsOtros" aria-expanded="false" aria-controls="collapseLayoutsOtros">
                <div class="nav-link-icon"><i data-feather="folder"></i></div>Otros<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayoutsOtros" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                    <a class="nav-link" href="otros/index.php">Logo</a>
                    <a class="nav-link" href="otros/avisos.php">Avisos</a>
                </nav>
            </div>

            <div class="sidenav-menu-heading">Perfil</div>
            <a class="nav-link" href="perfil.php">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Perfil
            </a>
            <a class="nav-link" href="../../logout.php">
                <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                Salir
            </a>
        </div>
    </div>
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logeado como:</div>
            <div class="sidenav-footer-title">Administrador</div>
        </div>
    </div>
</nav>
