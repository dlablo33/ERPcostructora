# 📚 DOCUMENTACIÓN COMPLETA DEL SISTEMA ERP CONSTRUCTORA

**Generado:** 2026-06-24 20:07:54

## 📂 CONTROLADORES Y ACCIONES

### 🗂️ Módulo: General

#### 📄 AuthenticatedSessionController
- **Archivo:** `/app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- **Métodos disponibles:** 12

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `create()` | ninguno | * | Illuminate\View\View |
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `destroy()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 ConfirmablePasswordController
- **Archivo:** `/app/Http/Controllers/Auth/ConfirmablePasswordController.php`
- **Métodos disponibles:** 11

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `show()` | ninguno | * | Illuminate\View\View |
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 EmailVerificationNotificationController
- **Archivo:** `/app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
- **Métodos disponibles:** 10

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 EmailVerificationPromptController
- **Archivo:** `/app/Http/Controllers/Auth/EmailVerificationPromptController.php`
- **Métodos disponibles:** 9

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 NewPasswordController
- **Archivo:** `/app/Http/Controllers/Auth/NewPasswordController.php`
- **Métodos disponibles:** 11

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `create()` | $request | * | Illuminate\View\View |
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 PasswordController
- **Archivo:** `/app/Http/Controllers/Auth/PasswordController.php`
- **Métodos disponibles:** 10

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `update()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 PasswordResetLinkController
- **Archivo:** `/app/Http/Controllers/Auth/PasswordResetLinkController.php`
- **Métodos disponibles:** 11

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `create()` | ninguno | * | Illuminate\View\View |
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 RegisteredUserController
- **Archivo:** `/app/Http/Controllers/Auth/RegisteredUserController.php`
- **Métodos disponibles:** 11

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `create()` | ninguno | * | Illuminate\View\View |
| `store()` | $request | * | Illuminate\Http\RedirectResponse |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 VerifyEmailController
- **Archivo:** `/app/Http/Controllers/Auth/VerifyEmailController.php`
- **Métodos disponibles:** 9

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 CFDIController
- **Archivo:** `/app/Http/Controllers/Facturacion/CFDIController.php`
- **Métodos disponibles:** 14

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `indexView()` | ninguno | * | mixed |
| `getData()` | $request | * | mixed |
| `show()` | $id | * | mixed |
| `pdf()` | $id | * | mixed |
| `xml()` | $id | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 DatosGeneralesController
- **Archivo:** `/app/Http/Controllers/Facturacion/DatosGeneralesController.php`
- **Métodos disponibles:** 14

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | ninguno | Lista todos los registros | mixed |
| `store()` | $request | Guarda un nuevo registro en la base de datos | mixed |
| `show()` | $id | Muestra los detalles de un registro específico | mixed |
| `update()` | $request, $id | Actualiza un registro existente | mixed |
| `destroy()` | $id | Elimina un registro | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 NotaCreditoController
- **Archivo:** `/app/Http/Controllers/Facturacion/NotaCreditoController.php`
- **Métodos disponibles:** 16

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `indexView()` | ninguno | * | mixed |
| `getData()` | $request | * | mixed |
| `create()` | ninguno | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id | * | mixed |
| `pdf()` | $id | * | mixed |
| `destroy()` | $id | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 TimbradoController
- **Archivo:** `/app/Http/Controllers/Facturacion/TimbradoController.php`
- **Métodos disponibles:** 11

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `timbrarCFDI()` | $factura | * | mixed |
| `cancelarCFDI()` | $factura, $motivo | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 AreaController
- **Archivo:** `/app/Http/Controllers/RH/AreaController.php`
- **Métodos disponibles:** 16

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `downloadExcel()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 AsistenciaController
- **Archivo:** `/app/Http/Controllers/RH/AsistenciaController.php`
- **Métodos disponibles:** 22

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `debugEmpleados()` | $request | * | mixed |
| `getEmpleadosACargo()` | $request | * | mixed |
| `storeMasivo()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `registrarEntrada()` | $request | * | mixed |
| `registrarSalida()` | $request, $id | * | mixed |
| `testEmpleados()` | $request | * | mixed |
| `showByDate()` | $fecha | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 CatTipoIncidenciaController
- **Archivo:** `/app/Http/Controllers/RH/CatTipoIncidenciaController.php`
- **Métodos disponibles:** 17

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `getActivos()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `toggleActive()` | $id, $request | * | mixed |
| `getStats()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 IncidenciaController
- **Archivo:** `/app/Http/Controllers/RH/IncidenciaController.php`
- **Métodos disponibles:** 17

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `getDataGrid()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `cambiarEstatus()` | $request, $id | * | mixed |
| `getEstadisticas()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 PlantillaController
- **Archivo:** `/app/Http/Controllers/RH/PlantillaController.php`
- **Métodos disponibles:** 26

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `getAreas()` | $request | * | mixed |
| `getBancos()` | $request | * | mixed |
| `getTiposCuenta()` | $request | * | mixed |
| `getCoordinadores()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `getDataGrid()` | $request | * | mixed |
| `getPuestosByArea()` | $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `downloadExcel()` | $request | * | mixed |
| `subirArchivoDocumento()` | $request, $id | * | mixed |
| `getDocumentos()` | $id | * | mixed |
| `eliminarDocumento()` | $empleadoId, $documentoId | * | mixed |
| `descargarDocumento()` | $empleadoId, $documentoId | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 PuestoController
- **Archivo:** `/app/Http/Controllers/RH/PuestoController.php`
- **Métodos disponibles:** 17

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `getByArea()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `downloadExcel()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 RolController
- **Archivo:** `/app/Http/Controllers/RH/RolController.php`
- **Métodos disponibles:** 18

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `create()` | ninguno | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `edit()` | $rol | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `downloadExcel()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 UserController
- **Archivo:** `/app/Http/Controllers/RH/UserController.php`
- **Métodos disponibles:** 18

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `index()` | $request | * | mixed |
| `getRoles()` | $request | * | mixed |
| `store()` | $request | * | mixed |
| `show()` | $id, $request | * | mixed |
| `update()` | $request, $id | * | mixed |
| `destroy()` | $id, $request | * | mixed |
| `resetPassword()` | $id, $request | * | mixed |
| `exportExcel()` | $request | * | mixed |
| `downloadExcel()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

### 🗂️ Módulo: Facturación

#### 📄 FacturaController
- **Archivo:** `/app/Http/Controllers/Facturacion/FacturaController.php`
- **Métodos disponibles:** 32

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `indexView()` | ninguno | * | mixed |
| `getData()` | $request | * | mixed |
| `getProyectosActivos()` | ninguno | * | mixed |
| `getClientes()` | ninguno | * | mixed |
| `getSeriesActivas()` | ninguno | * | mixed |
| `getSeriesNotaCredito()` | ninguno | * | mixed |
| `getFacturasParaNotaCredito()` | $request | * | mixed |
| `getSiguienteFolio()` | $id | * | mixed |
| `getUsosCFDI()` | ninguno | * | mixed |
| `getFormasPago()` | ninguno | Método getFormasPago del sistema | mixed |
| `getMetodosPago()` | ninguno | Método getMetodosPago del sistema | mixed |
| `store()` | $request | * | mixed |
| `timbrarFactura()` | $request, $id | * | mixed |
| `show()` | $id | * | mixed |
| `pdf()` | $id | * | mixed |
| `downloadXml()` | $id | * | mixed |
| `index()` | $request | Lista todos los registros | mixed |
| `update()` | $request, $id | Actualiza un registro existente | mixed |
| `destroy()` | $id | Elimina un registro | mixed |
| `edit()` | $id | Muestra formulario para editar un registro | mixed |
| `create()` | ninguno | Muestra formulario para crear nuevo registro | mixed |
| `enviarCorreo()` | $id | Método enviarCorreo del sistema | mixed |
| `getFacturasParaPago()` | $request | * | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

#### 📄 ReporteFacturasController
- **Archivo:** `/app/Http/Controllers/Facturacion/ReporteFacturasController.php`
- **Métodos disponibles:** 12

| Método | Parámetros | Descripción | Retorna |
|--------|-----------|-------------|---------|
| `resumenMensual()` | $request | Método resumenMensual del sistema | mixed |
| `facturasPorCliente()` | $request | Método facturasPorCliente del sistema | mixed |
| `facturasPorProyecto()` | $request | Método facturasPorProyecto del sistema | mixed |
| `middleware()` | $middleware, $options | * | mixed |
| `getMiddleware()` | ninguno | * | mixed |
| `callAction()` | $method, $parameters | * | mixed |
| `authorize()` | $ability, $arguments | * | mixed |
| `authorizeForUser()` | $user, $ability, $arguments | * | mixed |
| `authorizeResource()` | $model, $parameter, $options, $request | * | mixed |
| `validateWith()` | $validator, $request | * | mixed |
| `validate()` | $request, $rules, $messages, $attributes | * | mixed |
| `validateWithBag()` | $errorBag, $request, $rules, $messages, $attributes | * | mixed |

## 🎨 VISTAS BLADE

Total de vistas: **187**

### 📁 administracion

- **`cuentasavanzadas.blade.php`**
  - Ruta: `administracion/cuentasavanzadas/cuentasavanzadas.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`cuentasbancarias.blade.php`**
  - Ruta: `administracion/cuentasavanzadas/cuentasbancarias.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`registrocuenta.blade.php`**
  - Ruta: `administracion/cuentasavanzadas/registrocuenta.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`saldos.blade.php`**
  - Ruta: `administracion/cuentascobrar/saldos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`pagos.blade.php`**
  - Ruta: `administracion/cuentaspago/pagos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`bitacora.blade.php`**
  - Ruta: `administracion/facturacion/bitacora.blade.php`
  - ✅ Contiene tablas de datos
- **`cfdi.blade.php`**
  - Ruta: `administracion/facturacion/cfdi.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`comiciones.blade.php`**
  - Ruta: `administracion/facturacion/comiciones.blade.php`
  - ✅ Contiene tablas de datos
- **`contrarecibo.blade.php`**
  - Ruta: `administracion/facturacion/contrarecibo.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`factoraje.blade.php`**
  - Ruta: `administracion/facturacion/factoraje.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`facturacion.blade.php`**
  - Ruta: `administracion/facturacion/facturacion.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`nota.blade.php`**
  - Ruta: `administracion/facturacion/nota.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`ventas.blade.php`**
  - Ruta: `administracion/facturacion/ventas.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`anticipo.blade.php`**
  - Ruta: `administracion/operaciones/anticipo.blade.php`
  - ✅ Contiene tablas de datos
- **`credito.blade.php`**
  - Ruta: `administracion/operaciones/credito.blade.php`
  - ✅ Contiene tablas de datos
- **`prepago.blade.php`**
  - Ruta: `administracion/operaciones/prepago.blade.php`
  - ✅ Contiene tablas de datos
- **`facturacion.blade.php`**
  - Ruta: `administracion/presupuestos/facturacion.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`gastos.blade.php`**
  - Ruta: `administracion/presupuestos/gastos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`mensual.blade.php`**
  - Ruta: `administracion/presupuestos/mensual.blade.php`
  - ✅ Contiene tablas de datos
- **`reasignacion.blade.php`**
  - Ruta: `administracion/presupuestos/reasignacion.blade.php`
  - ✅ Contiene tablas de datos
- **`conciliacion.blade.php`**
  - Ruta: `administracion/tesoreria/conciliacion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`depositos.blade.php`**
  - Ruta: `administracion/tesoreria/depositos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`estadosdecuenta.blade.php`**
  - Ruta: `administracion/tesoreria/estadosdecuenta.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`flujomensual.blade.php`**
  - Ruta: `administracion/tesoreria/flujomensual.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`flujos.blade.php`**
  - Ruta: `administracion/tesoreria/flujos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`pagos.blade.php`**
  - Ruta: `administracion/tesoreria/pagos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`programacion.blade.php`**
  - Ruta: `administracion/tesoreria/programacion.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`transacciones.blade.php`**
  - Ruta: `administracion/tesoreria/transacciones.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`trasferencias.blade.php`**
  - Ruta: `administracion/tesoreria/trasferencias.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX

### 📁 almacen

- **`activos.blade.php`**
  - Ruta: `almacen/catalogo/activos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`almacen.blade.php`**
  - Ruta: `almacen/catalogo/almacen.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`articulos.blade.php`**
  - Ruta: `almacen/catalogo/articulos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`familias.blade.php`**
  - Ruta: `almacen/catalogo/familias.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`inventario.blade.php`**
  - Ruta: `almacen/existencia/inventario.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`reqproyecto.blade.php`**
  - Ruta: `almacen/existencia/reqproyecto.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`vale.blade.php`**
  - Ruta: `almacen/existencia/vale.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`entrada.blade.php`**
  - Ruta: `almacen/movimiento/entrada.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`requisiciones_devoluciones_equipo.blade.php`**
  - Ruta: `almacen/movimiento/requisiciones_devoluciones_equipo.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`traspasos.blade.php`**
  - Ruta: `almacen/movimiento/traspasos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX

### 📁 auth

- **`confirm-password.blade.php`**
  - Ruta: `auth/confirm-password.blade.php`
  - ✅ Contiene formularios
- **`forgot-password.blade.php`**
  - Ruta: `auth/forgot-password.blade.php`
  - ✅ Contiene formularios
- **`login.blade.php`**
  - Ruta: `auth/login.blade.php`
  - ✅ Contiene formularios
- **`register.blade.php`**
  - Ruta: `auth/register.blade.php`
  - ✅ Contiene formularios
- **`reset-password.blade.php`**
  - Ruta: `auth/reset-password.blade.php`
  - ✅ Contiene formularios
- **`verify-email.blade.php`**
  - Ruta: `auth/verify-email.blade.php`
  - ✅ Contiene formularios

### 📁 bi

- **`historial.blade.php`**
  - Ruta: `bi/cobranza/historial.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`proyecciones.blade.php`**
  - Ruta: `bi/cobranza/proyecciones.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`dashboard.blade.php`**
  - Ruta: `bi/dashboard/dashboard.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`finanzas.blade.php`**
  - Ruta: `bi/dashboard/finanzas.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`licitaciones.blade.php`**
  - Ruta: `bi/dashboard/licitaciones.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`facturacion.blade.php`**
  - Ruta: `bi/facturacion/facturacion.blade.php`
  - ✅ Contiene tablas de datos
- **`pendiente.blade.php`**
  - Ruta: `bi/facturacion/pendiente.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`seguimiento.blade.php`**
  - Ruta: `bi/facturacion/seguimiento.blade.php`
  - ✅ Contiene tablas de datos
- **`analisis.blade.php`**
  - Ruta: `bi/ventas/analisis.blade.php`
  - ✅ Contiene tablas de datos
- **`papeline.blade.php`**
  - Ruta: `bi/ventas/papeline.blade.php`
  - ✅ Contiene tablas de datos
- **`propuestas.blade.php`**
  - Ruta: `bi/ventas/propuestas.blade.php`
  - ✅ Contiene tablas de datos

### 📁 components

- **`application-logo.blade.php`**
  - Ruta: `components/application-logo.blade.php`
- **`auth-session-status.blade.php`**
  - Ruta: `components/auth-session-status.blade.php`
- **`danger-button.blade.php`**
  - Ruta: `components/danger-button.blade.php`
- **`dropdown-link.blade.php`**
  - Ruta: `components/dropdown-link.blade.php`
- **`dropdown.blade.php`**
  - Ruta: `components/dropdown.blade.php`
- **`input-error.blade.php`**
  - Ruta: `components/input-error.blade.php`
- **`input-label.blade.php`**
  - Ruta: `components/input-label.blade.php`
- **`modal.blade.php`**
  - Ruta: `components/modal.blade.php`
  - ✅ Tiene modales
- **`nav-link.blade.php`**
  - Ruta: `components/nav-link.blade.php`
- **`primary-button.blade.php`**
  - Ruta: `components/primary-button.blade.php`
- **`responsive-nav-link.blade.php`**
  - Ruta: `components/responsive-nav-link.blade.php`
- **`secondary-button.blade.php`**
  - Ruta: `components/secondary-button.blade.php`
- **`text-input.blade.php`**
  - Ruta: `components/text-input.blade.php`

### 📁 compras

- **`almacen.blade.php`**
  - Ruta: `compras/almacen/almacen.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`autorizacion.blade.php`**
  - Ruta: `compras/compras/autorizacion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`ordenes.blade.php`**
  - Ruta: `compras/compras/ordenes.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`autorizacion.blade.php`**
  - Ruta: `compras/requisicion/autorizacion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`requisicion.blade.php`**
  - Ruta: `compras/requisicion/requisicion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`gestion.blade.php`**
  - Ruta: `compras/subcontratistas/gestion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX

### 📁 config

- **`index.blade.php`**
  - Ruta: `config/index.blade.php`
- **`menuconfig.blade.php`**
  - Ruta: `config/topmenu/menuconfig.blade.php`

### 📁 conta

- **`analisis.blade.php`**
  - Ruta: `conta/analisis/analisis.blade.php`
- **`comparativos.blade.php`**
  - Ruta: `conta/analisis/comparativos.blade.php`
- **`razones.blade.php`**
  - Ruta: `conta/analisis/razones.blade.php`
- **`reportes.blade.php`**
  - Ruta: `conta/analisis/reportes.blade.php`
- **`auxiliar.blade.php`**
  - Ruta: `conta/catalogo/auxiliar.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
- **`centros.blade.php`**
  - Ruta: `conta/catalogo/centros.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
- **`configuracion.blade.php`**
  - Ruta: `conta/catalogo/configuracion.blade.php`
- **`cuentas.blade.php`**
  - Ruta: `conta/catalogo/cuentas.blade.php`
  - ✅ Contiene tablas de datos
- **`amortizacion.blade.php`**
  - Ruta: `conta/cierre/amortizacion.blade.php`
- **`anual.blade.php`**
  - Ruta: `conta/cierre/anual.blade.php`
- **`depreciaciones.blade.php`**
  - Ruta: `conta/cierre/depreciaciones.blade.php`
- **`mensual.blade.php`**
  - Ruta: `conta/cierre/mensual.blade.php`
- **`balance.blade.php`**
  - Ruta: `conta/estados/balance.blade.php`
  - ✅ Contiene tablas de datos
- **`capital.blade.php`**
  - Ruta: `conta/estados/capital.blade.php`
  - ✅ Contiene tablas de datos
- **`comprobacion.blade.php`**
  - Ruta: `conta/estados/comprobacion.blade.php`
  - ✅ Contiene tablas de datos
- **`estados.blade.php`**
  - Ruta: `conta/estados/estados.blade.php`
  - ✅ Contiene tablas de datos
- **`flujo.blade.php`**
  - Ruta: `conta/estados/flujo.blade.php`
  - ✅ Contiene tablas de datos
- **`general.blade.php`**
  - Ruta: `conta/estados/general.blade.php`
- **`liquidacion.blade.php`**
  - Ruta: `conta/estados/liquidacion.blade.php`
- **`unidad.blade.php`**
  - Ruta: `conta/estados/unidad.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`complementos.blade.php`**
  - Ruta: `conta/fiscal/complementos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`contabilidad.blade.php`**
  - Ruta: `conta/fiscal/contabilidad.blade.php`
- **`declaraciones.blade.php`**
  - Ruta: `conta/fiscal/declaraciones.blade.php`
- **`diot.blade.php`**
  - Ruta: `conta/fiscal/diot.blade.php`
  - ✅ Usa AJAX
- **`retenciones.blade.php`**
  - Ruta: `conta/fiscal/retenciones.blade.php`
  - ✅ Usa AJAX
- **`asignacion.blade.php`**
  - Ruta: `conta/porproyecto/asignacion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`cierre.blade.php`**
  - Ruta: `conta/porproyecto/cierre.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`costo.blade.php`**
  - Ruta: `conta/porproyecto/costo.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
