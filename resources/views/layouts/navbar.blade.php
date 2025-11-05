<style>
    .navbar-item {
        color: #e9ecef;
        text-decoration: none;
        background-color: transparent;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 12px 20px;
        display: flex;
        align-items: center;
        font-size: 15px;
        font-weight: 500;
        border-radius: 8px;
        margin: 4px 8px;
        position: relative;
        overflow: hidden;
    }

    .navbar-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 2px;
    }

    .navbar-item:hover {
        color: #ffffff;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        transform: translateX(8px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .navbar-item:hover::before {
        transform: scaleY(1);
    }

    .navbar-item i {
        margin-right: 12px;
        font-size: 18px;
        width: 24px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .navbar-item:hover i {
        transform: scale(1.1);
    }

    /* .nav-flex-column {
        background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        border-radius: 12px;
        padding: 16px 8px;
        margin: 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    } */

    .nav-item {
        margin-bottom: 4px;
    }

    .nav-header {
        padding: 16px 20px 8px;
        color: #bdc3c7;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin: 0 8px 12px;
    }

    /* Efecto de partículas en hover */
    .navbar-item::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        transition: all 0.6s ease;
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    .navbar-item:hover::after {
        width: 120px;
        height: 120px;
    }

    /* Indicador de página activa */
    .navbar-item.active {
        color: #ffffff;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .navbar-item.active::before {
        transform: scaleY(1);
        background: #ffffff;
    }

    /* Animación de entrada para los items */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .nav-item {
        animation: slideIn 0.5s ease forwards;
    }

    .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .nav-item:nth-child(2) { animation-delay: 0.2s; }
    .nav-item:nth-child(3) { animation-delay: 0.3s; }
    .nav-item:nth-child(4) { animation-delay: 0.4s; }
    .nav-item:nth-child(5) { animation-delay: 0.5s; }
</style>

<ul class="nav flex-column nav-flex-column">
    <!-- Encabezado opcional -->
    <div class="nav-header">
        Menú de navegación
    </div>
    
    @isset($navigation)
        @foreach ($navigation as $key_nav => $route_nav)
            <li class="nav-item">
                <a class="nav-link navbar-item {{ request()->is($route_nav) ? 'active' : '' }}" 
                   href="{{ $route_nav }}">
                    <i class="fas fa-{{ $loop->index == 0 ? 'home' : ($loop->index == 1 ? 'chart-bar' : 'credit-card') }}"></i>
                    {{ $key_nav }}
                </a>
            </li>
        @endforeach
    @endisset
</ul>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">