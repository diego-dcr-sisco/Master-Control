<style>
    .navbar-brand img {
        max-width: 200px;
        height: auto;
    }

    /* Ajustes para dispositivos móviles */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: #403a34ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .dropdown-menu {
            margin-left: 15px;
            width: calc(100% - 30px);
        }
    }

    /* Mejoras visuales para el botón de toggle */
    .navbar-toggler {
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light  px-3 mb-0 p-1" style="background: linear-gradient(135deg, #ff6a00 0%, #ff8c00 50%, #ce8b10ff 100%); box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);">
    <div class="container-fluid">
        <!-- Logo del menú -->
        <a href=" #"
            class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
        </a>

        <!-- Botón toggle para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link {{-- dropdown-toggle --}} text-light fw-bold" data-bs-toggle="dropdown"
                        href="#" role="button" aria-expanded="false">
                        <i class="bi bi-person-fill"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-lg-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                                    Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>