- **`gastos.blade.php`**
  - Ruta: `conta/porproyecto/gastos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`rentabilidad.blade.php`**
  - Ruta: `conta/porproyecto/rentabilidad.blade.php`
  - ✅ Contiene tablas de datos
- **`ajustes.blade.php`**
  - Ruta: `conta/registros/ajustes.blade.php`
- **`auxiliar.blade.php`**
  - Ruta: `conta/registros/auxiliar.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
- **`diario.blade.php`**
  - Ruta: `conta/registros/diario.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
- **`libro.blade.php`**
  - Ruta: `conta/registros/libro.blade.php`
  - ✅ Contiene tablas de datos
- **`polizas.blade.php`**
  - Ruta: `conta/registros/polizas.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX

### 📁 home.blade.php

- **`home.blade.php`**
  - Ruta: `home.blade.php`

### 📁 layouts

- **`app.blade.php`**
  - Ruta: `layouts/app.blade.php`
- **`guest.blade.php`**
  - Ruta: `layouts/guest.blade.php`
- **`navigation.blade.php`**
  - Ruta: `layouts/navigation.blade.php`
  - ✅ Contiene formularios
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`navigationrespaldo.blade.php`**
  - Ruta: `layouts/navigationrespaldo.blade.php`
  - ✅ Contiene formularios
  - ✅ Tiene modales
  - ✅ Usa AJAX

### 📁 pdfs

- **`cfdi.blade.php`**
  - Ruta: `pdfs/cfdi.blade.php`
  - ✅ Contiene tablas de datos
- **`factura.blade.php`**
  - Ruta: `pdfs/factura.blade.php`
  - ✅ Contiene tablas de datos

### 📁 profile

- **`edit.blade.php`**
  - Ruta: `profile/edit.blade.php`
- **`delete-user-form.blade.php`**
  - Ruta: `profile/partials/delete-user-form.blade.php`
  - ✅ Contiene formularios
  - ✅ Tiene modales
- **`update-password-form.blade.php`**
  - Ruta: `profile/partials/update-password-form.blade.php`
  - ✅ Contiene formularios
- **`update-profile-information-form.blade.php`**
  - Ruta: `profile/partials/update-profile-information-form.blade.php`
  - ✅ Contiene formularios

### 📁 proyectos

- **`estimaciones.blade.php`**
  - Ruta: `proyectos/avances/estimaciones.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`reportes.blade.php`**
  - Ruta: `proyectos/avances/reportes.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`control.blade.php`**
  - Ruta: `proyectos/control/control.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`desviaciones.blade.php`**
  - Ruta: `proyectos/control/desviaciones.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`directos.blade.php`**
  - Ruta: `proyectos/costos/directos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`indirectos.blade.php`**
  - Ruta: `proyectos/costos/indirectos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`rentabilidad.blade.php`**
  - Ruta: `proyectos/costos/rentabilidad.blade.php`
  - ✅ Contiene tablas de datos
- **`evidencia.blade.php`**
  - Ruta: `proyectos/documentacion/evidencia.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`permisos.blade.php`**
  - Ruta: `proyectos/documentacion/permisos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`planos.blade.php`**
  - Ruta: `proyectos/documentacion/planos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`alta.blade.php`**
  - Ruta: `proyectos/gestion/alta.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`bitacora.blade.php`**
  - Ruta: `proyectos/gestion/bitacora.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`cartera.blade.php`**
  - Ruta: `proyectos/gestion/cartera.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`hitos.blade.php`**
  - Ruta: `proyectos/gestion/hitos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`index.blade.php`**
  - Ruta: `proyectos/index.blade.php`
- **`activas.blade.php`**
  - Ruta: `proyectos/licitacion/activas.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`analisis.blade.php`**
  - Ruta: `proyectos/licitacion/analisis.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`presupuestos.blade.php`**
  - Ruta: `proyectos/licitacion/presupuestos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`asignacion.blade.php`**
  - Ruta: `proyectos/maquinaria/asignacion.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`bitacora.blade.php`**
  - Ruta: `proyectos/maquinaria/bitacora.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`control.blade.php`**
  - Ruta: `proyectos/maquinaria/control.blade.php`
  - ✅ Contiene tablas de datos
- **`mantenimiento.blade.php`**
  - Ruta: `proyectos/maquinaria/mantenimiento.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`asignada.blade.php`**
  - Ruta: `proyectos/personal/asignada.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`flotillas.blade.php`**
  - Ruta: `proyectos/personal/flotillas.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`presupuesto.blade.php`**
  - Ruta: `proyectos/presupuestos/presupuesto.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`presupuestos.blade.php`**
  - Ruta: `proyectos/presupuestos/presupuestos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`real.blade.php`**
  - Ruta: `proyectos/presupuestos/real.blade.php`

### 📁 rh

- **`asistencia.blade.php`**
  - Ruta: `rh/asistencia/asistencia.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`control.blade.php`**
  - Ruta: `rh/asistencia/control.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`incidensias.blade.php`**
  - Ruta: `rh/asistencia/incidensias.blade.php`
- **`justificantes.blade.php`**
  - Ruta: `rh/asistencia/justificantes.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`lista.blade.php`**
  - Ruta: `rh/asistencia/lista.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`areas.blade.php`**
  - Ruta: `rh/catalogos/areas.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`deducciones.blade.php`**
  - Ruta: `rh/catalogos/deducciones.blade.php`
- **`imss.blade.php`**
  - Ruta: `rh/catalogos/imss.blade.php`
  - ✅ Contiene tablas de datos
- **`percepciones.blade.php`**
  - Ruta: `rh/catalogos/percepciones.blade.php`
- **`roles.blade.php`**
  - Ruta: `rh/catalogos/roles.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`turnos.blade.php`**
  - Ruta: `rh/catalogos/turnos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`alta.blade.php`**
  - Ruta: `rh/gestion/alta.blade.php`
- **`expediente.blade.php`**
  - Ruta: `rh/gestion/expediente.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`historial.blade.php`**
  - Ruta: `rh/gestion/historial.blade.php`
- **`plantilla.blade.php`**
  - Ruta: `rh/gestion/plantilla.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`semaforo.blade.php`**
  - Ruta: `rh/gestion/semaforo.blade.php`
  - ✅ Contiene tablas de datos
- **`calculo.blade.php`**
  - Ruta: `rh/nomina/calculo.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`historial.blade.php`**
  - Ruta: `rh/nomina/historial.blade.php`
- **`pagos.blade.php`**
  - Ruta: `rh/nomina/pagos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`tabla.blade.php`**
  - Ruta: `rh/nomina/partials/tabla.blade.php`
- **`recibos.blade.php`**
  - Ruta: `rh/nomina/recibos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`sueldos.blade.php`**
  - Ruta: `rh/nomina/sueldos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`aguinaldo.blade.php`**
  - Ruta: `rh/prestaciones/aguinaldo.blade.php`
- **`descuentos.blade.php`**
  - Ruta: `rh/prestaciones/descuentos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`finequito.blade.php`**
  - Ruta: `rh/prestaciones/finequito.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`prestamos.blade.php`**
  - Ruta: `rh/prestaciones/prestamos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`vacaciones.blade.php`**
  - Ruta: `rh/prestaciones/vacaciones.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`costos.blade.php`**
  - Ruta: `rh/reportes/costos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`imss.blade.php`**
  - Ruta: `rh/reportes/imss.blade.php`
- **`sat.blade.php`**
  - Ruta: `rh/reportes/sat.blade.php`
- **`bitacora.blade.php`**
  - Ruta: `rh/unidades/bitacora.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`carros.blade.php`**
  - Ruta: `rh/unidades/carros.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`flotillas.blade.php`**
  - Ruta: `rh/unidades/flotillas.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`semaforos.blade.php`**
  - Ruta: `rh/unidades/semaforos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales

### 📁 tareas

- **`index.blade.php`**
  - Ruta: `tareas/index.blade.php`
  - ✅ Contiene formularios
  - ✅ Tiene modales

### 📁 welcome.blade.php

- **`welcome.blade.php`**
  - Ruta: `welcome.blade.php`
  - ✅ Contiene formularios

## 🛣️ RUTAS API Y WEB

Total de rutas: **956**

### General

- `[GET|HEAD]` **_dusk/login/{userId}/{guard?}** → `UserController@login`
  - Nombre: `dusk.login`
- `[GET|HEAD]` **_dusk/logout/{guard?}** → `UserController@logout`
  - Nombre: `dusk.logout`
- `[GET|HEAD]` **_dusk/user/{guard?}** → `UserController@user`
  - Nombre: `dusk.user`
- `[GET|HEAD]` **sanctum/csrf-cookie** → `CsrfCookieController@show`
  - Nombre: `sanctum.csrf-cookie`
- `[GET|HEAD]` **_ignition/health-check** → `HealthCheckController`
  - Nombre: `ignition.healthCheck`
- `[POST]` **_ignition/execute-solution** → `ExecuteSolutionController`
  - Nombre: `ignition.executeSolution`
- `[POST]` **_ignition/update-config** → `UpdateConfigController`
  - Nombre: `ignition.updateConfig`
- `[GET|POST|HEAD]` **broadcasting/auth** → `BroadcastController@authenticate`
- `[GET|HEAD]` **api/estado-resultados-periodos** → `EstadoResultadosController@getPeriodos`
- `[GET|HEAD]` **api/estado-resultados-data** → `EstadoResultadosController@getData`
- `[GET|HEAD]` **api/cuentas-bancarias** → `CuentaBancariaController@getData`
- `[POST]` **api/cuentas-bancarias** → `CuentaBancariaController@store`
- `[GET|HEAD]` **api/cuentas-bancarias/{id}** → `CuentaBancariaController@show`
- `[PUT]` **api/cuentas-bancarias/{id}** → `CuentaBancariaController@update`
- `[DELETE]` **api/cuentas-bancarias/{id}** → `CuentaBancariaController@destroy`
- `[GET|HEAD]` **api/movimientos-bancarios** → `MovimientoBancarioController@getDataForEstadosCuenta`
- `[GET|HEAD]` **api/monedas** → `MonedaController@index`
- `[POST]` **api/monedas** → `MonedaController@store`
- `[GET|HEAD]` **api/monedas/{id}** → `MonedaController@show`
- `[PUT]` **api/monedas/{id}** → `MonedaController@update`
- `[DELETE]` **api/monedas/{id}** → `MonedaController@destroy`
- `[GET|HEAD]` **api/monedas-activas** → `MonedaController@getActivas`
- `[GET|HEAD]` **api/bancos** → `BancoController@index`
- `[POST]` **api/bancos** → `BancoController@store`
- `[GET|HEAD]` **api/bancos/{id}** → `BancoController@show`
- `[PUT]` **api/bancos/{id}** → `BancoController@update`
- `[DELETE]` **api/bancos/{id}** → `BancoController@destroy`
- `[GET|HEAD]` **api/bancos-activos** → `BancoController@getActivos`
- `[GET|HEAD]` **api/tipos-ingreso** → `TipoIngresoController@index`
- `[POST]` **api/tipos-ingreso** → `TipoIngresoController@store`
- `[GET|HEAD]` **api/tipos-ingreso/{id}** → `TipoIngresoController@show`
- `[PUT]` **api/tipos-ingreso/{id}** → `TipoIngresoController@update`
- `[DELETE]` **api/tipos-ingreso/{id}** → `TipoIngresoController@destroy`
- `[GET|HEAD]` **api/tipos-ingreso-activos** → `TipoIngresoController@getActivos`
- `[GET|HEAD]` **api/tipos-egreso** → `TipoEgresoController@index`
- `[POST]` **api/tipos-egreso** → `TipoEgresoController@store`
- `[GET|HEAD]` **api/tipos-egreso/{id}** → `TipoEgresoController@show`
- `[PUT]` **api/tipos-egreso/{id}** → `TipoEgresoController@update`
- `[DELETE]` **api/tipos-egreso/{id}** → `TipoEgresoController@destroy`
- `[GET|HEAD]` **api/tipos-egreso-activos** → `TipoEgresoController@getActivos`
- `[GET|HEAD]` **api/metodos-pago** → `MetodoPagoController@index`
- `[POST]` **api/metodos-pago** → `MetodoPagoController@store`
- `[GET|HEAD]` **api/metodos-pago/{id}** → `MetodoPagoController@show`
- `[PUT]` **api/metodos-pago/{id}** → `MetodoPagoController@update`
- `[DELETE]` **api/metodos-pago/{id}** → `MetodoPagoController@destroy`
- `[GET|HEAD]` **api/metodos-pago-activos** → `MetodoPagoController@getActivos`
- `[GET|HEAD]` **api/categorias-gasto** → `CategoriaGastoController@index`
- `[POST]` **api/categorias-gasto** → `CategoriaGastoController@store`
- `[GET|HEAD]` **api/categorias-gasto/{id}** → `CategoriaGastoController@show`
- `[PUT]` **api/categorias-gasto/{id}** → `CategoriaGastoController@update`
- `[DELETE]` **api/categorias-gasto/{id}** → `CategoriaGastoController@destroy`
- `[GET|HEAD]` **api/nomina** → `NominaController@index`
  - Nombre: `api.nomina.index`
- `[POST]` **api/nomina/calcular** → `NominaController@calcular`
  - Nombre: `api.nomina.calcular`
- `[GET|HEAD]` **api/nomina/{id}** → `NominaController@show`
  - Nombre: `api.nomina.show`
- `[PUT]` **api/nomina/{id}/estatus** → `NominaController@actualizarEstatus`
  - Nombre: `api.nomina.actualizar-estatus`
- `[DELETE]` **api/nomina/{id}** → `NominaController@cancelar`
  - Nombre: `api.nomina.cancelar`
- `[GET|HEAD]` **api/nomina/{id}/print** → `NominaController@imprimirRecibo`
  - Nombre: `api.nomina.print`
- `[GET|HEAD]` **api/nomina/{id}/pdf** → `NominaController@generarPDF`
  - Nombre: `api.nomina.pdf`
- `[GET|HEAD]` **api/nomina/resumen** → `NominaController@resumen`
  - Nombre: `api.nomina.resumen`
- `[POST]` **api/nomina/exportar** → `NominaController@exportar`
  - Nombre: `api.nomina.exportar`
- `[GET|HEAD]` **api/movimientos** → `MovimientoBancarioController@index`
- `[POST]` **api/movimientos** → `MovimientoBancarioController@store`
- `[GET|HEAD]` **api/movimientos/{id}** → `MovimientoBancarioController@show`
- `[PUT]` **api/movimientos/{id}** → `MovimientoBancarioController@update`
- `[DELETE]` **api/movimientos/{id}** → `MovimientoBancarioController@destroy`
- `[POST]` **api/movimientos/{id}/aplicar** → `MovimientoBancarioController@aplicar`
- `[POST]` **api/movimientos/{id}/cancelar** → `MovimientoBancarioController@cancelar`
- `[GET|HEAD]` **api/categorias-por-tipo-egreso/{tipoEgresoId}** → `CategoriaGastoController@getPorTipoEgreso`
- `[GET|HEAD]` **api/saldo-cuenta/{cuentaId}** → `MovimientoBancarioController@getSaldoCuenta`
- `[POST]` **api/cuentas-bancarias/{id}/actualizar-saldo** → `CuentaBancariaController@actualizarSaldo`
- `[POST]` **api/cuentas-bancarias/actualizar-todos-saldos** → `CuentaBancariaController@actualizarTodosSaldos`
- `[GET|HEAD]` **api/api/cheques-transferencias** → `ChequeTransferenciaController@getData`
- `[POST]` **api/api/cheques-transferencias** → `ChequeTransferenciaController@store`
- `[GET|HEAD]` **api/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@show`
- `[PUT]` **api/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@update`
- `[DELETE]` **api/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@destroy`
- `[POST]` **api/api/cheques-transferencias/{id}/aplicar** → `ChequeTransferenciaController@aplicar`
- `[GET|HEAD]` **api/cheques-transferencias** → `ChequeTransferenciaController@index`
  - Nombre: `cheques.transferencias`
- `[GET|HEAD]` **profile** → `ProfileController@edit`
  - Nombre: `profile.edit`
- `[PATCH]` **profile** → `ProfileController@update`
  - Nombre: `profile.update`
- `[DELETE]` **profile** → `ProfileController@destroy`
  - Nombre: `profile.destroy`
- `[GET|HEAD]` **estimaciones** → `EstimacionesPartidaController@index`
  - Nombre: `estimaciones.index`
- `[GET|HEAD]` **estimaciones/api/resumen** → `EstimacionesPartidaController@getResumen`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **estimaciones/api/detalle** → `EstimacionesPartidaController@getDetalle`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **estimaciones/api/historial/{partidaId}** → `EstimacionesPartidaController@getHistorialPartida`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **estimaciones/exportar** → `EstimacionesPartidaController@exportarResumen`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **estimaciones/api/{id}** → `EstimacionesPartidaController@show`
  - Nombre: `estimaciones.`
- `[POST]` **estimaciones/api** → `EstimacionesPartidaController@store`
  - Nombre: `estimaciones.`
- `[PUT]` **estimaciones/api/{id}** → `EstimacionesPartidaController@update`
  - Nombre: `estimaciones.`
- `[DELETE]` **estimaciones/api/{id}** → `EstimacionesPartidaController@destroy`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **admin/cuentasporcobrar** → `CuentasPorCobrarController@saldos`
  - Nombre: `admin.saldos`
- `[GET|HEAD]` **admin/cuentasporpagar** → `CuentasPorPagarController@index`
  - Nombre: `admin.pagos`
- `[GET|HEAD]` **admin/conciliacion** → `ConciliacionBancariaController@index`
  - Nombre: `tesoreria.conciliacion`
