@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Flujo de Dinero -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #6B8ACE; padding: 15px 20px;">
                <h2 style="color: #083CAE; font-weight: bold; margin: 0; font-size: 24px; text-align: center;">
                    Flujo de Dinero
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Barra de herramientas -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <label for="year" style="font-weight: 600; color: #083CAE;">Año:</label>
                        <select id="year" style="padding: 8px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; background-color: white;">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026" selected>2026</option>
                        </select>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label for="semana" style="font-weight: 600; color: #083CAE;">Semana:</label>
                        <select id="semana" style="padding: 8px 12px; border: 1px solid #083CAE; border-radius: 4px; font-size: 14px; width: 250px; background-color: white;">
                            <option value="1">Semana 1</option>
                            <option value="2">Semana 2</option>
                            <option value="3" selected>Semana 3</option>
                            <option value="4">Semana 4</option>
                            <option value="5">Semana 5</option>
                            <option value="6">Semana 6</option>
                            <option value="7">Semana 7</option>
                            <option value="8">Semana 8</option>
                            <option value="9">Semana 9</option>
                            <option value="10">Semana 10</option>
                            <option value="11">Semana 11</option>
                            <option value="12">Semana 12</option>
                            <option value="13">Semana 13</option>
                            <option value="14">Semana 14</option>
                            <option value="15">Semana 15</option>
                            <option value="16">Semana 16</option>
                            <option value="17">Semana 17</option>
                            <option value="18">Semana 18</option>
                            <option value="19">Semana 19</option>
                            <option value="20">Semana 20</option>
                            <option value="21">Semana 21</option>
                            <option value="22">Semana 22</option>
                            <option value="23">Semana 23</option>
                            <option value="24">Semana 24</option>
                            <option value="25">Semana 25</option>
                            <option value="26">Semana 26</option>
                            <option value="27">Semana 27</option>
                            <option value="28">Semana 28</option>
                            <option value="29">Semana 29</option>
                            <option value="30">Semana 30</option>
                            <option value="31">Semana 31</option>
                            <option value="32">Semana 32</option>
                            <option value="33">Semana 33</option>
                            <option value="34">Semana 34</option>
                            <option value="35">Semana 35</option>
                            <option value="36">Semana 36</option>
                            <option value="37">Semana 37</option>
                            <option value="38">Semana 38</option>
                            <option value="39">Semana 39</option>
                            <option value="40">Semana 40</option>
                            <option value="41">Semana 41</option>
                            <option value="42">Semana 42</option>
                            <option value="43">Semana 43</option>
                            <option value="44">Semana 44</option>
                            <option value="45">Semana 45</option>
                            <option value="46">Semana 46</option>
                            <option value="47">Semana 47</option>
                            <option value="48">Semana 48</option>
                            <option value="49">Semana 49</option>
                            <option value="50">Semana 50</option>
                            <option value="51">Semana 51</option>
                            <option value="52">Semana 52</option>
                        </select>

                        <button id="btnExcel" 
                            style="background-color: #2CBF1F; border: 1px solid #2CBF1F; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-size: 14px; display: flex; align-items: center; gap: 5px; color: white;">
                            <i class="fas fa-file-excel" style="color: white;"></i> Excel
                        </button>
                    </div>
                </div>

                <!-- Tabla de Flujo de Dinero -->
                <div class="table-responsive" style="margin-top: 10px; border: 1px solid #dee2e6; border-radius: 8px; overflow: auto; max-height: 70vh;" id="tablaContainer">
                    <table class="table table-bordered" id="tablaFlujoDinero" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 20; background-color: #6B8ACE; color: white;">
                            <tr>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: left; background-color: #6B8ACE; color: white; min-width: 250px;">
                                    <span>Cuentas</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Lunes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Martes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Miércoles</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Jueves</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Viernes</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Sábado</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 100px;">
                                    <span>Domingo</span>
                                </th>
                                <th style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; background-color: #6B8ACE; color: white; min-width: 120px;">
                                    <span>Acumulado</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">
                            <tr><td colspan="9" style="text-align: center; padding: 40px;">Cargando datos...</td</tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Mensaje "Sin datos" -->
                <div style="text-align: center; padding: 40px 20px; background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 8px; margin: 20px 0; display: none;" id="sinDatosMensaje">
                    <i class="fas fa-file-invoice" style="font-size: 48px; color: #ced4da; margin-bottom: 15px;"></i>
                    <h3 style="color: #6c757d; font-size: 18px; margin: 0;">Sin datos</h3>
                    <p style="color: #adb5bd; font-size: 14px; margin-top: 5px;">No hay información para la semana seleccionada</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #6B8ACE;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(107, 138, 206, 0.15) !important;
        border-color: #6B8ACE !important;
    }
    
    .table th {
        white-space: nowrap;
        font-size: 12px;
        background-color: #6B8ACE !important;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
    }
    
    .table td {
        white-space: nowrap;
        font-size: 12px;
        padding: 10px 8px;
    }
    
    .cuenta-principal {
        font-weight: bold;
        background-color: #f8f9fc !important;
        cursor: pointer;
    }
    
    .cuenta-principal:hover {
        background-color: #e9ecef !important;
    }
    
    .cuenta-principal i {
        transition: transform 0.2s;
        color: #6B8ACE;
        margin-right: 8px;
    }
    
    .subcuenta {
        padding-left: 30px !important;
        background-color: #ffffff;
    }
    
    .subcuenta:hover {
        background-color: #f2f2f2;
    }
    
    @media (max-width: 768px) {
        div[style*="justify-content: space-between"] {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        select, button {
            width: 100% !important;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado - Flujo de Dinero');
        
        // Elementos del DOM
        const selectSemana = document.getElementById('semana');
        const selectYear = document.getElementById('year');
        const btnExcel = document.getElementById('btnExcel');
        const tablaBody = document.getElementById('tablaBody');
        const sinDatosMensaje = document.getElementById('sinDatosMensaje');

        // Variables globales
        let semanaActual = 3;
        let yearActual = 2026;
        let datosActuales = { cuentas: [] };
        let datosExpandidos = { 1: false, 2: false };

        // Función para formatear moneda
        function formatCurrency(amount) {
            if (amount === undefined || amount === null) amount = 0;
            return '$' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        // Función para calcular acumulado de una subcuenta
        function calcularAcumulado(subcuenta) {
            return (subcuenta.lunes || 0) + (subcuenta.martes || 0) + (subcuenta.miercoles || 0) +
                   (subcuenta.jueves || 0) + (subcuenta.viernes || 0) + (subcuenta.sabado || 0) +
                   (subcuenta.domingo || 0);
        }

        // Función para alternar expansión
        function toggleExpand(cuentaId) {
            datosExpandidos[cuentaId] = !datosExpandidos[cuentaId];
            cargarTabla();
        }

        // Función para cargar datos desde el servidor
        function cargarDatos() {
            tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Cargando datos...</td</tr>';
            sinDatosMensaje.style.display = 'none';
            
            fetch(`/admin/api/flujo-dinero?semana=${semanaActual}&year=${yearActual}`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(result => {
                if (result.success && result.data && result.data.cuentas) {
                    datosActuales = result.data;
                    cargarTabla();
                    
                    // Actualizar el rango de fechas en el select
                    if (result.rango) {
                        const option = selectSemana.querySelector(`option[value="${semanaActual}"]`);
                        if (option) {
                            option.text = `Semana ${semanaActual} (${result.rango})`;
                        }
                    }
                } else {
                    console.error('Error:', result.message);
                    tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center; color: red; padding: 40px;">Error al cargar datos</td</tr>';
                    sinDatosMensaje.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tablaBody.innerHTML = '<tr><td colspan="9" style="text-align: center; color: red; padding: 40px;">Error de conexión</td</tr>';
                sinDatosMensaje.style.display = 'block';
            });
        }

        // Función para cargar la tabla
        function cargarTabla() {
            const semanaData = datosActuales;
            
            if (!semanaData || !semanaData.cuentas || semanaData.cuentas.length === 0) {
                sinDatosMensaje.style.display = 'block';
                tablaBody.innerHTML = '';
                return;
            }

            sinDatosMensaje.style.display = 'none';
            tablaBody.innerHTML = '';

            semanaData.cuentas.forEach(cuenta => {
                // Calcular totales de la cuenta principal
                let totalCuentaLunes = 0, totalCuentaMartes = 0, totalCuentaMiercoles = 0;
                let totalCuentaJueves = 0, totalCuentaViernes = 0, totalCuentaSabado = 0;
                let totalCuentaDomingo = 0, totalCuentaAcumulado = 0;

                cuenta.subcuentas.forEach(sub => {
                    totalCuentaLunes += sub.lunes || 0;
                    totalCuentaMartes += sub.martes || 0;
                    totalCuentaMiercoles += sub.miercoles || 0;
                    totalCuentaJueves += sub.jueves || 0;
                    totalCuentaViernes += sub.viernes || 0;
                    totalCuentaSabado += sub.sabado || 0;
                    totalCuentaDomingo += sub.domingo || 0;
                    totalCuentaAcumulado += calcularAcumulado(sub);
                });

                // Fila de cuenta principal
                const rowPrincipal = document.createElement('tr');
                rowPrincipal.className = 'cuenta-principal';
                rowPrincipal.setAttribute('data-cuenta-id', cuenta.id);
                
                const icono = datosExpandidos[cuenta.id] ? 'fa-chevron-down' : 'fa-chevron-right';
                
                rowPrincipal.innerHTML = `
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; font-weight: bold;">
                        <i class="fas ${icono}" style="margin-right: 8px; color: #6B8ACE;"></i>
                        ${cuenta.codigo} - ${cuenta.nombre}
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaLunes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaMartes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaMiercoles)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaJueves)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaViernes)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaSabado)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right;">${formatCurrency(totalCuentaDomingo)}</td>
                    <td style="border: 1px solid #dee2e6; padding: 12px 8px; text-align: right; font-weight: bold;">${formatCurrency(totalCuentaAcumulado)}</td>
                `;
                
                rowPrincipal.addEventListener('click', (e) => {
                    if (e.target.classList.contains('fas')) {
                        toggleExpand(cuenta.id);
                    } else {
                        toggleExpand(cuenta.id);
                    }
                });
                
                tablaBody.appendChild(rowPrincipal);

                // Agregar subcuentas si está expandido
                if (datosExpandidos[cuenta.id]) {
                    cuenta.subcuentas.forEach(sub => {
                        const subAcumulado = calcularAcumulado(sub);
                        
                        const rowSub = document.createElement('tr');
                        rowSub.className = 'subcuenta';
                        rowSub.innerHTML = `
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; padding-left: 35px;">${sub.codigo} - ${sub.nombre}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.lunes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.martes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.miercoles || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.jueves || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.viernes || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.sabado || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(sub.domingo || 0)}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 8px; text-align: right;">${formatCurrency(subAcumulado)}</td>
                        `;
                        tablaBody.appendChild(rowSub);
                    });
                }
            });
        }

        // Event Listeners
        selectSemana.addEventListener('change', function() {
            semanaActual = parseInt(selectSemana.value);
            cargarDatos();
        });

        selectYear.addEventListener('change', function() {
            yearActual = parseInt(selectYear.value);
            cargarDatos();
        });

        btnExcel.addEventListener('click', function() {
            window.location.href = `/admin/api/flujo-dinero/exportar-excel?semana=${semanaActual}&year=${yearActual}`;
        });

        // Cargar datos iniciales
        cargarDatos();
    });
</script>
@endsection