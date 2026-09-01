@extends('page.layouts.landing')

@section('title', 'MejoraSoft ERP - Solución Integral para Construcción')

@section('content')

<style>
    /* ============================================
       PALETA DE COLORES PERSONALIZADA
    ============================================ */
    :root {
        --color-primary: #002A4A;
        --color-primary-dark: #001a2e;
        --color-primary-light: #003d6b;
        --color-blue-bright: #0057E8;
        --color-blue-light: #e8f0fe;
        --color-green: #2FB41E;
        --color-green-light: #e8f5e6;
        --color-white: #ffffff;
        --color-gray-50: #f8fafc;
        --color-gray-100: #f1f5f9;
        --color-gray-200: #e2e8f0;
        --color-gray-300: #cbd5e1;
        --color-gray-400: #94a3b8;
        --color-gray-500: #64748b;
        --color-gray-600: #475569;
        --color-gray-700: #334155;
        --color-gray-800: #1e293b;
        --color-gray-900: #0f172a;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        --gradient-primary: linear-gradient(135deg, #002A4A 0%, #0057E8 100%);
        --gradient-green: linear-gradient(135deg, #2FB41E 0%, #45d830 100%);
        --gradient-hero: linear-gradient(135deg, #001a2e 0%, #002A4A 50%, #0057E8 100%);
    }

    /* ============================================
       RESET & BASE
    ============================================ */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: var(--color-white);
        color: var(--color-gray-800);
        overflow-x: hidden;
        line-height: 1.6;
    }

    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .section-padding {
        padding: 100px 0;
    }

    /* ============================================
       SCROLLBAR
    ============================================ */
    ::-webkit-scrollbar {
        width: 10px;
    }
    ::-webkit-scrollbar-track {
        background: var(--color-gray-100);
    }
    ::-webkit-scrollbar-thumb {
        background: var(--gradient-primary);
        border-radius: 5px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--color-primary);
    }

    /* ============================================
       TYPOGRAPHY
    ============================================ */
    .section-title {
        font-size: 2.8rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 1rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .section-title.white {
        background: none;
        -webkit-text-fill-color: white;
        color: white;
    }

    .section-subtitle {
        text-align: center;
        font-size: 1.15rem;
        color: var(--color-gray-500);
        max-width: 650px;
        margin: 0 auto 3rem;
        line-height: 1.8;
    }

    .section-subtitle.white {
        color: rgba(255, 255, 255, 0.85);
    }

    /* ============================================
       BUTTONS
    ============================================ */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(0, 87, 232, 0.35);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 35px rgba(0, 87, 232, 0.45);
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        background: transparent;
        color: var(--color-white);
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-green {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        background: var(--gradient-green);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(47, 180, 30, 0.35);
    }

    .btn-green:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 35px rgba(47, 180, 30, 0.45);
    }

    /* ============================================
       NAVBAR
    ============================================ */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 18px 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
    }

    .navbar.scrolled {
        background: rgba(0, 42, 74, 0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 2px 30px rgba(0, 0, 0, 0.15);
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
        gap: 14px;
        text-decoration: none;
    }

    .navbar-brand img {
        height: 45px;
        width: auto;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover img {
        transform: scale(1.05);
    }

    .navbar-brand span {
        font-size: 1.4rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.02em;
    }

    .navbar-brand span small {
        font-weight: 400;
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.7);
        display: block;
        letter-spacing: 0.05em;
    }

    .navbar-links {
        display: flex;
        align-items: center;
        gap: 32px;
        list-style: none;
    }

    .navbar-links a {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        position: relative;
        padding: 4px 0;
    }

    .navbar-links a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--color-blue-bright);
        transition: width 0.3s ease;
    }

    .navbar-links a:hover {
        color: white;
    }

    .navbar-links a:hover::after {
        width: 100%;
    }

    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-login {
        padding: 10px 24px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-login:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }

    .btn-demo {
        padding: 10px 24px;
        background: var(--gradient-green);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(47, 180, 30, 0.3);
    }

    .btn-demo:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(47, 180, 30, 0.4);
    }

    .mobile-menu-btn {
        display: none;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        font-size: 1.5rem;
        cursor: pointer;
        color: white;
        padding: 8px 14px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .mobile-menu-btn:hover {
        background: rgba(255, 255, 255, 0.2);
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
            background: rgba(0, 42, 74, 0.98);
            backdrop-filter: blur(20px);
            padding: 24px;
            flex-direction: column;
            gap: 16px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .navbar-links.active {
            display: flex;
        }

        .navbar-actions {
            display: none;
        }
    }

    /* ============================================
       HERO SECTION - IMAGEN DE LADO A LADO
    ============================================ */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 120px 0 80px;
        background: var(--gradient-hero);
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(0, 87, 232, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 4s ease-in-out infinite;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(47, 180, 30, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 5s ease-in-out infinite reverse;
    }

    @keyframes pulseGlow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
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
        font-size: 3.8rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: white;
        letter-spacing: -0.02em;
        animation: fadeInUp 1s ease;
    }

    .hero-content h1 .highlight {
        background: linear-gradient(135deg, #2FB41E 0%, #45d830 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.8;
        margin-bottom: 2rem;
        max-width: 500px;
        animation: fadeInUp 1.2s ease;
    }

    .hero-buttons {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        animation: fadeInUp 1.4s ease;
    }

    .hero-image {
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeInRight 1s ease;
    }

    .hero-image img {
        max-width: 100%;
        height: auto;
        border-radius: 24px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        animation: floatImage 6s ease-in-out infinite;
        transition: all 0.5s ease;
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .hero-image img:hover {
        transform: scale(1.02) rotate(-1deg);
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
    }

    @keyframes floatImage {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        animation: fadeInUp 1.6s ease;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat .number {
        font-size: 2rem;
        font-weight: 800;
        color: #2FB41E;
        display: block;
    }

    .hero-stat .label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
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
            font-size: 2.8rem;
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

    /* ============================================
       FEATURES / MÓDULOS
    ============================================ */
    .features {
        background: var(--color-white);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: var(--color-white);
        border-radius: 20px;
        padding: 35px 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--color-gray-200);
        text-align: center;
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
        transform: scaleX(0);
        transition: transform 0.4s ease;
        transform-origin: left;
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 42, 74, 0.12);
        border-color: var(--color-blue-bright);
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
        transition: all 0.4s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(-5deg);
        background: var(--gradient-green);
    }

    .feature-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--color-gray-800);
    }

    .feature-card p {
        color: var(--color-gray-500);
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .feature-card .learn-more {
        display: inline-block;
        margin-top: 16px;
        color: var(--color-blue-bright);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .feature-card .learn-more i {
        transition: transform 0.3s ease;
        display: inline-block;
    }

    .feature-card:hover .learn-more i {
        transform: translateX(5px);
    }

    /* ============================================
       ABOUT / QUIENES SOMOS
    ============================================ */
    .about-section {
        background: var(--color-gray-50);
        position: relative;
        overflow: hidden;
    }

    .about-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(0, 87, 232, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .about-image img {
        width: 100%;
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        transition: all 0.5s ease;
    }

    .about-image img:hover {
        transform: scale(1.02);
    }

    .about-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .about-content p {
        color: var(--color-gray-600);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .about-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 24px;
    }

    .about-feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        color: var(--color-gray-700);
    }

    .about-feature-item i {
        color: var(--color-green);
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
        }
        .about-features {
            grid-template-columns: 1fr;
        }
        .about-content h2 {
            font-size: 2rem;
        }
    }

    /* ============================================
       WHY US / POR QUÉ PREFERIRNOS
    ============================================ */
    .why-us {
        background: var(--color-white);
    }

    .why-us-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .why-us-item {
        text-align: center;
        padding: 30px 20px;
        border-radius: 16px;
        transition: all 0.4s ease;
        border: 1px solid var(--color-gray-200);
        background: var(--color-white);
    }

    .why-us-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--color-blue-bright);
    }

    .why-us-item .icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
        color: white;
        background: var(--gradient-primary);
        transition: all 0.4s ease;
    }

    .why-us-item:hover .icon {
        background: var(--gradient-green);
        transform: rotateY(180deg);
    }

    .why-us-item h4 {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: var(--color-gray-800);
    }

    .why-us-item p {
        color: var(--color-gray-500);
        font-size: 0.95rem;
        line-height: 1.7;
    }

    /* ============================================
       STATS
    ============================================ */
    .stats-section {
        background: var(--gradient-primary);
        padding: 70px 0;
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 6s ease-in-out infinite;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .stat-item .number {
        font-size: 3.2rem;
        font-weight: 900;
        display: block;
        color: white;
        line-height: 1.2;
    }

    .stat-item .label {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .stat-item .number {
            font-size: 2.2rem;
        }
    }

    /* ============================================
       TESTIMONIALS
    ============================================ */
    .testimonials {
        background: var(--color-gray-50);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background: var(--color-white);
        border-radius: 20px;
        padding: 35px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--color-gray-200);
        transition: all 0.4s ease;
        position: relative;
    }

    .testimonial-card::before {
        content: '\201C';
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 4rem;
        color: var(--color-blue-bright);
        opacity: 0.1;
        font-family: Georgia, serif;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .testimonial-card .quote {
        font-size: 1rem;
        line-height: 1.8;
        color: var(--color-gray-600);
        margin-bottom: 20px;
        font-style: italic;
        position: relative;
        z-index: 1;
    }

    .testimonial-card .author {
        display: flex;
        align-items: center;
        gap: 14px;
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
        flex-shrink: 0;
    }

    .testimonial-card .author-info h4 {
        font-weight: 700;
        font-size: 1rem;
        color: var(--color-gray-800);
    }

    .testimonial-card .author-info p {
        font-size: 0.85rem;
        color: var(--color-gray-500);
    }

    /* ============================================
       CTA SECTION
    ============================================ */
    .cta-section {
        background: var(--gradient-primary);
        padding: 80px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(47, 180, 30, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulseGlow 5s ease-in-out infinite;
    }

    .cta-section h2 {
        font-size: 2.8rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .cta-section p {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 600px;
        margin: 0 auto 2rem;
        line-height: 1.8;
        position: relative;
        z-index: 1;
    }

    .cta-section .btn-primary {
        background: white;
        color: var(--color-primary);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .cta-section .btn-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
        .cta-section h2 {
            font-size: 2rem;
        }
    }

    /* ============================================
       FOOTER
    ============================================ */
    .footer {
        background: var(--color-primary-dark);
        color: rgba(255, 255, 255, 0.7);
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
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer ul a:hover {
        color: white;
        padding-left: 5px;
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

    /* ============================================
       ANIMACIONES GENERALES
    ============================================ */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .fade-in-left {
        opacity: 0;
        transform: translateX(-30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in-left.visible {
        opacity: 1;
        transform: translateX(0);
    }

    .fade-in-right {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fade-in-right.visible {
        opacity: 1;
        transform: translateX(0);
    }
</style>


<!-- ============================================
   HERO SECTION
============================================ -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <h1>
                Gestiona tu empresa de <br>
                <span class="highlight">construcción</span> con el mejor ERP
            </h1>
            <p>
                Controla proyectos, finanzas, nómina, almacén y más en una sola plataforma 
                diseñada específicamente para la industria de la construcción.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">
                    <i class="fas fa-rocket"></i> Comenzar Ahora
                </a>
                <a href="#features" class="btn-secondary">
                    <i class="fas fa-play-circle"></i> Ver Módulos
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="number">500+</span>
                    <span class="label">Proyectos Gestionados</span>
                </div>
                <div class="hero-stat">
                    <span class="number">98%</span>
                    <span class="label">Satisfacción Cliente</span>
                </div>
                <div class="hero-stat">
                    <span class="number">24/7</span>
                    <span class="label">Soporte Técnico</span>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('img/page/image.png') }}" alt="MejoraSoft ERP Dashboard">
        </div>
    </div>
</section>

<!-- ============================================
   FEATURES / MÓDULOS
============================================ -->
<section class="features section-padding" id="features">
    <div class="container">
        <h2 class="section-title">Módulos Especializados</h2>
        <p class="section-subtitle">
            Cada módulo está diseñado para cubrir las necesidades específicas de tu empresa constructora
        </p>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-project-diagram"></i></div>
                <h3>Gestión de Proyectos</h3>
                <p>Controla presupuestos, cronogramas, hitos y avances de obra en tiempo real.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-money-bill-wave"></i></div>
                <h3>Administración Financiera</h3>
                <p>Gestiona facturación, cuentas por cobrar/pagar, conciliación bancaria y más.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                <h3>Contabilidad</h3>
                <p>Estados financieros, pólizas contables, DIOT, retenciones y complementos.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Recursos Humanos</h3>
                <p>Nómina, asistencias, prestaciones, vacaciones y gestión de personal.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h3>Almacén e Inventarios</h3>
                <p>Control de materiales, entradas/salidas, traspasos y requisiciones.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-shopping-cart"></i></div>
                <h3>Compras</h3>
                <p>Requisiciones, cotizaciones, órdenes de compra y proveedores.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Business Intelligence</h3>
                <p>Dashboards interactivos, reportes en tiempo real y análisis de datos.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon"><i class="fas fa-tractor"></i></div>
                <h3>Maquinaria y Equipo</h3>
                <p>Asignación de equipo, mantenimiento, control de combustible y costos.</p>
                <a href="#" class="learn-more">Ver más <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   ABOUT / QUIENES SOMOS
============================================ -->
<section class="about-section section-padding" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image fade-in-left">
                <img src="{{ asset('img/page/image.png') }}" alt="Quiénes Somos">
            </div>
            <div class="about-content fade-in-right">
                <h2>¿Quiénes Somos?</h2>
                <p>
                    <strong>MejoraSoft</strong> es una empresa mexicana especializada en el desarrollo 
                    de soluciones tecnológicas para la industria de la construcción. Con más de 10 años 
                    de experiencia, hemos ayudado a más de 50 empresas a optimizar sus procesos.
                </p>
                <p>
                    Nuestro ERP nació de la necesidad de contar con una herramienta integral que 
                    cubriera todos los aspectos de la gestión de una empresa constructora: desde la 
                    planificación de proyectos hasta la contabilidad y recursos humanos.
                </p>
                <div class="about-features">
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i> 10+ años de experiencia
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i> 50+ empresas confían en nosotros
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i> 1000+ usuarios activos
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i> Soporte 24/7
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   WHY US / POR QUÉ PREFERIRNOS
============================================ -->
<section class="why-us section-padding" id="why-us">
    <div class="container">
        <h2 class="section-title">¿Por qué preferirnos?</h2>
        <p class="section-subtitle">
            Razones por las que empresas constructoras eligen MejoraSoft ERP
        </p>

        <div class="why-us-grid">
            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-rocket"></i></div>
                <h4>Implementación Rápida</h4>
                <p>Ponemos tu sistema en marcha en menos de 30 días con nuestro método probado.</p>
            </div>

            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Seguridad Garantizada</h4>
                <p>Tus datos están protegidos con los más altos estándares de seguridad y cifrado.</p>
            </div>

            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-headset"></i></div>
                <h4>Soporte Dedicado</h4>
                <p>Equipo de soporte técnico disponible 24/7 para resolver cualquier duda o problema.</p>
            </div>

            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-mobile-alt"></i></div>
                <h4>Acceso desde cualquier lugar</h4>
                <p>Plataforma responsive que funciona en dispositivos móviles, tablets y desktop.</p>
            </div>

            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-sync-alt"></i></div>
                <h4>Actualizaciones Constantes</h4>
                <p>Mejoras continuas basadas en las necesidades reales de nuestros clientes.</p>
            </div>

            <div class="why-us-item fade-in">
                <div class="icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h4>Compromiso con el Cliente</h4>
                <p>Tu éxito es nuestro éxito. Trabajamos codo a codo con tu equipo.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   STATS
============================================ -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="number" data-count="8">0</span>
                <span class="label">Módulos Integrados</span>
            </div>
            <div class="stat-item">
                <span class="number" data-count="50">0</span>
                <span class="label">Empresas Confían</span>
            </div>
            <div class="stat-item">
                <span class="number" data-count="1000">0</span>
                <span class="label">Usuarios Activos</span>
            </div>
            <div class="stat-item">
                <span class="number" data-count="99">0</span>
                <span class="label">Uptime Garantizado %</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   TESTIMONIALS
============================================ -->
<section class="testimonials section-padding" id="testimonials">
    <div class="container">
        <h2 class="section-title">Lo que dicen nuestros clientes</h2>
        <p class="section-subtitle">
            Empresas que ya confían en MejoraSoft ERP para transformar su gestión
        </p>

        <div class="testimonials-grid">
            <div class="testimonial-card fade-in">
                <div class="quote">
                    "MejoraSoft ha revolucionado la forma en que gestionamos nuestros proyectos. 
                    La integración entre módulos nos ha dado un control total de la obra."
                </div>
                <div class="author">
                    <div class="author-avatar">J</div>
                    <div class="author-info">
                        <h4>Juan Pérez</h4>
                        <p>Director de Proyectos - Constructora ABC</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card fade-in">
                <div class="quote">
                    "El módulo de contabilidad y el control de nómina nos han ahorrado horas de trabajo. 
                    La precisión y confiabilidad es excepcional."
                </div>
                <div class="author">
                    <div class="author-avatar">M</div>
                    <div class="author-info">
                        <h4>María González</h4>
                        <p>Gerente Administrativo - Grupo Constructor XYZ</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card fade-in">
                <div class="quote">
                    "La facilidad de uso y el soporte técnico son increíbles. 
                    Nuestra empresa ha crecido gracias a las herramientas que nos ofrece."
                </div>
                <div class="author">
                    <div class="author-avatar">C</div>
                    <div class="author-info">
                        <h4>Carlos Rodríguez</h4>
                        <p>CEO - Desarrollo y Construcción</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   CTA SECTION
============================================ -->
<section class="cta-section" id="contact">
    <div class="container">
        <h2>¿Listo para transformar tu empresa?</h2>
        <p>
            Solicita una demostración gratuita y descubre cómo MejoraSoft ERP puede 
            optimizar la gestión de tu empresa constructora.
        </p>
        <a href="#" class="btn-primary">
            <i class="fas fa-calendar-check"></i> Solicitar Demo
        </a>
    </div>
</section>



<!-- ============================================
   JAVASCRIPT
============================================ -->
<script>
    // ===== NAVBAR SCROLL EFFECT =====
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // ===== MOBILE MENU TOGGLE =====
    function toggleMobileMenu() {
        const links = document.getElementById('navbarLinks');
        links.classList.toggle('active');
    }

    // ===== SMOOTH SCROLL =====
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

    // ===== FADE-IN ANIMATIONS ON SCROLL =====
    const fadeElements = document.querySelectorAll('.fade-in, .fade-in-left, .fade-in-right');

    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    fadeElements.forEach(el => observer.observe(el));

    // ===== ANIMACIÓN DE NÚMEROS EN STATS =====
    function animateNumbers() {
        const statNumbers = document.querySelectorAll('.stat-item .number');
        
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-count') || stat.textContent);
            if (target > 0 && !stat.dataset.animated) {
                stat.dataset.animated = 'true';
                let current = 0;
                const duration = 2000;
                const steps = 60;
                const increment = target / steps;
                const stepTime = duration / steps;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = target + (target > 10 ? '+' : '');
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(current).toLocaleString();
                    }
                }, stepTime);
            }
        });
    }

    // ===== OBSERVAR STATS SECTION =====
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumbers();
                }
            });
        }, { threshold: 0.3 });
        statsObserver.observe(statsSection);
    }

    // ===== ANIMACIONES AL HOVER EN CARDS (efecto adicional) =====
    document.querySelectorAll('.feature-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });

    // ===== CONTADOR DE FAVORITOS - LOG =====
    console.log('🚀 MejoraSoft ERP - Landing Page cargada');
    console.log('📊 Colores:', {
        primary: '#002A4A',
        blueBright: '#0057E8',
        green: '#2FB41E'
    });

    // ===== EFECTO DE PARALLAX EN HERO =====
    window.addEventListener('scroll', function() {
        const hero = document.querySelector('.hero');
        const scrolled = window.pageYOffset;
        if (hero) {
            hero.style.backgroundPositionY = scrolled * 0.3 + 'px';
        }
    });

    // ===== CERRAR MENÚ AL HACER CLIC FUERA =====
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('navbarLinks');
        const btn = document.querySelector('.mobile-menu-btn');
        if (menu && btn && !menu.contains(event.target) && !btn.contains(event.target)) {
            menu.classList.remove('active');
        }
    });
</script>

@endsection