- `[GET|HEAD]` **admin/api/categorias-por-tipo-egreso/{tipoEgresoId}** → `PagoController@getCategoriasPorTipoEgreso`
- `[GET|HEAD]` **admin/gastosfijos/data** → `GastoFijoController@getData`
- `[POST]` **admin/gastosfijos** → `GastoFijoController@store`
- `[GET|HEAD]` **admin/gastosfijos/{id}** → `GastoFijoController@show`
- `[PUT]` **admin/gastosfijos/{id}** → `GastoFijoController@update`
- `[DELETE]` **admin/gastosfijos/{id}** → `GastoFijoController@destroy`
- `[GET|HEAD]` **admin/conciliacion/movimientos** → `ConciliacionBancariaController@getMovimientosSistema`
  - Nombre: `admin.conciliacion.movimientos`
- `[POST]` **admin/conciliacion/upload** → `ConciliacionBancariaController@uploadExcel`
  - Nombre: `admin.conciliacion.upload`
- `[POST]` **admin/conciliacion/guardar** → `ConciliacionBancariaController@guardarConciliacion`
  - Nombre: `admin.conciliacion.guardar`
- `[GET|HEAD]` **admin/conciliacion/plantilla** → `ConciliacionBancariaController@downloadTemplate`
  - Nombre: `admin.conciliacion.template`
- `[GET|HEAD]` **admin/conciliacion/lista** → `ConciliacionBancariaController@getConciliaciones`
  - Nombre: `admin.conciliacion.lista`
- `[GET|HEAD]` **admin/conciliacion/detalle/{id}** → `ConciliacionBancariaController@getDetalleConciliacion`
  - Nombre: `admin.conciliacion.detalle`
- `[DELETE]` **admin/conciliacion/{id}** → `ConciliacionBancariaController@destroy`
  - Nombre: `admin.conciliacion.delete`
- `[GET|HEAD]` **admin/traspasos** → `TraspasoController@index`
  - Nombre: `traspasos.index`
- `[GET|HEAD]` **admin/api/traspasos** → `TraspasoController@getData`
- `[POST]` **admin/api/traspasos** → `TraspasoController@store`
- `[GET|HEAD]` **admin/api/traspasos/{id}** → `TraspasoController@show`
- `[PUT]` **admin/api/traspasos/{id}** → `TraspasoController@update`
- `[DELETE]` **admin/api/traspasos/{id}** → `TraspasoController@destroy`
- `[POST]` **admin/api/traspasos/{id}/aplicar** → `TraspasoController@aplicar`
- `[GET|HEAD]` **admin/api/traspasos-estadisticas** → `TraspasoController@getEstadisticas`
- `[GET|HEAD]` **admin/api/flujo-dinero** → `FlujoDineroController@getData`
- `[GET|HEAD]` **admin/api/flujo-dinero/semanas** → `FlujoDineroController@getSemanas`
- `[GET|HEAD]` **admin/api/flujo-dinero/exportar-excel** → `FlujoDineroController@exportarExcel`
- `[GET|HEAD]` **admin/flujo-mensual** → `FlujoMensualController@index`
  - Nombre: `tesoreria.flujo_mensual`
- `[GET|HEAD]` **admin/api/flujo-mensual** → `FlujoMensualController@getData`
- `[GET|HEAD]` **admin/api/flujo-mensual/exportar-excel** → `FlujoMensualController@exportarExcel`
- `[GET|HEAD]` **admin/depositos** → `DepositoController@index`
  - Nombre: `depositos.index`
- `[GET|HEAD]` **admin/api/depositos** → `DepositoController@getData`
- `[POST]` **admin/api/depositos** → `DepositoController@store`
- `[GET|HEAD]` **admin/api/depositos/{id}** → `DepositoController@show`
- `[PUT]` **admin/api/depositos/{id}** → `DepositoController@update`
- `[DELETE]` **admin/api/depositos/{id}** → `DepositoController@destroy`
- `[POST]` **admin/api/depositos/{id}/aplicar** → `DepositoController@aplicar`
- `[GET|HEAD]` **admin/api/cheques-transferencias** → `ChequeTransferenciaController@getData`
- `[POST]` **admin/api/cheques-transferencias** → `ChequeTransferenciaController@store`
- `[GET|HEAD]` **admin/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@show`
- `[PUT]` **admin/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@update`
- `[DELETE]` **admin/api/cheques-transferencias/{id}** → `ChequeTransferenciaController@destroy`
- `[POST]` **admin/api/cheques-transferencias/{id}/aplicar** → `ChequeTransferenciaController@aplicar`
- `[GET|HEAD]` **admin/test-datos** → `ChequeTransferenciaController@test`
  - Nombre: `test.datos`
- `[GET|HEAD]` **admin/trasferencia** → `ChequeTransferenciaController@index`
  - Nombre: `tesoreria.trasferencia`
- `[GET|HEAD]` **admin/pagos** → `PagoController@index`
  - Nombre: `pagos.index`
- `[GET|HEAD]` **admin/gastosfijos** → `GastoFijoController@index`
  - Nombre: `presupuestos.gastos`
- `[GET|HEAD]` **admin/programacion** → `ProgramacionPagoController@index`
  - Nombre: `tesoreria.programacion`
- `[GET|HEAD]` **admin/programacion/data** → `ProgramacionPagoController@getData`
- `[POST]` **admin/programacion** → `ProgramacionPagoController@store`
- `[GET|HEAD]` **admin/programacion/{id}** → `ProgramacionPagoController@show`
- `[PUT]` **admin/programacion/{id}** → `ProgramacionPagoController@update`
- `[DELETE]` **admin/programacion/{id}** → `ProgramacionPagoController@destroy`
- `[POST]` **admin/programacion/{id}/pagar** → `ProgramacionPagoController@registrarPago`
- `[GET|HEAD]` **admin/proveedores** → `ProveedorController@index`
  - Nombre: `proveedores.index`
- `[GET|HEAD]` **admin/api/proveedores** → `ProveedorController@getData`
- `[POST]` **admin/api/proveedores** → `ProveedorController@store`
- `[GET|HEAD]` **admin/api/proveedores/{id}** → `ProveedorController@show`
- `[PUT]` **admin/api/proveedores/{id}** → `ProveedorController@update`
- `[DELETE]` **admin/api/proveedores/{id}** → `ProveedorController@destroy`
- `[GET|HEAD]` **admin/api/pagos** → `PagoController@getData`
- `[POST]` **admin/api/pagos** → `PagoController@store`
- `[GET|HEAD]` **admin/api/pagos/{id}** → `PagoController@show`
- `[PUT]` **admin/api/pagos/{id}** → `PagoController@update`
- `[DELETE]` **admin/api/pagos/{id}** → `PagoController@destroy`
- `[POST]` **admin/api/pagos/{id}/aplicar** → `PagoController@aplicar`
- `[GET|HEAD]` **admin/api/pagos-estadisticas** → `PagoController@getEstadisticas`
- `[GET|HEAD]` **conta/flujo** → `FlujoEfectivoController@index`
  - Nombre: `conta.flujo`
- `[GET|HEAD]` **conta/flujo/excel** → `FlujoEfectivoController@exportarExcel`
  - Nombre: `conta.flujo.excel`
- `[GET|HEAD]` **conta/flujo/pdf** → `FlujoEfectivoController@exportarPDF`
  - Nombre: `conta.flujo.pdf`
- `[GET|HEAD]` **conta/unidad** → `EstadoResultadosUnidadController@index`
  - Nombre: `conta.unidad`
- `[GET|HEAD]` **conta/unidad/data** → `EstadoResultadosUnidadController@getData`
  - Nombre: `conta.unidad.data`
- `[GET|HEAD]` **conta/unidad/excel** → `EstadoResultadosUnidadController@exportarExcel`
  - Nombre: `conta.unidad.excel`
- `[GET|HEAD]` **conta/unidad/config** → `EstadoResultadosUnidadController@getConfiguracion`
  - Nombre: `conta.unidad.config`
- `[POST]` **conta/unidad/config/guardar** → `EstadoResultadosUnidadController@guardarConfiguracion`
  - Nombre: `conta.unidad.config.guardar`
- `[POST]` **conta/unidad/concepto/guardar** → `EstadoResultadosUnidadController@guardarConcepto`
  - Nombre: `conta.unidad.concepto.guardar`
- `[DELETE]` **conta/unidad/concepto/{id}** → `EstadoResultadosUnidadController@eliminarConcepto`
  - Nombre: `conta.unidad.concepto.eliminar`
- `[GET|HEAD]` **conta/poliza/data** → `PolizaController@getData`
- `[GET|HEAD]` **conta/poliza/{id}** → `PolizaController@show`
- `[POST]` **conta/poliza** → `PolizaController@store`
- `[PUT]` **conta/poliza/{id}** → `PolizaController@update`
- `[DELETE]` **conta/poliza/{id}** → `PolizaController@destroy`
- `[GET|HEAD]` **conta/poliza/excel** → `PolizaController@exportExcel`
- `[GET|HEAD]` **conta/diariogeneral/data** → `DiarioGeneralController@index`
  - Nombre: `conta.diario.data`
- `[GET|HEAD]` **conta/diariogeneral/exportar-excel** → `DiarioGeneralController@exportarExcel`
  - Nombre: `conta.diario.exportar`
- `[GET|HEAD]` **conta/diariogeneral/movimiento/{id}** → `DiarioGeneralController@show`
  - Nombre: `conta.diario.show`
- `[GET|HEAD]` **conta/diariogeneral/estadisticas** → `DiarioGeneralController@estadisticas`
  - Nombre: `conta.diario.estadisticas`
- `[GET|HEAD]` **conta/estados** → `EstadoResultadosController@index`
  - Nombre: `conta.estados`
- `[GET|HEAD]` **conta/estados/excel** → `EstadoResultadosController@exportarExcel`
  - Nombre: `conta.estados.excel`
- `[GET|HEAD]` **conta/estados/pdf** → `EstadoResultadosController@exportarPdf`
  - Nombre: `conta.estados.pdf`
- `[GET|HEAD]` **conta/balance** → `BalanceGeneralController@index`
  - Nombre: `conta.balance`
- `[GET|HEAD]` **conta/balance/excel** → `BalanceGeneralController@exportarExcel`
  - Nombre: `conta.balance.excel`
- `[GET|HEAD]` **conta/comprobacion** → `BalanzaComprobacionController@index`
  - Nombre: `conta.comprobacion`
- `[GET|HEAD]` **conta/comprobacion/excel** → `BalanzaComprobacionController@exportarExcel`
  - Nombre: `conta.comprobacion.excel`
- `[GET|HEAD]` **conta/complementos** → `ComplementoPagoController@vista`
  - Nombre: `conta.complementos`
- `[GET|HEAD]` **conta/complementos/exportar-excel** → `ComplementoPagoController@exportarExcel`
  - Nombre: `conta.complementos.exportar`
- `[GET|HEAD]` **conta/diot** → `DiotController@vista`
  - Nombre: `conta.diot`
- `[GET|HEAD]` **conta/retenciones** → `RetencionController@vista`
  - Nombre: `conta.retenciones`
- `[GET|HEAD]` **conta/costo** → `CostoObraController@index`
  - Nombre: `conta.costo`
- `[GET|HEAD]` **conta/costoobras** → `CostoObraController@index`
  - Nombre: `conta.costoobras`
- `[GET|HEAD]` **conta/costo/exportar-excel** → `CostoObraController@exportarExcel`
  - Nombre: `conta.costo.exportar`
- `[GET|HEAD]` **conta/costo/programa-suministros** → `CostoObraController@programaSuministros`
  - Nombre: `conta.costo.programa`
- `[GET|HEAD]` **conta/gastos** → `GastoIndirectoController@vista`
  - Nombre: `conta.gastos`
- `[GET|HEAD]` **conta/gastos/exportar-excel** → `GastoIndirectoController@exportarExcel`
  - Nombre: `conta.gastos.exportar`
- `[GET|HEAD]` **conta/cobranza** → `CobranzaController@index`
  - Nombre: `conta.cobranza`
- `[GET|HEAD]` **conta/cobranza/exportar-excel** → `CobranzaController@exportarExcel`
  - Nombre: `conta.cobranza.exportar`
- `[GET|HEAD]` **conta/cobranza/detalle-dia** → `CobranzaController@getDetalleDia`
  - Nombre: `conta.cobranza.detalle`
- `[GET|HEAD]` **api/estado-resultados/construccion/periodos** → `EstadoResultadosConstruccionController@getPeriodos`
- `[GET|HEAD]` **api/estado-resultados/construccion** → `EstadoResultadosConstruccionController@getData`
- `[GET|HEAD]` **rh/plantilla** → `PlantillaController@index`
  - Nombre: `rh.plantilla`
- `[GET|HEAD]` **rh/incidencias** → `IncidenciaController@index`
  - Nombre: `rh.incidencias`
- `[GET|HEAD]` **rh/justificantes** → `JustificacionPermisoController@index`
  - Nombre: `rh.justificantes`
- `[POST]` **rh/justificantes** → `JustificacionPermisoController@store`
  - Nombre: `rh.justificantes.store`
- `[GET|HEAD]` **rh/justificantes/{id}** → `JustificacionPermisoController@show`
  - Nombre: `rh.`
- `[PUT]` **rh/justificantes/{id}** → `JustificacionPermisoController@update`
  - Nombre: `rh.`
- `[DELETE]` **rh/justificantes/{id}** → `JustificacionPermisoController@destroy`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/justificantes/{id}/print** → `JustificacionPermisoController@print`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/justificantes/{id}/justificante** → `JustificacionPermisoController@downloadJustificante`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/lista** → `ListaAsistenciaController@index`
  - Nombre: `rh.lista`
- `[POST]` **rh/lista** → `ListaAsistenciaController@store`
  - Nombre: `rh.`
- `[POST]` **rh/lista/generar** → `ListaAsistenciaController@generarListaDiaria`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/lista/{fecha}** → `ListaAsistenciaController@show`
  - Nombre: `rh.`
- `[PUT]` **rh/lista/detalle/{id}** → `ListaAsistenciaController@updateDetalle`
  - Nombre: `rh.`
- `[DELETE]` **rh/lista/{fecha}** → `ListaAsistenciaController@destroy`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/empleados-lista** → `ListaAsistenciaController@getEmpleados`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/control** → `ControlHorariosController@index`
  - Nombre: `rh.control`
- `[POST]` **rh/control/registrar** → `ControlHorariosController@registrar`
  - Nombre: `rh.`
- `[PUT]` **rh/control/{id}** → `ControlHorariosController@update`
  - Nombre: `rh.`
- `[DELETE]` **rh/control/{id}** → `ControlHorariosController@destroy`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/control/resumen** → `ControlHorariosController@getResumen`
  - Nombre: `rh.`
- `[GET|HEAD]` **rh/nomina/sueldos** → `TablaSueldoController@index`
  - Nombre: `rh.nomina.sueldos.index`
- `[POST]` **rh/nomina/sueldos** → `TablaSueldoController@store`
  - Nombre: `rh.nomina.sueldos.store`
- `[GET|HEAD]` **rh/nomina/sueldos/export** → `TablaSueldoController@export`
  - Nombre: `rh.nomina.sueldos.export`
- `[GET|HEAD]` **rh/nomina/sueldos/{id}** → `TablaSueldoController@show`
  - Nombre: `rh.nomina.sueldos.show`
- `[PUT]` **rh/nomina/sueldos/{id}** → `TablaSueldoController@update`
  - Nombre: `rh.nomina.sueldos.update`
- `[DELETE]` **rh/nomina/sueldos/{id}** → `TablaSueldoController@destroy`
  - Nombre: `rh.nomina.sueldos.destroy`
- `[GET|HEAD]` **rh/finiquito** → `FiniquitoController@index`
  - Nombre: `rh.finiquito.index`
- `[GET|HEAD]` **rh/vacaciones** → `VacacionController@index`
  - Nombre: `rh.vacaciones.index`
- `[GET|HEAD]` **rh/prestamos/export/excel** → `PrestamoController@exportExcel`
  - Nombre: `rh.prestamos.export`
- `[GET|HEAD]` **rh/prestamos** → `PrestamoController@index`
  - Nombre: `rh.prestamos.index`
- `[POST]` **rh/prestamos** → `PrestamoController@store`
  - Nombre: `rh.prestamos.store`
- `[GET|HEAD]` **rh/prestamos/{id}** → `PrestamoController@show`
  - Nombre: `rh.prestamos.show`
- `[PUT]` **rh/prestamos/{id}** → `PrestamoController@update`
  - Nombre: `rh.prestamos.update`
- `[DELETE]` **rh/prestamos/{id}** → `PrestamoController@destroy`
  - Nombre: `rh.prestamos.destroy`
- `[GET|HEAD]` **rh/vacaciones/export/excel** → `VacacionController@exportExcel`
  - Nombre: `rh.vacaciones.export`
- `[POST]` **rh/vacaciones** → `VacacionController@store`
  - Nombre: `rh.vacaciones.store`
- `[GET|HEAD]` **rh/vacaciones/{id}** → `VacacionController@show`
  - Nombre: `rh.vacaciones.show`
- `[PUT]` **rh/vacaciones/{id}** → `VacacionController@update`
  - Nombre: `rh.vacaciones.update`
- `[DELETE]` **rh/vacaciones/{id}** → `VacacionController@destroy`
  - Nombre: `rh.vacaciones.destroy`
- `[GET|HEAD]` **rh/finiquito/export/excel** → `FiniquitoController@exportExcel`
  - Nombre: `rh.finiquito.export`
- `[POST]` **rh/finiquito** → `FiniquitoController@store`
  - Nombre: `rh.finiquito.store`
- `[GET|HEAD]` **rh/finiquito/{id}** → `FiniquitoController@show`
  - Nombre: `rh.finiquito.show`
- `[PUT]` **rh/finiquito/{id}** → `FiniquitoController@update`
  - Nombre: `rh.finiquito.update`
- `[DELETE]` **rh/finiquito/{id}** → `FiniquitoController@destroy`
  - Nombre: `rh.finiquito.destroy`
- `[POST]` **rh/finiquito/{id}/autorizar** → `FiniquitoController@autorizar`
  - Nombre: `rh.finiquito.autorizar`
- `[POST]` **rh/finiquito/{id}/pago** → `FiniquitoController@registrarPago`
  - Nombre: `rh.finiquito.pago`
- `[GET|HEAD]` **rh/areas** → `AreaController@index`
  - Nombre: `rh.areas`
- `[GET|HEAD]` **rh/roles** → `RolController@index`
  - Nombre: `rh.roles`
- `[GET|HEAD]` **rh/tipos-incidencias** → `CatTipoIncidenciaController@index`
  - Nombre: `rh.tipos_incidencias`
- `[GET|HEAD]` **rh/nomina** → `NominaController@indexView`
  - Nombre: `rh.nomina`
- `[GET|HEAD]` **rh/asistencia-api** → `AsistenciaController@index`
  - Nombre: `rh.asistencia.api.`
- `[POST]` **rh/asistencia-api** → `AsistenciaController@store`
  - Nombre: `rh.asistencia.api.`
- `[GET|HEAD]` **rh/asistencia-api/{id}** → `AsistenciaController@show`
  - Nombre: `rh.asistencia.api.`
- `[PUT]` **rh/asistencia-api/{id}** → `AsistenciaController@update`
  - Nombre: `rh.asistencia.api.`
