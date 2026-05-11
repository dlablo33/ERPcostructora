# 📚 DOCUMENTACIÓN COMPLETA DEL SISTEMA ERP CONSTRUCTORA

**Generado:** 2026-04-28 17:39:32

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

## 🎨 VISTAS BLADE

Total de vistas: **185**

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
- **`pagos.blade.php`**
  - Ruta: `administracion/cuentaspago/pagos.blade.php`
  - ✅ Contiene tablas de datos
- **`bitacora.blade.php`**
  - Ruta: `administracion/facturacion/bitacora.blade.php`
  - ✅ Contiene tablas de datos
- **`cfdi.blade.php`**
  - Ruta: `administracion/facturacion/cfdi.blade.php`
  - ✅ Contiene tablas de datos
- **`comiciones.blade.php`**
  - Ruta: `administracion/facturacion/comiciones.blade.php`
  - ✅ Contiene tablas de datos
- **`contrarecibo.blade.php`**
  - Ruta: `administracion/facturacion/contrarecibo.blade.php`
  - ✅ Contiene tablas de datos
- **`factoraje.blade.php`**
  - Ruta: `administracion/facturacion/factoraje.blade.php`
  - ✅ Contiene tablas de datos
- **`facturacion.blade.php`**
  - Ruta: `administracion/facturacion/facturacion.blade.php`
  - ✅ Contiene tablas de datos
- **`nota.blade.php`**
  - Ruta: `administracion/facturacion/nota.blade.php`
  - ✅ Contiene tablas de datos
- **`ventas.blade.php`**
  - Ruta: `administracion/facturacion/ventas.blade.php`
  - ✅ Contiene tablas de datos
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
  - ✅ Contiene tablas de datos
- **`gastos.blade.php`**
  - Ruta: `administracion/presupuestos/gastos.blade.php`
  - ✅ Contiene tablas de datos
- **`mensual.blade.php`**
  - Ruta: `administracion/presupuestos/mensual.blade.php`
  - ✅ Contiene tablas de datos
- **`reasignacion.blade.php`**
  - Ruta: `administracion/presupuestos/reasignacion.blade.php`
  - ✅ Contiene tablas de datos
- **`conciliacion.blade.php`**
  - Ruta: `administracion/tesoreria/conciliacion.blade.php`
  - ✅ Contiene tablas de datos
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
  - ✅ Contiene tablas de datos
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
  - ✅ Contiene tablas de datos
- **`centros.blade.php`**
  - Ruta: `conta/catalogo/centros.blade.php`
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
- **`complementos.blade.php`**
  - Ruta: `conta/fiscal/complementos.blade.php`
  - ✅ Contiene tablas de datos
- **`contabilidad.blade.php`**
  - Ruta: `conta/fiscal/contabilidad.blade.php`
- **`declaraciones.blade.php`**
  - Ruta: `conta/fiscal/declaraciones.blade.php`
- **`diot.blade.php`**
  - Ruta: `conta/fiscal/diot.blade.php`
- **`retenciones.blade.php`**
  - Ruta: `conta/fiscal/retenciones.blade.php`
- **`asignacion.blade.php`**
  - Ruta: `conta/porproyecto/asignacion.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`cierre.blade.php`**
  - Ruta: `conta/porproyecto/cierre.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`costo.blade.php`**
  - Ruta: `conta/porproyecto/costo.blade.php`
  - ✅ Contiene tablas de datos
- **`gastos.blade.php`**
  - Ruta: `conta/porproyecto/gastos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`rentabilidad.blade.php`**
  - Ruta: `conta/porproyecto/rentabilidad.blade.php`
  - ✅ Contiene tablas de datos
- **`ajustes.blade.php`**
  - Ruta: `conta/registros/ajustes.blade.php`
- **`auxiliar.blade.php`**
  - Ruta: `conta/registros/auxiliar.blade.php`
  - ✅ Contiene tablas de datos
- **`diario.blade.php`**
  - Ruta: `conta/registros/diario.blade.php`
  - ✅ Contiene tablas de datos
- **`libro.blade.php`**
  - Ruta: `conta/registros/libro.blade.php`
  - ✅ Contiene tablas de datos
- **`polizas.blade.php`**
  - Ruta: `conta/registros/polizas.blade.php`
  - ✅ Contiene tablas de datos

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
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`control.blade.php`**
  - Ruta: `proyectos/control/control.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`desviaciones.blade.php`**
  - Ruta: `proyectos/control/desviaciones.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`directos.blade.php`**
  - Ruta: `proyectos/costos/directos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`indirectos.blade.php`**
  - Ruta: `proyectos/costos/indirectos.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`rentabilidad.blade.php`**
  - Ruta: `proyectos/costos/rentabilidad.blade.php`
  - ✅ Contiene tablas de datos
- **`evidencia.blade.php`**
  - Ruta: `proyectos/documentacion/evidencia.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`permisos.blade.php`**
  - Ruta: `proyectos/documentacion/permisos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`planos.blade.php`**
  - Ruta: `proyectos/documentacion/planos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`alta.blade.php`**
  - Ruta: `proyectos/gestion/alta.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Usa AJAX
- **`bitacora.blade.php`**
  - Ruta: `proyectos/gestion/bitacora.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`cartera.blade.php`**
  - Ruta: `proyectos/gestion/cartera.blade.php`
  - ✅ Contiene formularios
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
  - ✅ Usa AJAX
