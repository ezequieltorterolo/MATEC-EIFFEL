<?php
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\UserController;
use rutex\Route;

//usuario comun
Route::get("/"          , [HomeController::class, "index"]);
Route::get("/producto"  , [HomeController::class, "producto"]);
Route::get("/catalogo"  , [HomeController::class, "catalogo"]);
Route::get("/carrito"  , [HomeController::class, "carrito"]);
//ADMINISTRADOR
Route::get("/admin"          , [AdminController::class, "login"]);
Route::post("/ValidarIngreso", [AdminController::class, "ValidarIngresoAdmin"]);
Route::get("/admin/gestionProductos", [AdminController::class, "gestionProductos"]);
Route::get("/admin/reservas" , [AdminController::class, "reservas"]);
Route::get("/admin/productoAdmin", [AdminController::class, "productoAdmin"]);
Route::get("/admin/delete", [AdminController::class, "delete"]);

//login
Route::get("/login"                 , [UserController::class, "login"]);
Route::get("/registro"          , [UserController::class, "registro"]);
Route::post("/login"                , [UserController::class, "ValidarIngreso"]);
Route::post("/ValidarRegistro"      , [UserController::class, "ValidarRegistro"]);
