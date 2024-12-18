<?php
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\UserController;
use rutex\Route;
use app\controllers\CarritoController;

//usuario comun
Route::get("/"                                , [HomeController::class, "index"]);
Route::get("/producto"                        , [HomeController::class, "producto"]);
Route::get("/catalogo"                        , [HomeController::class, "catalogo"]);
Route::post("/catalogo"                       , [HomeController::class, "catalogo"]);
Route::get("/sobreNosotros"                   , [HomeController::class, "sobreNos"]);
Route::get("/verReservas"                     , [HomeController::class, "verReservas"]);
Route::get("/cancelarReserva"                 , [HomeController::class, "cancelarReserva"]);





//CARRITO
Route::get("/carrito"                         , [CarritoController::class , "carrito"]             );
Route::get("/prdinfo/:id"                     , [CarritoController::class , "prdinfo"]             );
Route::post("/carrito_confirmar"              , [CarritoController::class , "carrito_confirmar"]   );

//login
Route::get("/login"                           , [UserController::class, "login"]);
Route::get("/registro"                        , [UserController::class, "registro"]);
Route::get("/logout"                          , [UserController::class, "logout"]);

//validacion login/registro
Route::post("/login"                          , [UserController::class, "ValidarIngreso"]);
Route::post("/ValidarRegistro"                , [UserController::class, "ValidarRegistro"]);

//recuperacion de contraseña
Route::get("/recuperarContraseniaCorreo"      , [UserController::class, "recuperarContraseñaCorreo"]);
Route::get("/recuperarContraseniaPregunta"    , [UserController::class, "recuperarContraseñaPregunta"]);
Route::get("/nuevaContrasenia"                , [UserController::class, "nuevaContraseña"]);
Route::post("/recuperarContraseniaCorreo"     , [UserController::class, "validarPasosdeRecuperacion"]);
Route::post("/recuperarContraseniaPregunta"   , [UserController::class, "validarPasosdeRecuperacion"]);
Route::post("/nuevaContrasenia"               , [UserController::class, "validarPasosdeRecuperacion"]);

//ADMINISTRADOR
Route::get("/admin"                           , [AdminController::class, "login"]);
Route::post("/ValidarIngreso"                 , [AdminController::class, "ValidarIngresoAdmin"]);
Route::get("/admin/homeAdmin"                 , [AdminController::class, "homeAdmin"]);

//Administrador-paginas de productos
Route::get("/admin/productoAdmin"             , [AdminController::class, "productoAdmin"]);
Route::get("/admin/gestionProductos"          , [AdminController::class, "gestionProductos"]);

//Formularios de producto
Route::get("/admin/aniadirProducto"           , [AdminController::class, "añadirProducto"]);
Route::get("/admin/modificarProducto"         , [AdminController::class, "modificarProducto"]);

//Validacion de cambios o eliminacion del producto
Route::post("/admin/gestionProductos"         , [AdminController::class, "guardarTodoProductos"]);
Route::post("/admin/aniadirProducto"          , [AdminController::class, "validarProducto"]);
Route::post("/admin/modificarProducto"        , [AdminController::class, "validarProducto"]);
Route::get("/admin/eliminarProducto"          , [AdminController::class, "eliminarProducto"]);


//Administrador-pagina de reservas
Route::get("/admin/gestionReservas"           , [AdminController::class, "gestionReservas"]);
Route::post("/admin/gestionReservas"          , [AdminController::class, "guardarTodoReservas"]);
Route::post("/admin/agregarProducto"          , [AdminController::class, "agregarProducto"]);
Route::get("/admin/eliminarProductoReserva"   , [AdminController::class, "eliminarProductoReserva"]);
Route::get("/admin/eliminarReserva"           , [AdminController::class, "eliminarReserva"]);


Route::get("/admin/gestionUsuarios"           , [AdminController::class, "gestionUsuarios"]);
Route::get("/admin/eliminarUsuario"           , [AdminController::class, "eliminarUsuario"]);