- `[DELETE]` **rh/asistencia-api/{id}** → `AsistenciaController@destroy`
  - Nombre: `rh.asistencia.api.`
- `[POST]` **rh/asistencia-api/entrada** → `AsistenciaController@registrarEntrada`
  - Nombre: `rh.asistencia.api.`
- `[POST]` **rh/asistencia-api/{id}/salida** → `AsistenciaController@registrarSalida`
  - Nombre: `rh.asistencia.api.`
- `[GET|HEAD]` **rh/asistencia-api/exportar-excel** → `AsistenciaController@exportExcel`
  - Nombre: `rh.asistencia.api.export`
- `[GET|HEAD]` **almacen/requisicion** → `RequisicionMaterialController@index`
  - Nombre: `almacen.requisicion`
- `[GET|HEAD]` **almacen/requisiciones-devoluciones-equipo** → `EquipoRequisicionController@index`
  - Nombre: `almacen.requisiciones_devoluciones_equipo`
- `[GET|HEAD]` **almacen/articulos** → `ArticuloController@index`
  - Nombre: `almacen.articulo`
- `[GET|HEAD]` **almacen/familias** → `FamiliaController@index`
  - Nombre: `almacen.familias`
- `[GET|HEAD]` **almacen/activos** → `ActivoController@index`
  - Nombre: `almacen.activos`
- `[GET|HEAD]` **almacen/api/articulos** → `ArticuloController@getArticulos`
  - Nombre: `almacen.api.articulos`
- `[GET|HEAD]` **almacen/api/articulos/{id}** → `ArticuloController@show`
  - Nombre: `almacen.api.articulos.show`
- `[POST]` **almacen/api/articulos** → `ArticuloController@store`
  - Nombre: `almacen.api.articulos.store`
- `[PUT]` **almacen/api/articulos/{id}** → `ArticuloController@update`
  - Nombre: `almacen.api.articulos.update`
- `[DELETE]` **almacen/api/articulos/{id}** → `ArticuloController@destroy`
  - Nombre: `almacen.api.articulos.destroy`
- `[GET|HEAD]` **almacen/api/articulos/exportar** → `ArticuloController@exportar`
  - Nombre: `almacen.api.articulos.exportar`
- `[GET|HEAD]` **almacen/api/subfamilias-por-familia/{familiaId}** → `ArticuloController@getSubfamiliasByFamilia`
  - Nombre: `almacen.api.subfamilias-por-familia`
- `[GET|HEAD]` **almacen/api/familias** → `FamiliaController@getFamilias`
  - Nombre: `almacen.api.familias`
- `[GET|HEAD]` **almacen/api/subfamilias** → `FamiliaController@getSubfamilias`
  - Nombre: `almacen.api.subfamilias`
- `[GET|HEAD]` **almacen/api/familias-select** → `FamiliaController@getFamiliasSelect`
  - Nombre: `almacen.api.familias-select`
- `[POST]` **almacen/api/familias** → `FamiliaController@storeFamilia`
  - Nombre: `almacen.api.familias.store`
- `[PUT]` **almacen/api/familias/{id}** → `FamiliaController@updateFamilia`
  - Nombre: `almacen.api.familias.update`
- `[DELETE]` **almacen/api/familias/{id}** → `FamiliaController@destroyFamilia`
  - Nombre: `almacen.api.familias.destroy`
- `[POST]` **almacen/api/subfamilias** → `FamiliaController@storeSubfamilia`
  - Nombre: `almacen.api.subfamilias.store`
- `[PUT]` **almacen/api/subfamilias/{id}** → `FamiliaController@updateSubfamilia`
  - Nombre: `almacen.api.subfamilias.update`
- `[DELETE]` **almacen/api/subfamilias/{id}** → `FamiliaController@destroySubfamilia`
  - Nombre: `almacen.api.subfamilias.destroy`
- `[GET|HEAD]` **almacen/api/familias/exportar** → `FamiliaController@exportarFamilias`
  - Nombre: `almacen.api.familias.exportar`
- `[GET|HEAD]` **almacen/api/subfamilias/exportar** → `FamiliaController@exportarSubfamilias`
  - Nombre: `almacen.api.subfamilias.exportar`
- `[GET|HEAD]` **almacen/api/activos** → `ActivoController@getActivos`
  - Nombre: `almacen.api.activos`
- `[GET|HEAD]` **almacen/api/activos/{id}** → `ActivoController@show`
  - Nombre: `almacen.api.activos.show`
- `[POST]` **almacen/api/activos** → `ActivoController@store`
  - Nombre: `almacen.api.activos.store`
- `[PUT]` **almacen/api/activos/{id}** → `ActivoController@update`
  - Nombre: `almacen.api.activos.update`
- `[DELETE]` **almacen/api/activos/{id}** → `ActivoController@destroy`
  - Nombre: `almacen.api.activos.destroy`
- `[POST]` **almacen/api/activos/{id}/asignar** → `ActivoController@asignar`
  - Nombre: `almacen.api.activos.asignar`
- `[GET|HEAD]` **almacen/api/activos/disponibles** → `ActivoController@getDisponibles`
  - Nombre: `almacen.api.activos.disponibles`
- `[GET|HEAD]` **almacen/api/activos/exportar** → `ActivoController@exportar`
  - Nombre: `almacen.api.activos.exportar`
- `[GET|HEAD]` **almacen/api/requisiciones-activos** → `RequisicionActivoController@getRequisiciones`
  - Nombre: `almacen.api.requisiciones-activos`
- `[GET|HEAD]` **almacen/api/requisiciones-activos/{id}** → `RequisicionActivoController@show`
  - Nombre: `almacen.api.requisiciones-activos.show`
- `[POST]` **almacen/api/requisiciones-activos** → `RequisicionActivoController@store`
  - Nombre: `almacen.api.requisiciones-activos.store`
- `[POST]` **almacen/api/requisiciones-activos/{id}/autorizar** → `RequisicionActivoController@autorizar`
  - Nombre: `almacen.api.requisiciones-activos.autorizar`
- `[POST]` **almacen/api/requisiciones-activos/{id}/rechazar** → `RequisicionActivoController@rechazar`
  - Nombre: `almacen.api.requisiciones-activos.rechazar`
- `[DELETE]` **almacen/api/requisiciones-activos/{id}** → `RequisicionActivoController@destroy`
  - Nombre: `almacen.api.requisiciones-activos.destroy`
- `[GET|HEAD]` **almacen/api/devoluciones-activos** → `DevolucionActivoController@getDevoluciones`
  - Nombre: `almacen.api.devoluciones-activos`
- `[POST]` **almacen/api/devoluciones-activos/salida** → `DevolucionActivoController@registrarSalida`
  - Nombre: `almacen.api.devoluciones-activos.salida`
- `[POST]` **almacen/api/devoluciones-activos/{id}/devolver** → `DevolucionActivoController@registrarDevolucion`
  - Nombre: `almacen.api.devoluciones-activos.devolver`
- `[GET|HEAD]` **almacen/api/devoluciones-activos/asignaciones-activas** → `DevolucionActivoController@getAsignacionesActivas`
  - Nombre: `almacen.api.devoluciones-activos.asignaciones-activas`
- `[GET|HEAD]` **inventario/api/requisiciones** → `RequisicionMaterialController@getRequisiciones`
  - Nombre: `inventario.api.requisiciones`
- `[GET|HEAD]` **inventario/api/requisiciones/{id}** → `RequisicionMaterialController@show`
  - Nombre: `inventario.api.requisiciones.show`
- `[POST]` **inventario/api/requisiciones** → `RequisicionMaterialController@store`
  - Nombre: `inventario.api.requisiciones.store`
- `[POST]` **inventario/api/requisiciones/{id}/autorizar** → `RequisicionMaterialController@autorizar`
  - Nombre: `inventario.api.requisiciones.autorizar`
- `[POST]` **inventario/api/requisiciones/{id}/rechazar** → `RequisicionMaterialController@rechazar`
  - Nombre: `inventario.api.requisiciones.rechazar`
- `[GET|HEAD]` **inventario/api/requisiciones/{id}/generar-surtido** → `RequisicionMaterialController@generarSurtido`
  - Nombre: `inventario.api.requisiciones.generar-surtido`
- `[POST]` **inventario/api/requisiciones/{id}/ejecutar-surtido** → `RequisicionMaterialController@ejecutarSurtido`
  - Nombre: `inventario.api.requisiciones.ejecutar-surtido`
- `[DELETE]` **inventario/api/requisiciones/{id}** → `RequisicionMaterialController@destroy`
  - Nombre: `inventario.api.requisiciones.destroy`
- `[POST]` **inventario/api/articulos/crear-temporal** → `ArticuloController@crearTemporal`
  - Nombre: `inventario.api.articulos.crear-temporal`
- `[GET|HEAD]` **compras/autorizaciones** → `CotizacionController@autorizacionCotizaciones`
  - Nombre: `compras.autorizaciones`
- `[GET|HEAD]` **compras/proveedores** → `ProveedorController@index`
  - Nombre: `compras.gestion`
- `[GET|HEAD]` **compras/api/proveedores** → `ProveedorController@getData`
  - Nombre: `compras.api.proveedores`
- `[GET|HEAD]` **compras/api/proveedores/{id}** → `ProveedorController@show`
  - Nombre: `compras.api.proveedores.show`
- `[POST]` **compras/api/proveedores** → `ProveedorController@store`
  - Nombre: `compras.api.proveedores.store`
- `[PUT]` **compras/api/proveedores/{id}** → `ProveedorController@update`
  - Nombre: `compras.api.proveedores.update`
- `[DELETE]` **compras/api/proveedores/{id}** → `ProveedorController@destroy`
  - Nombre: `compras.api.proveedores.destroy`
- `[GET|HEAD]` **compras/api/proveedores/exportar** → `ProveedorController@exportar`
  - Nombre: `compras.api.proveedores.exportar`
- `[GET|HEAD]` **compras/requisiciones** → `RequisicionController@index`
  - Nombre: `compras.requisiciones.index`
- `[GET|HEAD]` **compras/requisiciones/generar-folio** → `RequisicionController@generarFolio`
  - Nombre: `compras.requisiciones.generar-folio`
- `[GET|HEAD]` **compras/requisiciones/areas** → `RequisicionController@getAreas`
  - Nombre: `compras.requisiciones.areas`
- `[GET|HEAD]` **compras/requisiciones/{id}** → `RequisicionController@show`
  - Nombre: `compras.requisiciones.show`
- `[POST]` **compras/requisiciones** → `RequisicionController@store`
  - Nombre: `compras.requisiciones.store`
- `[PUT]` **compras/requisiciones/{id}** → `RequisicionController@update`
  - Nombre: `compras.requisiciones.update`
- `[DELETE]` **compras/requisiciones/{id}** → `RequisicionController@destroy`
  - Nombre: `compras.requisiciones.destroy`
- `[POST]` **compras/requisiciones/{id}/aprobar** → `RequisicionController@aprobar`
  - Nombre: `compras.requisiciones.aprobar`
- `[POST]` **compras/requisiciones/{id}/rechazar** → `RequisicionController@rechazar`
  - Nombre: `compras.requisiciones.rechazar`
- `[GET|HEAD]` **compras/requisiciones/exportar/excel** → `RequisicionController@exportar`
  - Nombre: `compras.requisiciones.exportar`
- `[GET|HEAD]` **compras/autorizacion-requisiciones/get-data** → `AutorizacionRequisicionController@getRequisiciones`
  - Nombre: `compras.autorizacion.get-data`
- `[POST]` **compras/autorizacion-requisiciones/{id}/autorizar** → `AutorizacionRequisicionController@autorizar`
  - Nombre: `compras.autorizacion.autorizar`
- `[POST]` **compras/autorizacion-requisiciones/{id}/rechazar** → `AutorizacionRequisicionController@rechazar`
  - Nombre: `compras.autorizacion.rechazar`
- `[POST]` **compras/autorizacion-requisiciones/{id}/revertir** → `AutorizacionRequisicionController@revertirAutorizacion`
  - Nombre: `compras.autorizacion.revertir`
- `[POST]` **compras/autorizacion-requisiciones/{id}/reabrir** → `AutorizacionRequisicionController@reabrir`
  - Nombre: `compras.autorizacion.reabrir`
- `[GET|HEAD]` **compras/autorizacion-requisiciones/{id}/detalle** → `AutorizacionRequisicionController@detalle`
  - Nombre: `compras.autorizacion.detalle`
- `[GET|HEAD]` **compras/autorizacion-requisiciones/exportar** → `AutorizacionRequisicionController@exportar`
  - Nombre: `compras.autorizacion.exportar`
- `[GET|HEAD]` **compras/ordenes** → `CotizacionController@ordenesPendientes`
  - Nombre: `compras.ordenes`
- `[GET|HEAD]` **compras/autorizacion-cotizaciones** → `CotizacionController@autorizacionCotizaciones`
  - Nombre: `compras.autorizacion-cotizaciones`
- `[GET|HEAD]` **compras/cotizaciones** → `CotizacionController@index`
  - Nombre: `compras.cotizaciones.index`
- `[GET|HEAD]` **compras/cotizaciones/solicitar/{requisicionId}** → `CotizacionController@solicitar`
  - Nombre: `compras.cotizaciones.solicitar`
- `[POST]` **compras/cotizaciones** → `CotizacionController@store`
  - Nombre: `compras.cotizaciones.store`
- `[GET|HEAD]` **compras/cotizaciones/comparativo/{requisicionId}** → `CotizacionController@comparativo`
  - Nombre: `compras.cotizaciones.comparativo`
- `[GET|HEAD]` **compras/cotizaciones/comparativo-json/{requisicionId}** → `CotizacionController@getComparativo`
  - Nombre: `compras.cotizaciones.comparativo-json`
- `[POST]` **compras/cotizaciones/seleccionar/{cotizacionId}** → `CotizacionController@seleccionar`
  - Nombre: `compras.cotizaciones.seleccionar`
- `[GET|HEAD]` **compras/cotizaciones/articulos/{requisicionId}** → `CotizacionController@getArticulos`
  - Nombre: `compras.cotizaciones.get-articulos`
- `[GET|HEAD]` **compras/cotizaciones/requisiciones-para-autorizar** → `CotizacionController@requisicionesParaAutorizar`
  - Nombre: `compras.cotizaciones.requisiciones-para-autorizar`
- `[POST]` **compras/cotizaciones/autorizar-todas/{requisicionId}** → `CotizacionController@autorizarTodasCotizaciones`
  - Nombre: `compras.cotizaciones.autorizar-todas`
- `[GET|HEAD]` **compras/cotizaciones/{id}** → `CotizacionController@show`
  - Nombre: `compras.cotizaciones.show`
- `[GET|HEAD]` **proyectos/hitos** → `HitoController@index`
  - Nombre: `proyectos.hitos`
- `[GET|HEAD]` **proyectos/hitos/data** → `HitoController@getHitos`
  - Nombre: `proyectos.hitos.data`
- `[GET|HEAD]` **proyectos/hitos/estadisticas** → `HitoController@estadisticas`
  - Nombre: `proyectos.hitos.stats`
- `[GET|HEAD]` **proyectos/hitos/{id}** → `HitoController@show`
  - Nombre: `proyectos.hitos.show`
- `[POST]` **proyectos/hitos** → `HitoController@store`
  - Nombre: `proyectos.hitos.store`
- `[PUT]` **proyectos/hitos/{id}** → `HitoController@update`
  - Nombre: `proyectos.hitos.update`
- `[DELETE]` **proyectos/hitos/{id}** → `HitoController@destroy`
  - Nombre: `proyectos.hitos.destroy`
- `[GET|HEAD]` **proyectos/asignacion** → `AsignacionPersonalController@asignada`
  - Nombre: `proyectos.asignada`
- `[GET|HEAD]` **proyectos/personal-asignado** → `AsignacionPersonalController@index`
  - Nombre: `proyectos.personal-asignado.index`
- `[GET|HEAD]` **proyectos/personal-asignado/estadisticas** → `AsignacionPersonalController@estadisticas`
  - Nombre: `proyectos.personal-asignado.estadisticas`
- `[GET|HEAD]` **proyectos/personal-asignado/exportar** → `AsignacionPersonalController@exportar`
  - Nombre: `proyectos.personal-asignado.exportar`
- `[GET|HEAD]` **proyectos/personal-asignado/{id}** → `AsignacionPersonalController@show`
  - Nombre: `proyectos.personal-asignado.show`
- `[GET|HEAD]` **proyectos/personal-asignado/catalogos/empleados** → `AsignacionPersonalController@empleados`
  - Nombre: `proyectos.personal-asignado.catalogos.empleados`
- `[GET|HEAD]` **proyectos/personal-asignado/catalogos/puestos** → `AsignacionPersonalController@puestos`
  - Nombre: `proyectos.personal-asignado.catalogos.puestos`
- `[POST]` **proyectos/personal-asignado** → `AsignacionPersonalController@store`
  - Nombre: `proyectos.personal-asignado.store`
- `[PUT]` **proyectos/personal-asignado/{id}** → `AsignacionPersonalController@update`
  - Nombre: `proyectos.personal-asignado.update`
- `[DELETE]` **proyectos/personal-asignado/{id}** → `AsignacionPersonalController@destroy`
  - Nombre: `proyectos.personal-asignado.destroy`
- `[POST]` **proyectos/personal-asignado/{id}/reasignar** → `AsignacionPersonalController@reasignar`
  - Nombre: `proyectos.personal-asignado.reasignar`
- `[GET|HEAD]` **proyectos/flotillas** → `AsistenciaCuadrillaController@flotillas`
  - Nombre: `proyectos.flotillas`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/asistencias** → `AsistenciaCuadrillaController@indexAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.index`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/asistencias/{id}** → `AsistenciaCuadrillaController@showAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.show`
- `[POST]` **proyectos/asistencia-cuadrillas/asistencias** → `AsistenciaCuadrillaController@storeAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.store`
- `[PUT]` **proyectos/asistencia-cuadrillas/asistencias/{id}** → `AsistenciaCuadrillaController@updateAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.update`
- `[POST]` **proyectos/asistencia-cuadrillas/asistencias/tomar** → `AsistenciaCuadrillaController@tomarAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.tomar`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/asistencias/exportar** → `AsistenciaCuadrillaController@exportarAsistencia`
  - Nombre: `proyectos.asistencia-cuadrillas.asistencias.exportar`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/cuadrillas** → `AsistenciaCuadrillaController@indexCuadrillas`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.index`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/cuadrillas/{id}** → `AsistenciaCuadrillaController@showCuadrilla`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.show`
