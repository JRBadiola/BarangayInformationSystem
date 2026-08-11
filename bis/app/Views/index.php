<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Bacolod - Official Portal | Bato, Camarines Sur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --navy: #1d2448;
            --navy-mid: #2e3a6e;
            --navy-dark: #0f1117;
            --accent: #5b6fd6;
            --accent-light: #7b8fe8;
            --white: #ffffff;
            --gray-light: #f4f6fb;
            --gray-mid: #e8ecf4;
            --text-dark: #1a1d2e;
            --text-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: #fff;
            padding: 0 0;
            transition: box-shadow .3s;
        }

        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, .10);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: contain;
        }

        .nav-brand span {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            transition: background .2s, color .2s;
        }

        .nav-links a:hover {
            background: var(--gray-light);
            color: var(--navy);
        }

        .nav-divider {
            width: 1px;
            height: 24px;
            background: var(--gray-mid);
            margin: 0 8px;
        }

        .btn-login {
            background: var(--navy);
            color: #fff !important;
            padding: 9px 20px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .btn-login:hover {
            background: var(--navy-mid) !important;
            color: #fff !important;
        }

        .btn-signup {
            border: 2px solid var(--navy);
            color: var(--navy) !important;
            padding: 7px 18px !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .btn-signup:hover {
            background: var(--navy);
            color: #fff !important;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 8px;
            border: none;
            background: none;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--navy);
            border-radius: 2px;
            transition: .3s;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 68px;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid var(--gray-mid);
            padding: 16px 24px;
            z-index: 999;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
        }

        .mobile-menu.open {
            display: block;
        }

        .mobile-menu a {
            display: block;
            padding: 12px 0;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            border-bottom: 1px solid var(--gray-mid);
        }

        .mobile-menu a:last-child {
            border-bottom: none;
        }

        .mobile-menu .btn-login,
        .mobile-menu .btn-signup {
            display: block;
            text-align: center;
            margin-top: 8px;
            padding: 12px !important;
            border-radius: 8px !important;
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 60%, #3a4a8a 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 68px;
        }

        .hero-shapes {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: .07;
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: #fff;
            top: -100px;
            right: -100px;
            animation: float1 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: var(--accent);
            bottom: -80px;
            left: -80px;
            animation: float2 10s ease-in-out infinite;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: #fff;
            top: 40%;
            left: 30%;
            animation: float3 7s ease-in-out infinite;
        }

        @keyframes float1 {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        @keyframes float2 {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(20px) rotate(-8deg);
            }
        }

        @keyframes float3 {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 20px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .hero-badge i {
            color: var(--accent-light);
        }

        .hero h1 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: var(--accent-light);
        }

        .hero-sub {
            font-size: 16px;
            color: rgba(255, 255, 255, .75);
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 480px;
        }

        .hero-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #fff;
            color: var(--navy);
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .2);
        }

        .btn-outline-white {
            border: 2px solid rgba(255, 255, 255, .5);
            color: #fff;
            padding: 12px 26px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, border-color .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, .1);
            border-color: #fff;
        }

        .hero-logo-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-logo-ring {
            position: relative;
            width: 280px;
            height: 280px;
        }

        .hero-logo-ring::before {
            content: '';
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, .15);
            animation: spin 20s linear infinite;
        }

        .hero-logo-ring::after {
            content: '';
            position: absolute;
            inset: -32px;
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, .08);
            animation: spin 30s linear infinite reverse;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hero-logo-glow {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(91, 111, 214, .4) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: .6;
            }

            50% {
                opacity: 1;
            }
        }

        .hero-logo-img {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: contain;
            background: rgba(255, 255, 255, .08);
            padding: 24px;
            border: 2px solid rgba(255, 255, 255, .15);
        }

        /* ── STATS BAR ── */
        .stats-bar {
            background: #fff;
            padding: 40px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        }

        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            transition: background .2s;
        }

        .stat-item:hover {
            background: var(--gray-light);
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .stat-num {
            font-size: 28px;
            font-weight: 800;
            color: var(--navy);
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
            font-weight: 500;
        }

        /* ── SECTION COMMON ── */
        .section-tag {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 16px;
        }

        .section-sub {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
            max-width: 560px;
        }

        /* ── SERVICES ── */
        .services {
            background: var(--gray-light);
            padding: 80px 24px;
        }

        .services-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .services-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .services-header .section-sub {
            margin: 0 auto;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .service-card {
            background: #fff;
            border-radius: 16px;
            padding: 36px 28px;
            transition: transform .3s, box-shadow .3s;
            border: 1px solid var(--gray-mid);
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(29, 36, 72, .1);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .service-icon.blue {
            background: #eef1fd;
            color: var(--accent);
        }

        .service-icon.green {
            background: #e8f8f0;
            color: #27ae60;
        }

        .service-icon.orange {
            background: #fff4e8;
            color: #e67e22;
        }

        .service-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .service-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .service-link {
            font-size: 14px;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap .2s;
        }

        .service-link:hover {
            gap: 10px;
        }

        /* ── ABOUT ── */
        .about {
            background: #fff;
            padding: 80px 24px;
        }

        .about-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 28px;
        }

        .info-row {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            padding: 20px;
            background: var(--gray-light);
            border-radius: 12px;
            border-left: 4px solid var(--accent);
        }

        .info-row-icon {
            width: 40px;
            height: 40px;
            background: var(--navy);
            color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-row-text h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .info-row-text p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .feature-card {
            background: var(--gray-light);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--gray-mid);
        }

        .feature-card i {
            font-size: 22px;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .feature-card h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .feature-card p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── HOW IT WORKS ── */
        .how {
            background: var(--gray-light);
            padding: 80px 24px;
        }

        .how-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .how-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 48px;
            left: calc(16.66% + 24px);
            right: calc(16.66% + 24px);
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            z-index: 0;
        }

        .step {
            text-align: center;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .step-num {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: var(--navy);
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid #fff;
            box-shadow: 0 4px 20px rgba(29, 36, 72, .2);
        }

        .step h3 {
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .step p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ── CTA BANNER ── */
        .cta-banner {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
            padding: 80px 24px;
            text-align: center;
        }

        .cta-banner h2 {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 14px;
        }

        .cta-banner p {
            font-size: 16px;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 32px;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--navy-dark);
            padding: 60px 24px 0;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr;
            gap: 48px;
            padding-bottom: 48px;
        }

        .footer-brand img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin-bottom: 14px;
        }

        .footer-brand h3 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .footer-brand p {
            font-size: 13px;
            color: rgba(255, 255, 255, .5);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 10px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .social-links a:hover {
            background: var(--accent);
            color: #fff;
        }

        .footer-col h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 13px;
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-col ul li a:hover {
            color: #fff;
        }

        .footer-contact-item {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }

        .footer-contact-item i {
            color: var(--accent);
            font-size: 14px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .footer-contact-item span {
            font-size: 13px;
            color: rgba(255, 255, 255, .5);
            line-height: 1.6;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .08);
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-bottom p {
            font-size: 12px;
            color: rgba(255, 255, 255, .35);
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }

        .footer-bottom-links a {
            font-size: 12px;
            color: rgba(255, 255, 255, .35);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-bottom-links a:hover {
            color: rgba(255, 255, 255, .7);
        }

        /* ── TOAST ── */
        .toast-container {
            position: fixed;
            top: 84px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: #fff;
            border-radius: 10px;
            padding: 14px 18px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 280px;
            max-width: 360px;
            animation: slideIn .3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast.success {
            border-left: 4px solid #27ae60;
        }

        .toast.error {
            border-left: 4px solid #e74c3c;
        }

        .toast-icon {
            font-size: 16px;
            margin-top: 1px;
        }

        .toast.success .toast-icon {
            color: #27ae60;
        }

        .toast.error .toast-icon {
            color: #e74c3c;
        }

        .toast-body {
            flex: 1;
        }

        .toast-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 2px;
        }

        .toast-msg {
            font-size: 12px;
            color: var(--text-muted);
        }

        .toast-close {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
            line-height: 1;
        }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
        }

        .modal-header {
            padding: 24px 28px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #aaa;
            cursor: pointer;
            padding: 4px;
            transition: color .2s;
        }

        .modal-close:hover {
            color: var(--navy);
        }

        .modal-body {
            padding: 20px 28px 28px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #4a5068;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            outline: none;
            transition: border-color .2s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(29, 36, 72, .07);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 90px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-submit:hover {
            background: var(--navy-mid);
        }

        /* ── FADE-IN ANIMATION ── */
        .fade-in {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── RESPONSIVE ── */
        @media(max-width:900px) {
            .hero-inner {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 40px;
            }

            .hero-logo-wrap {
                order: -1;
            }

            .hero-logo-ring {
                width: 200px;
                height: 200px;
            }

            .hero-btns {
                justify-content: center;
            }

            .hero-sub {
                margin: 0 auto 36px;
            }

            .stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .about-inner {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .steps::before {
                display: none;
            }

            .footer-inner {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media(max-width:768px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:480px) {
            .stats-inner {
                grid-template-columns: 1fr 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- ── TOAST FLASH MESSAGES ── -->
    <?php if (session()->getFlashdata('blotter_success')): ?>
        <div class="toast-container" id="toastContainer">
            <div class="toast success" id="toastMsg">
                <i class="fas fa-check-circle toast-icon"></i>
                <div class="toast-body">
                    <div class="toast-title">Blotter Submitted</div>
                    <div class="toast-msg"><?= esc(session()->getFlashdata('blotter_success')) ?></div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast').remove()"><i class="fas fa-times"></i></button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('blotter_error')): ?>
        <div class="toast-container" id="toastContainer">
            <div class="toast error" id="toastMsg">
                <i class="fas fa-exclamation-circle toast-icon"></i>
                <div class="toast-body">
                    <div class="toast-title">Submission Failed</div>
                    <div class="toast-msg"><?= esc(session()->getFlashdata('blotter_error')) ?></div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast').remove()"><i class="fas fa-times"></i></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- ── NAVBAR ── -->
    <nav class="navbar" id="navbar">
        <div class="nav-inner">
            <a href="/" class="nav-brand">
                <img src="/bacolod.png" alt="Bacolod Logo">
                <span>Bacolod BIS</span>
            </a>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>
                <a href="/faqs">FAQs</a>
                <div class="nav-divider"></div>
                <a href="/login" class="btn-login">Login</a>
                <a href="/signup" class="btn-signup">Sign Up</a>
            </div>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>
    <div class="mobile-menu" id="mobileMenu">
        <a href="/">Home</a>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="/faqs">FAQs</a>
        <a href="/login" class="btn-login">Login</a>
        <a href="/signup" class="btn-signup">Sign Up</a>
    </div>

    <!-- ── HERO ── -->
    <section class="hero">
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="hero-inner">
            <div class="hero-content">
                <div class="hero-badge"><i class="fas fa-shield-alt"></i> Official Barangay Portal</div>
                <h1>Serving <span>Bacolod,</span><br>Bato, Camarines Sur</h1>
                <p class="hero-sub">Your trusted digital gateway to barangay services. Request documents, file blotter reports, and access community information — all in one place.</p>
                <div class="hero-btns">
                    <a href="/login" class="btn-primary"><i class="fas fa-sign-in-alt"></i> Get Started</a>
                    <a href="#services" class="btn-outline-white"><i class="fas fa-th-large"></i> View Services</a>
                </div>
            </div>
            <div class="hero-logo-wrap">
                <div class="hero-logo-ring">
                    <div class="hero-logo-glow"></div>
                    <img src="/bacolod.png" alt="Barangay Bacolod Seal" class="hero-logo-img">
                </div>
            </div>
        </div>
    </section>

    <!-- ── SERVICES ── -->
    <section class="services" id="services">
        <div class="services-inner">
            <div class="services-header fade-in">
                <span class="section-tag">What We Offer</span>
                <h2 class="section-title">Barangay Services</h2>
                <p class="section-sub">Access essential barangay services online. Fast, transparent, and convenient for all residents of Bacolod, Bato, Camarines Sur.</p>
            </div>
            <div class="services-grid">
                <div class="service-card fade-in">
                    <div class="service-icon blue"><i class="fas fa-certificate"></i></div>
                    <h3>Barangay Clearances</h3>
                    <p>Request barangay clearance, certificate of residency, and certificate of indigency online. Track your request status in real time.</p>
                    <a href="/login" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card fade-in">
                    <div class="service-icon green"><i class="fas fa-file-signature"></i></div>
                    <h3>Blotter Reports</h3>
                    <p>File and track barangay blotter reports for incidents and disputes. Our officials will respond promptly to your concerns.</p>
                    <a href="#blotter-modal" class="service-link" onclick="openBlotterModal(event)">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card fade-in">
                    <div class="service-icon orange"><i class="fas fa-database"></i></div>
                    <h3>Census Records</h3>
                    <p>Access and update household census information. Ensure your family's data is accurate for proper barangay services and benefits.</p>
                    <a href="/login" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── ABOUT ── -->
    <section class="about" id="about">
        <div class="about-inner">
            <div class="about-text fade-in">
                <span class="section-tag">About Us</span>
                <h2 class="section-title">Barangay Bacolod</h2>
                <p>Barangay Bacolod is a vibrant community in the municipality of Bato, Camarines Sur. Our Barangay Information System (BIS) is designed to modernize and streamline the delivery of public services to our residents.</p>
                <p>We are committed to transparency, efficiency, and accessibility in all our operations, ensuring that every resident receives the services they need with ease and dignity.</p>
                <div class="info-row">
                    <div class="info-row-icon"><i class="fas fa-bullseye"></i></div>
                    <div class="info-row-text">
                        <h4>Our Mission</h4>
                        <p>To provide efficient, transparent, and accessible barangay services that empower residents and foster community development in Bacolod, Bato, Camarines Sur.</p>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-row-icon"><i class="fas fa-eye"></i></div>
                    <div class="info-row-text">
                        <h4>Our Vision</h4>
                        <p>A progressive, digitally-enabled barangay where every resident has equal access to government services and participates actively in community governance.</p>
                    </div>
                </div>
            </div>
            <div class="features-grid fade-in">
                <div class="feature-card">
                    <i class="fas fa-bolt"></i>
                    <h4>Fast Service</h4>
                    <p>Streamlined processes ensure your requests are handled quickly and efficiently.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-lock"></i>
                    <h4>Secure Data</h4>
                    <p>Your personal information is protected with industry-standard security measures.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-eye"></i>
                    <h4>Transparent</h4>
                    <p>Track your requests in real time. No more guessing about your application status.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-universal-access"></i>
                    <h4>Accessible</h4>
                    <p>Available 24/7 online so you can access services anytime, anywhere.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── HOW IT WORKS ── -->
    <section class="how">
        <div class="how-inner">
            <div class="how-header fade-in">
                <span class="section-tag">Simple Process</span>
                <h2 class="section-title">How It Works</h2>
                <p class="section-sub" style="margin:0 auto;">Getting barangay services has never been easier. Follow these three simple steps.</p>
            </div>
            <div class="steps">
                <div class="step fade-in">
                    <div class="step-num">1</div>
                    <h3>Create Account</h3>
                    <p>Register with your personal information to create your resident account on the portal.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-num">2</div>
                    <h3>Submit Request</h3>
                    <p>Choose the service you need and fill out the required form. Submit your request online.</p>
                </div>
                <div class="step fade-in">
                    <div class="step-num">3</div>
                    <h3>Receive Document</h3>
                    <p>Get notified when your document is ready. Pick it up at the barangay hall or receive it digitally.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA BANNER ── -->
    <section class="cta-banner">
        <div class="fade-in">
            <h2>Ready to access barangay services?</h2>
            <p>Join hundreds of residents already using the Bacolod BIS portal for their barangay needs.</p>
            <a href="/signup" class="btn-primary" style="display:inline-flex;"><i class="fas fa-user-plus"></i> Get Started</a>
        </div>
    </section>

    <!-- ── FOOTER ── -->
    <footer>
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="/bacolod.png" alt="Bacolod Logo">
                <h3>Barangay Bacolod BIS</h3>
                <p>Official Barangay Information System of Barangay Bacolod, Bato, Camarines Sur. Serving our community with transparency and efficiency.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="/faqs">FAQs</a></li>
                    <li><a href="/privacy-policy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Use</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Barangay Bacolod, Bato, Camarines Sur, Philippines</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+63 (054) 000-0000</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>barangaybacolod@bato.gov.ph</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Mon – Fri: 8:00 AM – 5:00 PM</span>
                </div>
            </div>
        </div>
        <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Barangay Bacolod, Bato, Camarines Sur. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="/privacy-policy">Privacy Policy</a>
                    <a href="/terms">Terms of Use</a>
                    <a href="/faqs">FAQs</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ── PUBLIC BLOTTER MODAL ── -->
    <div class="modal-overlay" id="blotterModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-file-signature" style="color:var(--accent);margin-right:8px;"></i>File a Blotter Report</h3>
                <button class="modal-close" onclick="closeBlotterModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13px;color:var(--text-muted);margin-bottom:16px;">Fill out the form below to file a blotter report. Our barangay officials will review and respond to your report promptly.</p>
                <form action="/public/blotter/store" method="post" id="blotterForm">
                    <?= csrf_field() ?>

                    <!-- ── Complainant Name ── -->
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin-bottom:8px;">Complainant Information</p>
                    <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Last Name <span style="color:#e74c3c;">*</span></label>
                            <input type="text" name="complainant_last_name" placeholder="Last name" required>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>First Name <span style="color:#e74c3c;">*</span></label>
                            <input type="text" name="complainant_first_name" placeholder="First name" required>
                        </div>
                    </div>
                    <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Middle Name <span style="font-size:11px;color:#b0b6cc;font-weight:400;">(optional)</span></label>
                            <input type="text" name="complainant_middle_name" placeholder="Middle name">
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Contact Number <span style="color:#e74c3c;">*</span></label>
                            <input type="text" name="contact_number" placeholder="e.g. 09XX-XXX-XXXX" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
                        <label>Email Address <span style="color:#e74c3c;">*</span></label>
                        <input type="email" name="complainant_email" placeholder="your@email.com" required>
                    </div>

                    <!-- ── Incident Details ── -->
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin:14px 0 8px;">Incident Details</p>
                    <div class="form-group" style="margin-bottom:10px;">
                        <label>Respondent Name <span style="color:#e74c3c;">*</span></label>
                        <input type="text" name="respondent_name" placeholder="Name of the person being reported" required>
                    </div>
                    <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Incident Type <span style="color:#e74c3c;">*</span></label>
                            <select name="incident_type" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="Dispute">Dispute</option>
                                <option value="Physical Assault">Physical Assault</option>
                                <option value="Verbal Abuse">Verbal Abuse</option>
                                <option value="Theft">Theft</option>
                                <option value="Trespassing">Trespassing</option>
                                <option value="Noise Complaint">Noise Complaint</option>
                                <option value="Domestic Violence">Domestic Violence</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label>Incident Date</label>
                            <input type="date" name="incident_date">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
                        <label>Incident Description <span style="color:#e74c3c;">*</span></label>
                        <textarea name="narrative" rows="3" placeholder="Describe the incident in detail..." required style="resize:vertical;"></textarea>
                    </div>

                    <!-- ── Appointment Scheduling ── -->
                    <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9aa0b4;margin:14px 0 8px;">Appointment Scheduling</p>
                    <div style="background:#f5f7ff;border:1px solid #dde2f5;border-radius:10px;padding:12px 14px;margin-bottom:10px;">
                        <p style="font-size:12px;color:#4a5068;margin-bottom:10px;"><i class="fas fa-calendar-check" style="color:#5b6fd6;margin-right:6px;"></i>Optionally request an appointment with the Barangay Captain. Dates with existing events are marked and unavailable.</p>
                        <div class="form-row" style="grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Preferred Date</label>
                                <input type="date" name="appointment_date" id="appointmentDate"
                                    min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Preferred Time</label>
                                <input type="time" name="appointment_time" id="appointmentTime"
                                    min="08:00" max="17:00">
                            </div>
                        </div>
                        <div id="apptDateHint" style="margin-top:8px;font-size:12px;display:none;"></div>
                        <!-- Occupied slots list (shown after date is picked) -->
                        <div id="apptSlotList" style="display:none;margin-top:10px;"></div>
                        <!-- Time conflict warning -->
                        <div id="apptTimeConflict" style="display:none;margin-top:8px;font-size:12px;"></div>
                    </div>

                    <button type="submit" class="btn-submit" id="blotterSubmitBtn"><i class="fas fa-paper-plane" style="margin-right:8px;"></i>Submit Blotter Report</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Navbar scroll shadow
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 10) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Hamburger menu
        document.getElementById('hamburger').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('open');
        });

        // Close mobile menu on link click
        document.querySelectorAll('#mobileMenu a').forEach(function(a) {
            a.addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.remove('open');
            });
        });

        // Blotter modal
        function openBlotterModal(e) {
            if (e) e.preventDefault();
            document.getElementById('blotterModal').classList.add('open');
            document.body.style.overflow = 'hidden';
            loadBusyDates();
        }

        function closeBlotterModal() {
            document.getElementById('blotterModal').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.getElementById('blotterModal').addEventListener('click', function(e) {
            if (e.target === this) closeBlotterModal();
        });

        // ── Appointment date/time availability ────────────────────────────
        let busyDateMap = {}; // date → { count, busy }
        let dateSlotsMap = {}; // date → [{ start, end, label }]

        function loadBusyDates() {
            if (Object.keys(busyDateMap).length > 0) return;
            fetch('/public/blotter/busy-dates')
                .then(r => r.json())
                .then(data => {
                    busyDateMap = {};
                    (data.dates || []).forEach(d => {
                        busyDateMap[d.date] = d;
                    });
                })
                .catch(() => {});
        }

        function fmt12(hhmm) {
            if (!hhmm) return '';
            const [h, m] = hhmm.split(':').map(Number);
            const ampm = h >= 12 ? 'PM' : 'AM';
            const h12 = h % 12 || 12;
            return h12 + ':' + String(m).padStart(2, '0') + ' ' + ampm;
        }

        // Convert HH:MM to total minutes
        function toMin(t) {
            if (!t) return null;
            const [h, m] = t.split(':').map(Number);
            return h * 60 + m;
        }

        // Returns true if [aStart, aEnd) overlaps [bStart, bEnd)
        // Uses 1-hour default duration when end is unknown
        function overlaps(aStart, bStart, bEnd) {
            const a0 = toMin(aStart);
            const a1 = a0 + 60; // 1-hour appointment slot
            const b0 = toMin(bStart);
            const b1 = bEnd ? toMin(bEnd) : b0 + 60;
            if (a0 === null || b0 === null) return false;
            return a0 < b1 && a1 > b0;
        }

        function checkTimeConflict() {
            const timeVal = document.getElementById('appointmentTime').value;
            const dateVal = document.getElementById('appointmentDate').value;
            const conflictEl = document.getElementById('apptTimeConflict');
            const submitBtn = document.getElementById('blotterSubmitBtn');
            conflictEl.style.display = 'none';
            conflictEl.innerHTML = '';
            if (submitBtn) submitBtn.disabled = false;

            if (!timeVal || !dateVal) return;

            const slots = dateSlotsMap[dateVal] || [];
            const conflicting = slots.filter(s => overlaps(timeVal, s.start, s.end));

            if (conflicting.length > 0) {
                const names = conflicting.map(s => {
                    const endStr = s.end ? ' – ' + fmt12(s.end) : ' (1 hr)';
                    return '<strong>' + s.label + '</strong> (' + fmt12(s.start) + endStr + ')';
                }).join(', ');
                conflictEl.innerHTML = '<span style="color:#c0392b;"><i class="fas fa-exclamation-circle" style="margin-right:5px;"></i>This time conflicts with: ' + names + '. Please pick a different time.</span>';
                conflictEl.style.display = 'block';
                if (submitBtn) submitBtn.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const apptDate = document.getElementById('appointmentDate');
            const apptTime = document.getElementById('appointmentTime');
            const hint = document.getElementById('apptDateHint');
            const slotList = document.getElementById('apptSlotList');
            if (!apptDate) return;

            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            apptDate.min = tomorrow.toISOString().split('T')[0];

            apptDate.addEventListener('change', function() {
                const val = this.value;
                hint.style.display = 'none';
                hint.innerHTML = '';
                slotList.style.display = 'none';
                slotList.innerHTML = '';
                document.getElementById('apptTimeConflict').style.display = 'none';
                apptTime.disabled = false;
                const submitBtn = document.getElementById('blotterSubmitBtn');
                if (submitBtn) submitBtn.disabled = false;

                if (!val) return;

                // Block Sundays
                const picked = new Date(val + 'T00:00:00');
                if (picked.getDay() === 0) {
                    hint.innerHTML = '<span style="color:#c0392b;"><i class="fas fa-times-circle"></i> Sundays are unavailable. Please pick a weekday.</span>';
                    hint.style.display = 'block';
                    this.value = '';
                    return;
                }

                const info = busyDateMap[val];
                if (info && info.busy) {
                    hint.innerHTML = '<span style="color:#c0392b;"><i class="fas fa-ban"></i> This date is fully booked (' + info.count + ' appointments). Please choose another date.</span>';
                    hint.style.display = 'block';
                    apptTime.disabled = true;
                    this.value = '';
                    return;
                } else if (info && info.count >= 2) {
                    hint.innerHTML = '<span style="color:#e67e22;"><i class="fas fa-exclamation-triangle"></i> This date is getting busy (' + info.count + '/3 slots). Accepted at barangay\'s discretion.</span>';
                    hint.style.display = 'block';
                } else {
                    hint.innerHTML = '<span style="color:#16a085;"><i class="fas fa-check-circle"></i> This date looks available.</span>';
                    hint.style.display = 'block';
                }

                // Fetch occupied time slots for this date
                fetch('/public/blotter/busy-slots?date=' + val)
                    .then(r => r.json())
                    .then(data => {
                        const slots = data.slots || [];
                        dateSlotsMap[val] = slots;

                        if (slots.length > 0) {
                            let html = '<div style="font-size:11.5px;font-weight:700;color:#4a5068;margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px;">Occupied Time Slots on ' + new Date(val + 'T00:00:00').toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            }) + ':</div>';
                            html += '<div style="display:flex;flex-direction:column;gap:5px;">';
                            slots.forEach(s => {
                                const endStr = s.end ? ' – ' + fmt12(s.end) : ' (1 hr)';
                                html += '<div style="display:flex;align-items:center;gap:8px;background:#fff0f0;border:1px solid #fad4d4;border-radius:7px;padding:6px 10px;">' +
                                    '<i class="fas fa-clock" style="color:#c0392b;font-size:11px;"></i>' +
                                    '<span style="color:#7a1a1a;font-size:12px;"><strong>' + fmt12(s.start) + endStr + '</strong> — ' + s.label + '</span></div>';
                            });
                            html += '</div>';
                            slotList.innerHTML = html;
                            slotList.style.display = 'block';
                        }

                        // Re-check time conflict if time was already selected
                        if (apptTime.value) checkTimeConflict();
                    })
                    .catch(() => {});
            });

            apptTime.addEventListener('change', checkTimeConflict);
            apptTime.addEventListener('input', checkTimeConflict);
        });

        // Fade-in on scroll
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.fade-in').forEach(function(el) {
            observer.observe(el);
        });

        // Auto-dismiss toast after 5s
        setTimeout(function() {
            var t = document.getElementById('toastMsg');
            if (t) t.style.animation = 'slideIn .3s ease reverse forwards', setTimeout(function() {
                t.remove();
            }, 300);
        }, 5000);
    </script>

    <!-- ══ PUBLIC CHATBOT WIDGET ══ -->
    <style>
        /* ── Chat widget ── */
        .cw-wrap {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .cw-toggle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(29, 36, 72, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s, box-shadow .2s;
            position: relative;
        }

        .cw-toggle:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 28px rgba(29, 36, 72, .45);
        }

        .cw-unread {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #c0392b;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .cw-panel {
            display: none;
            flex-direction: column;
            width: 340px;
            max-height: 520px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, .18);
            overflow: hidden;
            margin-bottom: 12px;
            animation: cwSlide .2s ease;
        }

        .cw-panel.cw-open {
            display: flex;
        }

        @keyframes cwSlide {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .cw-header {
            background: linear-gradient(135deg, #1d2448, #2e3a6e);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .cw-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cw-header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            position: relative;
        }

        .cw-header-dot {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 9px;
            height: 9px;
            background: #16c79a;
            border-radius: 50%;
            border: 2px solid #1d2448;
        }

        .cw-header-name {
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        .cw-header-sub {
            color: rgba(255, 255, 255, .65);
            font-size: 11px;
            font-family: 'Poppins', sans-serif;
        }

        .cw-header-actions {
            display: flex;
            gap: 6px;
        }

        .cw-hbtn {
            background: rgba(255, 255, 255, .15);
            border: none;
            color: #fff;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .cw-hbtn:hover {
            background: rgba(255, 255, 255, .28);
        }

        .cw-date-divider {
            text-align: center;
            padding: 8px 0;
            font-size: 11px;
            color: #b0b6cc;
            font-family: 'Poppins', sans-serif;
        }

        .cw-date-divider span {
            background: #f5f6fa;
            padding: 2px 10px;
            border-radius: 100px;
        }

        .cw-messages {
            flex: 1;
            overflow-y: auto;
            padding: 8px 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f5f6fa;
        }

        .cw-row {
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .cw-row--user {
            flex-direction: row-reverse;
        }

        .cw-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #1d2448;
            color: #fff;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .cw-body {
            display: flex;
            flex-direction: column;
            max-width: 80%;
        }

        .cw-row--user .cw-body {
            align-items: flex-end;
        }

        .cw-bubble {
            background: #fff;
            border-radius: 14px 14px 14px 4px;
            padding: 10px 13px;
            font-size: 13px;
            color: #1a1d2e;
            line-height: 1.55;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
            font-family: 'Poppins', sans-serif;
        }

        .cw-row--user .cw-bubble {
            background: #1d2448;
            color: #fff;
            border-radius: 14px 14px 4px 14px;
        }

        .cw-ts {
            font-size: 10px;
            color: #b0b6cc;
            margin-top: 3px;
            font-family: 'Poppins', sans-serif;
        }

        .cw-typing span {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #9aa0b4;
            border-radius: 50%;
            margin: 0 2px;
            animation: cwDot 1.2s infinite;
        }

        .cw-typing span:nth-child(2) {
            animation-delay: .2s
        }

        .cw-typing span:nth-child(3) {
            animation-delay: .4s
        }

        @keyframes cwDot {

            0%,
            80%,
            100% {
                transform: scale(.8);
                opacity: .5
            }

            40% {
                transform: scale(1.1);
                opacity: 1
            }
        }

        .cw-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 4px 0 2px;
        }

        .cw-chip {
            background: #fff;
            border: 1.5px solid #e2e5ef;
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 11.5px;
            font-weight: 600;
            color: #1d2448;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cw-chip:hover {
            background: #1d2448;
            color: #fff;
            border-color: #1d2448;
        }

        .cw-footer {
            padding: 10px 12px;
            background: #fff;
            border-top: 1px solid #f0f2f8;
            flex-shrink: 0;
        }

        .cw-input-wrap {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .cw-input {
            flex: 1;
            padding: 9px 14px;
            border: 1.5px solid #e2e5ef;
            border-radius: 100px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #1a1d2e;
            outline: none;
            transition: border-color .2s;
        }

        .cw-input:focus {
            border-color: #1d2448;
        }

        .cw-send {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #1d2448;
            border: none;
            color: #fff;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
            flex-shrink: 0;
        }

        .cw-send:hover {
            background: #2e3a6e;
        }

        .cw-powered {
            font-size: 10px;
            color: #b0b6cc;
            text-align: center;
            margin-top: 6px;
            font-family: 'Poppins', sans-serif;
        }

        @media(max-width:400px) {
            .cw-panel {
                width: calc(100vw - 32px);
            }
        }
    </style>

    <div class="cw-wrap" id="cwWrap">
        <div class="cw-panel" id="cwPanel">
            <div class="cw-header">
                <div class="cw-header-left">
                    <div class="cw-header-avatar">
                        <i class="fas fa-robot"></i>
                        <span class="cw-header-dot"></span>
                    </div>
                    <div>
                        <div class="cw-header-name">BIS Assistant</div>
                        <div class="cw-header-sub">Bacolod Barangay · Online</div>
                    </div>
                </div>
                <div class="cw-header-actions">
                    <button class="cw-hbtn" onclick="cwClose()" title="Close"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="cw-date-divider"><span>Today</span></div>
            <div class="cw-messages" id="cwMessages">
                <div class="cw-row cw-row--bot">
                    <div class="cw-avatar"><i class="fas fa-robot"></i></div>
                    <div class="cw-body">
                        <div class="cw-bubble">Hello! I'm the <strong>BIS Assistant</strong> 👋<br>I can answer questions about barangay services, documents, and how the system works.</div>
                        <span class="cw-ts">Just now</span>
                    </div>
                </div>
                <div class="cw-chips" id="cwChips">
                    <button class="cw-chip" onclick="cwQuick('How do I request a barangay clearance?')"><i class="fas fa-file-alt"></i> Request clearance</button>
                    <button class="cw-chip" onclick="cwQuick('How do I create an account?')"><i class="fas fa-user-plus"></i> Create account</button>
                    <button class="cw-chip" onclick="cwQuick('How do I file a blotter report?')"><i class="fas fa-book"></i> File blotter</button>
                    <button class="cw-chip" onclick="cwQuick('What documents can I request?')"><i class="fas fa-file-contract"></i> Documents</button>
                    <button class="cw-chip" onclick="cwQuick('What are the office hours?')"><i class="fas fa-clock"></i> Office hours</button>
                    <button class="cw-chip" onclick="cwQuick('What is the fee for barangay clearance?')"><i class="fas fa-coins"></i> Fees</button>
                </div>
            </div>
            <div class="cw-footer">
                <div class="cw-input-wrap">
                    <input type="text" id="cwInput" class="cw-input" placeholder="Ask a question…" onkeydown="if(event.key==='Enter')cwSend()">
                    <button class="cw-send" onclick="cwSend()"><i class="fas fa-paper-plane"></i></button>
                </div>
                <p class="cw-powered">Powered by <strong>Bacolod BIS</strong></p>
            </div>
        </div>
        <button class="cw-toggle" id="cwToggle" onclick="cwTogglePanel()" aria-label="Open chat">
            <i class="fas fa-comment-dots" id="cwIcon"></i>
            <span class="cw-unread" id="cwUnread">1</span>
        </button>
    </div>

    <script>
        (function() {
            const KB = [{
                    keys: ['create account', 'sign up', 'register', 'how to register', 'new account'],
                    answer: '📝 <strong>Creating an Account:</strong><br>1. Click <strong>Sign Up</strong> on this page or go to <em>/signup</em>.<br>2. Select your role: <strong>Resident</strong> or <strong>SK</strong>.<br>3. Fill in your name, email, username, and password.<br>4. For Residents: enter your <strong>5-digit household number</strong>.<br>5. Check your email for a <strong>6-digit verification code</strong> (valid 15 minutes).<br>6. After verifying, wait for the Captain or Secretary to approve your account.'
                },
                {
                    keys: ['login', 'sign in', 'cannot login', 'account pending', 'account rejected'],
                    answer: '🔐 <strong>Logging In:</strong><br>Go to <em>/login</em> and enter your username and password.<br><br><strong>Common issues:</strong><br>• <em>Unverified</em> — check your email for the OTP code.<br>• <em>Pending</em> — awaiting approval by the Captain or Secretary.<br>• <em>Rejected</em> — contact the barangay office.<br>• Wrong password — use <strong>Forgot Password</strong> on the login page.'
                },
                {
                    keys: ['forgot password', 'reset password', 'change password', 'lost password'],
                    answer: '🔑 <strong>Forgot Password:</strong><br>1. Click <strong>"Forgot password?"</strong> on the login page.<br>2. Enter your registered email address.<br>3. Check your email for a <strong>6-digit reset code</strong> (valid 15 minutes).<br>4. Enter the code and set your new password (minimum 8 characters).'
                },
                {
                    keys: ['request clearance', 'apply clearance', 'barangay clearance', 'how to get clearance', 'clearance request'],
                    answer: '📄 <strong>Requesting a Barangay Clearance:</strong><br>1. Log in to your account.<br>2. Go to <strong>My Clearances</strong> in the sidebar.<br>3. Click <strong>"New Request"</strong>.<br>4. Select who the document is for.<br>5. Choose <strong>Barangay Clearance</strong> and enter the purpose.<br>6. Submit — processing takes <strong>1–2 business days</strong>.<br>7. Pick up at the barangay hall when notified.'
                },
                {
                    keys: ['certificate of residency', 'residency certificate', 'proof of residence'],
                    answer: '🏠 <strong>Certificate of Residency:</strong><br>Log in → My Clearances → New Request → Select <strong>Certificate of Residency</strong>.<br>Enter the purpose and submit. Processing takes 1–2 business days.<br>This certifies you are a resident of Barangay Bacolod, Bato, Camarines Sur.'
                },
                {
                    keys: ['certificate of indigency', 'indigency', 'indigent', 'low income'],
                    answer: '💙 <strong>Certificate of Indigency:</strong><br>This document is <strong>free of charge</strong>.<br><br>⚠️ <strong>Income Qualification:</strong> Your household\'s total net monthly income must be <strong>₱12,000 or below</strong>. Requests above this limit are automatically rejected.<br><br>Log in → My Clearances → New Request → Select <strong>Certificate of Indigency</strong>.'
                },
                {
                    keys: ['good moral', 'certificate of good moral'],
                    answer: '✅ <strong>Certificate of Good Moral Character:</strong><br>Log in → My Clearances → New Request → Select <strong>Certificate of Good Moral</strong>.<br>Enter the purpose (e.g., employment, scholarship) and submit. Processing takes 1–2 business days.'
                },
                {
                    keys: ['first time job seeker', 'first time job', 'ftjs'],
                    answer: '💼 <strong>First Time Job Seeker Certificate:</strong><br>Log in → My Clearances → New Request → Select <strong>First Time Job Seekers</strong>.<br>This is <strong>free of charge</strong> under Republic Act 11261.'
                },
                {
                    keys: ['what documents', 'available documents', 'types of documents', 'what can i request', 'document types'],
                    answer: '📋 <strong>Available Documents:</strong><br>1. 🏅 Barangay Clearance<br>2. 🏠 Certificate of Residency<br>3. 💙 Certificate of Indigency (income ≤ ₱12,000/mo — FREE)<br>4. ✅ Certificate of Good Moral<br>5. 💼 First Time Job Seekers (FREE)<br><br>All processed within <strong>1–2 business days</strong>. Log in and go to <strong>My Clearances → New Request</strong>.'
                },
                {
                    keys: ['fee', 'cost', 'how much', 'price', 'payment'],
                    answer: '💰 <strong>Document Fees:</strong><br>• Barangay Clearance — standard fee (paid at pickup)<br>• Certificate of Residency — standard fee<br>• Certificate of Indigency — <strong>FREE</strong><br>• Certificate of Good Moral — standard fee<br>• First Time Job Seekers — <strong>FREE</strong><br><br>Contact the barangay office for the current fee schedule.'
                },
                {
                    keys: ['file blotter', 'blotter report', 'file complaint', 'report incident', 'file a report'],
                    answer: '📋 <strong>Filing a Blotter Report:</strong><br><strong>Without an account:</strong> Use the <strong>"File a Report"</strong> button on this page under Services.<br><br><strong>With an account:</strong> Log in → Dashboard → File Blotter.<br><br>Provide: your name, contact, incident type, date/time, location, persons involved, and a detailed description.'
                },
                {
                    keys: ['hearing', 'summons', 'blotter status', 'when is my hearing'],
                    answer: '📅 <strong>Blotter Hearing:</strong><br>After filing, the barangay reviews your report and may schedule a <strong>hearing</strong> at the Barangay Hall.<br><br>Both parties receive an official <strong>Summons Letter</strong> via email with the hearing date, time, and venue.<br><br>Hearings follow the <em>Katarungang Pambarangay Law (RA 7160)</em>.'
                },
                {
                    keys: ['census', 'household number', 'household no', 'what is my household number'],
                    answer: '🏘️ <strong>Household Number:</strong><br>Your <strong>5-digit household number</strong> is assigned by the barangay when your household is registered in the census.<br><br>You need it to register as a Resident in the BIS system. If you don\'t know it, visit the barangay hall or contact the Secretary.'
                },
                {
                    keys: ['office hours', 'open', 'when is the office', 'barangay hall hours'],
                    answer: '🕐 <strong>Office Hours:</strong><br>📅 <strong>Monday to Friday</strong><br>⏰ <strong>8:00 AM – 5:00 PM</strong><br><br>Closed on weekends and public holidays.<br><br>The BIS online portal is available <strong>24/7</strong> for submitting requests.'
                },
                {
                    keys: ['contact', 'phone number', 'email', 'address', 'where is the barangay'],
                    answer: '📍 <strong>Contact Information:</strong><br>🏢 Barangay Hall, Bacolod, Bato, Camarines Sur<br>📞 +63 (054) 000-0000<br>📧 barangaybacolod@bato.gov.ph<br>🕐 Mon–Fri, 8:00 AM – 5:00 PM'
                },
                {
                    keys: ['what is bis', 'about bis', 'about the system', 'barangay information system'],
                    answer: '🏛️ <strong>About the BIS:</strong><br>The <strong>Barangay Information System (BIS)</strong> is the official digital platform of Barangay Bacolod, Bato, Camarines Sur.<br><br>Residents can request documents, file blotter reports, and track requests online. Officials manage census, clearances, blotter cases, reports, and schedules — all in one secure system.'
                },
                {
                    keys: ['privacy', 'data privacy', 'personal data', 'ra 10173'],
                    answer: '🔒 <strong>Data Privacy:</strong><br>The BIS complies with the <strong>Data Privacy Act of 2012 (RA 10173)</strong>.<br><br>Your personal information is encrypted, stored securely, and only accessed by authorized barangay officials. It is never sold or shared without consent.<br><br>See the <strong>Privacy Policy</strong> link in the footer for full details.'
                },
                {
                    keys: ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'kumusta'],
                    answer: '👋 Hello! I\'m the <strong>BIS Assistant</strong> for Barangay Bacolod, Bato, Camarines Sur.<br><br>I can help you with:<br>• Requesting documents (clearance, residency, indigency)<br>• Filing blotter reports<br>• Account registration and login<br>• Understanding how the system works<br><br>What would you like to know?'
                },
                {
                    keys: ['thank', 'thanks', 'salamat', 'thank you'],
                    answer: '😊 You\'re welcome! If you have more questions, feel free to ask. You can also visit the barangay hall (Mon–Fri, 8AM–5PM) for in-person assistance.'
                }
            ];

            function getR(msg) {
                const m = msg.toLowerCase().trim();

                // ── 1. Gibberish / too short / random characters ──────────────
                if (m.length < 2) {
                    return '😊 Please type a complete question so I can help you better.';
                }
                // Detect gibberish: mostly non-alphabetic or random repeated chars
                const alphaRatio = (m.match(/[a-z]/g) || []).length / m.length;
                const hasRepeats = /(.)\1{4,}/.test(m);
                if (alphaRatio < 0.4 || hasRepeats) {
                    return '🤖 I didn\'t quite catch that. Please type a clear question about barangay services and I\'ll be happy to help!';
                }
                // Detect nonsense words: no word is a real common word
                const realWords = ['how', 'what', 'when', 'where', 'who', 'why', 'can', 'do', 'i', 'is', 'are', 'the', 'a', 'an', 'my', 'me', 'to', 'for', 'in', 'of', 'and', 'or', 'not', 'yes', 'no', 'please', 'help', 'need', 'want', 'get', 'have', 'make', 'file', 'apply', 'request', 'barangay', 'clearance', 'account', 'register', 'login', 'password', 'blotter', 'census', 'document', 'certificate', 'office', 'hours', 'fee', 'cost', 'requirement', 'household', 'resident', 'sk', 'captain', 'secretary', 'report', 'complaint', 'hearing', 'schedule', 'appointment', 'create', 'update', 'change', 'reset', 'forgot', 'lost', 'pending', 'approved', 'rejected', 'status', 'track', 'cancel', 'submit', 'upload', 'photo', 'profile', 'contact', 'address', 'phone', 'email', 'name', 'number', 'zone', 'purok', 'indigency', 'residency', 'moral', 'job', 'seeker', 'good', 'first', 'time', 'what', 'about', 'tell', 'explain', 'show', 'give', 'send', 'receive', 'pick', 'up', 'visit', 'hall', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'am', 'pm', 'open', 'close', 'closed', 'available', 'free', 'paid', 'process', 'days', 'business', 'week', 'month', 'year', 'old', 'new', 'valid', 'id', 'form', 'fill', 'out', 'bring', 'need', 'required', 'requirements', 'ano', 'paano', 'saan', 'kailan', 'sino', 'bakit', 'pwede', 'hindi', 'oo', 'salamat', 'po', 'ako', 'ikaw', 'siya', 'kami', 'kayo', 'sila', 'ng', 'sa', 'at', 'na', 'ay', 'ang', 'mga', 'ito', 'iyan', 'iyon', 'dito', 'diyan', 'doon', 'may', 'wala', 'mayroon'];
                const msgWords = m.split(/\s+/);
                const hasRealWord = msgWords.some(w => realWords.includes(w) || w.length <= 2);
                // Also check if any word appears in our KB keys
                const inKB = KB.some(e => e.keys.some(k => k.split(/\s+/).some(kw => msgWords.some(w => w === kw))));
                if (!hasRealWord && !inKB && m.length < 20) {
                    return '🤖 That doesn\'t look like a question I can understand. Please type a clear question in English or Filipino about barangay services.<br><br>Example: <em>"How do I get a barangay clearance?"</em>';
                }

                // ── 2. Inappropriate / rude language ─────────────────────────
                const rude = ['putang', 'gago', 'bobo', 'tanga', 'ulol', 'puta', 'fuck', 'shit', 'damn', 'idiot', 'stupid', 'dumb', 'ass', 'bitch', 'hate', 'kill', 'die'];
                if (rude.some(w => m.includes(w))) {
                    return '🙏 I understand you may be frustrated, but I\'m here to help with barangay services. Please keep our conversation respectful so I can assist you better.<br><br>If you have an urgent concern, please visit the <strong>Barangay Hall</strong> (Mon–Fri, 8AM–5PM) or call <strong>+63 (054) 000-0000</strong>.';
                }

                // ── 3. Spam / test messages ───────────────────────────────────
                const spam = ['test', 'testing', 'asdf', 'qwerty', 'lorem', '1234', 'abcd', 'xyz', 'aaa', 'bbb'];
                if (spam.some(w => m === w || m.startsWith(w + ' '))) {
                    return '👋 It looks like you\'re testing the chat! I\'m ready to answer real questions about Barangay Bacolod\'s services.<br><br>Try asking: <em>"How do I request a barangay clearance?"</em> or <em>"How do I create an account?"</em>';
                }

                // ── 4. Out-of-scope topics ────────────────────────────────────
                const outOfScope = [{
                        keys: ['weather', 'forecast', 'temperature', 'rain', 'typhoon'],
                        reply: '🌤️ I can only answer questions about barangay services. For weather updates, please check <strong>PAGASA</strong> or your local news.'
                    },
                    {
                        keys: ['news', 'politics', 'election', 'president', 'mayor', 'governor'],
                        reply: '📰 I\'m focused on Barangay Bacolod services and can\'t discuss political topics. For local government news, visit the official municipal website.'
                    },
                    {
                        keys: ['recipe', 'food', 'cook', 'restaurant', 'eat'],
                        reply: '🍽️ I\'m a barangay services assistant and can\'t help with food-related questions. Is there anything about barangay documents or services I can help you with?'
                    },
                    {
                        keys: ['game', 'play', 'movie', 'music', 'song', 'netflix', 'youtube', 'tiktok', 'facebook'],
                        reply: '🎮 I\'m here specifically to help with barangay services. I can\'t assist with entertainment topics. Try asking about clearances, blotter reports, or account registration!'
                    },
                    {
                        keys: ['joke', 'funny', 'laugh', 'meme'],
                        reply: '😄 I appreciate the fun spirit, but I\'m a barangay services assistant! I\'m best at answering questions about documents, accounts, and barangay processes. How can I help you today?'
                    },
                    {
                        keys: ['love', 'relationship', 'boyfriend', 'girlfriend', 'crush', 'marry'],
                        reply: '💙 That\'s sweet, but I\'m a barangay services assistant! I can help you with clearances, blotter reports, account registration, and more. What barangay service do you need?'
                    },
                    {
                        keys: ['money', 'loan', 'borrow', 'invest', 'stock', 'crypto', 'bitcoin'],
                        reply: '💰 I can only assist with barangay services. For financial concerns, please contact the appropriate government agencies (SSS, Pag-IBIG, BIR) or your local bank.'
                    },
                    {
                        keys: ['medical', 'doctor', 'hospital', 'medicine', 'sick', 'health', 'covid'],
                        reply: '🏥 For medical concerns, please contact your nearest health center or hospital. The Barangay Health Center of Bacolod can also assist with basic health services. I can only answer questions about barangay documents and services.'
                    },
                    {
                        keys: ['school', 'college', 'university', 'enroll', 'tuition', 'scholarship'],
                        reply: '🎓 For educational concerns, please contact your school or DepEd. I can only assist with barangay services like clearances, blotter reports, and account registration.'
                    },
                    {
                        keys: ['police', 'crime', 'arrest', 'nbi', 'pnp', 'court', 'lawyer', 'legal advice'],
                        reply: '⚖️ For serious legal or criminal matters, please contact the <strong>Philippine National Police (PNP)</strong> or consult a lawyer. The barangay can assist with community disputes through the blotter system.'
                    },
                    {
                        keys: ['who are you', 'what are you', 'are you human', 'are you ai', 'are you a robot', 'are you real'],
                        reply: '🤖 I\'m the <strong>BIS Assistant</strong> — an automated chatbot for Barangay Bacolod, Bato, Camarines Sur. I\'m not a human, but I\'m here to help you with barangay services 24/7!<br><br>For complex concerns, visit the barangay hall (Mon–Fri, 8AM–5PM).'
                    },
                    {
                        keys: ['what can you do', 'what do you know', 'help me', 'i need help'],
                        reply: '🙋 I can help you with:<br><br>• 📄 <strong>Documents</strong> — clearance, residency, indigency, good moral<br>• 👤 <strong>Account</strong> — registration, login, password reset<br>• 📋 <strong>Blotter</strong> — filing a report, hearing schedule<br>• 🏘️ <strong>Census</strong> — household number, updating records<br>• 🕐 <strong>Office hours</strong> and contact information<br><br>Just type your question!'
                    },
                ];
                for (const entry of outOfScope) {
                    if (entry.keys.some(k => m.includes(k))) return entry.reply;
                }

                // ── 5. Knowledge base matching ────────────────────────────────
                for (const e of KB) {
                    for (const k of e.keys) {
                        if (m.includes(k)) return e.answer;
                    }
                }
                // Partial word fallback
                const words = m.split(/\s+/);
                for (const e of KB) {
                    for (const k of e.keys) {
                        if (k.split(/\s+/).some(kw => kw.length > 3 && words.some(w => w.includes(kw) || kw.includes(w)))) return e.answer;
                    }
                }

                // ── 6. Final fallback ─────────────────────────────────────────
                return '🤔 I\'m not sure how to answer that. I\'m specialized in <strong>Barangay Bacolod services</strong>.<br><br>Here\'s what I can help with:<br>• 📄 Document requests (clearance, residency, indigency)<br>• 👤 Account registration and login<br>• 📋 Filing blotter reports<br>• 🕐 Office hours and contact info<br><br>Try rephrasing your question, or visit the <strong>Barangay Hall</strong> (Mon–Fri, 8AM–5PM) for direct assistance.';
            }

            function now() {
                const d = new Date();
                return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
            }

            function addMsg(text, isUser) {
                const wrap = document.getElementById('cwMessages');
                const chips = document.getElementById('cwChips');
                if (chips) chips.remove();
                const row = document.createElement('div');
                row.className = 'cw-row ' + (isUser ? 'cw-row--user' : 'cw-row--bot');
                row.innerHTML = isUser ?
                    `<div class="cw-body"><div class="cw-bubble">${text}</div><span class="cw-ts">${now()}</span></div>` :
                    `<div class="cw-avatar"><i class="fas fa-robot"></i></div><div class="cw-body"><div class="cw-bubble">${text}</div><span class="cw-ts">${now()}</span></div>`;
                wrap.appendChild(row);
                wrap.scrollTop = wrap.scrollHeight;
            }

            function typing() {
                const wrap = document.getElementById('cwMessages');
                const t = document.createElement('div');
                t.id = 'cwTyping';
                t.className = 'cw-row cw-row--bot';
                t.innerHTML = `<div class="cw-avatar"><i class="fas fa-robot"></i></div><div class="cw-body"><div class="cw-bubble cw-typing"><span></span><span></span><span></span></div></div>`;
                wrap.appendChild(t);
                wrap.scrollTop = wrap.scrollHeight;
            }

            window.cwSend = function() {
                const inp = document.getElementById('cwInput');
                const msg = inp.value.trim();
                if (!msg) return;
                addMsg(msg, true);
                inp.value = '';
                document.getElementById('cwUnread').style.display = 'none';
                typing();
                setTimeout(() => {
                    const t = document.getElementById('cwTyping');
                    if (t) t.remove();
                    addMsg(getR(msg), false);
                }, 800);
            };

            window.cwQuick = function(msg) {
                const chips = document.getElementById('cwChips');
                if (chips) chips.remove();
                addMsg(msg, true);
                document.getElementById('cwUnread').style.display = 'none';
                typing();
                setTimeout(() => {
                    const t = document.getElementById('cwTyping');
                    if (t) t.remove();
                    addMsg(getR(msg), false);
                }, 800);
            };

            window.cwTogglePanel = function() {
                const panel = document.getElementById('cwPanel');
                const unread = document.getElementById('cwUnread');
                const icon = document.getElementById('cwIcon');
                panel.classList.toggle('cw-open');
                if (panel.classList.contains('cw-open')) {
                    unread.style.display = 'none';
                    icon.className = 'fas fa-times';
                } else {
                    icon.className = 'fas fa-comment-dots';
                }
            };

            window.cwClose = function() {
                document.getElementById('cwPanel').classList.remove('cw-open');
                document.getElementById('cwIcon').className = 'fas fa-comment-dots';
            };
        })();
    </script>
</body>

</html>