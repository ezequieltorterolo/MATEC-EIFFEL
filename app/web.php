<?php
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\UserController;
use rutex\Route;
use app\controllers\CarritoController;

//usuario comun
Route::get("/"                         , [HomeController::class, "index"]);
Route::get("/producto"                 , [HomeController::class, "producto"]);
Route::get("/catalogo"                 , [HomeController::class, "catalogo"]);
Route::post("/catalogo"                , [HomeController::class, "catalogo"]);
Route::get("/sobreNosotros"            , [HomeController::class, "sobreNos"]);



//CARRITO
Route::get("/carrito"                  , [CarritoController::class , "carrito"]             );
Route::get("/prdinfo/:id"              , [CarritoController::class , "prdinfo"]             );
Route::post("/carrito_confirmar"       , [CarritoController::class , "carrito_confirmar"]   );

//login
Route::get("/login"                    , [UserController::class, "login"]);
Route::get("/registro"                 , [UserController::class, "registro"]);
Route::get("/logout"                   , [UserController::class, "logout"]);

//validacion login/registro
Route::post("/login"                   , [UserController::class, "ValidarIngreso"]);
Route::post("/ValidarRegistro"         , [UserController::class, "ValidarRegistro"]);

//ADMINISTRADOR
Route::get("/admin"                    , [AdminController::class, "login"]);
Route::post("/ValidarIngreso"          , [AdminController::class, "ValidarIngresoAdmin"]);

//Administrador-paginas de productos
Route::get("/admin/productoAdmin"      , [AdminController::class, "productoAdmin"]);
Route::get("/admin/gestionProductos"   , [AdminController::class, "gestionProductos"]);

//Formularios de producto
Route::get("/admin/aniadirProducto"    , [AdminController::class, "añadirProducto"]);
Route::get("/admin/modificarProducto"  , [AdminController::class, "modificarProducto"]);

//Validacion de cambios o eliminacion del producto
Route::post("/admin/gestionProductos"  , [AdminController::class, "guardarTodoProductos"]);
Route::post("/admin/aniadirProducto"   , [AdminController::class, "validarProducto"]);
Route::post("/admin/modificarProducto" , [AdminController::class, "validarProducto"]);
Route::get("/admin/eliminar", [AdminController::class, "eliminar"]);


//Administrador-pagina de reservas
Route::get("/admin/gestionReservas"    , [AdminController::class, "gestionReservas"]);
Route::post("/admin/gestionReservas"   , [AdminController::class, "guardarTodoReservas"]);
Route::get("/admin/agregarProducto"    , [AdminController::class, "agregarProducto"]);
Route::get("/admin/eliminarProducto"   , [AdminController::class, "eliminarProducto"]);

