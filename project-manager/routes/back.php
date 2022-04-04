<?php

use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Back\FrontendController;
use App\Http\Controllers\Back\MenuController;
use App\Http\Controllers\Back\OtherPageController;
use App\Http\Controllers\Back\ProjectController;
use App\Http\Controllers\Back\AssignProjectCotroller;
use App\Http\Controllers\Back\SliderController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;
 
// Auth
// Route::get('login',             [AuthController::class, 'login'])->name('back.login');

Route::middleware('auth', 'isAdmin')->group(function () {
    // Other pages
    Route::get('/', [OtherPageController::class, 'dashboard']);
    Route::get('dashboard', [OtherPageController::class, 'dashboard'])->name('dashboard');

    // Admin CRUD
    // Update admin profile
    Route::get('profile/update-profile', [AdminController::class, 'update_profile_page'])->name('admin.update-profile');
    Route::post('profile/update-profile/action', [AdminController::class, 'update_profile'])->name('back.admins.update.action');
    Route::post('profile/update-password', [AdminController::class, 'update_password'])->name('admin.password-update');
    Route::resource('admins', AdminController::class, ['as' => 'back']);

    // Project CRUD
    Route::get('projects/remove-image/{project}', [ProjectController::class, 'removeImage'])->name('back.projects.removeImage');
    Route::post('projects/section/create/{project}', [ProjectController::class, 'sectionCreate'])->name('back.projects.sectionCreate');
    Route::get('projects/section/delete/{section}', [ProjectController::class, 'sectionDelete'])->name('back.projects.sectionDelete');
    Route::get('projects/section-item/delete/{section_item}', [ProjectController::class, 'sectionItemDelete'])->name('back.projects.sectionItemDelete');
    Route::post('projects/section-item/create', [ProjectController::class, 'sectionItemCreate'])->name('back.projects.sectionItemCreate');
    Route::post('projects/section-item/update', [ProjectController::class, 'sectionItemUpdarte'])->name('back.projects.sectionItemUpdarte');
    Route::get('projects/item-check', [ProjectController::class, 'itemCheck'])->name('back.projects.itemCheck');
    Route::get('projects/submit/{project}/{status}', [ProjectController::class, 'submit'])->name('back.projects.submit');
    Route::post('projects/section-item/add-comment', [ProjectController::class, 'addComment'])->name('back.projects.addComment');
    Route::post('projects/section-item/view-comment', [ProjectController::class, 'viewComment'])->name('back.projects.viewComment');
    Route::post('projects/section-position', [ProjectController::class, 'sectionPosition'])->name('back.projects.sectionPosition');
    Route::get('projects/check-uncheck/{project}/{group}/{status}', [ProjectController::class, 'checkUncheck'])->name('back.projects.checkUncheck');
    Route::resource('projects', ProjectController::class, ['as' => 'back']);

    Route::get('assign',[AssignProjectCotroller::class,'viewAssign'])->name('back.projects.assign_project');
    Route::get('assign_user/{id}',[AssignProjectCotroller::class,'viewAssignUser'])->name('back.projects.assign_user');
    

    // Media
    Route::get('media/settings', [MediaController::class, 'settings'])->name('back.media.settings');
    Route::post('media/settings', [MediaController::class, 'settingsUpdate']);
    Route::post('media/upload', [MediaController::class, 'upload'])->name('back.media.upload');
    // Image Upload
    Route::post('media/image-upload',  [MediaController::class, 'imageUpload'])->name('imageUpload');

    // Frontend
    Route::get('frontend/general', [FrontendController::class, 'general'])->name('back.frontend.general');
    Route::post('frontend/general', [FrontendController::class, 'generalStore']);

    Route::post('sliders/position', [SliderController::class, 'position'])->name('back.sliders.position');
    Route::get('sliders/delete/{slider}', [SliderController::class, 'destroy'])->name('back.sliders.delete');
    Route::resource('sliders', SliderController::class, ['as' => 'back']);

    // Menus
    Route::get('menus', [MenuController::class, 'index'])->name('back.menus.index');
    Route::post('menus/store', [MenuController::class, 'store'])->name('back.menus.store');
    Route::post('menus/store/menu-item', [MenuController::class, 'storeMenuItem'])->name('back.menus.storeMenuItem');
    Route::post('menus/menu-item/position', [MenuController::class, 'menuItemPosition'])->name('back.menus.menuItemPosition');
    Route::get('menus/destroy/{menu}', [MenuController::class, 'destroy'])->name('back.menus.destroy');
    Route::get('menus/item/destroy/{menu_item}', [MenuController::class, 'destroyItem'])->name('back.menus.destroyItem');
});
