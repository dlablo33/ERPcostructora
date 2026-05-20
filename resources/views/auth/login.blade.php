<x-guest-layout>
    <!-- Agregar Bootstrap si no lo tienes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* ===== ESTILOS BASE ===== */
        * {
            box-sizing: border-box;
        }
        
        body {
            width: 100%;
            height: 100%;
            margin: 0px;
            background-color: #083CAE;
            font-family: 'Nunito', sans-serif;
            color: black;
        }
        
        hr {
            color: black;
            border-color: black;
        }
        
        /* ===== CONTENEDORES PRINCIPALES ===== */
        .div_recuadro_login {
            margin: 0 auto;
            width: 60vw;
            height: 750px;
            box-shadow: -1px 1px 20px #999;
            overflow: hidden;
            border-style: solid;
            border-color: #083CAE;
            background-color: white;
            position: relative;
            z-index: 1;
        }
        
        .divImgLogo {
            float: left;
            padding: 12px;
            overflow: hidden;
            text-align: center;
        }
        
        /* ===== PANEL DERECHO - FORMULARIO ===== */
        .div_col1 {
            float: right;
            width: 55%;
            height: 100%;
            overflow: hidden;
            padding-top: 20px;
            padding-left: 40px;
            padding-right: 40px;
            padding-bottom: 20px;
            position: relative !important;
            z-index: 100 !important;
            pointer-events: auto !important;
        }
        
        /* ===== LOGOS - NO BLOQUEAN ===== */
        .img_logo_a {
            background-image: url('../img/login/logo_local.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            height: 800px;
            width: 100%;
            margin-top: -350px;
            margin-bottom: -350px;
            pointer-events: none !important;
            user-select: none;
            display: block;
        }
        
        .img_logo_b {
            background-image: url('../img/login/logo_local.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center center;
            height: 800px;
            width: 100%;
            margin-top: -350px;
            margin-bottom: -350px;
            pointer-events: none !important;
            user-select: none;
            display: block;
        }
        
        /* Clase para la fila de logos */
        .row-logos {
            margin-bottom: 20px;
            height: auto;
            min-height: 100px;
            overflow: visible;
            position: relative;
            z-index: 5;
            pointer-events: none !important;
        }
        
        /* Ajustamos las columnas para que no recorten */
        .row-logos .col-6 {
            overflow: visible;
            pointer-events: none !important;
        }
        
        /* ===== PANEL IZQUIERDO - IMAGEN ===== */
        .login_img {
            float: left;
            width: 45%;
            height: 100%;
            background-image: url('../img/login/edificio_verde.png');
            background-size: cover;
            background-position: center center;
            position: relative;
            z-index: 1;
        }
        
        .login_overlay {
            background: rgba(8, 60, 174, 0.3);
            height: 100%;
            width: 100%;
            pointer-events: none !important;
        }
        
        /* ===== CONTENEDOR PRINCIPAL LOGIN ===== */
        .login_container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #083CAE;
            padding: 20px;
            position: relative;
        }
        
        /* ===== FOOTER ===== */
        .login_footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            width: 100%;
            color: white;
            font-size: 12px;
            pointer-events: none;
            z-index: 10;
        }
        
        /* ===== ESTILOS DEL FORMULARIO ===== */
        .login_label {
            display: block;
            margin-bottom: 5px;
            color: #083CAE;
            font-weight: bold;
            font-size: 14px;
            pointer-events: none;
        }
        
        .login_subtitle {
            text-align: center;
            color: #083CAE;
            margin-bottom: 30px;
            font-size: 16px;
            pointer-events: none !important;
            user-select: none;
        }
        
        /* ESTILOS ESPECÍFICOS PARA SUBTÍTULOS COLORIDOS */
        .login_subtitle[style*="color: #083CAE"] {
            color: #083CAE !important;
            font-size: 24px !important;
            margin-top: 10px !important;
        }
        
        .login_subtitle[style*="color: #FF0000"] {
            color: #FF0000 !important;
            font-size: 24px !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
        }
        
        /* ===== INPUTS - TOTALMENTE INTERACTIVOS ===== */
        .input_datos {
            height: 50px;
            border-style: none;
            border-color: darkgray;
            border-width: 1px;
            padding: 12px;
            color: black;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ddd;
            pointer-events: auto !important;
            cursor: text !important;
            position: relative;
            z-index: 250 !important;
            background-color: white;
            transition: all 0.3s ease;
        }
        
        .input_datos:hover {
            border-color: #083CAE;
            box-shadow: 0 0 5px rgba(8, 60, 174, 0.3);
        }
        
        .input_datos:focus {
            outline: none;
            border-color: #083CAE;
            box-shadow: 0 0 8px rgba(8, 60, 174, 0.5);
        }
        
        /* IDs específicos para inputs */
        #email,
        #password {
            pointer-events: auto !important;
            cursor: text !important;
            position: relative;
            z-index: 250 !important;
            height: 50px;
            border: 1px solid #ddd;
            padding: 12px;
            width: 100%;
            font-size: 16px;
        }
        
        /* ===== BOTÓN DE INICIO DE SESIÓN ===== */
        .div_boton_loginA {
            width: 100%;
            padding: 14px;
            border-width: 0px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            color: white;
            pointer-events: auto !important;
            position: relative;
            z-index: 250 !important;
            background-color: #083CAE;
            transition: background-color 0.3s ease;
        }
        
        .div_boton_loginA:hover {
            background-color: #052b7a !important;
        }
        
        .login_button {
            background: none;
            border: none;
            color: white;
            width: 100%;
            cursor: pointer !important;
            font-weight: bold;
            font-size: 16px;
            pointer-events: auto !important;
        }
        
        /* ===== ENLACES ===== */
        .login_forgot {
            color: #083CAE;
            text-decoration: none;
            font-size: 14px;
            pointer-events: auto !important;
            cursor: pointer !important;
            position: relative;
            z-index: 250 !important;
            transition: color 0.3s ease;
        }
        
        .login_forgot:hover {
            text-decoration: underline;
            color: #052b7a;
        }
        
        /* ===== MENSAJES DE ERROR ===== */
        .login_error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            pointer-events: none;
        }
        
        /* ===== CHECKBOX (si se usa) ===== */
        .login_checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            pointer-events: auto !important;
        }
        
        .login_checkbox input {
            margin-right: 5px;
            width: auto;
            cursor: pointer;
            pointer-events: auto !important;
        }
        
        .login_checkbox span {
            color: #666;
            font-size: 14px;
            pointer-events: none;
        }
        
        /* ===== FORMULARIO COMPLETO ===== */
        form {
            position: relative;
            z-index: 200 !important;
            pointer-events: auto !important;
        }
        
        form * {
            pointer-events: auto !important;
        }
        
        /* Elementos no interactivos dentro del formulario */
        form .login_label,
        form .login_error {
            pointer-events: none !important;
        }
        
        /* ===== COLORES UTILITARIOS ===== */
        .color_negro {
            background-color: white;
        }
        
        .color_fondo {
            background-color: #083CAE;
        }
        
        .color_boton {
            background-color: #083CAE;
        }
        
        .color_azul {
            background-color: #083CAE;
            color: white;
        }
        
        /* ===== ESTILOS ADICIONALES DEL SISTEMA ===== */
        .div_cerrar_b {
            width: 50px;
            float: right;
            text-align: right;
            cursor: pointer;
            font-weight: bold;
            font-size: 24px;
        }
        
        .div_input {
            width: 300px;
            text-align: left;
            border-style: solid;
            border-width: 1px;
            border-color: darkgrey;
            margin-bottom: 6px;
            overflow: hidden;
        }
        
        .img_fondo_log {
            overflow: hidden;
            padding-top: 50px;
            width: 100%;
            height: 100vh;
        }
        
        .logo {
            width: 70px;
        }
        
        .logo2 {
            width: 100px;
            padding-top: 15px;
        }
        
        .vert_align {
            vertical-align: middle;
        }
        
        .float_l {
            float: left;
        }
        
        .float_r {
            float: right;
        }
        
        .div_logo_menu {
            height: 70px;
            padding-left: 20px;
            padding-right: 20px;
        }
        
        .ban1 {
            z-index: 2;
            position: fixed;
            background-color: white;
            overflow: hidden;
            padding-left: 20px;
            padding-right: 20px;
            width: 100%;
        }
        
        .ban2 {
            z-index: 2;
            position: fixed;
            top: 70px;
            background-color: #083CAE;
            overflow: hidden;
            padding-left: 20px;
            padding-right: 20px;
            color: white;
            width: 100%;
        }
        
        .titulo1 {
            font-size: 22px;
            font-weight: bold;
        }
        
        .titulo_group1 {
            font-size: 15px;
            font-weight: bold;
            width: 100%;
            float: left;
            overflow: hidden;
            padding-top: 10px;
            padding-left: 10px;
            color: black;
        }
        
        .menu1 {
            float: left;
            padding: 14px;
            font-size: 15px;
            cursor: pointer;
            text-align: center;
        }
        
        .div_opcion {
            cursor: pointer;
            color: blue;
            overflow: hidden;
            padding: 2px;
            font-size: 14px;
            line-height: 12px;
            padding-top: 10px;
            padding-bottom: 4px;
        }
        
        .div_mod1 {
            z-index: 1;
            position: absolute;
            top: 130px;
            left: 0px;
            width: 100%;
            overflow: hidden;
            padding: 20px;
        }
        
        .div_mod2 {
            margin: 0 auto;
            width: 87vw;
            overflow: hidden;
            background-color: white;
            padding: 10px;
            box-shadow: -3px 3px 16px #333333;
        }
        
        .div_fondo_pantalla {
            background-color: white;
            padding: 14px;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .div_fondo_pantalla2 {
            height: 56vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 5px;
        }
        
        .div_titulo_2 {
            width: 100%;
            font-size: 20px;
            font-weight: bold;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .div_titulo_3 {
            float: left;
            font-size: 20px;
            font-weight: bold;
            overflow: hidden;
            margin-bottom: 10px;
        }
        
        .div_opciones {
            float: left;
            background-color: red;
            padding: 5px;
            margin-right: 10px;
            overflow: hidden;
            cursor: pointer;
            min-width: 80px;
            text-align: center;
            color: white;
            font-size: 13px;
        }
        
        .div_opciones_2 {
            float: left;
            background-color: red;
            padding: 5px;
            margin-right: 10px;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
            color: white;
            font-size: 11px;
        }
        
        .toggle_div {
            display: none;
            overflow: hidden;
            width: 100%;
        }
        
        .div_opciones_cerrar {
            float: right;
            background-color: red;
            padding: 5px;
            margin-right: 10px;
            overflow: hidden;
            font-weight: bold;
            cursor: pointer;
            width: 80px;
            text-align: center;
            color: white;
        }
        
        .div_hr {
            width: 100%;
            overflow: hidden;
        }
        
        .float_left {
            float: left;
        }
        
        .contenedor2 {
            min-height: 100px;
            overflow: hidden;
            margin-right: 12px;
        }
        
        .margin_right {
            margin-right: 20px;
        }
        
        .lightgrey {
            background-color: lightgray;
        }
        
        select {
            width: 150px;
        }
        
        .padding1 {
            padding: 6px;
        }
        
        .txtsize11 {
            font-size: 11px;
        }
        
        .pantalla {
            z-index: 1;
            position: absolute;
            top: 0px;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
        }
        
        .pantalla_menu_glob {
            position: fixed;
            top: 120px;
            max-width: 1000px;
        }
        
        .ad2 {
            overflow: hidden;
            float: left;
            width: 100%;
        }
        
        .d2 {
            overflow: hidden;
            float: left;
            width: 160px;
            height: 170px;
            padding: 10px;
        }
        
        .d2_b {
            overflow: hidden;
            float: left;
            width: 160px;
            height: 50px;
            padding: 10px;
        }
        
        .pantalla_menu {
            float: left;
            width: 200px;
            max-height: 430px;
            overflow: hidden;
            font-size: 14px;
        }
        
        .menu2 {
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            border-top-right-radius: 20px;
            border-bottom-left-radius: 20px;
            background-color: white;
            margin-bottom: 5px;
        }
        
        .pantalla_menu2 {
            float: left;
            position: fixed;
            z-index: 4;
            top: 120px;
            background-color: white;
            font-size: 12px;
            display: none;
            width: 500px;
            max-height: 450px;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px;
            border-left-style: solid;
            border-left-color: red;
            border-bottom-left-radius: 20px;
            border-top-right-radius: 20px;
        }
        
        .espacio_r {
            padding-bottom: 10px;
        }
        
        .fondo_blanco1 {
            background-color: white;
        }
        
        .menu3 {
            cursor: pointer;
            padding: 10px;
        }
        
        .pantalla_menu3 {
            float: left;
            background-color: white;
            overflow: hidden;
            font-size: 12px;
            display: none;
            width: 500px;
        }
        
        .titulo_d2 {
            font-weight: bold;
            font-size: 15px;
            line-height: 14px;
            margin-top: 16px;
        }
        
        .scroll {
            overflow: auto;
        }
        
        input {
            font-size: 11px;
        }
        
        select {
            font-size: 11px;
        }
        
        .div_plus {
            float: left;
            background-color: red;
            padding: 5px;
            margin-right: 10px;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
            width: 30px;
            height: 30px;
        }
        
        .msgctre {
            float: left;
            font-weight: bold;
            width: 200px;
        }
        
        .no_hay_reg {
            font-weight: bold;
            font-size: 14px;
        }
        
        .tabla1 {
            width: 100%;
            border-spacing: 0px;
            border-color: lightgrey;
            font-size: 12px;
            border-left-style: none;
            border-right-style: none;
        }
        
        td {
            padding: 6px;
            border-left-style: none;
            border-right-style: none;
        }
        
        th {
            background-color: #083CAE;
            color: white;
            border-style: none;
            text-align: center;
        }
        
        .t_td {
            padding: 4px;
            margin: 4px;
            overflow: hidden;
            font-size: 12px;
            font-weight: bold;
            width: 32%;
            text-align: right;
            color: #083CAE;
            background-color: lightgray;
        }
        
        .d_pestañas.accordion-header {
            background-color: rgb(211, 211, 211) !important;
            color: #fff !important;
            font-size: 16px !important;
        }
        
        .d_pestañas.accordion-header button {
            color: #000000;
        }
        
        .collapsed {
            color: #000 !important;
        }
        
        .rt1 {
            text-align: right;
            padding: 6px;
            overflow: hidden;
        }
        
        input.campos-formularios {
            width: 100%;
            border-radius: 0px;
            font-size: 12px !important;
            height: 25px !important;
            font-family: Arial,Helvetica,sans-serif;
            padding: .375rem .75rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-clip: padding-box;
            border: 1px solid #979898;
            margin-bottom: 3px !important;
        }
        
        label.formularios-texto {
            font-family: Arial,Helvetica,sans-serif !important;
            color: #000;
            font: bold;
            font-size: small;
            margin-bottom: 3px !important;
        }
        
        select.campos-formularios {
            width: 100%;
            border-radius: 0px;
            font-size: 12px !important;
            height: 25px !important;
            font-family: Arial,Helvetica,sans-serif;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-clip: padding-box;
            border: 1px solid #979898;
            margin-bottom: 3px !important;
        }
        
        div.encabezados-form {
            padding-left: 0px !important;
            padding-right: 0px !important;
            margin-bottom: 5px !important;
        }
        
        textarea.campos-formularios {
            width: 100%;
            height: 66px;
            padding: .375rem .75rem;
            font-size: 12px;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #979898;
            border-radius: 0px;
        }
        
        .table td, .table th {
            padding: 0px !important;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-family: Arial,Helvetica,sans-serif !important;
            text-align: left;
            font-size: 14px;
        }
        
        div.table-procesos-c {
            min-height: 150px;
            max-height: 250px;
        }
        
        button.boton-icon-tabla {
            height: 27px !important;
            padding-top: 1px !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
        
        .div_fecha_hora {
            width: 100%;
            overflow: hidden;
            position: fixed;
            bottom: 0px;
            z-index: 5;
            background-color: #083CAE;
            color: white;
            font-weight: bold;
            font-size: 12px;
            padding: 4px;
            padding-right: 20px;
            text-align: right;
        }
        
        .menu2_oculto {
            display: none;
        }
        
        .posicion_gerencial {
            left: 20px;
        }
        
        .posicion2_gerencial {
            left: 220px;
        }
        
        .form-control {
            border-radius: 0px !important;
        }
        
        #login {
            background-color: #083CAE;
            border-color: initial;
            border-radius: 0px;
        }
        
        /* ===== ESTILOS RESPONSIVE ===== */
        @media only screen and (min-width: 560px) {
            .inputs-combinados-1 {
                padding-right: 0px !important;
            }
            
            .inputs-combinados-2 {
                padding-left: 0px !important;
            }
        }
        
        @media only screen and (max-width: 1200px) {
            .img_fondo_log {
                position: relative;
            }
        }
        
        @media only screen and (max-width: 920px) {
            .t_td {
                font-size: 12px;
                width: 48%;
            }
        }
        
        @media only screen and (max-width: 700px) {
            .menu1 {
                padding: 12px;
                font-size: 12px;
                width: 50%;
                min-width: 150px;
            }
            
            .cont {
                padding-top: 200px;
                padding-left: 20px;
                padding-right: 20px;
            }
            
            .pantalla_menu_glob {
                top: 190px;
            }
            
            .pantalla_menu {
                width: 150px;
                font-size: 14px;
            }
            
            .pantalla_menu2 {
                top: 190px;
                font-size: 12px;
                width: 190px;
                height: 350px;
                overflow-y: auto;
            }
            
            .div_mod1 {
                top: 200px;
                width: 100%;
                padding: 0px;
            }
            
            .div_mod2 {
                width: 85vw;
                background-color: white;
                padding: 10px;
            }
            
            .t_td {
                font-size: 12px;
                width: 100%;
            }
            
            input {
                width: 270px;
            }
            
            .div_recuadro_login > div {
                flex-direction: column !important;
            }
            
            .div_col1, .login_img {
                width: 100% !important;
            }
            
            .login_img {
                min-height: 200px !important;
                order: 0;
            }
            
            .div_col1 {
                float: none !important;
                order: 1;
            }
            
            .div_recuadro_login {
                height: auto !important;
                min-height: 600px;
            }
            
            /* Ajustes responsive para las imágenes */
            .img_logo_a, .img_logo_b {
                height: 300px !important;
                margin-top: -100px !important;
                margin-bottom: -100px !important;
            }
        }
        
        @media only screen and (max-width: 560px) {
            .rt1 {
                text-align: left !important;
            }
        }
        
        @media only screen and (max-width: 480px) {
            .div_col1 {
                padding: 20px !important;
            }
            
            .input_datos,
            #email,
            #password {
                font-size: 14px !important;
                height: 45px !important;
            }
            
            .div_boton_loginA {
                padding: 12px !important;
            }
            
            .img_logo_a, .img_logo_b {
                height: 200px !important;
                margin-top: -50px !important;
                margin-bottom: -50px !important;
            }
            
            .login_subtitle {
                font-size: 20px !important;
            }
        }
        
        @media only screen and (max-width: 290px) {
            .div_recuadro_login {
                width: 270px;
            }
            
            .div_col1 {
                width: 230px;
                padding: 12px;
            }
            
            .div_cerrar_b {
                width: 30px;
            }
            
            .input_datos,
            #email,
            #password {
                width: 170px;
            }
        }
        
        /* ===== ESTILOS PARA INPUTS DESHABILITADOS ===== */
        input:disabled {
            cursor: default;
            background-color: #e8e8e8 !important;
        }
        
        select:disabled {
            cursor: default;
            background-color: #e8e8e8 !important;
        }
        
        /* ===== SOLUCIÓN ADICIONAL PARA PROBLEMAS DE CLIC ===== */
        .div_recuadro_login {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
        }
        
        /* Forzar que los elementos interactivos estén por encima */
        button, 
        a, 
        input[type="submit"],
        input[type="button"] {
            cursor: pointer !important;
        }
        
        /* Eliminar cualquier propiedad que pueda bloquear eventos */
        .no-pointer-events {
            pointer-events: none !important;
        }
        
        .auto-pointer-events {
            pointer-events: auto !important;
        }
        
        /* ===== ESTILOS DE DEPURACIÓN (opcional - comentar en producción) ===== */
        /*
        .debug-mode * {
            outline: 1px solid rgba(255, 0, 0, 0.2) !important;
        }
        
        .debug-mode .div_col1 {
            background-color: rgba(0, 255, 0, 0.1) !important;
        }
        
        .debug-mode input:focus {
            outline: 3px solid blue !important;
        }
        */
    </style>

    <div class="login_container">
        <!-- Contenedor principal del login -->
        <div class="div_recuadro_login">
            <div style="height: 100%;">
                <!-- Panel izquierdo - Imagen de fondo -->
                <div class="login_img">
                    <div class="login_overlay"></div>
                </div>

                <!-- Panel derecho - Formulario -->
                <div class="div_col1">
                    <!-- LOGOS EN FILA CON BOOTSTRAP - NO BLOQUEAN -->
                    <div class="row h-25 row-logos">
                        <div class="col-6">
                            <div class="img_logo_a"></div>
                        </div>
                        <div class="col-6">
                            <div class="img_logo_b"></div>
                        </div>
                    </div>
                    
                    <p class="login_subtitle" style="color: #083CAE; font-size: 24px; margin-top: 10px;">
                        Líder en Rentabilidad de Construcción
                    </p>                
                    
                    <p class="login_subtitle" style="color: #FF0000; font-size: 24px; font-weight: bold; margin-bottom: 5px;">
                        Bienvenidos
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div style="margin-bottom: 15px;">
                            <label class="login_label" for="email">Correo Electrónico</label>
                            <input 
                                id="email"
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required 
                                autofocus
                                class="input_datos"
                                placeholder="ejemplo@correo.com"
                            >
                            <x-input-error :messages="$errors->get('email')" class="login_error" />
                        </div>

                        <!-- Password -->
                        <div style="margin-bottom: 20px;">
                            <label class="login_label" for="password">Contraseña</label>
                            <input 
                                id="password"
                                type="password" 
                                name="password" 
                                required
                                class="input_datos"
                                placeholder="Ingrese su contraseña"
                            >
                            <x-input-error :messages="$errors->get('password')" class="login_error" />
                        </div>

                        <!-- Forgot Password -->
                        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="login_forgot">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <!-- Button -->
                        <div class="div_boton_loginA color_boton" style="width: 100%;">
                            <button type="submit" class="login_button">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="login_footer">
            <p>© 2026 MejoraSoft. Todos los derechos reservados.</p>
        </div>
    </div>

    <!-- Script de respaldo para asegurar interactividad -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Solución de respaldo para inputs no cliqueables
        setTimeout(function() {
            // Forzar que los inputs sean cliqueables
            const inputs = document.querySelectorAll('#email, #password, .input_datos');
            inputs.forEach(input => {
                input.style.pointerEvents = 'auto';
                input.style.position = 'relative';
                input.style.zIndex = '9999';
                input.style.cursor = 'text';
                console.log('Input corregido:', input.id || 'input');
            });
            
            // Forzar que el botón sea cliqueable
            const buttons = document.querySelectorAll('.div_boton_loginA, .login_button, button[type="submit"]');
            buttons.forEach(button => {
                button.style.pointerEvents = 'auto';
                button.style.position = 'relative';
                button.style.zIndex = '9999';
                button.style.cursor = 'pointer';
            });
            
            // Forzar que los enlaces sean cliqueables
            const links = document.querySelectorAll('.login_forgot, a');
            links.forEach(link => {
                link.style.pointerEvents = 'auto';
                link.style.position = 'relative';
                link.style.zIndex = '9999';
            });
            
            // Verificar si hay elementos superpuestos en el campo de email
            const emailField = document.getElementById('email');
            if (emailField) {
                const rect = emailField.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    const elementsAtPosition = document.elementsFromPoint(
                        rect.left + rect.width / 2, 
                        rect.top + rect.height / 2
                    );
                    
                    console.log('Elementos en posición del email:', elementsAtPosition.map(el => 
                        el.tagName + (el.id ? '#' + el.id : '') + (el.className ? '.' + el.className : '')
                    ));
                    
                    // Si el primer elemento no es el email, algo está bloqueando
                    if (elementsAtPosition[0] !== emailField) {
                        console.warn('⚠️ Elemento bloqueando el email:', elementsAtPosition[0]);
                        // Forzar al email a estar arriba
                        emailField.style.zIndex = '10000';
                        
                        // Si el bloqueador es un logo u elemento decorativo, desactivar sus eventos
                        const blocker = elementsAtPosition[0];
                        if (blocker && (blocker.classList.contains('img_logo_a') || 
                                        blocker.classList.contains('img_logo_b') || 
                                        blocker.classList.contains('login_overlay'))) {
                            blocker.style.pointerEvents = 'none';
                        }
                    } else {
                        console.log('✅ Email field is clickable');
                    }
                }
            }
        }, 500);
    });
    </script>
</x-guest-layout>