- `[POST]` **proyectos/asistencia-cuadrillas/cuadrillas** → `AsistenciaCuadrillaController@storeCuadrilla`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.store`
- `[PUT]` **proyectos/asistencia-cuadrillas/cuadrillas/{id}** → `AsistenciaCuadrillaController@updateCuadrilla`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.update`
- `[DELETE]` **proyectos/asistencia-cuadrillas/cuadrillas/{id}** → `AsistenciaCuadrillaController@destroyCuadrilla`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.destroy`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/cuadrillas/{id}/personal** → `AsistenciaCuadrillaController@personalPorCuadrilla`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.personal`
- `[POST]` **proyectos/asistencia-cuadrillas/cuadrillas/asignar** → `AsistenciaCuadrillaController@asignarEmpleado`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.asignar`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/cuadrillas/asignaciones** → `AsistenciaCuadrillaController@getAsignaciones`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.asignaciones`
- `[DELETE]` **proyectos/asistencia-cuadrillas/cuadrillas/asignaciones/{empleadoId}** → `AsistenciaCuadrillaController@removerAsignacion`
  - Nombre: `proyectos.asistencia-cuadrillas.cuadrillas.asignaciones.remover`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/estadisticas** → `AsistenciaCuadrillaController@estadisticas`
  - Nombre: `proyectos.asistencia-cuadrillas.estadisticas`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/reporte-mensual** → `AsistenciaCuadrillaController@reporteMensual`
  - Nombre: `proyectos.asistencia-cuadrillas.reporte-mensual`
- `[GET|HEAD]` **proyectos/asistencia-cuadrillas/catalogos** → `AsistenciaCuadrillaController@catalogos`
  - Nombre: `proyectos.asistencia-cuadrillas.catalogos`
- `[GET|HEAD]` **proyectos/maquinas** → `MaquinariaController@maquinas`
  - Nombre: `proyectos.asignacion`
- `[GET|HEAD]` **proyectos/maquinaria/catalogos** → `MaquinariaController@catalogos`
  - Nombre: `proyectos.maquinaria.catalogos`
- `[GET|HEAD]` **proyectos/maquinaria/estadisticas** → `MaquinariaController@estadisticas`
  - Nombre: `proyectos.maquinaria.estadisticas`
- `[GET|HEAD]` **proyectos/maquinaria/exportar** → `MaquinariaController@exportar`
  - Nombre: `proyectos.maquinaria.exportar`
- `[GET|HEAD]` **proyectos/maquinaria/asignaciones/activas** → `MaquinariaController@asignacionesActivas`
  - Nombre: `proyectos.maquinaria.asignaciones.activas`
- `[POST]` **proyectos/maquinaria/asignar** → `MaquinariaController@asignar`
  - Nombre: `proyectos.maquinaria.asignar`
- `[POST]` **proyectos/maquinaria/mantenimientos** → `MaquinariaController@registrarMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimientos.store`
- `[POST]` **proyectos/maquinaria/combustible/consumo** → `MaquinariaController@registrarConsumo`
  - Nombre: `proyectos.maquinaria.combustible.consumo`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimientos/list** → `MaquinariaController@getMantenimientos`
  - Nombre: `proyectos.maquinaria.mantenimientos.list`
- `[GET|HEAD]` **proyectos/maquinaria/combustible/historial** → `MaquinariaController@historialCombustible`
  - Nombre: `proyectos.maquinaria.combustible.historial`
- `[GET|HEAD]` **proyectos/maquinaria/combustible/estadisticas** → `MaquinariaController@estadisticasCombustible`
  - Nombre: `proyectos.maquinaria.combustible.estadisticas`
- `[POST]` **proyectos/maquinaria/{id}/devolver** → `MaquinariaController@devolver`
  - Nombre: `proyectos.maquinaria.devolver`
- `[GET|HEAD]` **proyectos/maquinaria/{activoId}/mantenimientos** → `MaquinariaController@mantenimientos`
  - Nombre: `proyectos.maquinaria.mantenimientos.index`
- `[GET|HEAD]` **proyectos/maquinaria/{activoId}/combustible** → `MaquinariaController@combustible`
  - Nombre: `proyectos.maquinaria.combustible.index`
- `[GET|HEAD]` **proyectos/maquinaria** → `MaquinariaController@index`
  - Nombre: `proyectos.maquinaria.index`
- `[POST]` **proyectos/maquinaria** → `MaquinariaController@store`
  - Nombre: `proyectos.maquinaria.store`
- `[GET|HEAD]` **proyectos/maquinaria/{id}** → `MaquinariaController@show`
  - Nombre: `proyectos.maquinaria.show`
- `[PUT]` **proyectos/maquinaria/{id}** → `MaquinariaController@update`
  - Nombre: `proyectos.maquinaria.update`
- `[DELETE]` **proyectos/maquinaria/{id}** → `MaquinariaController@destroy`
  - Nombre: `proyectos.maquinaria.destroy`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/estadisticas** → `MaquinariaController@getEstadisticasMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.estadisticas`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/list** → `MaquinariaController@getListadoMantenimientos`
  - Nombre: `proyectos.maquinaria.mantenimiento.list`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/activos** → `MaquinariaController@getMantenimientosActivos`
  - Nombre: `proyectos.maquinaria.mantenimiento.activos`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/programados** → `MaquinariaController@getMantenimientosProgramados`
  - Nombre: `proyectos.maquinaria.mantenimiento.programados`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/historial** → `MaquinariaController@getHistorialMantenimientos`
  - Nombre: `proyectos.maquinaria.mantenimiento.historial`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/costos** → `MaquinariaController@getCostosMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.costos`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/alertas** → `MaquinariaController@getAlertasMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.alertas`
- `[POST]` **proyectos/maquinaria/mantenimiento/registrar** → `MaquinariaController@storeMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.registrar`
- `[POST]` **proyectos/maquinaria/mantenimiento/{id}/completar** → `MaquinariaController@completarMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.completar`
- `[POST]` **proyectos/maquinaria/mantenimiento/{id}/iniciar** → `MaquinariaController@iniciarMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.iniciar`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/{id}** → `MaquinariaController@getDetalleMantenimiento`
  - Nombre: `proyectos.maquinaria.mantenimiento.detalle`
- `[GET|HEAD]` **proyectos/maquinaria/mantenimiento/exportar/excel** → `MaquinariaController@exportarMantenimientosExcel`
  - Nombre: `proyectos.maquinaria.mantenimiento.exportar.excel`
- `[GET|HEAD]` **proyectos/planos** → `DocumentosController@index`
  - Nombre: `proyectos.planos`
- `[GET|HEAD]` **proyectos/documentos-api/resumen** → `DocumentosController@resumen`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/contratos** → `DocumentosController@contratos`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/contrato/{id}** → `DocumentosController@contratoDetalle`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/documentos-api/contrato** → `DocumentosController@storeContrato`
  - Nombre: `proyectos.`
- `[PUT]` **proyectos/documentos-api/contrato/{id}** → `DocumentosController@updateContrato`
  - Nombre: `proyectos.`
- `[DELETE]` **proyectos/documentos-api/contrato/{id}** → `DocumentosController@deleteContrato`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/planos** → `DocumentosController@planos`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/plano/{id}** → `DocumentosController@planoDetalle`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/documentos-api/plano** → `DocumentosController@storePlano`
  - Nombre: `proyectos.`
- `[PUT]` **proyectos/documentos-api/plano/{id}** → `DocumentosController@updatePlano`
  - Nombre: `proyectos.`
- `[DELETE]` **proyectos/documentos-api/plano/{id}** → `DocumentosController@deletePlano`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/versiones** → `DocumentosController@historialVersiones`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/version/{id}/descargar** → `DocumentosController@descargarVersion`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/descargar/{id}** → `DocumentosController@descargarDocumento`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/exportar/excel** → `DocumentosController@exportarExcel`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/documentos-api/reporte/pdf** → `DocumentosController@reportePdf`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencia** → `EvidenciaController@index`
  - Nombre: `proyectos.evidencia`
- `[GET|HEAD]` **proyectos/evidencias-api/resumen** → `EvidenciaController@resumen`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/listar** → `EvidenciaController@listar`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/galeria** → `EvidenciaController@galeria`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/{id}** → `EvidenciaController@detalle`
  - Nombre: `proyectos.`
- `[DELETE]` **proyectos/evidencias-api/{id}** → `EvidenciaController@eliminar`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/descargar/{id}** → `EvidenciaController@descargar`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/categorias** → `EvidenciaController@categorias`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/evidencias-api/exportar/excel** → `EvidenciaController@exportarExcel`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/activas** → `LicitacionController@activas`
  - Nombre: `proyectos.activas`
- `[GET|HEAD]` **proyectos/licitaciones** → `LicitacionController@index`
  - Nombre: `proyectos.licitaciones.index`
- `[GET|HEAD]` **proyectos/licitaciones/clientes** → `LicitacionController@clientes`
  - Nombre: `proyectos.licitaciones.clientes`
- `[GET|HEAD]` **proyectos/licitaciones/responsables** → `LicitacionController@responsables`
  - Nombre: `proyectos.licitaciones.responsables`
- `[GET|HEAD]` **proyectos/licitaciones/estadisticas** → `LicitacionController@estadisticas`
  - Nombre: `proyectos.licitaciones.estadisticas`
- `[GET|HEAD]` **proyectos/licitaciones/exportar** → `LicitacionController@exportar`
  - Nombre: `proyectos.licitaciones.exportar`
- `[GET|HEAD]` **proyectos/licitaciones/{id}** → `LicitacionController@show`
  - Nombre: `proyectos.licitaciones.show`
- `[POST]` **proyectos/licitaciones** → `LicitacionController@store`
  - Nombre: `proyectos.licitaciones.store`
- `[PUT]` **proyectos/licitaciones/{id}** → `LicitacionController@update`
  - Nombre: `proyectos.licitaciones.update`
- `[DELETE]` **proyectos/licitaciones/{id}** → `LicitacionController@destroy`
  - Nombre: `proyectos.licitaciones.destroy`
- `[POST]` **proyectos/licitaciones/{id}/participar** → `LicitacionController@participar`
  - Nombre: `proyectos.licitaciones.participar`
- `[DELETE]` **proyectos/licitaciones/{id}/documentos/{index}** → `LicitacionController@eliminarDocumento`
  - Nombre: `proyectos.licitaciones.documentos.destroy`
- `[GET|HEAD]` **proyectos/analisis** → `APUController@analisis`
  - Nombre: `proyectos.analisis`
- `[GET|HEAD]` **proyectos/apu** → `APUController@index`
  - Nombre: `proyectos.apu.index`
- `[GET|HEAD]` **proyectos/apu/estadisticas** → `APUController@estadisticas`
  - Nombre: `proyectos.apu.estadisticas`
- `[GET|HEAD]` **proyectos/apu/exportar** → `APUController@exportar`
  - Nombre: `proyectos.apu.exportar`
- `[GET|HEAD]` **proyectos/apu/{id}** → `APUController@show`
  - Nombre: `proyectos.apu.show`
- `[GET|HEAD]` **proyectos/apu/catalogos/materiales** → `APUController@materiales`
  - Nombre: `proyectos.apu.catalogos.materiales`
- `[GET|HEAD]` **proyectos/apu/catalogos/maquinaria** → `APUController@maquinaria`
  - Nombre: `proyectos.apu.catalogos.maquinaria`
- `[GET|HEAD]` **proyectos/apu/catalogos/puestos** → `APUController@puestos`
  - Nombre: `proyectos.apu.catalogos.puestos`
- `[GET|HEAD]` **proyectos/apu/catalogos/proveedores** → `APUController@proveedores`
  - Nombre: `proyectos.apu.catalogos.proveedores`
- `[POST]` **proyectos/apu** → `APUController@store`
  - Nombre: `proyectos.apu.store`
- `[PUT]` **proyectos/apu/{id}** → `APUController@update`
  - Nombre: `proyectos.apu.update`
- `[DELETE]` **proyectos/apu/{id}** → `APUController@destroy`
  - Nombre: `proyectos.apu.destroy`
- `[POST]` **proyectos/apu/{id}/duplicar** → `APUController@duplicar`
  - Nombre: `proyectos.apu.duplicar`
- `[GET|HEAD]` **proyectos/indirectos** → `CostoIndirectoController@indirectos`
  - Nombre: `proyectos.indirectos`
- `[GET|HEAD]` **proyectos/costos-indirectos** → `CostoIndirectoController@index`
  - Nombre: `proyectos.costos-indirectos.index`
- `[GET|HEAD]` **proyectos/costos-indirectos/estadisticas** → `CostoIndirectoController@estadisticas`
  - Nombre: `proyectos.costos-indirectos.estadisticas`
- `[GET|HEAD]` **proyectos/costos-indirectos/exportar** → `CostoIndirectoController@exportar`
  - Nombre: `proyectos.costos-indirectos.exportar`
- `[GET|HEAD]` **proyectos/costos-indirectos/{id}** → `CostoIndirectoController@show`
  - Nombre: `proyectos.costos-indirectos.show`
- `[GET|HEAD]` **proyectos/costos-indirectos/catalogos/proveedores** → `CostoIndirectoController@proveedores`
  - Nombre: `proyectos.costos-indirectos.catalogos.proveedores`
- `[POST]` **proyectos/costos-indirectos** → `CostoIndirectoController@store`
  - Nombre: `proyectos.costos-indirectos.store`
- `[PUT]` **proyectos/costos-indirectos/{id}** → `CostoIndirectoController@update`
  - Nombre: `proyectos.costos-indirectos.update`
- `[DELETE]` **proyectos/costos-indirectos/{id}** → `CostoIndirectoController@destroy`
  - Nombre: `proyectos.costos-indirectos.destroy`
- `[DELETE]` **proyectos/costos-indirectos/{id}/documentos/{documentoId}** → `CostoIndirectoController@eliminarDocumento`
  - Nombre: `proyectos.costos-indirectos.documentos.eliminar`
- `[GET|HEAD]` **proyectos/costos-indirectos/{id}/documentos/{documentoId}/descargar** → `CostoIndirectoController@descargarDocumento`
  - Nombre: `proyectos.costos-indirectos.documentos.descargar`
- `[GET|HEAD]` **proyectos/directos** → `CostoDirectoController@directos`
  - Nombre: `proyectos.directos`
- `[GET|HEAD]` **proyectos/costos-directos** → `CostoDirectoController@index`
  - Nombre: `proyectos.costos-directos.index`
- `[GET|HEAD]` **proyectos/costos-directos/estadisticas** → `CostoDirectoController@estadisticas`
  - Nombre: `proyectos.costos-directos.estadisticas`
- `[GET|HEAD]` **proyectos/costos-directos/exportar** → `CostoDirectoController@exportar`
  - Nombre: `proyectos.costos-directos.exportar`
- `[GET|HEAD]` **proyectos/costos-directos/{id}** → `CostoDirectoController@show`
  - Nombre: `proyectos.costos-directos.show`
- `[GET|HEAD]` **proyectos/costos-directos/catalogos/proveedores** → `CostoDirectoController@proveedores`
  - Nombre: `proyectos.costos-directos.catalogos.proveedores`
- `[GET|HEAD]` **proyectos/costos-directos/catalogos/empleados** → `CostoDirectoController@empleados`
  - Nombre: `proyectos.costos-directos.catalogos.empleados`
- `[POST]` **proyectos/costos-directos** → `CostoDirectoController@store`
  - Nombre: `proyectos.costos-directos.store`
- `[PUT]` **proyectos/costos-directos/{id}** → `CostoDirectoController@update`
  - Nombre: `proyectos.costos-directos.update`
- `[DELETE]` **proyectos/costos-directos/{id}** → `CostoDirectoController@destroy`
  - Nombre: `proyectos.costos-directos.destroy`
- `[DELETE]` **proyectos/costos-directos/{id}/documentos/{documentoId}** → `CostoDirectoController@eliminarDocumento`
  - Nombre: `proyectos.costos-directos.documentos.eliminar`
- `[GET|HEAD]` **proyectos/costos-directos/{id}/documentos/{documentoId}/descargar** → `CostoDirectoController@descargarDocumento`
  - Nombre: `proyectos.costos-directos.documentos.descargar`
- `[GET|HEAD]` **proyectos/reportes** → `ReporteFotograficoController@reportes`
  - Nombre: `proyectos.reportes`
- `[GET|HEAD]` **proyectos/reportes-fotograficos** → `ReporteFotograficoController@index`
  - Nombre: `proyectos.reportes-fotograficos.index`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/estadisticas** → `ReporteFotograficoController@estadisticas`
  - Nombre: `proyectos.reportes-fotograficos.estadisticas`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/exportar** → `ReporteFotograficoController@exportar`
  - Nombre: `proyectos.reportes-fotograficos.exportar`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/{id}** → `ReporteFotograficoController@show`
  - Nombre: `proyectos.reportes-fotograficos.show`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/{id}/descargar** → `ReporteFotograficoController@descargar`
  - Nombre: `proyectos.reportes-fotograficos.descargar`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/catalogos/responsables** → `ReporteFotograficoController@responsables`
  - Nombre: `proyectos.reportes-fotograficos.catalogos.responsables`
- `[POST]` **proyectos/reportes-fotograficos** → `ReporteFotograficoController@store`
  - Nombre: `proyectos.reportes-fotograficos.store`
- `[PUT]` **proyectos/reportes-fotograficos/{id}** → `ReporteFotograficoController@update`
  - Nombre: `proyectos.reportes-fotograficos.update`
- `[DELETE]` **proyectos/reportes-fotograficos/{id}** → `ReporteFotograficoController@destroy`
  - Nombre: `proyectos.reportes-fotograficos.destroy`
- `[POST]` **proyectos/reportes-fotograficos/{id}/archivar** → `ReporteFotograficoController@archivar`
  - Nombre: `proyectos.reportes-fotograficos.archivar`
- `[POST]` **proyectos/reportes-fotograficos/{id}/restaurar** → `ReporteFotograficoController@restaurar`
  - Nombre: `proyectos.reportes-fotograficos.restaurar`
- `[GET|HEAD]` **proyectos/control_proyectos** → `CalidadController@index`
  - Nombre: `proyectos.control`
- `[GET|HEAD]` **proyectos/calidad-api/resumen** → `CalidadController@resumen`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/pruebas** → `CalidadController@pruebas`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/prueba/{noPrueba}** → `CalidadController@pruebaDetalle`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/calidad-api/prueba** → `CalidadController@storePrueba`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/indicadores** → `CalidadController@indicadores`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/no-conformidades** → `CalidadController@noConformidades`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/nc/{noNc}** → `CalidadController@ncDetalle`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/calidad-api/nc** → `CalidadController@storeNC`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/calidad-api/nc/{noNc}/cerrar** → `CalidadController@cerrarNC`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/exportar/excel** → `CalidadController@exportarExcel`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/calidad-api/reporte/pdf** → `CalidadController@reportePdf`
  - Nombre: `proyectos.`
- `[GET|HEAD]` **proyectos/desviaciones** → `DesviacionController@index`
  - Nombre: `proyectos.desviaciones`
- `[GET|HEAD]` **roles** → `RolController@index`
  - Nombre: `roles.index`
- `[GET|HEAD]` **roles/create** → `RolController@create`
  - Nombre: `roles.create`
- `[POST]` **roles** → `RolController@store`
  - Nombre: `roles.store`