- **`hitos.blade.php`**
  - Ruta: `proyectos/gestion/hitos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`index.blade.php`**
  - Ruta: `proyectos/index.blade.php`
- **`activas.blade.php`**
  - Ruta: `proyectos/licitacion/activas.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`analisis.blade.php`**
  - Ruta: `proyectos/licitacion/analisis.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`presupuestos.blade.php`**
  - Ruta: `proyectos/licitacion/presupuestos.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`asignacion.blade.php`**
  - Ruta: `proyectos/maquinaria/asignacion.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`bitacora.blade.php`**
  - Ruta: `proyectos/maquinaria/bitacora.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`control.blade.php`**
  - Ruta: `proyectos/maquinaria/control.blade.php`
  - ✅ Contiene tablas de datos
- **`mantenimiento.blade.php`**
  - Ruta: `proyectos/maquinaria/mantenimiento.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
- **`asignada.blade.php`**
  - Ruta: `proyectos/personal/asignada.blade.php`
  - ✅ Contiene tablas de datos
- **`flotillas.blade.php`**
  - Ruta: `proyectos/personal/flotillas.blade.php`
  - ✅ Contiene tablas de datos
  - ✅ Tiene modales
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

Total de rutas: **549**

### General

- `[GET|HEAD]` **sanctum/csrf-cookie** → `CsrfCookieController@show`
  - Nombre: `sanctum.csrf-cookie`
- `[GET|HEAD]` **_ignition/health-check** → `HealthCheckController`
  - Nombre: `ignition.healthCheck`
- `[POST]` **_ignition/execute-solution** → `ExecuteSolutionController`
  - Nombre: `ignition.executeSolution`
- `[POST]` **_ignition/update-config** → `UpdateConfigController`
  - Nombre: `ignition.updateConfig`
- `[GET|POST|HEAD]` **broadcasting/auth** → `BroadcastController@authenticate`
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
- `[GET|HEAD]` **admin/api/categorias-por-tipo-egreso/{tipoEgresoId}** → `PagoController@getCategoriasPorTipoEgreso`
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
- `[GET|HEAD]` **api/proyectos/{proyecto}/partidas** → `PresupuestoProyectoController@getPartidas`
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

### Contabilidad

- `[GET|HEAD]` **api/cuentas-contables** → `CuentaContableController@getData`
- `[POST]` **api/cuentas-contables** → `CuentaContableController@store`
- `[GET|HEAD]` **api/cuentas-contables/{id}** → `CuentaContableController@show`
- `[PUT]` **api/cuentas-contables/{id}** → `CuentaContableController@update`
- `[DELETE]` **api/cuentas-contables/{id}** → `CuentaContableController@destroy`
- `[GET|HEAD]` **api/cuentas-contables-padre** → `CuentaContableController@getCuentasPadre`
- `[GET|HEAD]` **registro-cuentas** → `CuentaContableController@index`
  - Nombre: `registro.cuentas`

### BI

- `[GET|HEAD]` **api/tipos-cambio** → `TipoCambioController@index`
- `[POST]` **api/tipos-cambio** → `TipoCambioController@store`
- `[GET|HEAD]` **api/tipos-cambio/{id}** → `TipoCambioController@show`
- `[PUT]` **api/tipos-cambio/{id}** → `TipoCambioController@update`
- `[DELETE]` **api/tipos-cambio/{id}** → `TipoCambioController@destroy`
- `[GET|HEAD]` **admin/api/tipo-cambio** → `TraspasoController@getTipoCambio`
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



---

🏠 **ERP Constructora MejoraSoft**
├── 📊 **Administración**
│   ├── Facturación
│   ├── Tesorería
│   ├── Cuentas por pagar/cobrar
│   └── Presupuestos
├── 🏗️ **Proyectos**
│   ├── Gestión de proyectos
│   ├── Licitaciones
│   ├── Costos
│   └── Avances
├── 📋 **Contabilidad**
│   ├── Estados financieros
│   └── Fiscal
├── 👥 **RRHH**
│   ├── Personal
│   ├── 