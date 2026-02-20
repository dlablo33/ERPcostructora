@extends('layouts.navigation')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-800">
    <section class="content container-fluid py-3">
        <!-- Antiguedad de Cuentas Por Cobrar -->
        <div class="semaforo card mt-2">
            <div class="semaforo card-header" style="background-color: #f4f6f9; border-bottom: 2px solid #083CAE; padding: 15px 20px;">
<h2 style="color: #083CAE; font-weight: bold; margin: 0 0 15px 0; font-size: 24px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
    Antiguedad de Cuentas Por Cobrar
    <i class="fa-solid fa-arrow-trend-up" style="color: #16a34a; font-size: 26px;"></i>
</h2>
                
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="contacto_id" style="color: #083CAE; font-weight: 500; margin-right: 10px;">Cliente:</label>
                        <select class="form-control form-control-sm" id="contacto_id" style="width: auto; display: inline-block; border: 1px solid #083CAE; border-radius: 4px; padding: 5px 10px;">
                            <option value="0" selected>TODOS</option>
                            <option value="38">Maquiladora Industrial</option>
                            <option value="42">Cartones del Norte Demo</option>
                            <option value="43">Farmaceutica Demo</option>
                            <option value="44">Corporativo Monterrey Demo</option>
                            <option value="47">Cliente Mty Demo</option>
                            <option value="50">Empresa USA Demo</option>
                            <option value="52">Logistica Demo</option>
                            <option value="131">Cedis Mty 1</option>
                        </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-sm" id="buttonExcel" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-excel mr-1"></i> Descarga Excel
                        </button>
                        <button type="button" class="btn btn-sm" id="buttonVerPDF" style="background-color: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 4px; margin-right: 5px;">
                            <i class="fas fa-file-pdf mr-1"></i> Descarga PDF
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- PRIMERA FILA: 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                    <!-- Cuadro 1: Total CXC -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #28a745; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-search-dollar" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Total CXC</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">549,323.56</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 2: Corriente -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #28a745; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-search-dollar" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Corriente</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$50,400.00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 3: De 1 a 30 Días -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-usd" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">De 1 a 30 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$29,957.76</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 4: 31 a 60 Días -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-usd" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">31 a 60 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$50,400.00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEGUNDA FILA: 4 CUADROS -->
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                    <!-- Cuadro 5: 61 a 90 Días -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-usd" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">61 a 90 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$0.00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 6: 91 a 120 Días -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-usd" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">91 a 120 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$20,000.00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 7: Mas de 120 Días -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px;">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #dc3545; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-hand-holding-usd" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Mas de 120 Días</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">$398,565.80</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cuadro 8: Pendiente de Revisión (oculto por defecto) -->
                    <div style="flex: 1 1 calc(12.5% - 15px); min-width: 130px; display: none;" id="pendiente_revision">
                        <div class="custom-card" style="border: 2px solid #083CAE; border-radius: 10px; padding: 12px; display: flex; align-items: center; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); height: 100%;">
                            <div style="background-color: #ffc107; width: 50px; height: 50px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;">
                                <i class="fas fa-exclamation-circle" style="color: white; font-size: 24px;"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="color: #6c757d; font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Pendiente Revisión</div>
                                <div style="color: #083CAE; font-size: 16px; font-weight: bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="monto_pendiente">$0.00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de antigüedad de cuentas por cobrar -->
                <div class="table-responsive" style="margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px; max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered table-striped" id="semaforoCXC" style="width: 100%; margin-bottom: 0; font-size: 12px; border-collapse: collapse;">
                        <thead style="position: sticky; top: 0; z-index: 10;">
                            <!-- Fila vacía -->
                            <tr style="background-color: #e9ecef; height: 5px;"></tr>
                            
                            <!-- Segunda fila de encabezado - títulos principales -->
                            <tr style="background-color: #e9ecef;">
                                <th style="width: 30px; text-align: center; border: 1px solid #dee2e6; padding: 8px 5px; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; min-width: 200px; background-color: #6B8ACE !important; color: white;">Cliente</th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; min-width: 80px; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; min-width: 80px; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="width: 120px; background-color: #32cd32 !important; color: #000; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">Corriente</th>
                                <th style="width: 100px; background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">De 1 a 30</th>
                                <th style="width: 100px; background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">De 31 a 60</th>
                                <th style="width: 100px; background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">De 61 a 90</th>
                                <th style="width: 100px; background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">De 91 a 120</th>
                                <th style="width: 100px; background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">+ 120</th>
                                <th style="width: 120px; background-color: #6B8ACE !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;">Total</th>
                            </tr>
                            
                            <!-- Tercera fila de encabezado - subtítulos -->
                            <tr style="background-color: #e9ecef;">
                                <th style="width: 30px; border: 1px solid #dee2e6; padding: 8px 5px; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; background-color: #6B8ACE !important; color: white;"></th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; text-align: center; background-color: #6B8ACE !important; color: white;">Fecha</th>
                                <th style="border: 1px solid #dee2e6; padding: 8px 5px; text-align: center; background-color: #6B8ACE !important; color: white;">Fecha Vencimiento</th>
                                <th style="background-color: #32cd32 !important; color: #000; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;" colspan="1">Días por Vencer</th>
                                <th style="background-color: #ff0000 !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;" colspan="5">Días de Vencido</th>
                                <th style="background-color: #6B8ACE !important; color: white; border: 1px solid #dee2e6; padding: 8px 5px; text-align: center;"></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <!-- Maquiladora Industrial -->
                            <tr class="parent-row" data-cliente="38" style="background-color: #f8f9fa; font-weight: 500; cursor: pointer;">
                                <td style="text-align: center; border: 1px solid #dee2e6; padding: 6px 4px;">
                                    <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">Maquiladora Industrial</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">56,952.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px; font-weight: bold;">56,952.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-25</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">19/06/2024</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">19/07/2024</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">34,160.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">34,160.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-118</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">26/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">25/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-117</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">25/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">24/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-111</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">11/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">10/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-108</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">06/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">05/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">5,632.00</td>
                            </tr>
                            <tr class="child-row" data-parent="38" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-107</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">05/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">04/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">264.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">264.00</td>
                            </tr>

                            <!-- Cartones del Norte Demo -->
                            <tr class="parent-row" data-cliente="42" style="background-color: #f8f9fa; font-weight: 500; cursor: pointer;">
                                <td style="text-align: center; border: 1px solid #dee2e6; padding: 6px 4px;">
                                    <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">Cartones del Norte Demo</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">20,000.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px; font-weight: bold;">120,800.00</td>
                            </tr>
                            <tr class="child-row" data-parent="42" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-80</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">16/02/2026</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">18/03/2026</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                            </tr>
                            <tr class="child-row" data-parent="42" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-70</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">15/12/2025</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">14/01/2026</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">50,400.00</td>
                            </tr>
                            <tr class="child-row" data-parent="42" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">TCN-8</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">17/10/2025</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">16/11/2025</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">20,000.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">20,000.00</td>
                            </tr>

                            <!-- Farmaceutica Demo -->
                            <tr class="parent-row" data-cliente="43" style="background-color: #f8f9fa; font-weight: 500; cursor: pointer;">
                                <td style="text-align: center; border: 1px solid #dee2e6; padding: 6px 4px;">
                                    <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">Farmaceutica Demo</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">7,920.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px; font-weight: bold;">7,920.00</td>
                            </tr>
                            <tr class="child-row" data-parent="43" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-103</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">02/01/2023</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">01/02/2023</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">7,920.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">7,920.00</td>
                            </tr>

                            <!-- ... resto de clientes con la misma estructura ... -->
                            
                            <!-- Cedis Mty 1 -->
                            <tr class="parent-row" data-cliente="131" style="background-color: #f8f9fa; font-weight: 500; cursor: pointer;">
                                <td style="text-align: center; border: 1px solid #dee2e6; padding: 6px 4px;">
                                    <i class="fas fa-chevron-right toggle-icon" style="color: #083CAE;"></i>
                                </td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">Cedis Mty 1</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">279,000.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px; font-weight: bold;">279,000.00</td>
                            </tr>
                            <tr class="child-row" data-parent="131" style="background-color: #ffffff; display: none;">
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;"><span style="text-decoration: underline; color: #0000ee; cursor: pointer;">A-56</span></td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">30/09/2025</td>
                                <td style="border: 1px solid #dee2e6; padding: 6px 4px;">30/09/2025</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">-</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">279,000.00</td>
                                <td style="text-align: right; border: 1px solid #dee2e6; padding: 6px 4px;">279,000.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .semaforo .card-header {
        background-color: #f4f6f9;
        border-bottom: 2px solid #083CAE;
    }
    
    .custom-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(8, 60, 174, 0.15) !important;
        border-color: #083CAE !important;
    }
    
    #contacto_id {
        border: 1px solid #083CAE;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 14px;
        color: #083CAE;
        background-color: white;
    }
    
    #contacto_id:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(8, 60, 174, 0.1);
    }
    
    .btn-sm {
        font-size: 13px;
        padding: 5px 12px;
        transition: opacity 0.2s;
    }
    
    .btn-sm:hover {
        opacity: 0.9;
    }
    
    .table {
        border-collapse: collapse;
    }
    
    .table th {
        font-weight: 600;
        font-size: 13px;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
    }
    
    .table td {
        padding: 8px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
    
    .table-striped tbody tr:hover {
        background-color: rgba(8, 60, 174, 0.05);
    }
    
    .parent-row {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .parent-row:hover {
        background-color: #e9ecef !important;
    }
    
    .toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    
    .toggle-icon.rotated {
        transform: rotate(90deg);
    }
    
    /* Animación para las filas hijo */
    .child-row {
        transition: all 0.3s ease-out;
    }
    
    .child-row.hiding {
        opacity: 0;
        transform: translateY(-10px);
    }
    
    .child-row.showing {
        animation: slideDown 0.3s ease-out forwards;
    }
    
    @keyframes slideDown {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Asegurarnos que el DOM está completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM completamente cargado');
        
        // Función para expandir/colapsar
        function toggleCliente(element) {
            // Obtener el ID del cliente
            var clienteId = element.getAttribute('data-cliente');
            if (!clienteId) {
                // Si el clic fue en el icono, buscar el padre
                var parentRow = element.closest('.parent-row');
                if (parentRow) {
                    clienteId = parentRow.getAttribute('data-cliente');
                }
            }
            
            if (!clienteId) {
                console.log('No se encontró ID de cliente');
                return;
            }
            
            console.log('Toggle cliente:', clienteId);
            
            // Buscar todas las filas hijo de este cliente
            var childRows = document.querySelectorAll('.child-row[data-parent="' + clienteId + '"]');
            console.log('Filas hijo encontradas:', childRows.length);
            
            // Buscar el icono en la fila padre
            var parentRow = document.querySelector('.parent-row[data-cliente="' + clienteId + '"]');
            var icon = parentRow ? parentRow.querySelector('.toggle-icon') : null;
            
            if (childRows.length === 0) {
                console.log('No hay filas hijo');
                return;
            }
            
            // Verificar si la primera fila hijo está visible
            var firstChild = childRows[0];
            var isVisible = window.getComputedStyle(firstChild).display !== 'none';
            
            if (isVisible) {
                console.log('Ocultando filas');
                // Ocultar con animación
                Array.from(childRows).forEach(function(row, index) {
                    setTimeout(function() {
                        row.classList.add('hiding');
                        setTimeout(function() {
                            row.style.display = 'none';
                            row.classList.remove('hiding');
                        }, 200);
                    }, index * 50);
                });
                
                // Rotar icono
                if (icon) {
                    icon.classList.remove('rotated');
                }
            } else {
                console.log('Mostrando filas');
                // Mostrar con animación
                Array.from(childRows).forEach(function(row) {
                    row.style.display = 'table-row';
                    row.classList.add('showing');
                    
                    setTimeout(function() {
                        row.classList.remove('showing');
                    }, 300);
                });
                
                // Rotar icono
                if (icon) {
                    icon.classList.add('rotated');
                }
            }
        }
        
        // Agregar eventos click a todas las filas padre
        var parentRows = document.querySelectorAll('.parent-row');
        console.log('Filas padre encontradas:', parentRows.length);
        
        parentRows.forEach(function(row) {
            row.addEventListener('click', function(e) {
                // Prevenir si el clic fue en un enlace
                if (e.target.tagName === 'A' || e.target.tagName === 'SPAN') {
                    return;
                }
                toggleCliente(this);
            });
        });
        
        // Agregar eventos click a los iconos
        var icons = document.querySelectorAll('.toggle-icon');
        console.log('Iconos encontrados:', icons.length);
        
        icons.forEach(function(icon) {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                var parentRow = this.closest('.parent-row');
                if (parentRow) {
                    toggleCliente(parentRow);
                }
            });
        });
        
        // Botones de acción
        document.getElementById('buttonRecargar')?.addEventListener('click', function() {
            location.reload();
        });
        
        document.getElementById('buttonExcel')?.addEventListener('click', function() {
            exportTableToExcel('semaforoCXC', 'CuentasPorCobrar');
        });
        
        document.getElementById('buttonVerPDF')?.addEventListener('click', function() {
            alert('Funcionalidad de PDF - En desarrollo');
        });
        
        // Función para exportar a Excel
        function exportTableToExcel(tableId, filename = '') {
            var table = document.getElementById(tableId);
            if (!table) return;
            
            var html = table.outerHTML;
            var url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            
            var link = document.createElement('a');
            link.href = url;
            link.download = filename + '.xls';
            link.click();
        }
        
        // Select cambio de cliente
        document.getElementById('contacto_id')?.addEventListener('change', function() {
            console.log('Cliente seleccionado:', this.value);
        });
    });
</script>
@endsection