- `[GET|HEAD]` **roles/{role}** → `RolController@show`
  - Nombre: `roles.show`
- `[GET|HEAD]` **roles/{role}/edit** → `RolController@edit`
  - Nombre: `roles.edit`
- `[PUT|PATCH]` **roles/{role}** → `RolController@update`
  - Nombre: `roles.update`
- `[DELETE]` **roles/{role}** → `RolController@destroy`
  - Nombre: `roles.destroy`
- `[GET|HEAD]` **puestos** → `PuestoController@index`
  - Nombre: `puestos.index`
- `[GET|HEAD]` **puestos/create** → `PuestoController@create`
  - Nombre: `puestos.create`
- `[POST]` **puestos** → `PuestoController@store`
  - Nombre: `puestos.store`
- `[GET|HEAD]` **puestos/{puesto}** → `PuestoController@show`
  - Nombre: `puestos.show`
- `[GET|HEAD]` **puestos/{puesto}/edit** → `PuestoController@edit`
  - Nombre: `puestos.edit`
- `[PUT|PATCH]` **puestos/{puesto}** → `PuestoController@update`
  - Nombre: `puestos.update`
- `[DELETE]` **puestos/{puesto}** → `PuestoController@destroy`
  - Nombre: `puestos.destroy`
- `[GET|HEAD]` **areas** → `AreaController@index`
  - Nombre: `areas.index`
- `[GET|HEAD]` **areas/create** → `AreaController@create`
  - Nombre: `areas.create`
- `[POST]` **areas** → `AreaController@store`
  - Nombre: `areas.store`
- `[GET|HEAD]` **areas/{area}** → `AreaController@show`
  - Nombre: `areas.show`
- `[GET|HEAD]` **areas/{area}/edit** → `AreaController@edit`
  - Nombre: `areas.edit`
- `[PUT|PATCH]` **areas/{area}** → `AreaController@update`
  - Nombre: `areas.update`
- `[DELETE]` **areas/{area}** → `AreaController@destroy`
  - Nombre: `areas.destroy`
- `[GET|HEAD]` **plantilla** → `PlantillaController@index`
  - Nombre: `plantilla.index`
- `[GET|HEAD]` **plantilla/create** → `PlantillaController@create`
  - Nombre: `plantilla.create`
- `[POST]` **plantilla** → `PlantillaController@store`
  - Nombre: `plantilla.store`
- `[GET|HEAD]` **plantilla/{id}** → `PlantillaController@show`
  - Nombre: `plantilla.show`
- `[GET|HEAD]` **plantilla/{id}/edit** → `PlantillaController@edit`
  - Nombre: `plantilla.edit`
- `[PUT|PATCH]` **plantilla/{id}** → `PlantillaController@update`
  - Nombre: `plantilla.update`
- `[DELETE]` **plantilla/{id}** → `PlantillaController@destroy`
  - Nombre: `plantilla.destroy`
- `[GET|HEAD]` **usuarios** → `UserController@index`
  - Nombre: `usuarios.index`
- `[GET|HEAD]` **usuarios/create** → `UserController@create`
  - Nombre: `usuarios.create`
- `[POST]` **usuarios** → `UserController@store`
  - Nombre: `usuarios.store`
- `[GET|HEAD]` **usuarios/{usuario}** → `UserController@show`
  - Nombre: `usuarios.show`
- `[GET|HEAD]` **usuarios/{usuario}/edit** → `UserController@edit`
  - Nombre: `usuarios.edit`
- `[PUT|PATCH]` **usuarios/{usuario}** → `UserController@update`
  - Nombre: `usuarios.update`
- `[DELETE]` **usuarios/{usuario}** → `UserController@destroy`
  - Nombre: `usuarios.destroy`
- `[POST]` **roles/exportar-excel** → `RolController@exportExcel`
  - Nombre: `roles.export`
- `[POST]` **puestos/exportar-excel** → `PuestoController@exportExcel`
  - Nombre: `puestos.export`
- `[POST]` **areas/exportar-excel** → `AreaController@exportExcel`
  - Nombre: `areas.export`
- `[POST]` **plantilla/exportar-excel** → `PlantillaController@exportExcel`
  - Nombre: `plantilla.export`
- `[POST]` **usuarios/exportar-excel** → `UserController@exportExcel`
  - Nombre: `usuarios.export`
- `[GET|HEAD]` **roles/descargar-excel** → `RolController@downloadExcel`
  - Nombre: `roles.export.download`
- `[GET|HEAD]` **puestos/descargar-excel** → `PuestoController@downloadExcel`
  - Nombre: `puestos.export.download`
- `[GET|HEAD]` **areas/descargar-excel** → `AreaController@downloadExcel`
  - Nombre: `areas.export.download`
- `[GET|HEAD]` **plantilla/descargar-excel** → `PlantillaController@downloadExcel`
  - Nombre: `plantilla.export.download`
- `[GET|HEAD]` **usuarios/download-excel** → `UserController@downloadExcel`
  - Nombre: `usuarios.export.download`
- `[GET|HEAD]` **api/roles** → `RolController@index`
  - Nombre: `roles.index`
- `[POST]` **api/roles** → `RolController@store`
  - Nombre: `roles.store`
- `[GET|HEAD]` **api/roles/{role}** → `RolController@show`
  - Nombre: `roles.show`
- `[PUT|PATCH]` **api/roles/{role}** → `RolController@update`
  - Nombre: `roles.update`
- `[DELETE]` **api/roles/{role}** → `RolController@destroy`
  - Nombre: `roles.destroy`
- `[POST]` **api/roles/exportar-excel** → `RolController@exportExcel`
- `[GET|HEAD]` **api/puestos** → `PuestoController@index`
  - Nombre: `puestos.index`
- `[POST]` **api/puestos** → `PuestoController@store`
  - Nombre: `puestos.store`
- `[GET|HEAD]` **api/puestos/{puesto}** → `PuestoController@show`
  - Nombre: `puestos.show`
- `[PUT|PATCH]` **api/puestos/{puesto}** → `PuestoController@update`
  - Nombre: `puestos.update`
- `[DELETE]` **api/puestos/{puesto}** → `PuestoController@destroy`
  - Nombre: `puestos.destroy`
- `[POST]` **api/puestos/exportar-excel** → `PuestoController@exportExcel`
- `[GET|HEAD]` **api/areas** → `AreaController@index`
  - Nombre: `areas.index`
- `[POST]` **api/areas** → `AreaController@store`
  - Nombre: `areas.store`
- `[GET|HEAD]` **api/areas/{area}** → `AreaController@show`
  - Nombre: `areas.show`
- `[PUT|PATCH]` **api/areas/{area}** → `AreaController@update`
  - Nombre: `areas.update`
- `[DELETE]` **api/areas/{area}** → `AreaController@destroy`
  - Nombre: `areas.destroy`
- `[POST]` **api/areas/exportar-excel** → `AreaController@exportExcel`
- `[GET|HEAD]` **api/usuarios** → `UserController@index`
  - Nombre: `usuarios.index`
- `[POST]` **api/usuarios** → `UserController@store`
  - Nombre: `usuarios.store`
- `[GET|HEAD]` **api/usuarios/{usuario}** → `UserController@show`
  - Nombre: `usuarios.show`
- `[PUT|PATCH]` **api/usuarios/{usuario}** → `UserController@update`
  - Nombre: `usuarios.update`
- `[DELETE]` **api/usuarios/{usuario}** → `UserController@destroy`
  - Nombre: `usuarios.destroy`
- `[POST]` **api/usuarios/exportar-excel** → `UserController@exportExcel`
- `[POST]` **api/usuarios/{id}/reset-password** → `UserController@resetPassword`
- `[GET|HEAD]` **api/roles-activos** → `UserController@getRoles`
- `[GET|HEAD]` **api/plantilla** → `PlantillaController@index`
- `[GET|HEAD]` **api/plantilla/datagrid** → `PlantillaController@getDataGrid`
- `[POST]` **api/plantilla** → `PlantillaController@store`
- `[GET|HEAD]` **api/plantilla/{id}** → `PlantillaController@show`
- `[PUT]` **api/plantilla/{id}** → `PlantillaController@update`
- `[DELETE]` **api/plantilla/{id}** → `PlantillaController@destroy`
- `[POST]` **api/plantilla/exportar-excel** → `PlantillaController@exportExcel`
- `[GET|HEAD]` **api/puestos-por-area** → `PlantillaController@getPuestosByArea`
- `[GET|HEAD]` **api/plantilla/{id}/documentos** → `PlantillaController@getDocumentos`
- `[DELETE]` **api/plantilla/{id}/documentos/{documentoId}** → `PlantillaController@eliminarDocumento`
- `[GET|HEAD]` **api/plantilla/{id}/documentos/{documentoId}/descargar** → `PlantillaController@descargarDocumento`
- `[GET|HEAD]` **api/cat-tipos-incidencias** → `CatTipoIncidenciaController@index`
- `[GET|HEAD]` **api/cat-tipos-incidencias/activos** → `CatTipoIncidenciaController@getActivos`
- `[POST]` **api/cat-tipos-incidencias** → `CatTipoIncidenciaController@store`
- `[GET|HEAD]` **api/cat-tipos-incidencias/{id}** → `CatTipoIncidenciaController@show`
- `[PUT]` **api/cat-tipos-incidencias/{id}** → `CatTipoIncidenciaController@update`
- `[DELETE]` **api/cat-tipos-incidencias/{id}** → `CatTipoIncidenciaController@destroy`
- `[PATCH]` **api/cat-tipos-incidencias/{id}/toggle-active** → `CatTipoIncidenciaController@toggleActive`
- `[GET|HEAD]` **api/cat-tipos-incidencias/stats** → `CatTipoIncidenciaController@getStats`
- `[GET|HEAD]` **api/incidencias** → `IncidenciaController@index`
- `[GET|HEAD]` **api/incidencias/datagrid** → `IncidenciaController@getDataGrid`
- `[POST]` **api/incidencias** → `IncidenciaController@store`
- `[GET|HEAD]` **api/incidencias/{id}** → `IncidenciaController@show`
- `[PUT]` **api/incidencias/{id}** → `IncidenciaController@update`
- `[DELETE]` **api/incidencias/{id}** → `IncidenciaController@destroy`
- `[GET|HEAD]` **api/asistencias/empleados-a-cargo** → `AsistenciaController@getEmpleadosACargo`
- `[POST]` **api/asistencias/masivo** → `AsistenciaController@storeMasivo`
- `[POST]` **api/asistencias/entrada** → `AsistenciaController@registrarEntrada`
- `[POST]` **api/asistencias/exportar-excel** → `AsistenciaController@exportExcel`
- `[GET|HEAD]` **api/asistencias/debug** → `AsistenciaController@debugEmpleados`
- `[GET|HEAD]` **api/asistencias/test-empleados** → `AsistenciaController@testEmpleados`
- `[GET|HEAD]` **api/asistencias** → `AsistenciaController@index`
- `[POST]` **api/asistencias** → `AsistenciaController@store`
- `[GET|HEAD]` **api/asistencias/{id}** → `AsistenciaController@show`
- `[PUT]` **api/asistencias/{id}** → `AsistenciaController@update`
- `[DELETE]` **api/asistencias/{id}** → `AsistenciaController@destroy`
- `[POST]` **api/asistencias/{id}/salida** → `AsistenciaController@registrarSalida`
- `[GET|HEAD]` **api/justificaciones-permisos** → `JustificacionPermisoController@index`
  - Nombre: `justificaciones-permisos.index`
- `[POST]` **api/justificaciones-permisos** → `JustificacionPermisoController@store`
  - Nombre: `justificaciones-permisos.store`
- `[GET|HEAD]` **api/justificaciones-permisos/{justificaciones_permiso}** → `JustificacionPermisoController@show`
  - Nombre: `justificaciones-permisos.show`
- `[PUT|PATCH]` **api/justificaciones-permisos/{justificaciones_permiso}** → `JustificacionPermisoController@update`
  - Nombre: `justificaciones-permisos.update`
- `[DELETE]` **api/justificaciones-permisos/{justificaciones_permiso}** → `JustificacionPermisoController@destroy`
  - Nombre: `justificaciones-permisos.destroy`
- `[GET|HEAD]` **api/justificaciones-permisos/{id}/print** → `JustificacionPermisoController@print`
- `[GET|HEAD]` **api/justificaciones-permisos/{id}/justificante** → `JustificacionPermisoController@downloadJustificante`
- `[GET|HEAD]` **monedas** → `MonedaController@index`
  - Nombre: `monedas.index`
- `[GET|HEAD]` **monedas/create** → `MonedaController@create`
  - Nombre: `monedas.create`
- `[POST]` **monedas** → `MonedaController@store`
  - Nombre: `monedas.store`
- `[GET|HEAD]` **monedas/{id}/edit** → `MonedaController@edit`
  - Nombre: `monedas.edit`
- `[PUT]` **monedas/{id}** → `MonedaController@update`
  - Nombre: `monedas.update`
- `[DELETE]` **monedas/{id}** → `MonedaController@destroy`
  - Nombre: `monedas.destroy`
- `[GET|HEAD]` **bancos** → `BancoController@index`
  - Nombre: `bancos.index`
- `[GET|HEAD]` **bancos/create** → `BancoController@create`
  - Nombre: `bancos.create`
- `[POST]` **bancos** → `BancoController@store`
  - Nombre: `bancos.store`
- `[GET|HEAD]` **bancos/{id}/edit** → `BancoController@edit`
  - Nombre: `bancos.edit`
- `[PUT]` **bancos/{id}** → `BancoController@update`
  - Nombre: `bancos.update`
- `[DELETE]` **bancos/{id}** → `BancoController@destroy`
  - Nombre: `bancos.destroy`
- `[GET|HEAD]` **cuentas-bancarias** → `CuentaBancariaController@index`
  - Nombre: `cuentas.bancarias`
- `[GET|HEAD]` **cuentas-bancarias/create** → `CuentaBancariaController@create`
  - Nombre: `cuentas-bancarias.create`
- `[POST]` **cuentas-bancarias** → `CuentaBancariaController@store`
  - Nombre: `cuentas-bancarias.store`
- `[GET|HEAD]` **cuentas-bancarias/{id}/edit** → `CuentaBancariaController@edit`
  - Nombre: `cuentas-bancarias.edit`
- `[PUT]` **cuentas-bancarias/{id}** → `CuentaBancariaController@update`
  - Nombre: `cuentas-bancarias.update`
- `[DELETE]` **cuentas-bancarias/{id}** → `CuentaBancariaController@destroy`
  - Nombre: `cuentas-bancarias.destroy`
- `[GET|HEAD]` **metodos-pago** → `MetodoPagoController@index`
  - Nombre: `metodos-pago.index`
- `[GET|HEAD]` **metodos-pago/create** → `MetodoPagoController@create`
  - Nombre: `metodos-pago.create`
- `[POST]` **metodos-pago** → `MetodoPagoController@store`
  - Nombre: `metodos-pago.store`
- `[GET|HEAD]` **metodos-pago/{id}/edit** → `MetodoPagoController@edit`
  - Nombre: `metodos-pago.edit`
- `[PUT]` **metodos-pago/{id}** → `MetodoPagoController@update`
  - Nombre: `metodos-pago.update`
- `[DELETE]` **metodos-pago/{id}** → `MetodoPagoController@destroy`
  - Nombre: `metodos-pago.destroy`
- `[GET|HEAD]` **tipos-ingreso** → `TipoIngresoController@index`
  - Nombre: `tipos-ingreso.index`
- `[GET|HEAD]` **tipos-ingreso/create** → `TipoIngresoController@create`
  - Nombre: `tipos-ingreso.create`
- `[POST]` **tipos-ingreso** → `TipoIngresoController@store`
  - Nombre: `tipos-ingreso.store`
- `[GET|HEAD]` **tipos-ingreso/{id}/edit** → `TipoIngresoController@edit`
  - Nombre: `tipos-ingreso.edit`
- `[PUT]` **tipos-ingreso/{id}** → `TipoIngresoController@update`
  - Nombre: `tipos-ingreso.update`
- `[DELETE]` **tipos-ingreso/{id}** → `TipoIngresoController@destroy`
  - Nombre: `tipos-ingreso.destroy`
- `[GET|HEAD]` **tipos-egreso** → `TipoEgresoController@index`
  - Nombre: `tipos-egreso.index`
- `[GET|HEAD]` **tipos-egreso/create** → `TipoEgresoController@create`
  - Nombre: `tipos-egreso.create`
- `[POST]` **tipos-egreso** → `TipoEgresoController@store`
  - Nombre: `tipos-egreso.store`
- `[GET|HEAD]` **tipos-egreso/{id}/edit** → `TipoEgresoController@edit`
  - Nombre: `tipos-egreso.edit`
- `[PUT]` **tipos-egreso/{id}** → `TipoEgresoController@update`
  - Nombre: `tipos-egreso.update`
- `[DELETE]` **tipos-egreso/{id}** → `TipoEgresoController@destroy`
  - Nombre: `tipos-egreso.destroy`
- `[GET|HEAD]` **categorias-gasto** → `CategoriaGastoController@index`
  - Nombre: `categorias-gasto.index`
- `[GET|HEAD]` **categorias-gasto/create** → `CategoriaGastoController@create`
  - Nombre: `categorias-gasto.create`
- `[POST]` **categorias-gasto** → `CategoriaGastoController@store`
  - Nombre: `categorias-gasto.store`
- `[GET|HEAD]` **categorias-gasto/{id}/edit** → `CategoriaGastoController@edit`
  - Nombre: `categorias-gasto.edit`
- `[PUT]` **categorias-gasto/{id}** → `CategoriaGastoController@update`
  - Nombre: `categorias-gasto.update`
- `[DELETE]` **categorias-gasto/{id}** → `CategoriaGastoController@destroy`
  - Nombre: `categorias-gasto.destroy`
- `[GET|HEAD]` **movimientos** → `MovimientoBancarioController@index`
  - Nombre: `movimientos.index`
- `[GET|HEAD]` **movimientos/create** → `MovimientoBancarioController@create`
  - Nombre: `movimientos.create`
- `[POST]` **movimientos** → `MovimientoBancarioController@store`
  - Nombre: `movimientos.store`
- `[GET|HEAD]` **movimientos/{id}** → `MovimientoBancarioController@show`
  - Nombre: `movimientos.show`
- `[GET|HEAD]` **movimientos/{id}/edit** → `MovimientoBancarioController@edit`
  - Nombre: `movimientos.edit`
- `[PUT]` **movimientos/{id}** → `MovimientoBancarioController@update`
  - Nombre: `movimientos.update`
- `[DELETE]` **movimientos/{id}** → `MovimientoBancarioController@destroy`
  - Nombre: `movimientos.destroy`
- `[POST]` **movimientos/{id}/aplicar** → `MovimientoBancarioController@aplicar`
  - Nombre: `movimientos.aplicar`
