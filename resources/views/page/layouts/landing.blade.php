<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MejoraSoft ERP - Solución para Construcción')</title>
    <meta name="description" content="Sistema ERP especializado para empresas de construcción. Gestiona proyectos, nómina, contabilidad y más.">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/page/logopage.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('img/page/logopage.png') }}">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    
    <style>
        /* ========== VARIABLES ========== */
        :root {
            --primary: #083CAE;
            --primary-dark: #062D82;
            --primary-light: #3b82f6;
            --secondary: #2CBF1F;
            --accent: #eaf512;
            --dark: #0a0a1a;
            --text-light: #f8f9fa;
            --text-dark: #1a1a2e;
            --gradient-primary: linear-gradient(135deg, #083CAE 0%, #1a4fc3 50%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #2CBF1F 0%, #34d399 100%);
            --shadow-lg: 0 20px 60px rgba(8, 60, 174, 0.15);
            --shadow-xl: 0 30px 80px rgba(8, 60, 174, 0.2);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* ========== UTILITIES ========== */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-padding {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.8;
        }

        .btn-primary {
            display: inline-block;
            padding: 16px 40px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(8, 60, 174, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(8, 60, 174, 0.4);
        }

        .btn-secondary {
            display: inline-block;
            padding: 16px 40px;
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* ========== NAVBAR ========== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 16px 0;
            transition: var(--transition);
            background: transparent;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 12px 0;
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            transition: var(--transition);
        }

        .navbar-brand span {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
        }

        .navbar-brand span small {
            font-weight: 400;
            font-size: 0.8rem;
            color: #6b7280;
            display: block;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .navbar-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .navbar-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        .navbar-links a:hover::after {
            width: 100%;
        }

        .navbar-links a:hover {
            color: var(--primary);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            padding: 10px 24px;
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-login:hover {
            background: var(--primary);
            color: white;
        }

        .btn-demo {
            padding: 10px 24px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(8, 60, 174, 0.3);
        }

        .btn-demo:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(8, 60, 174, 0.4);
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-dark);
            padding: 8px;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .navbar-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 20px;
                flex-direction: column;
                gap: 16px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border-radius: 0 0 20px 20px;
            }

            .navbar-links.active {
                display: flex;
            }

            .navbar-actions {
                display: none;
            }

            .navbar-actions.mobile-visible {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
        }

        /* ========== HERO SECTION ========== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #e0e7ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(8, 60, 174, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(44, 191, 31, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }

        .hero-content h1 .highlight {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #4b5563;
            line-height: 1.8;
            margin-bottom: 2rem;
            max-width: 500px;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(8, 60, 174, 0.1);
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat .number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }

        .hero-stat .label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            .hero .container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-content p {
                margin: 0 auto 2rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-stats {
                justify-items: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            .hero-stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }

        /* ========== FEATURES / MÓDULOS ========== */
        .features {
            background: #ffffff;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: var(--transition);
            border: 1px solid #f0f0f0;
            text-align: center;
            cursor: default;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            background: var(--gradient-primary);
        }

        .feature-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            color: var(--text-dark);
        }

        .feature-card p {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* ========== STATS SECTION ========== */
        .stats-section {
            background: var(--gradient-primary);
            color: white;
            padding: 60px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .stat-item .number {
            font-size: 3rem;
            font-weight: 900;
            display: block;
        }

        .stat-item .label {
            font-size: 1rem;
            opacity: 0.8;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .stat-item .number {
                font-size: 2rem;
            }
        }

        /* ========== TESTIMONIALS ========== */
        .testimonials {
            background: #f8fafc;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .testimonial-card .quote {
            font-size: 1rem;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-card .author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .testimonial-card .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .testimonial-card .author-info h4 {
            font-weight: 700;
            font-size: 1rem;
        }

        .testimonial-card .author-info p {
            font-size: 0.85rem;
            color: #6b7280;
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            background: var(--gradient-primary);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.8;
        }

        .cta-section .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .cta-section .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: var(--dark);
            color: #9ca3af;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand img {
            height: 45px;
            margin-bottom: 16px;
        }

        .footer-brand p {
            font-size: 0.95rem;
            line-height: 1.8;
            max-width: 300px;
        }

        .footer h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul a {
            color: #9ca3af;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer ul a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }

            .footer-brand p {
                margin: 0 auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ========== NAVBAR ========== -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ route('landing') }}" class="navbar-brand">
                <img src="{{ asset('img/page/logopage.png') }}" alt="MejoraSoft ERP">
            </a>

            <ul class="navbar-links" id="navbarLinks">
                <li><a href="#features">Módulos</a></li>
                <li><a href="#modules">Características</a></li>
                <li><a href="#testimonials">Servicios</a></li>
                <li><a href="#contact">Contacto</a></li>
            </ul>

            <div class="navbar-actions">
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="#demo" class="btn-demo">
                    <i class="fas fa-play"></i> Ver Demo
                </a>
            </div>

            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <main>
        @yield('content')
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="{{ asset('img/page/logopage.png') }}" alt="MejoraSoft" style="height: 50px;">
                    <p>
                        Sistema ERP especializado para la industria de la construcción. 
                        Gestiona proyectos, finanzas, recursos humanos y más en una sola plataforma.
                    </p>
                </div>
                <div>
                    <h4>Módulos</h4>
                    <ul>
                        <li><a href="#">Proyectos</a></li>
                        <li><a href="#">Administración</a></li>
                        <li><a href="#">Contabilidad</a></li>
                        <li><a href="#">RRHH</a></li>
                        <li><a href="#">Almacén</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Recursos</h4>
                    <ul>
                        <li><a href="#">Documentación</a></li>
                        <li><a href="#">Soporte</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contacto</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +52 (33) 1234-5678</li>
                        <li><i class="fas fa-envelope"></i> info@mejorasoft.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Guadalajara, Jalisco</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} MejoraSoft ERP. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- ========== JAVASCRIPT ========== -->
    <script>
        // ===== Navbar Scroll Effect =====
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // ===== Mobile Menu Toggle =====
        function toggleMobileMenu() {
            const links = document.getElementById('navbarLinks');
            links.classList.toggle('active');
        }

        // ===== Smooth Scroll =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Cerrar menú móvil
                    document.getElementById('navbarLinks')?.classList.remove('active');
                }
            });
        });

        // ===== Animación de números (stats) =====
        function animateNumbers() {
            const stats = document.querySelectorAll('.stat-item .number');
            stats.forEach(stat => {
                const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
                if (target > 0) {
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = target.toLocaleString() + '+';
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 30);
                }
            });
        }

        // ===== Intersection Observer para animaciones =====
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumbers();
                }
            });
        }, { threshold: 0.5 });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // ===== Fade-in en scroll =====
        const fadeElements = document.querySelectorAll('.feature-card, .testimonial-card');
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            fadeObserver.observe(el);
        });
    </script>

    @stack('scripts')
</body>
</html>