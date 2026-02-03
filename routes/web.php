<?php

use App\Models\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Middleware\CheckStreamSubscription;
use App\Http\Controllers\Admin\FixtureController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UploadsTinyImages;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\Admin\StreamTypeController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\MemberExportController;
use App\Http\Controllers\Admin\ReportIncomeController;
use App\Http\Controllers\Admin\MembershipTypeController;
use App\Http\Controllers\Admin\StreamMembershipController;
use App\Http\Controllers\Admin\MembershipVerificationController;
use App\Http\Controllers\Admin\MerchandiseController;
use App\Http\Controllers\Member\FixtureController as MemberFixtureController;
use App\Http\Controllers\Member\PaymentController as MemberPaymentController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\SettingController as MemberSettingController;
use App\Http\Controllers\Member\ExtensionController as MemberExtensionController;
use App\Http\Controllers\Member\AnnouncementController as MemberAnnouncementController;
use App\Http\Controllers\Member\StreamMembershipController as MemberStreamMembershipController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

//route API

Route::get('/getMemberAktif',[MemberController::class, 'getOnlyActiveMember']);

//Route public
Route::group([], function () {
    //index Login Check
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    //login dan register
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'submitForm'])->name('register.submit');
    
    Route::get('/verifikasi', function () {
        return view('auth.manual-verify');
    })->name('manual.verify');
    
    //lupa Password
    Route::get('/forgot-password', function() {
        return view('auth.forgot-password');
    })->name('forgot.password.form');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('reset.password.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('reset.password.form');
    Route::post('/verify-token', [AuthController::class, 'verifyToken'])->name('verify.token');
    
    //verify
    Route::get('/verify', function (Request $request) {
        $token = $request->query('token');
        $verify = Verify::where('token', $token)->first();
    
        if (!$verify) {
            return redirect()->route('login')->withErrors(['Token tidak valid.']);
        }
    
        $verify->verify = 1;
        $verify->save();
    
        return redirect()->route('login')->with('success', 'Akun Anda berhasil diverifikasi. Silakan login.');
    });
    
    Route::post('/verifikasi', function (Request $request) {
        $request->validate(['token' => 'required']);
    
        $verify = \App\Models\Verify::where('token', $request->token)->first();
    
        if (!$verify) {
            return back()->withErrors(['Token tidak ditemukan.']);
        }
    
        $verify->verify = 1;
        $verify->save();
    
        return redirect()->route('login')->with('success', 'Akun Anda berhasil diverifikasi, Silahkan Login !');
    });
    
    //route resend token
    Route::post('/resend-token', [\App\Http\Controllers\AuthController::class, 'resendToken']);
    
    //route download
    Route::get('/download',[DownloadController::class, 'index'])->name('download');
    
});

//super_admin
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    
    //delete member
    Route::delete('/members/{member}/destroy', [MemberController::class, 'destroy'])->name('members.destroy');
    
    //tipe member resource
    Route::resource('membership-types', MembershipTypeController::class);

    // BANK Resource
    Route::resource('/banks', BankController::class);

    // PEMBAYARAN
    Route::prefix('payments')->group(function () {
        Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    });

    //manajemen user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{id}/update-email', [UserController::class, 'updateEmail'])->name('users.update-email');

    //manajemen pengaturan app
    Route::post('/settings/update', [SettingController::class, 'updateSettings'])->name('settings.update');

    //manajemen jadwal pertandingan
    Route::resource('fixtures', FixtureController::class);
    Route::resource('clubs', ClubController::class);

    //manajemen stream membership
    Route::get('stream-membership/{id}/perpanjang', [StreamMembershipController::class, 'showPerpanjang'])->name('stream.perpanjang');
    Route::post('stream-membership/{id}/perpanjang', [StreamMembershipController::class, 'submitPerpanjang'])->name('stream.perpanjang.submit');

    //stram type
    Route::resource('stream-type', StreamTypeController::class);


});

