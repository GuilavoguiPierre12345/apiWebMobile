<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route pour les catégorie
Route::prefix('/categorie')->controller(CategorieController::class)->group(function()
{
    Route::get('/listeCategorie','listCategorie')->name('listCategorie');
    Route::get('/addCategorie','addCategorie')->name('addCategorie');
    Route::post('/storeCategorie','store')->name('storeCategorie');
    Route::get('/editCategorie/{categorie}','edit')->name('editCategorie');
    Route::put('/updateCategorie/{categorie}','update')->name('updateCategorie');
    Route::delete('/deleteCategorie/{categorie}','destroy')->name('destroyCategorie');

});

// Route pour les produits

Route::prefix('/produit')->controller(ProduitController::class)->group(function()
    {
    Route::get('/listeProduit','listProduit')->name('listProduit');
    Route::get('/addProduit','addProduit')->name('addProduit');
    Route::post('/storeProduit','store')->name('storeProduit');
    Route::get('/editProduit/{produit}','edit')->name('editProduit');
    Route::put('/updateProduit/{produit}','update')->name('updateProduit');
    Route::delete('/deleteProduit/{produit}','destroy')->name('destroyProduit');
    }
);