- `[POST]` **movimientos/{id}/cancelar** → `MovimientoBancarioController@cancelar`
  - Nombre: `movimientos.cancelar`
- `[GET|HEAD]` **movimientos-bancarios-data** → `MovimientoBancarioController@getDataForEstadosCuenta`
- `[GET|HEAD]` **notas-credito** → `NotaCreditoController@indexView`
  - Nombre: `notas-credito.index`
- `[GET|HEAD]` **notas-credito/data** → `NotaCreditoController@getData`
- `[GET|HEAD]` **notas-credito/create-data** → `NotaCreditoController@create`
- `[GET|HEAD]` **notas-credito/{id}** → `NotaCreditoController@show`
- `[GET|HEAD]` **notas-credito/{id}/pdf** → `NotaCreditoController@pdf`
- `[POST]` **api/notas-credito** → `NotaCreditoController@store`
- `[DELETE]` **api/notas-credito/{id}** → `NotaCreditoController@destroy`
- `[GET|HEAD]` **cfdi** → `CFDIController@indexView`
  - Nombre: `cfdi.index`
- `[GET|HEAD]` **cfdi/data** → `CFDIController@getData`
- `[GET|HEAD]` **cfdi/{id}** → `CFDIController@show`
- `[GET|HEAD]` **cfdi/{id}/pdf** → `CFDIController@pdf`
- `[GET|HEAD]` **cfdi/{id}/xml** → `CFDIController@xml`
- `[GET|HEAD]` **ventas** → `VentasController@indexView`
  - Nombre: `ventas.index`
- `[GET|HEAD]` **ventas/data** → `VentasController@getData`
- `[GET|HEAD]` **ventas/{id}** → `VentasController@show`
- `[GET|HEAD]` **contrarecibos** → `ContrareciboController@indexView`
  - Nombre: `contrarecibos.index`
- `[GET|HEAD]` **contrarecibos/data** → `ContrareciboController@getData`
- `[POST]` **contrarecibos** → `ContrareciboController@store`
- `[GET|HEAD]` **contrarecibos/{id}** → `ContrareciboController@show`
- `[DELETE]` **contrarecibos/{id}** → `ContrareciboController@destroy`
- `[GET|HEAD]` **factoraje** → `FactorajeController@indexView`
  - Nombre: `factoraje`
- `[GET|HEAD]` **factoraje/data** → `FactorajeController@getData`
- `[GET|HEAD]` **factoraje/create** → `FactorajeController@create`
- `[GET|HEAD]` **factoraje/factores** → `FactorajeController@getFactores`
- `[GET|HEAD]` **factoraje/solicitud/{id}** → `FactorajeController@show`
- `[POST]` **factoraje/solicitud** → `FactorajeController@store`
- `[PUT]` **factoraje/solicitud/{id}/autorizar** → `FactorajeController@autorizar`
- `[PUT]` **factoraje/solicitud/{id}/rechazar** → `FactorajeController@rechazar`
- `[PUT]` **factoraje/solicitud/{id}/liquidar** → `FactorajeController@liquidar`
- `[DELETE]` **factoraje/solicitud/{id}** → `FactorajeController@destroy`
- `[GET|HEAD]` **factoraje/excel** → `FactorajeController@exportExcel`
- `[GET|HEAD]` **cuentas-por-cobrar** → `CuentasPorCobrarController@index`
  - Nombre: `cuentas-por-cobrar.index`
- `[POST]` **facturas/{factura}/pagos** → `CuentasPorCobrarController@registrarPago`
  - Nombre: `facturas.pagos.registrar`
- `[GET|HEAD]` **cuentas-por-cobrar/exportar** → `CuentasPorCobrarController@exportarExcel`
  - Nombre: `cuentas-por-cobrar.export`
- `[GET|HEAD]` **administracion/cuentaspago/pagos** → `CuentasPorPagarController@index`
  - Nombre: `cuentaspago.pagos`
- `[GET|HEAD]` **administracion/cuentaspago/detalle/{id}** → `CuentasPorPagarController@getDetallePago`
  - Nombre: `cuentaspago.detalle`
- `[GET|HEAD]` **api/gastos-indirectos** → `GastoIndirectoController@index`
  - Nombre: `api.gastos-indirectos.index`
- `[POST]` **api/gastos-indirectos** → `GastoIndirectoController@store`
  - Nombre: `api.gastos-indirectos.store`
- `[GET|HEAD]` **api/gastos-indirectos/{id}** → `GastoIndirectoController@show`
  - Nombre: `api.gastos-indirectos.show`
- `[PUT]` **api/gastos-indirectos/{id}** → `GastoIndirectoController@update`
  - Nombre: `api.gastos-indirectos.update`
- `[DELETE]` **api/gastos-indirectos/{id}** → `GastoIndirectoController@destroy`
  - Nombre: `api.gastos-indirectos.destroy`
- `[GET|HEAD]` **api/gastos-indirectos/kpis** → `GastoIndirectoController@getKPIs`
  - Nombre: `api.gastos-indirectos.kpis`
- `[GET|HEAD]` **api/gastos-indirectos/test** → `GastoIndirectoController@test`
  - Nombre: `api.gastos-indirectos.test`
- `[GET|HEAD]` **api/diot/data** → `DiotController@getData`
  - Nombre: `api.diot.data`
- `[GET|HEAD]` **api/diot/descargar** → `DiotController@descargarTxt`
  - Nombre: `api.diot.descargar`
- `[GET|HEAD]` **api/diot/test** → `DiotController@test`
  - Nombre: `api.diot.test`
- `[GET|HEAD]` **api/complementos-pago/clientes** → `ComplementoPagoController@getClientes`
  - Nombre: `api.complementos-pago.clientes`
- `[GET|HEAD]` **api/complementos-pago/kpis** → `ComplementoPagoController@getKPIs`
  - Nombre: `api.complementos-pago.kpis`
- `[GET|HEAD]` **api/complementos-pago/test** → `ComplementoPagoController@test`
  - Nombre: `api.complementos-pago.test`
- `[GET|HEAD]` **api/complementos-pago** → `ComplementoPagoController@index`
  - Nombre: `api.complementos-pago.index`
- `[POST]` **api/complementos-pago** → `ComplementoPagoController@store`
  - Nombre: `api.complementos-pago.store`
- `[GET|HEAD]` **api/complementos-pago/{id}** → `ComplementoPagoController@show`
  - Nombre: `api.complementos-pago.show`
- `[PUT]` **api/complementos-pago/{id}** → `ComplementoPagoController@update`
  - Nombre: `api.complementos-pago.update`
- `[DELETE]` **api/complementos-pago/{id}** → `ComplementoPagoController@destroy`
  - Nombre: `api.complementos-pago.destroy`
- `[POST]` **api/complementos-pago/{id}/timbrar** → `ComplementoPagoController@timbrar`
  - Nombre: `api.complementos-pago.timbrar`
- `[POST]` **api/complementos-pago/{id}/cancelar** → `ComplementoPagoController@cancelar`
  - Nombre: `api.complementos-pago.cancelar`
- `[GET|HEAD]` **api/retenciones/data** → `RetencionController@getData`
  - Nombre: `api.retenciones.data`
- `[GET|HEAD]` **api/retenciones/exportar** → `RetencionController@exportarExcel`
  - Nombre: `api.retenciones.exportar`
- `[GET|HEAD]` **api/retenciones/test** → `RetencionController@test`
  - Nombre: `api.retenciones.test`
- `[GET|HEAD]` **desviaciones** → `DesviacionController@index`
  - Nombre: `desviaciones`
- `[GET|HEAD]` **desviaciones-api/resumen** → `DesviacionController@resumen`
- `[GET|HEAD]` **desviaciones-api/costos** → `DesviacionController@costos`
- `[GET|HEAD]` **desviaciones-api/tiempos** → `DesviacionController@tiempos`
- `[GET|HEAD]` **desviaciones-api/graficos** → `DesviacionController@graficos`
- `[GET|HEAD]` **desviaciones-api/exportar/excel** → `DesviacionController@exportarExcel`
- `[GET|HEAD]` **desviaciones-api/reporte/pdf** → `DesviacionController@reportePdf`
- `[GET|HEAD]` **register** → `RegisteredUserController@create`
  - Nombre: `register`
- `[POST]` **register** → `RegisteredUserController@store`
- `[GET|HEAD]` **login** → `AuthenticatedSessionController@create`
  - Nombre: `login`
- `[POST]` **login** → `AuthenticatedSessionController@store`
- `[GET|HEAD]` **forgot-password** → `PasswordResetLinkController@create`
  - Nombre: `password.request`
- `[POST]` **forgot-password** → `PasswordResetLinkController@store`
  - Nombre: `password.email`
- `[GET|HEAD]` **reset-password/{token}** → `NewPasswordController@create`
  - Nombre: `password.reset`
- `[POST]` **reset-password** → `NewPasswordController@store`
  - Nombre: `password.store`
- `[GET|HEAD]` **verify-email** → `EmailVerificationPromptController`
  - Nombre: `verification.notice`
- `[GET|HEAD]` **verify-email/{id}/{hash}** → `VerifyEmailController`
  - Nombre: `verification.verify`
- `[POST]` **email/verification-notification** → `EmailVerificationNotificationController@store`
  - Nombre: `verification.send`
- `[GET|HEAD]` **confirm-password** → `ConfirmablePasswordController@show`
  - Nombre: `password.confirm`
- `[POST]` **confirm-password** → `ConfirmablePasswordController@store`
- `[PUT]` **password** → `PasswordController@update`
  - Nombre: `password.update`
- `[POST]` **logout** → `AuthenticatedSessionController@destroy`
  - Nombre: `logout`

### Proyectos

- `[GET|HEAD]` **api/proyectos/{proyecto}/presupuesto** → `PresupuestoProyectoController@getPresupuesto`
- `[GET|HEAD]` **api/proyectos/{proyecto}/partidas** → `PresupuestoProyectoController@getPatidas`
- `[GET|HEAD]` **api/proyectos/{proyecto}/partidas/{partida}** → `PresupuestoProyectoController@getPartida`
- `[POST]` **api/proyectos/{proyecto}/partidas** → `PresupuestoProyectoController@storePartida`
- `[PUT]` **api/proyectos/{proyecto}/partidas/{partida}** → `PresupuestoProyectoController@updatePartida`
- `[DELETE]` **api/proyectos/{proyecto}/partidas/{partida}** → `PresupuestoProyectoController@destroyPartida`
- `[GET|HEAD]` **api/proyectos/{proyecto}/resumen-seccion** → `PresupuestoProyectoController@getResumenPorSeccion`
- `[GET|HEAD]` **api/proyectos/{proyecto}/exportar-excel** → `PresupuestoProyectoController@exportarExcel`
- `[GET|HEAD]` **api/proyectos/{proyecto}/partidas-por-seccion/{seccion}** → `PresupuestoProyectoController@getPartidasPorSeccion`
- `[GET|HEAD]` **estimaciones/api/proyectos** → `EstimacionesPartidaController@getProyectos`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **estimaciones/api/partidas/{proyectoId}** → `EstimacionesPartidaController@getPartidasPorProyecto`
  - Nombre: `estimaciones.`
- `[GET|HEAD]` **conta/centros** → `ProyectoDashboardController@index`
  - Nombre: `conta.centros`
- `[GET|HEAD]` **conta/centros/exportar-excel** → `ProyectoDashboardController@exportarExcel`
  - Nombre: `conta.centros.exportar`
- `[GET|HEAD]` **conta/asignaciones** → `GastoProyectoController@vista`
  - Nombre: `conta.asignacion`
- `[GET|HEAD]` **conta/centro** → `ProyectoDashboardController@index`
  - Nombre: `conta.centro`
- `[GET|HEAD]` **conta/asignaciones/exportar-excel** → `GastoProyectoController@exportarExcel`
  - Nombre: `conta.asignacion.exportar`
- `[GET|HEAD]` **inventario/api/inventario-por-obra** → `InventarioProyectoController@getInventarioPorObra`
  - Nombre: `inventario.api.inventario-por-obra`
- `[GET|HEAD]` **inventario/api/filtros-catalogos** → `InventarioProyectoController@getFiltrosCatalogos`
  - Nombre: `inventario.api.filtros-catalogos`
- `[GET|HEAD]` **inventario/api/inventario** → `InventarioProyectoController@getInventario`
  - Nombre: `inventario.api.inventario`
- `[GET|HEAD]` **inventario/api/inventario/{id}** → `InventarioProyectoController@show`
  - Nombre: `inventario.api.inventario.show`
- `[POST]` **inventario/api/inventario** → `InventarioProyectoController@store`
  - Nombre: `inventario.api.inventario.store`
- `[PUT]` **inventario/api/inventario/{id}** → `InventarioProyectoController@update`
  - Nombre: `inventario.api.inventario.update`
- `[POST]` **inventario/api/inventario/{id}/agregar-stock** → `InventarioProyectoController@agregarStock`
  - Nombre: `inventario.api.inventario.agregar-stock`
- `[POST]` **inventario/api/inventario/{id}/retirar-stock** → `InventarioProyectoController@retirarStock`
  - Nombre: `inventario.api.inventario.retirar-stock`
- `[POST]` **inventario/api/inventario/{id}/transferir-stock** → `InventarioProyectoController@transferirStock`
  - Nombre: `inventario.api.inventario.transferir-stock`
- `[GET|HEAD]` **inventario/api/inventario/resumen/{proyectoId}** → `InventarioProyectoController@getResumenPorProyecto`
  - Nombre: `inventario.api.inventario.resumen`
- `[GET|HEAD]` **inventario/api/inventario/exportar** → `InventarioProyectoController@exportar`
  - Nombre: `inventario.api.inventario.exportar`
- `[GET|HEAD]` **compras/requisiciones/proyectos** → `RequisicionController@getProyectos`
  - Nombre: `compras.requisiciones.proyectos`
- `[GET|HEAD]` **proyectos/cartera** → `ProyectoController@index`
  - Nombre: `proyectos.cartera`
- `[GET|HEAD]` **proyectos/dashboard** → `ProyectoController@dashboard`
  - Nombre: `proyectos.dashboard`
- `[GET|HEAD]` **proyectos/alta** → `ProyectoController@create`
  - Nombre: `proyectos.alta`
- `[GET|HEAD]` **proyectos/create** → `ProyectoController@create`
  - Nombre: `proyectos.create`
- `[POST]` **proyectos** → `ProyectoController@store`
  - Nombre: `proyectos.store`
- `[GET|HEAD]` **proyectos/buscar/cliente** → `ProyectoController@buscarCliente`
  - Nombre: `proyectos.buscar-cliente`
- `[GET|HEAD]` **proyectos/personal-asignado/catalogos/proyectos** → `AsignacionPersonalController@proyectos`
  - Nombre: `proyectos.personal-asignado.catalogos.proyectos`
- `[GET|HEAD]` **proyectos/costos-indirectos/catalogos/proyectos** → `CostoIndirectoController@proyectos`
  - Nombre: `proyectos.costos-indirectos.catalogos.proyectos`
- `[GET|HEAD]` **proyectos/costos-directos/catalogos/proyectos** → `CostoDirectoController@proyectos`
  - Nombre: `proyectos.costos-directos.catalogos.proyectos`
- `[GET|HEAD]` **proyectos/reportes-fotograficos/catalogos/proyectos** → `ReporteFotograficoController@proyectos`
  - Nombre: `proyectos.reportes-fotograficos.catalogos.proyectos`
- `[GET|HEAD]` **proyectos/{id}/edit-data** → `ProyectoController@editData`
  - Nombre: `proyectos.edit-data`
- `[GET|HEAD]` **proyectos/{id}/detalle** → `ProyectoController@getDetalle`
  - Nombre: `proyectos.detalle`
- `[GET|HEAD]` **proyectos/{id}/edit** → `ProyectoController@edit`
  - Nombre: `proyectos.edit`
- `[PUT]` **proyectos/{id}** → `ProyectoController@update`
  - Nombre: `proyectos.update`
- `[DELETE]` **proyectos/{id}** → `ProyectoController@destroy`
  - Nombre: `proyectos.destroy`
- `[POST]` **proyectos/{proyecto_id}/documentos** → `ProyectoController@subirDocumento`
  - Nombre: `proyectos.subir-documento`
- `[GET|HEAD]` **proyectos/documentos/{id}/descargar** → `ProyectoController@descargarDocumento`
  - Nombre: `proyectos.descargar-documento`
- `[DELETE]` **proyectos/documentos/{id}** → `ProyectoController@eliminarDocumento`
  - Nombre: `proyectos.eliminar-documento`
- `[GET|HEAD]` **proyectos/{id}** → `ProyectoController@show`
  - Nombre: `proyectos.show`
- `[GET|HEAD]` **api/bitacora/proyectos** → `BitacoraController@getProyectosList`
  - Nombre: `api.bitacora.proyectos`
- `[GET|HEAD]` **api/dashboard/ventas-proyecto** → `DashboardController@getVentasProyecto`
- `[GET|HEAD]` **api/dashboard/nomina-proyectos** → `DashboardController@getNominaProyectos`
- `[GET|HEAD]` **api/proyectos/activos** → `FacturaController@getProyectosActivos`
- `[GET|HEAD]` **api/proyectos/lista** → `PolizaController@getProyectosLista`
- `[GET|HEAD]` **api/gastos-proyecto** → `GastoProyectoController@index`
  - Nombre: `api.gastos-proyecto.index`
- `[POST]` **api/gastos-proyecto** → `GastoProyectoController@store`
  - Nombre: `api.gastos-proyecto.store`
- `[GET|HEAD]` **api/gastos-proyecto/{id}** → `GastoProyectoController@show`
  - Nombre: `api.gastos-proyecto.show`
- `[PUT]` **api/gastos-proyecto/{id}** → `GastoProyectoController@update`
  - Nombre: `api.gastos-proyecto.update`
- `[DELETE]` **api/gastos-proyecto/{id}** → `GastoProyectoController@destroy`
  - Nombre: `api.gastos-proyecto.destroy`
- `[GET|HEAD]` **api/gastos-proyecto/kpis** → `GastoProyectoController@getKPIs`
  - Nombre: `api.gastos-proyecto.kpis`
- `[GET|HEAD]` **api/gastos-proyecto/test** → `GastoProyectoController@test`
  - Nombre: `api.gastos-proyecto.test`
- `[GET|HEAD]` **desviaciones-api/proyectos** → `DesviacionController@proyectos`
- `[GET|HEAD]` **desviaciones-api/proyecto/{id}** → `DesviacionController@proyectoDetalle`

### Contabilidad

- `[GET|HEAD]` **api/cuentas-contables** → `PolizaController@getCuentasContables`
- `[POST]` **api/cuentas-contables** → `CuentaContableController@store`
- `[GET|HEAD]` **api/cuentas-contables/{id}** → `CuentaContableController@show`
- `[PUT]` **api/cuentas-contables/{id}** → `CuentaContableController@update`
- `[DELETE]` **api/cuentas-contables/{id}** → `CuentaContableController@destroy`
- `[GET|HEAD]` **api/cuentas-contables-padre** → `CuentaContableController@getCuentasPadre`
- `[GET|HEAD]` **conta/auxiliar** → `AuxiliarContableController@index`
  - Nombre: `conta.auxiliar`
