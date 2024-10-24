<?php
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\UserController;
use rutex\Route;

//usuario comun
Route::get("/"          , [HomeController::class, "index"]);
Route::get("/producto"  , [HomeController::class, "producto"]);
Route::get("/catalogo"  , [HomeController::class, "catalogo"]);
Route::get("/carrito"   , [HomeController::class, "carrito"]);
Route::get("/prdinfo/:id"   , [HomeController::class, "prdinfo"]);

//login
Route::get("/login"                 , [UserController::class, "login"]);
Route::get("/registro"          , [UserController::class, "registro"]);
Route::get("/logout"          , [UserController::class, "logout"]);

//validacion login/registro
Route::post("/login"                , [UserController::class, "ValidarIngreso"]);
Route::post("/ValidarRegistro"      , [UserController::class, "ValidarRegistro"]);

//ADMINISTRADOR
Route::get("/admin"          , [AdminController::class, "login"]);
Route::post("/ValidarIngreso", [AdminController::class, "ValidarIngresoAdmin"]);

//Administrador-paginas de productos
Route::get("/admin/productoAdmin", [AdminController::class, "productoAdmin"]);
Route::get("/admin/gestionProductos"  , [AdminController::class, "gestionProductos"]);

//Formularios de producto
Route::get("/admin/aniadirProducto"    , [AdminController::class, "añadirProducto"]);
Route::get("/admin/modificarProducto" , [AdminController::class, "modificarProducto"]);

//Validacion de cambios o eliminacion del producto
Route::post("/admin/gestionProductos"  , [AdminController::class, "guardarTodo"]);
Route::post("/admin/aniadirProducto"    , [AdminController::class, "validarProducto"]);
Route::post("/admin/modificarProducto" , [AdminController::class, "validarProducto"]);
Route::get("/admin/eliminar", [AdminController::class, "eliminar"]);


//Administrador-pagina de reservas
Route::get("/admin/reservas" , [AdminController::class, "reservas"]);


