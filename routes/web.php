<?php

use App\Http\Controllers\Ads\ListingController;
use App\Http\Controllers\Ads\MyAdsController;
use App\Http\Controllers\AutocompleteResultController;
use App\Http\Controllers\Messages\OfferController;
use App\Http\Controllers\Category\CategoriesController;
use App\Http\Controllers\SymlinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\Offers\MyOfferController;
use App\Http\Controllers\Offers\OfferListController;
use App\Http\Controllers\SuperAdmin\OrganisationController;
use App\Http\Controllers\Workflows\WorkflowController;
use App\Http\Controllers\Settings\SetupController;
use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Document\DocumentManagementController;
use App\Http\Controllers\Legal\LegalRequestController;
use App\Http\Controllers\Legal\LegalRequestNoteController;
use App\Http\Controllers\Messages\MessageController;
use App\Http\Controllers\Settings\AccountSettingController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Legal\LegalSupportController;
use App\Http\Controllers\Organisations\OrgSettingsController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Individual\IndividualController;

Route::view('/', 'frontend.index');
Route::get('/symlink', [SymlinkController::class, 'index']);
Route::get('/locations/states', [LocationController::class, 'getStates']);
Route::get('/locations/cities/{state}', [LocationController::class, 'getCities']);
Route::get('/locations/postcode/{city}', [LocationController::class, 'getPostcode']);
Route::get('/locations/city-state/{postcode}', [LocationController::class, 'getCityState']);
Route::get('/locations/get-by-city-postcode', [LocationController::class, 'getByCityPostcode']);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/all', [UserController::class, 'getUsers']);
    Route::apiResource('/users', UserController::class);

    Route::get('/tags/all', [TagController::class, 'getTags']);
    Route::get('/tags/options', [TagController::class, 'getTagOptions']);
    Route::apiResource('/tags', TagController::class);

    Route::get('/collections/all', [CollectionController::class, 'getCollections']);
    Route::apiResource('/collections', CollectionController::class);

    Route::get('/organization/all', [OrganisationController::class, 'getOrganisationList']);
    Route::get('/organisation-management/all', [OrganisationController::class, 'getOrganisations']);
    Route::get('/auth-organisation', [OrganisationController::class, 'getAuthOrg']);
    Route::post('/organisation-management/file-delete', [OrganisationController::class, 'deleteFile']);
    Route::apiResource('/organisation-management', OrganisationController::class);


    Route::get('/locations/options', [LocationController::class, 'getAllLocations']);
    Route::get('/categories/options', [CategoryController::class, 'getAllCategories']);

    Route::get('/posts/all', [ListingController::class, 'getListings']);
    Route::post('/posts/images', [ListingController::class, 'storeImage']);
    Route::delete('/posts/images', [ListingController::class, 'deletePostImage']);
    Route::resource('/posts', ListingController::class);

    // Workflows
    Route::view('/workflows', 'workflows.index')->name('workflows');
    Route::get('/workflows/stage', [WorkflowController::class, 'index']);
    Route::post('/workflows', [WorkflowController::class, 'store']);
    Route::put('/workflows/{id}', [WorkflowController::class, 'update']);
    Route::delete('/workflows/{id}', [WorkflowController::class, 'destroy']);

    Route::get('/our-posts', MyAdsController::class)->name('our-posts');
    Route::get('/org-posts/{orgid}', [MyAdsController::class, 'index'])->name('own-posts');
    Route::get('/our-own-offers', [MyOfferController::class, 'getOwnOffers']);
    Route::get('/list-offers/{list}', [MyOfferController::class, 'getListOffers']);
    Route::get('/our-offers', [MyOfferController::class, 'index'])->name('our-offers');


    // Legal requests route
    Route::controller(LegalRequestController::class)->group(function () {
        Route::get('/legal-requests', 'render')->name('legal-requests');
        Route::get('/our-legal-requests', 'index');
        Route::get('/our-legal-requests/newLegalReq', 'newLegalRequest');
        Route::put('/our-legal-requests/{id}', 'update');
        Route::post('/our-legal-requests/{legalReq}/archived', 'archived');

        Route::get('/our-legal-requests/all', 'lawyerRequest');

        // legal assign or remove
        Route::post('/our-legal-requests/assign-legal', 'assignLegal');
        Route::post('/our-legal-requests/remove-legal', 'removeAssignLegal');
    });

    // Legal request notes
    Route::controller(LegalRequestNoteController::class)
        ->prefix('/our-legal-requests')
        ->group(function () {
            Route::post('/notes', 'store');
            Route::put('/notes/{id}', 'update');
            Route::delete('/notes/{id}', 'destroy');
        });

    //Legal Admin Dashboard

    Route::controller(LegalRequestController::class)->group(function () {
        Route::get('/our-new-legal-requests', 'index');
        Route::get('/our-new-legal-requests', 'newLegalRequest');
        Route::put('/our-new-legal-requests/{id}', 'update');
        Route::post('/our-new-legal-requests/{legalReq}/archived', 'archived');

        // legal assign or remove
        Route::post('/our-new-legal-requests/assign-legal', 'assignLegal');
        Route::post('/our-new-legal-requests/remove-legal', 'removeAssignLegal');
    });

    Route::get('/legal-admin-dashboard', [DashboardController::class, 'LegalAdmin']);

    // Legal Supports Route
    Route::post('/legal/{listingIdOrOrgId}/support', LegalSupportController::class);

    Route::get('/setup', SetupController::class)->name('setup');

    Route::get('/document-management/all', [DocumentManagementController::class, 'getDocumentCollections']);
    Route::get('/download-document/{id}', [DocumentManagementController::class, 'downloadDocument']);
    Route::get('/accessDocument/{encryptedId}', [DocumentManagementController::class, 'accessDocument']);
    Route::post('/document-management/file-delete', [DocumentManagementController::class, 'deleteFile']);
    Route::apiResource('/document-management', DocumentManagementController::class);

    Route::get('/purchase-documents', [DocumentController::class, 'purchaseDocument'])->name('purchase-documents');
    Route::get('/documents/purchase', [DocumentController::class, 'getPurchaseDocuments']);

    Route::get('/documents/all', [DocumentController::class, 'getDocuments']);
    Route::get('/documents/cartItems', [DocumentController::class, 'getCartItems']);
    Route::delete('/documents/delete-cartItems/{id}', [DocumentController::class, 'destroyCartItem']);
    Route::get('/documents/store-cartItems', [DocumentController::class, 'storeCartItems']);
    Route::get('/documents/orderDetails', [DocumentController::class, 'orderDetails']);
    Route::get('/documents/getUserOrderInfo', [DocumentController::class, 'getUserOrderInfo']);
    Route::apiResource('/documents', DocumentController::class);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/all', [OrderController::class, 'getAllOrders']);
    Route::get('/invoice/{id}', [OrderController::class, 'invoice']);
    Route::get('/checkout', [OrderController::class, 'checkout']);
    Route::get('/invoicepdf', [OrderController::class, 'invoicePdf'])->name('download-invoice');;

    //Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store']);
    Route::put('/offer-update/{comms}', [OfferController::class, 'updateOfferStatus']);
    Route::put('/make-offer/{comms}', [OfferController::class, 'makeOffer']);
    Route::put('/cancel-offer/{offer}', [OfferController::class, 'cancelOffer']);
    Route::put('/update-message-seen-time/{comms}', [ChatController::class, 'updateSeenTime']);
    Route::resource('/chats', ChatController::class);
    Route::get('/unseen-message-count', [ChatController::class, 'unSeenMessageCount'])->name('unseen-message-count');
    Route::get('list/message/{list}', [MessageController::class, 'getOwnAndReplied']);
    Route::get('organization/message/{organisation}', [MessageController::class, 'getOrgOwnAndReplied']);

    // Organisation settings routes
    Route::controller(OrgSettingsController::class)
        ->prefix('/organisation')
        ->group(function () {
            Route::get('/settings', 'index')->name('org.settings');
            Route::post('/settings', 'store');
            Route::post('/upload', 'uploadLogo');
        });

    Route::get('/nfp-admin/dashboard', [OrgSettingsController::class, 'nfpDashboard']);

    // Individual settings routes
    Route::controller(IndividualController::class)
        ->prefix('/individual')
        ->group(function () {
            Route::get('/settings', 'index')->name('individual.settings');
            Route::post('/settings', 'store');
            Route::post('/upload', 'uploadLogo');
        });

    // Account/Profile Settings routes
    Route::get('/account-settings', [AccountSettingController::class, 'index'])->name('account-settings');
    Route::put('/account-settings/profile-update', [AccountSettingController::class,
                                                    'updateProfile'])->name('account-settings.profile.update');
    Route::put('/account-settings/password-update', [AccountSettingController::class,
                                                     'updatePassword'])->name('account-settings.password.update');

    Route::get('/organisations', function () {
        return view('frontend.organisation');
    })->name('org.lists');

    Route::get('/organisations/{id}', [
        \App\Http\Controllers\Organisations\IndexController::class,
        'show'
    ])->name('org.details');

    Route::get('/map-location', [LocationController::class, 'getPlaceId']);

    // user autocomplete
    Route::post('/usr/autocomplete', AutocompleteResultController::class);

//    Route::view('/app-chat', 'app-chat')->name('messages');
    Route::view('/messages', 'app-chat')->name('messages');
//    Route::view('/messages', 'messages.index');

    Route::post('/file-upload', [FileUploadController::class, 'store']);
    Route::delete('/file-upload', [FileUploadController::class, 'destroy']);
    Route::post('/file-upload-document', [FileUploadController::class, 'documentFileUpload']);
    Route::post('/upload-org-file', [FileUploadController::class, 'uploadFileBeforeCreateOrg']);

    Route::view('/charts', 'statistics');

    // Pricing
    Route::view('/pricing', 'payment.index');

    // Category routes
    Route::get('categories/all', [CategoriesController::class, 'getAllCategories'])->name('categories.all');
    Route::get('categories/select2-parent-categories', [CategoriesController::class,
                                                        'getSelect2ParentCategories'])->name('categories.select2-parent-categories');
    Route::apiResource('categories', CategoriesController::class);
});

// auth routes
require __DIR__ . '/auth.php';