- `[GET|HEAD]` **conta/auxiliar/exportar-excel** → `AuxiliarContableController@exportarExcel`
  - Nombre: `conta.auxiliar.exportar`
- `[GET|HEAD]` **conta/auxiliar/datos-cuenta** → `AuxiliarContableController@getDatosCuenta`
  - Nombre: `conta.auxiliar.datos-cuenta`
- `[GET|HEAD]` **registro-cuentas** → `CuentaContableController@index`
  - Nombre: `registro.cuentas`

### BI

- `[GET|HEAD]` **api/tipos-cambio** → `TipoCambioController@index`
- `[POST]` **api/tipos-cambio** → `TipoCambioController@store`
- `[GET|HEAD]` **api/tipos-cambio/{id}** → `TipoCambioController@show`
- `[PUT]` **api/tipos-cambio/{id}** → `TipoCambioController@update`
- `[DELETE]` **api/tipos-cambio/{id}** → `TipoCambioController@destroy`
- `[GET|HEAD]` **admin/api/tipo-cambio** → `TraspasoController@getTipoCambio`
- `[PUT]` **proyectos/hitos/{id}/estado** → `HitoController@cambiarEstado`
  - Nombre: `proyectos.hitos.estado`
- `[GET|HEAD]` **proyectos/bitacora** → `BitacoraController@index`
  - Nombre: `proyectos.bitacora`
- `[PATCH]` **proyectos/personal-asignado/{id}/status** → `AsignacionPersonalController@cambiarStatus`
  - Nombre: `proyectos.personal-asignado.cambiar-status`
- `[POST]` **proyectos/documentos-api/subir** → `DocumentosController@subirDocumento`
  - Nombre: `proyectos.`
- `[POST]` **proyectos/evidencias-api/subir** → `EvidenciaController@subir`
  - Nombre: `proyectos.`
- `[PATCH]` **proyectos/apu/{id}/estado** → `APUController@cambiarEstado`
  - Nombre: `proyectos.apu.cambiar-estado`
- `[PATCH]` **proyectos/costos-indirectos/{id}/estatus-pago** → `CostoIndirectoController@cambiarEstatusPago`
  - Nombre: `proyectos.costos-indirectos.cambiar-estatus`
- `[POST]` **proyectos/costos-indirectos/{id}/documentos** → `CostoIndirectoController@subirDocumento`
  - Nombre: `proyectos.costos-indirectos.documentos.subir`
- `[PATCH]` **proyectos/costos-directos/{id}/estatus-pago** → `CostoDirectoController@cambiarEstatusPago`
  - Nombre: `proyectos.costos-directos.cambiar-estatus`
- `[POST]` **proyectos/costos-directos/{id}/documentos** → `CostoDirectoController@subirDocumento`
  - Nombre: `proyectos.costos-directos.documentos.subir`
- `[GET|HEAD]` **bitacora** → `BitacoraController@index`
  - Nombre: `bitacora.index`
- `[GET|HEAD]` **bitacora/export-pdf** → `BitacoraController@exportPDF`
  - Nombre: `bitacora.export-pdf`
- `[GET|HEAD]` **bitacora/print** → `BitacoraController@printView`
  - Nombre: `bitacora.print`
- `[GET|HEAD]` **api/bitacora/entries** → `BitacoraController@getEntries`
  - Nombre: `api.bitacora.entries`
- `[POST]` **api/bitacora/entries** → `BitacoraController@store`
  - Nombre: `api.bitacora.store`
- `[GET|HEAD]` **api/bitacora/entries/{id}** → `BitacoraController@show`
  - Nombre: `api.bitacora.show`
- `[PUT]` **api/bitacora/entries/{id}** → `BitacoraController@update`
  - Nombre: `api.bitacora.update`
- `[DELETE]` **api/bitacora/entries/{id}** → `BitacoraController@destroy`
  - Nombre: `api.bitacora.destroy`
- `[POST]` **api/bitacora/entries/{entryId}/comments** → `BitacoraController@addComment`
  - Nombre: `api.bitacora.comments.store`
- `[DELETE]` **api/bitacora/comments/{id}** → `BitacoraController@deleteComment`
  - Nombre: `api.bitacora.comments.destroy`
- `[POST]` **api/bitacora/entries/{entryId}/upload-image** → `BitacoraController@uploadImage`
  - Nombre: `api.bitacora.images.upload`
- `[DELETE]` **api/bitacora/images/{id}** → `BitacoraController@deleteImage`
  - Nombre: `api.bitacora.images.destroy`
- `[GET|HEAD]` **api/bitacora/evidencias** → `BitacoraController@getEvidencias`
  - Nombre: `api.bitacora.evidencias`
- `[GET|HEAD]` **api/bitacora/incidencias** → `BitacoraController@getIncidencias`
  - Nombre: `api.bitacora.incidencias`
- `[GET|HEAD]` **api/bitacora/incidencias/{id}** → `BitacoraController@getIncidencia`
  - Nombre: `api.bitacora.incidencias.show`
- `[PUT]` **api/bitacora/incidencias/{id}/resolve** → `BitacoraController@resolveIncidencia`
  - Nombre: `api.bitacora.incidencias.resolve`
- `[PUT]` **api/bitacora/incidencias/{id}/prioridad** → `BitacoraController@updatePrioridad`
  - Nombre: `api.bitacora.incidencias.prioridad`
- `[GET|HEAD]` **api/bitacora/estadisticas** → `BitacoraController@getEstadisticas`
  - Nombre: `api.bitacora.estadisticas`
- `[GET|HEAD]` **api/bitacora/reportes/resumen** → `BitacoraController@getResumenReporte`
  - Nombre: `api.bitacora.reportes.resumen`
- `[POST]` **api/bitacora/reportes/generar** → `BitacoraController@generarReporte`
  - Nombre: `api.bitacora.reportes.generar`
- `[GET|HEAD]` **api/bitacora/responsables** → `BitacoraController@getResponsablesList`
  - Nombre: `api.bitacora.responsables`
- `[POST]` **api/plantilla/{id}/documentos/archivo** → `PlantillaController@subirArchivoDocumento`
- `[GET|HEAD]` **tipos-cambio** → `TipoCambioController@index`
  - Nombre: `tipos-cambio.index`
- `[GET|HEAD]` **tipos-cambio/create** → `TipoCambioController@create`
  - Nombre: `tipos-cambio.create`
- `[POST]` **tipos-cambio** → `TipoCambioController@store`
  - Nombre: `tipos-cambio.store`
- `[GET|HEAD]` **tipos-cambio/{id}/edit** → `TipoCambioController@edit`
  - Nombre: `tipos-cambio.edit`
- `[PUT]` **tipos-cambio/{id}** → `TipoCambioController@update`
  - Nombre: `tipos-cambio.update`
- `[DELETE]` **tipos-cambio/{id}** → `TipoCambioController@destroy`
  - Nombre: `tipos-cambio.destroy`
- `[GET|HEAD]` **dashboard** → `DashboardController@index`
  - Nombre: `dashboard`
- `[GET|HEAD]` **api/dashboard/ventas-tendencia** → `DashboardController@getVentasTendencia`
- `[GET|HEAD]` **api/dashboard/facturacion-diaria** → `DashboardController@getFacturacionDiaria`
- `[GET|HEAD]` **api/dashboard/cuentas-pagar** → `DashboardController@getCuentasPagar`
- `[GET|HEAD]` **api/dashboard/cuentas-cobrar** → `DashboardController@getCuentasCobrar`
- `[GET|HEAD]` **api/dashboard/rentabilidad** → `DashboardController@getRentabilidad`
- `[GET|HEAD]` **api/dashboard/estado-resultados** → `DashboardController@getEstadoResultados`
- `[GET|HEAD]` **api/dashboard/nomina-resumen** → `DashboardController@getNominaResumen`
- `[GET|HEAD]` **api/dashboard/maquinaria-estado** → `DashboardController@getMaquinariaEstado`
- `[GET|HEAD]` **api/dashboard/maquinaria-costos** → `DashboardController@getMaquinariaCostos`

### Chat

- `[GET|HEAD]` **api/chat/users** → `ChatController@getUsers`
- `[GET|HEAD]` **api/chat/messages/{userId}** → `ChatController@getMessages`
- `[POST]` **api/chat/send** → `ChatController@sendMessage`
- `[POST]` **api/chat/mark-read/{userId}** → `ChatController@markAsRead`
- `[GET|HEAD]` **chat/conversations** → `ChatController@getConversations`
- `[GET|HEAD]` **chat/users** → `ChatController@getUsers`
- `[GET|HEAD]` **chat/messages/{userId}** → `ChatController@getMessages`
- `[POST]` **chat/send** → `ChatController@sendMessage`
- `[POST]` **chat/mark-read/{userId}** → `ChatController@markAsRead`
- `[GET|HEAD]` **chat/unread-count** → `ChatController@getTotalUnreadCount`

### Facturación

- `[GET|HEAD]` **admin/facturacionproveedores** → `FacturaProveedorController@index`
  - Nombre: `presupuestos.facturacion`
- `[GET|HEAD]` **admin/facturacionproveedores/data** → `FacturaProveedorController@getData`
- `[POST]` **admin/facturacionproveedores** → `FacturaProveedorController@store`
- `[GET|HEAD]` **admin/facturacionproveedores/{id}** → `FacturaProveedorController@show`
- `[DELETE]` **admin/facturacionproveedores/{id}** → `FacturaProveedorController@destroy`
- `[GET|HEAD]` **admin/proveedores-lista** → `FacturaProveedorController@getProveedores`
- `[POST]` **admin/proveedores-guardar** → `FacturaProveedorController@storeProveedor`
- `[GET|HEAD]` **api/facturas-para-pago** → `FacturaController@getFacturasParaPago`
- `[GET|HEAD]` **facturacion** → `FacturaController@indexView`
  - Nombre: `facturacion.index`
- `[GET|HEAD]` **facturacion/data** → `FacturaController@getData`
- `[GET|HEAD]` **facturacion/{id}** → `FacturaController@show`
- `[GET|HEAD]` **facturacion/{id}/edit** → `FacturaController@edit`
- `[GET|HEAD]` **facturacion/{id}/pdf** → `FacturaController@pdf`
  - Nombre: `facturacion.pdf`
- `[GET|HEAD]` **facturacion/{id}/xml** → `FacturaController@downloadXml`
  - Nombre: `facturacion.xml`
- `[POST]` **api/facturas** → `FacturaController@store`
- `[PUT]` **api/facturas/{id}** → `FacturaController@update`
- `[DELETE]` **api/facturas/{id}** → `FacturaController@destroy`
- `[POST]` **facturacion/{id}/timbrar** → `FacturaController@timbrar`
- `[POST]` **facturacion/{id}/cancelar** → `FacturaController@cancelar`
- `[POST]` **facturacion/{id}/enviar-correo** → `FacturaController@enviarCorreo`
- `[GET|HEAD]` **api/contactos** → `FacturaController@getClientes`
- `[GET|HEAD]` **api/series/activas** → `FacturaController@getSeriesActivas`
- `[GET|HEAD]` **api/series/{id}/siguiente-folio** → `FacturaController@getSiguienteFolio`
- `[GET|HEAD]` **api/sat/uso-cfdi** → `FacturaController@getUsosCFDI`
- `[GET|HEAD]` **api/sat/formas-pago** → `FacturaController@getFormasPago`
- `[GET|HEAD]` **api/sat/metodos-pago** → `FacturaController@getMetodosPago`
- `[GET|HEAD]` **api/facturas-para-nota-credito** → `FacturaController@getFacturasParaNotaCredito`
- `[GET|HEAD]` **api/series-nota-credito** → `FacturaController@getSeriesNotaCredito`
- `[GET|HEAD]` **factoraje/clientes-con-facturas** → `FactorajeController@getClientesConFacturas`
- `[GET|HEAD]` **factoraje/facturas-disponibles** → `FactorajeController@getFacturasDisponibles`
- `[GET|HEAD]` **facturas/{factura}/detalle** → `CuentasPorCobrarController@getDetalleFactura`
  - Nombre: `facturas.detalle`

### Inventarios

- `[GET|HEAD]` **almacen/entrada** → `MovimientoInventarioController@index`
  - Nombre: `almacen.entrada`
- `[GET|HEAD]` **almacen/traspasos** → `TraspasoAlmacenController@index`
  - Nombre: `almacen.traspasos`
- `[GET|HEAD]` **almacen/vales** → `MovimientoInventarioController@index`
  - Nombre: `almacen.vales`
- `[GET|HEAD]` **almacen/inventariofisico** → `InventarioFisicoController@index`
  - Nombre: `almacen.inventario`
- `[GET|HEAD]` **almacen/api/inventario-fisico** → `InventarioFisicoController@getInventario`
  - Nombre: `almacen.api.inventario-fisico`
- `[GET|HEAD]` **almacen/api/inventario-fisico/{id}** → `InventarioFisicoController@show`
  - Nombre: `almacen.api.inventario-fisico.show`
- `[GET|HEAD]` **almacen/api/inventario-fisico/exportar** → `InventarioFisicoController@exportar`
  - Nombre: `almacen.api.inventario-fisico.exportar`
- `[GET|HEAD]` **almacen/almacenes** → `AlmacenController@index`
  - Nombre: `almacen.almacen`
- `[GET|HEAD]` **almacen/api/almacenes** → `AlmacenController@getAlmacenes`
  - Nombre: `almacen.api.almacenes`
- `[GET|HEAD]` **almacen/api/almacenes/{id}** → `AlmacenController@show`
  - Nombre: `almacen.api.almacenes.show`
- `[POST]` **almacen/api/almacenes** → `AlmacenController@store`
  - Nombre: `almacen.api.almacenes.store`
- `[PUT]` **almacen/api/almacenes/{id}** → `AlmacenController@update`
  - Nombre: `almacen.api.almacenes.update`
- `[DELETE]` **almacen/api/almacenes/{id}** → `AlmacenController@destroy`
  - Nombre: `almacen.api.almacenes.destroy`
- `[POST]` **almacen/api/almacenes/{id}/reactivar** → `AlmacenController@reactivar`
  - Nombre: `almacen.api.almacenes.reactivar`
- `[GET|HEAD]` **almacen/api/almacenes/tipos** → `AlmacenController@getTipos`
  - Nombre: `almacen.api.almacenes.tipos`
- `[GET|HEAD]` **almacen/api/almacenes/exportar** → `AlmacenController@exportar`
  - Nombre: `almacen.api.almacenes.exportar`
- `[GET|HEAD]` **almacen/api/almacenes/estadisticas** → `AlmacenController@getEstadisticas`
  - Nombre: `almacen.api.almacenes.estadisticas`
- `[GET|HEAD]` **inventario/api/movimientos** → `MovimientoInventarioController@getMovimientos`
  - Nombre: `inventario.api.movimientos`
- `[POST]` **inventario/api/movimientos/entrada** → `MovimientoInventarioController@registrarEntrada`
  - Nombre: `inventario.api.movimientos.entrada`
- `[POST]` **inventario/api/movimientos/salida** → `MovimientoInventarioController@registrarSalida`
  - Nombre: `inventario.api.movimientos.salida`
- `[POST]` **inventario/api/movimientos/transferencia** → `MovimientoInventarioController@transferir`
  - Nombre: `inventario.api.movimientos.transferencia`
- `[POST]` **inventario/api/movimientos/ajuste** → `MovimientoInventarioController@ajustar`
  - Nombre: `inventario.api.movimientos.ajuste`
- `[GET|HEAD]` **inventario/api/movimientos/saldo** → `MovimientoInventarioController@getSaldo`
  - Nombre: `inventario.api.movimientos.saldo`
- `[GET|HEAD]` **inventario/api/movimientos/resumen** → `MovimientoInventarioController@getResumen`
  - Nombre: `inventario.api.movimientos.resumen`
- `[GET|HEAD]` **inventario/api/movimientos/exportar** → `MovimientoInventarioController@exportar`
  - Nombre: `inventario.api.movimientos.exportar`
- `[GET|HEAD]` **inventario/api/movimientos/verificar-stock** → `MovimientoInventarioController@verificarStock`
  - Nombre: `inventario.api.movimientos.verificar-stock`
- `[GET|HEAD]` **inventario/api/movimientos/{id}** → `MovimientoInventarioController@show`
  - Nombre: `inventario.api.movimientos.show`
- `[POST]` **inventario/api/movimientos/recepcion-multiple** → `MovimientoInventarioController@recepcionMultiple`
  - Nombre: `inventario.api.movimientos.recepcion-multiple`

### Compras

- `[GET|HEAD]` **compras/api/pendientes-recepcion** → `CompraRecepcionController@pendientes`
  - Nombre: `compras.api.pendientes-recepcion`
- `[GET|HEAD]` **compras/api/pendientes-recepcion/{id}/detalle** → `CompraRecepcionController@detalleCompra`
  - Nombre: `compras.api.pendientes-recepcion.detalle`



---

---
### **📌 Módulo: Autenticación (Gestión de Usuarios)**
**Qué puede hacer:**
- Registrar usuarios nuevos (`create()`).
- Iniciar sesión (`store()` en `AuthenticatedSessionController`).
- Cerrar sesión (`destroy()`).
- Confirmar contraseñas olvidadas (`store()` en `ConfirmablePasswordController`).
- Verificar email (`store()` en `EmailVerificationNotificationController`).

**Cómo se hace (pasos):**
1. **Registrar usuario:**
   - *Método:* `create()` → Ruta: `/register`.
   - *Pasos:* Llenar formulario (nombre, email, contraseña) → Sube datos → Sistema valida y crea usuario.
   - *Resultado:* Redirección a `/login` con mensaje de éxito.

2. **Iniciar sesión:**
   - *Método:* `store()` → Ruta: `/login`.
   - *Pasos:* Ingresar email/contraseña → Sistema autentica → Guarda sesión.
   - *Resultado:* Acceso al panel principal.

3. **Cerrar sesión:**
   - *Método:* `destroy()` → Ruta: `/logout`.
   - *Pasos:* Clic en "Cerrar sesión" → Destruye sesión activa.
   - *Resultado:* Redirección a `/login`.

4. **Verificar email:**
   - *Método:* `store()` → Ruta: `/verify-email`.
   - *Pasos:* Usuario hace clic en enlace del email → Sistema marca email como verificado.
   - *Resultado:* Acceso total al sistema.

**Métodos clave:**
- `create()` → Crea usuario nuevo.
- `store()` (en todos) → Procesa peticiones POST (login, registro, verificación).
- `destroy()` → Elimina sesión actual.

---
*(Nota: Falta definir módulos específicos de construcción como "Proyectos", "Presupuestos", etc., por falta de datos en el fragmento. Este módulo solo cubre autenticación).*