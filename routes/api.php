<?php

use App\Http\Controllers\V1\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\V1\Api\Auth\LoginController;
use App\Http\Controllers\V1\Api\Auth\LogoutController;
use App\Http\Controllers\V1\Api\Auth\RegisterController;
use App\Http\Controllers\V1\Api\Auth\ResetPasswordController;
use App\Http\Controllers\V1\Api\Auth\UpdateAccountPasswordController;
use App\Http\Controllers\V1\Api\Auth\UserController;
use App\Http\Controllers\V1\Api\Auth\VerificationController;
use App\Http\Controllers\V1\Api\FeaturedToursController;
use App\Http\Controllers\V1\Api\Guide\BookingDetailController;
use App\Http\Controllers\V1\Api\Guide\BookingListingController;
use App\Http\Controllers\V1\Api\Guide\CreateTourController;
use App\Http\Controllers\V1\Api\Guide\DashboardController;
use App\Http\Controllers\V1\Api\Guide\RegistrationController;
use App\Http\Controllers\V1\Api\Guide\TourListingController;
use App\Http\Controllers\V1\Api\Guide\UpdateTourController;
use App\Http\Controllers\V1\Api\GuideDetailsController;
use App\Http\Controllers\V1\Api\GuideSearchController;
use App\Http\Controllers\V1\Api\Messaging\MessagesController;
use App\Http\Controllers\V1\Api\Messaging\ThreadController;
use App\Http\Controllers\V1\Api\Protected\AddReviewController;
use App\Http\Controllers\V1\Api\Protected\AddToWishlistController;
use App\Http\Controllers\V1\Api\Protected\RemoveFromWishlistController;
use App\Http\Controllers\V1\Api\Protected\WishlistController;
use App\Http\Controllers\V1\Api\SearchTourController;
use App\Http\Controllers\V1\Api\Stripe\PaymentController;
use App\Http\Controllers\V1\Api\SubmitContactController;
use App\Http\Controllers\V1\Api\TourCategoryController;
use App\Http\Controllers\V1\Api\TourDetailController;
use App\Http\Controllers\V1\Api\Traveler\RegistrationController as TravelerRegistration;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth routes
    Route::prefix('auth')->name('auth.')->group(function () {

        // Guest auth routes
        Route::middleware('guest')->group(function () {
            Route::post('login',LoginController::class)->name('login');
            Route::post('register', RegisterController::class)->name('register');
            Route::post('email/send-verification', [VerificationController::class, 'sendVerificationMail'])
                ->name('verification.send');
            Route::post('verify', [VerificationController::class, 'verifyUser'])->name('verify.user');
            Route::post('forgot-password', ForgotPasswordController::class)->name('forgot.password');
        });

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user',UserController::class)->name('user');
            Route::get('logout',LogoutController::class)->name('logout');
            Route::put('reset-password',ResetPasswordController::class)->name('reset.password');
            Route::post('update-password', UpdateAccountPasswordController::class)->name('update.password');
        });

    });

    // Guide routes
    Route::prefix('guides')->name('guides.')->group(function () {

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('register', RegistrationController::class)->name('register');
            Route::get('dashboard', DashboardController::class)->name('dashboard');
            Route::get('bookings', BookingListingController::class)->name('bookings');
            Route::get('bookings/{booking}', BookingDetailController::class)->name('bookings.detail');
            Route::prefix('tours')->name('tours.')->group(function (){
                Route::get('/', TourListingController::class )->name('listing');
                Route::post('create', CreateTourController::class )->name('create');
                Route::post('update/{tour}', UpdateTourController::class )->name('update');
            });
        });

        Route::get('search', GuideSearchController::class)->name('search');
        Route::get('/{guide}', GuideDetailsController::class)->name('detail');

    });

    // Traveler routes
    Route::prefix('travelers')->name('travelers.')->group(function () {

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('register', TravelerRegistration::class)->name('register');
        });

    });

    // Protected Route
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('wishlist', WishlistController::class)->name('wishlist');
        Route::get('wishlist/{tour}', AddToWishlistController::class)->name('wishlist.add');
        Route::delete('wishlist/{tour}', RemoveFromWishlistController::class)->name('wishlist.remove');

        // Review Routes
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::post('/', AddReviewController::class)->name('add');
        });

        // Payments Route
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/{payment}', [PaymentController::class, 'getPayment'])->name('get');
            Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])
                ->name('create.intent');
            Route::get('confirm/{paymentId}', [PaymentController::class, 'confirmPayment'])->name('confirm');
        });

        // Messaging Routes
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::post('/threads', [ThreadController::class, 'createThread'])->name('threads');
            Route::get('/threads/{userId}', [ThreadController::class, 'fetchUserThreads'])
                ->name('threads.fetch');
            Route::post('/send', [MessagesController::class, 'sendMessage'])->name('send');
            Route::get('/list/{threadId}', [MessagesController::class, 'fetchMessages'])->name('list');
        });
    });

    // Guest Routes
    Route::prefix('/')->group(function () {
        Route::get('tour-categories', [TourCategoryController::class, 'index'])->name('tour_categories.index');
        Route::get('tour-categories/{slug}', [TourCategoryController::class, 'getCategory'])->name('tour_categories.single');
        Route::get('featured-tours', FeaturedToursController::class)->name('tours.featured');
        Route::get('search-tours', SearchTourController::class)->name('tours.search');
        Route::get('tours/get/{tour}', TourDetailController::class)->name('tours.detail');
        Route::get('tours/{tour:slug}', TourDetailController::class)->name('tours.detail.slug');
        Route::post('contact-submit', SubmitContactController::class)->name('contact.submit');
    });

});
