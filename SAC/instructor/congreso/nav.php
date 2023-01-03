<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Administrar</div>
            <a class="nav-link" href="../index.php">
                <div class="nav-link-icon"><i data-feather="home"></i></div>Inicio
            </a>

            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                <div class="nav-link-icon"><i data-feather="folder"></i></div>Congreso<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse" id="collapseDashboards" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <a class="nav-link" href="index.php">Talleres</a>
                    <a class="nav-link" href="mi_concurso.php">Concursos</a>
                    <a class="nav-link" href="mi_conferencia.php">Conferencias</a>
                </nav>
            </div>

            <a class="nav-link" href="../alumnos.php">
                <div class="nav-link-icon"><i data-feather="users"></i></div>Alumnos
            </a>
            <!-- <a class="nav-link" href="../certificado">
                <div class="nav-link-icon"><i data-feather="award"></i></div>Certificado
            </a> -->

            <div class="sidenav-menu-heading">Perfil</div>
            <a class="nav-link" href="../perfil.php">
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
            <div class="sidenav-footer-title">Instructor</div>
        </div>
    </div>
</nav>