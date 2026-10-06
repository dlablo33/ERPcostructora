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
        --gradient-primary: linear-gradient(135deg, #0057E8 0%, #002A4A 100%);
        --gradient-green: linear-gradient(135deg, #2FB41E 0%, #45d830 100%);
        --gradient-hero: linear-gradient(135deg, #0057E8 0%, #002A4A 50%, #001a2e 100%);
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
       HERO SECTION
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
        cursor: pointer;
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

    .feature-card.active {
        border-color: var(--color-blue-bright);
        box-shadow: 0 20px 60px rgba(0, 42, 74, 0.15);
    }

    .feature-card.active::before {
        transform: scaleX(1);
        background: var(--gradient-green);
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

    .feature-card.active .feature-icon {
        background: var(--gradient-green);
        transform: scale(1.05);
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
       MODAL / DETALLE DE MÓDULO
    ============================================ */
    .module-detail-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(10px);
        z-index: 2000;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .module-detail-overlay.active {
        display: flex;
    }

    .module-detail-modal {
        background: var(--color-white);
        border-radius: 24px;
        max-width: 700px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 48px 40px;
        position: relative;
        box-shadow: var(--shadow-2xl);
        animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .module-detail-modal .close-btn {
        position: absolute;
        top: 16px;
        right: 20px;
        background: var(--color-gray-100);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 1.4rem;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--color-gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .module-detail-modal .close-btn:hover {
        background: var(--color-gray-200);
        transform: rotate(90deg);
    }

    .module-detail-modal .modal-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        background: var(--gradient-primary);
        margin-bottom: 20px;
    }

    .module-detail-modal h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--color-gray-800);
        margin-bottom: 12px;
    }

    .module-detail-modal .module-description {
        color: var(--color-gray-600);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .module-detail-modal .module-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 16px;
    }

    .module-detail-modal .module-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--color-gray-700);
        font-size: 0.95rem;
        list-style: none;
    }

    .module-detail-modal .module-features li i {
        color: var(--color-green);
        font-size: 1.1rem;
    }

    .module-detail-modal .btn-primary {
        margin-top: 24px;
    }

    @media (max-width: 600px) {
        .module-detail-modal {
            padding: 32px 20px;
        }
        .module-detail-modal h2 {
            font-size: 1.5rem;
        }
        .module-detail-modal .module-features {
            grid-template-columns: 1fr;
        }
    }

    /* ============================================
       ABOUT / QUIENES SOMOS
    ============================================ */
    .about-section {
        background: var(--color-gray-50);
        position: relative;
        overflow: hidden;
        min-height: 600px;
        display: flex;
        align-items: center;
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
        align-items: stretch;
        position: relative;
        z-index: 1;
        min-height: 500px;
    }

    .about-image {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 400px;
    }

    .about-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        transition: all 0.5s ease;
        min-height: 400px;
        max-height: 600px;
    }

    .about-image img:hover {
        transform: scale(1.02);
    }

    .about-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px 0;
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
            gap: 30px;
            min-height: auto;
        }
        .about-features {
            grid-template-columns: 1fr;
        }
        .about-content h2 {
            font-size: 2rem;
        }
        .about-image {
            min-height: 250px;
        }
        .about-image img {
            min-height: 250px;
            max-height: 350px;
        }
    }

    /* ============================================
       FEATURES SECTION / CARACTERÍSTICAS
    ============================================ */
    .features-section {
        background: var(--color-white);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .features-section::before {
        content: '';
        position: absolute;
        top: -30%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0, 87, 232, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .features-section .features-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .features-section .features-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 24px;
    }

    .features-section .feature-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: var(--color-gray-50);
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .features-section .feature-item:hover {
        background: var(--color-blue-light);
        border-color: var(--color-blue-bright);
        transform: translateX(5px);
    }

    .features-section .feature-item i {
        font-size: 1.4rem;
        color: var(--color-blue-bright);
        width: 32px;
        text-align: center;
    }

    .features-section .feature-item span {
        font-weight: 500;
        color: var(--color-gray-700);
        font-size: 0.95rem;
    }

    .features-section .features-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .features-section .features-image img {
        width: 100%;
        max-width: 600px;
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        transition: all 0.5s ease;
    }

    .features-section .features-image img:hover {
        transform: scale(1.02) rotate(-1deg);
    }

    .features-section .features-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.2rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .features-section .features-content p {
        color: var(--color-gray-600);
        font-size: 1.05rem;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .features-section .features-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .features-section .features-list {
            grid-template-columns: 1fr;
        }
        .features-section .features-content h2 {
            font-size: 2rem;
        }
    }

    /* ============================================
       SERVICES SECTION / SERVICIOS
    ============================================ */
    .services-section {
        background: var(--color-gray-50);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .services-section::before {
        content: '';
        position: absolute;
        bottom: -30%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(47, 180, 30, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .services-section .services-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .services-section .services-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .services-section .services-image img {
        width: 100%;
        max-width: 600px;
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        transition: all 0.5s ease;
    }

    .services-section .services-image img:hover {
        transform: scale(1.02) rotate(1deg);
    }

    .services-section .services-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.2rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .services-section .services-content p {
        color: var(--color-gray-600);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .services-section .services-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 16px;
    }

    .services-section .service-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        background: var(--color-white);
        border-radius: 12px;
        border: 1px solid var(--color-gray-200);
        transition: all 0.3s ease;
    }

    .services-section .service-item:hover {
        border-color: var(--color-green);
        background: var(--color-green-light);
        transform: translateX(5px);
    }

    .services-section .service-item i {
        font-size: 1.2rem;
        color: var(--color-green);
        width: 28px;
        text-align: center;
    }

    .services-section .service-item span {
        font-weight: 500;
        color: var(--color-gray-700);
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .services-section .services-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .services-section .services-list {
            grid-template-columns: 1fr;
        }
        .services-section .services-content h2 {
            font-size: 2rem;
        }
    }

    /* ============================================
       AUTOMATION SECTION
    ============================================ */
    .automation-section {
        background: var(--color-white);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .automation-section::before {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(0, 87, 232, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .automation-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .automation-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .automation-content p {
        color: var(--color-gray-600);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .automation-image {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .automation-image img {
        width: 100%;
        max-width: 600px;
        border-radius: 24px;
        box-shadow: var(--shadow-2xl);
        transition: all 0.5s ease;
    }

    .automation-image img:hover {
        transform: scale(1.02) rotate(1deg);
    }

    .automation-benefits {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 24px;
    }

    .automation-benefit {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        color: var(--color-gray-700);
        padding: 12px 16px;
        background: var(--color-gray-50);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .automation-benefit:hover {
        background: var(--color-blue-light);
        transform: translateX(5px);
    }

    .automation-benefit i {
        color: var(--color-blue-bright);
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .automation-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .automation-benefits {
            grid-template-columns: 1fr;
        }
        .automation-content h2 {
            font-size: 2rem;
        }
    }

    /* ============================================
       CONTACT / INTERÉS SECTION
    ============================================ */
    .contact-section {
        background: var(--color-gray-50);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .contact-section::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(47, 180, 30, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .contact-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
        position: relative;
        z-index: 1;
    }

    .contact-info h2 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .contact-info p {
        color: var(--color-gray-600);
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-method {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        background: var(--color-white);
        border-radius: 12px;
        border: 1px solid var(--color-gray-200);
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--color-gray-700);
    }

    .contact-method:hover {
        transform: translateX(8px);
        border-color: var(--color-blue-bright);
        box-shadow: var(--shadow-md);
    }

    .contact-method .icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        background: var(--gradient-primary);
        flex-shrink: 0;
    }

    .contact-method .method-content h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--color-gray-800);
        margin-bottom: 2px;
    }

    .contact-method .method-content span {
        font-size: 0.9rem;
        color: var(--color-gray-500);
    }

    /* Formulario de contacto */
    .contact-form {
        background: var(--color-white);
        padding: 40px;
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--color-gray-200);
    }

    .contact-form h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--color-gray-800);
    }

    .contact-form .form-subtitle {
        color: var(--color-gray-500);
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--color-gray-700);
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--color-gray-200);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--color-gray-50);
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--color-blue-bright);
        box-shadow: 0 0 0 4px rgba(0, 87, 232, 0.1);
        background: var(--color-white);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-submit {
        width: 100%;
        padding: 14px;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .form-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 87, 232, 0.35);
    }

    /* Políticas de Privacidad */
    .privacy-policy {
        margin-top: 20px;
        text-align: center;
        font-size: 0.85rem;
        color: var(--color-gray-500);
    }

    .privacy-policy a {
        color: var(--color-blue-bright);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .privacy-policy a:hover {
        text-decoration: underline;
    }

    @media (max-width: 992px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .contact-info h2 {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 600px) {
        .contact-form {
            padding: 24px 20px;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .contact-info h2 {
            font-size: 1.8rem;
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

    /* ============================================
       RESPONSIVE TEXT
    ============================================ */
    @media (max-width: 992px) {
        .section-title {
            font-size: 2.2rem;
        }
        .section-subtitle {
            font-size: 1rem;
        }
    }

    @media (max-width: 600px) {
        .section-title {
            font-size: 1.8rem;
        }
        .section-subtitle {
            font-size: 0.95rem;
            padding: 0 16px;
        }
        .section-padding {
            padding: 60px 0;
        }
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
                <a href="#modules" class="btn-secondary">
                    <i class="fas fa-play-circle"></i> Ver Módulos
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="number">50+</span>
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
   FEATURES SECTION / CARACTERÍSTICAS
============================================ -->
<section class="features-section" id="features">
    <div class="container">
        <div class="features-grid">
            <div class="features-content fade-in-left">
                <h2>Características que marcan la diferencia</h2>
                <p>
                    Nuestro ERP está diseñado con funcionalidades avanzadas que te permiten 
                    gestionar cada aspecto de tu empresa constructora de manera eficiente y sencilla.
                </p>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Acceso en la nube</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Seguridad de datos</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Multiplataforma</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-sync-alt"></i>
                        <span>Actualizaciones automáticas</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes en tiempo real</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users-cog"></i>
                        <span>Gestión colaborativa</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-file-invoice"></i>
                        <span>Facturación integrada</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-headset"></i>
                        <span>Soporte 24/7</span>
                    </div>
                </div>
            </div>
            <div class="features-image fade-in-right">
                <img src="{{ asset('img/page/imagen3.png') }}" alt="Características MejoraSoft ERP">
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   MODULES / MÓDULOS
============================================ -->
<section class="features section-padding" id="modules">
    <div class="container">
        <h2 class="section-title">Módulos Especializados</h2>
        <p class="section-subtitle">
            Cada módulo está diseñado para cubrir las necesidades específicas de tu empresa constructora
        </p>

        <div class="features-grid">
            <div class="feature-card fade-in" data-module="proyectos">
                <div class="feature-icon"><i class="fas fa-project-diagram"></i></div>
                <h3>Gestión de Proyectos</h3>
                <p>Controla presupuestos, cronogramas, hitos y avances de obra en tiempo real.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="tesoreria">
                <div class="feature-icon"><i class="fas fa-money-bill-wave"></i></div>
                <h3>Tesoreria</h3>
                <p>Gestiona facturación, cuentas por cobrar/pagar, conciliación bancaria y más.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="contabilidad">
                <div class="feature-icon"><i class="fas fa-calculator"></i></div>
                <h3>Contabilidad</h3>
                <p>Estados financieros, pólizas contables, DIOT, retenciones y complementos.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="rh">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>Recursos Humanos</h3>
                <p>Nómina, asistencias, prestaciones, vacaciones y gestión de personal.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="almacen">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h3>Almacén e Inventarios</h3>
                <p>Control de materiales, entradas/salidas, traspasos y requisiciones.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="compras">
                <div class="feature-icon"><i class="fas fa-shopping-cart"></i></div>
                <h3>Compras</h3>
                <p>Requisiciones, cotizaciones, órdenes de compra y proveedores.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="bi">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Business Intelligence</h3>
                <p>Dashboards interactivos, reportes en tiempo real y análisis de datos.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>

            <div class="feature-card fade-in" data-module="maquinaria">
                <div class="feature-icon"><i class="fas fa-tractor"></i></div>
                <h3>Maquinaria y Equipo</h3>
                <p>Asignación de equipo, mantenimiento, control de combustible y costos.</p>
                <span class="learn-more">Ver más <i class="fas fa-arrow-right"></i></span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   MODAL / DETALLE DE MÓDULO
============================================ -->
<div class="module-detail-overlay" id="moduleModal">
    <div class="module-detail-modal">
        <button class="close-btn" id="closeModal"><i class="fas fa-times"></i></button>
        <div class="modal-icon" id="modalIcon"><i class="fas fa-project-diagram"></i></div>
        <h2 id="modalTitle">Gestión de Proyectos</h2>
        <p class="module-description" id="modalDescription">
            Controla todos los aspectos de tus proyectos de construcción desde una sola plataforma.
        </p>
        <ul class="module-features" id="modalFeatures">
            <li><i class="fas fa-check-circle"></i> Presupuestos detallados</li>
            <li><i class="fas fa-check-circle"></i> Cronogramas y hitos</li>
            <li><i class="fas fa-check-circle"></i> Avances de obra en tiempo real</li>
            <li><i class="fas fa-check-circle"></i> Gestión de riesgos</li>
        </ul>
        <a href="#" class="btn-primary"><i class="fas fa-rocket"></i> Conocer más</a>
    </div>
</div>

<!-- ============================================
   ABOUT / QUIENES SOMOS
============================================ -->
<section class="about-section section-padding" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image fade-in-left">
                <img src="{{ asset('img/page/banner.png') }}" alt="Quiénes Somos" style="width:100%; height:100%; object-fit:cover; min-height:400px;">
            </div>
            <div class="about-content fade-in-right">
                <h2>¿Quiénes Somos?</h2>
                <p>
                    <strong>Mejoracontinua</strong> es una empresa mexicana especializada en el desarrollo 
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
                        <i class="fas fa-check-circle"></i> 25+ años de experiencia
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
   SERVICES SECTION / SERVICIOS
============================================ -->
<section class="services-section" id="services">
    <div class="container">
        <div class="services-grid">
            <div class="services-image fade-in-left">
                <img src="{{ asset('img/page/imagen4.png') }}" alt="Servicios MejoraSoft">
            </div>
            <div class="services-content fade-in-right">
                <h2>Nuestros Servicios</h2>
                <p>
                    Ofrecemos soluciones integrales para la gestión de tu empresa constructora, 
                    adaptándonos a tus necesidades específicas y garantizando la mejor experiencia.
                </p>
                <p>
                    Desde la implementación hasta el soporte continuo, nuestro equipo te acompaña 
                    en cada paso del proceso para asegurar el éxito de tu proyecto.
                </p>
                <div class="services-list">
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Implementación personalizada</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Capacitación en sitio</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Soporte técnico especializado</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Consultoría estratégica</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Migración de datos</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Actualizaciones constantes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   AUTOMATION SECTION
============================================ -->
<section class="automation-section" id="automation">
    <div class="container">
        <div class="automation-grid">
            <div class="automation-content fade-in-left">
                <h2>Automatización de Procesos</h2>
                <p>
                    Optimiza cada área de tu empresa constructora con nuestra plataforma inteligente. 
                    Automatiza tareas repetitivas, reduce errores y mejora la eficiencia operativa.
                </p>
                <p>
                    Desde la gestión de proyectos hasta el control de inventarios, nuestro ERP 
                    integra todas las áreas de tu negocio para que puedas tomar decisiones 
                    informadas y oportunas.
                </p>
                <div class="automation-benefits">
                    <div class="automation-benefit">
                        <i class="fas fa-robot"></i> Automatización inteligente
                    </div>
                    <div class="automation-benefit">
                        <i class="fas fa-clock"></i> Ahorro de tiempo
                    </div>
                    <div class="automation-benefit">
                        <i class="fas fa-chart-pie"></i> Datos en tiempo real
                    </div>
                    <div class="automation-benefit">
                        <i class="fas fa-phone"></i> Integración móvil
                    </div>
                </div>
            </div>
            <div class="automation-image fade-in-right">
                <img src="{{ asset('img/page/imagen2.png') }}" alt="Automatización de Procesos">
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
                <h4>Implementación Efectiva</h4>
                <p>Ponemos tu sistema en marcha con nuestro método probado.</p>
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
                <span class="number" data-count="10">0</span>
                <span class="label">Empresas Confían</span>
            </div>
            <div class="stat-item">
                <span class="number" data-count="26">0</span>
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
   CONTACT / INTERÉS SECTION
============================================ -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info fade-in-left">
                <h2>¿Te interesa?</h2>
                <p>
                    Contáctanos y descubre cómo MejoraSoft ERP puede transformar la gestión 
                    de tu empresa constructora. Nuestro equipo de expertos está listo para 
                    atenderte.
                </p>
                <div class="contact-methods">
                    <a href="mailto:comercial@mejorasoft.com" class="contact-method">
                        <div class="icon"><i class="fas fa-envelope"></i></div>
                        <div class="method-content">
                            <h4>Correo Electrónico</h4>
                            <span>comercial@mejorasoft.com</span>
                        </div>
                    </a>
                    <a href="tel:+528132410008" class="contact-method">
                        <div class="icon"><i class="fas fa-phone"></i></div>
                        <div class="method-content">
                            <h4>Teléfono</h4>
                            <span>813-241-0008</span>
                        </div>
                    </a>
                    <a href="https://maps.google.com/?q=Av+Eugenio+Garza+Sada+3720,+Col+Villa+los+Pinos,+Monterrey,+Nuevo+León" target="_blank" class="contact-method">
                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="method-content">
                            <h4>Ubicación</h4>
                            <span>Av Eugenio Garza Sada 3720, Col Villa los Pinos, Monterrey, Nuevo León</span>
                        </div>
                    </a>
                </div>
                <div class="privacy-policy">
                    <a href="#"><i class="fas fa-lock"></i> Políticas de Privacidad</a>
                </div>
            </div>

            <div class="contact-form fade-in-right">
                <h3>Envíanos un mensaje</h3>
                <p class="form-subtitle">Completa el formulario y te contactaremos a la brevedad</p>
                <form id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" id="nombre" placeholder="Tu nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="empresa">Empresa</label>
                            <input type="text" id="empresa" placeholder="Nombre de tu empresa">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" placeholder="tu@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" placeholder="81 1234 5678">
                    </div>
                    <div class="form-group">
                        <label for="interes">¿Qué área te interesa?</label>
                        <select id="interes">
                            <option value="">Selecciona una opción</option>
                            <option value="proyectos">Gestión de Proyectos</option>
                            <option value="tesoreria">Tesoreria</option>
                            <option value="contabilidad">Contabilidad</option>
                            <option value="rh">Recursos Humanos</option>
                            <option value="almacen">Almacén e Inventarios</option>
                            <option value="compras">Compras</option>
                            <option value="bi">Business Intelligence</option>
                            <option value="maquinaria">Maquinaria y Equipo</option>
                            <option value="todo">Solución completa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" placeholder="Cuéntanos sobre tu proyecto o necesidad..." rows="4"></textarea>
                    </div>
                    <button type="submit" class="form-submit">
                        <i class="fas fa-paper-plane"></i> Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
   CTA SECTION
============================================ -->
<section class="cta-section" id="demo">
    <div class="container">
        <h2>¿Listo para transformar tu empresa?</h2>
        <p>
            Solicita una demostración gratuita y descubre cómo MejoraSoft ERP puede 
            optimizar la gestión de tu empresa constructora.
        </p>
        <a href="#contact" class="btn-primary">
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

    // ===== MODAL DE MÓDULOS =====
    const moduleData = {
        proyectos: {
            icon: 'fa-project-diagram',
            title: 'Gestión de Proyectos',
            description: 'Controla todos los aspectos de tus proyectos de construcción desde una sola plataforma. Planifica, ejecuta y monitorea cada etapa de tu obra con precisión.',
            features: [
                'Presupuestos detallados por etapa',
                'Cronogramas y hitos de obra',
                'Avances de obra en tiempo real',
                'Gestión de riesgos y contingencias',
                'Reportes de productividad'
            ]
        },
        tesoreria: {
            icon: 'fa-money-bill-wave',
            title: 'Tesoreria',
            description: 'Gestiona eficientemente los flujos de efectivo de tu empresa. Controla ingresos, egresos, conciliaciones bancarias y fianzas en un solo lugar.',
            features: [
                'Facturación y cobranza',
                'Cuentas por cobrar y pagar',
                'Conciliación bancaria',
                'Control de saldos y fianzas',
                'Flujo de efectivo proyectado'
            ]
        },
        contabilidad: {
            icon: 'fa-calculator',
            title: 'Contabilidad',
            description: 'Mantén tus finanzas en orden con un sistema contable completo. Genera estados financieros y cumple con todas las obligaciones fiscales.',
            features: [
                'Estados financieros automatizados',
                'Pólizas contables',
                'DIOT y retenciones',
                'Complementos de pago',
                'Contabilidad por proyecto'
            ]
        },
        rh: {
            icon: 'fa-users',
            title: 'Recursos Humanos',
            description: 'Administra todo tu capital humano de manera integral. Desde la contratación hasta la liquidación, optimiza la gestión de tu personal.',
            features: [
                'Nómina y prestaciones',
                'Control de asistencias',
                'Vacaciones y permisos',
                'Evaluación de desempeño',
                'Expedientes digitales'
            ]
        },
        almacen: {
            icon: 'fa-boxes',
            title: 'Almacén e Inventarios',
            description: 'Controla tus materiales y equipos con precisión. Optimiza tus niveles de inventario y reduce pérdidas por merma o robo.',
            features: [
                'Control de entradas y salidas',
                'Traspasos entre almacenes',
                'Requisiciones de materiales',
                'Inventarios físicos',
                'Alertas de stock mínimo'
            ]
        },
        compras: {
            icon: 'fa-shopping-cart',
            title: 'Compras',
            description: 'Optimiza tu proceso de adquisiciones. Desde la requisición hasta la orden de compra, gestiona a tus proveedores eficientemente.',
            features: [
                'Requisiciones de compra',
                'Cotizaciones a proveedores',
                'Órdenes de compra',
                'Evaluación de proveedores',
                'Historial de precios'
            ]
        },
        bi: {
            icon: 'fa-chart-line',
            title: 'Business Intelligence',
            description: 'Toma decisiones basadas en datos con dashboards interactivos. Visualiza el rendimiento de tu empresa en tiempo real.',
            features: [
                'Dashboards personalizados',
                'Reportes en tiempo real',
                'Análisis de rentabilidad',
                'Indicadores clave (KPI)',
                'Exportación de datos'
            ]
        },
        maquinaria: {
            icon: 'fa-tractor',
            title: 'Maquinaria y Equipo',
            description: 'Gestiona tu flota de maquinaria y equipo pesado. Controla asignaciones, mantenimiento y costos operativos de manera eficiente.',
            features: [
                'Asignación de equipo a obra',
                'Mantenimiento programado',
                'Control de combustible',
                'Costos por equipo',
                'Reportes de utilización'
            ]
        }
    };

    const modal = document.getElementById('moduleModal');
    const closeBtn = document.getElementById('closeModal');

    function openModuleModal(moduleKey) {
        const data = moduleData[moduleKey];
        if (!data) return;

        document.getElementById('modalIcon').innerHTML = `<i class="fas ${data.icon}"></i>`;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalDescription').textContent = data.description;

        const featuresList = document.getElementById('modalFeatures');
        featuresList.innerHTML = data.features.map(f => 
            `<li><i class="fas fa-check-circle"></i> ${f}</li>`
        ).join('');

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModuleModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Click en tarjetas de módulos
    document.querySelectorAll('.feature-card[data-module]').forEach(card => {
        card.addEventListener('click', function(e) {
            const moduleKey = this.dataset.module;
            openModuleModal(moduleKey);
        });
    });

    // Cerrar modal
    closeBtn.addEventListener('click', closeModuleModal);
    modal.addEventListener('click', function(e) {
        if (e.target === this) closeModuleModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModuleModal();
    });

    // ===== ANIMACIONES AL HOVER EN CARDS =====
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

    // ===== FORMULARIO DE CONTACTO =====
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.form-submit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        btn.disabled = true;

        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-check-circle"></i> ¡Mensaje enviado!';
            btn.style.background = 'var(--gradient-green)';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.style.background = '';
                this.reset();
            }, 3000);
        }, 2000);
    });
</script>

@endsection