//admin dan super admin routes
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     //Member management routes
    Route::resource('members', MemberController::class)->only(['index']);
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    Route::get('/members/export/pdf', [MemberExportController::class, 'exportPdf'])->name('members.export.pdf');
    Route::get('/members/export/excel', [MemberExportController::class, 'exportExcel'])->name('members.export.excel');
    Route::get('/verifikasi-membership', [MembershipVerificationController::class, 'index'])->name('verify-membership.index');
    Route::post('/verifikasi-membership/update/{id}', [MembershipVerificationController::class, 'update'])->name('verify-membership.update');

    // PEMBAYARAN
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/{id}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/{id}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    });
    
    //extension
    Route::get('/extension', [ExtensionController::class, 'index'])->name('extension.index');
    Route::get('/extensions/{id}/renew', [ExtensionController::class, 'renew'])->name('extensions.renew');
    Route::post('/extensions/{id}/renew', [ExtensionController::class, 'processRenew'])->name('extensions.processRenew');
    
    // Merchandise management routes
    Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
    Route::post('/merchandise', [MerchandiseController::class, 'store'])->name('merchandise.store');
    Route::put('/merchandise/{id}', [MerchandiseController::class, 'update'])->name('merchandise.update');
    Route::delete('/merchandise/{id}', [MerchandiseController::class, 'destroy'])->name('merchandise.destroy');

    //Laporan Membership
    Route::get('/reports/membership', [ReportController::class, 'membershipReport']);
    Route::post('/reports/membership/generate', [ReportController::class, 'generateMembershipReport']);
    Route::get('/reports/membership/export/pdf', [ReportController::class, 'exportMembershipPdf']);
    Route::get('/reports/membership/export/excel', [ReportController::class, 'exportMembershipExcel']);

    Route::get('/reports/income', [ReportIncomeController::class, 'index'])->name('report.income');
    Route::get('/reports/income/pdf', [ReportIncomeController::class, 'exportPdf'])->name('report.income.pdf');

    Route::resource('announcement', AnnouncementController::class)->middleware('auth');
    Route::post('/upload-image', [AnnouncementController::class, 'uploadImage']);

    //manajemen stream membership
    Route::resource('stream-membership', StreamMembershipController::class)->only(['index', 'edit', 'update']);

    //manajemen pengaturan app
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings/change-password', [SettingController::class, 'changePassword'])->name('settings.change-password');
    
    //fixtures
    //Route::get('/fixtures',[FixtureController::class, 'index'])->name('fixtures.index');
    //Route::get('/fixtures',[FixtureController::class, 'show'])->name('fixtures.show');
    Route::resource('fixtures', FixtureController::class)->only(['index','show']);

});

Route::middleware(['auth', 'role:member'])->prefix('member')->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    // Pengumuman Member
    Route::get('/pengumuman', [MemberAnnouncementController::class, 'index'])->name('member.announcements');
    Route::get('/pengumuman/{id}', [MemberAnnouncementController::class, 'show'])->name('member.announcements.show');

    // Profil Member
    Route::get('/profil', [MemberProfileController::class, 'index'])->name('member.profile');
    Route::get('/profil/edit', [MemberProfileController::class, 'edit'])->name('member.profile.edit');
    Route::post('/profil/update', [MemberProfileController::class, 'update'])->name('member.profile.update');
    Route::get('/profil/kartu', [MemberProfileController::class, 'downloadCard'])->name('member.profile.card');
    Route::get('/profil/preview-card', [MemberProfileController::class, 'previewCard'])->name('member.profile.card-preview');

    // Extension (Perpanjangan Membership)
    Route::get('/extension', [MemberExtensionController::class, 'index'])->name('member.extension');
    Route::get('/extension/form', [MemberExtensionController::class, 'create'])->name('member.extension.form');
    Route::post('/extension/submit', [MemberExtensionController::class, 'store'])->name('member.extension.submit');

    // Pembayaran Member
    Route::get('/payment/history', [MemberPaymentController::class, 'history'])->name('member.payment.history');
    Route::get('/payment/form/{id}', [MemberPaymentController::class, 'create'])->name('member.payment.form');
    Route::post('/payment/submit', [MemberPaymentController::class, 'store'])->name('member.payment.submit');
    Route::delete('/payment/{id}', [MemberPaymentController::class, 'destroy'])->name('member.payment.destroy');

    Route::prefix('/fixtures')->middleware(CheckStreamSubscription::class)->group(function () {
        Route::get('/fixtures', [MemberFixtureController::class, 'index'])->name('member.fixtures');
        Route::get('/fixtures/{id}', [MemberFixtureController::class, 'show'])->name('member.fixtures.show');
    });

    Route::prefix('/stream')->group(function () {
        Route::get('/', [MemberStreamMembershipController::class, 'index'])->name('member.stream');
        Route::get('/subscribe', [MemberStreamMembershipController::class, 'subscribe'])->name('member.stream.subscribe');
        Route::post('/subscribe', [MemberStreamMembershipController::class, 'store'])->name('member.stream.subscribe.store');
    });

    Route::get('/setting', [MemberSettingController::class, 'index'])->name('member.setting');
    Route::post('/setting', [MemberSettingController::class, 'store'])->name('member.setting.store');


});

