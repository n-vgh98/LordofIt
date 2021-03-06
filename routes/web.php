<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Console\Input\Input;
use App\Http\Controllers\Front\ServicePrice;

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\AdminWorkSample;
use App\Http\Controllers\Front\CourseController;
use App\Http\Controllers\Front\AboutUsController;
use App\Http\Controllers\Front\ArticleController;
use App\Http\Controllers\Front\FrontServicePrice;
use App\Http\Controllers\Front\OurTeamController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\WorkSampleCategory;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Front\WorkSampleController;
use App\Http\Controllers\Admin\AdminFooterController;
use App\Http\Controllers\Front\FrontSearchController;
use App\Http\Controllers\Admin\AdminAboutUsController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminCoursesController;
use App\Http\Controllers\Admin\AdminOurTeamController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Front\FrontServiceController;
use App\Http\Controllers\Admin\AdminServiceSubCategory;
use App\Http\Controllers\Admin\AdminWorkSampleCategory;
use App\Http\Controllers\Front\FrontUserPanleController;
use App\Http\Controllers\Admin\AdminFooterLinkController;
use App\Http\Controllers\Admin\AdminFooterTitleController;
use App\Http\Controllers\Admin\AdminServicePriceController;
use App\Http\Controllers\Admin\AdminCoursesSliderController;
use App\Http\Controllers\Admin\AdminFooterContentController;
use App\Http\Controllers\Admin\AdminOurTeamSliderController;
use App\Http\Controllers\Admin\AdminServicecategoryController;
use App\Http\Controllers\Admin\AdminServicePriceCategoryController;
use App\Http\Controllers\Admin\AdminServicePriceSubcategoryController;
use App\Http\Controllers\Admin\AdminWorkSamplesSliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */



//front routing

route::get("/", function () {
    return redirect()->route("home");
})->middleware("language");

// route::get("/fa", function () {
//     return redirect()->back();
// })->name("fa");

// route::get("/en", function () {
//     return redirect()->back();
// })->name("en");

Route::prefix('/{locale}')->middleware("language")->group(function () {
    Auth::routes();

    route::get("/", [HomeController::class, "index"])->name("home");
    route::get("/ourteam", [OurTeamController::class, "index"])->name("front.ourteam.index");

    route::prefix("user-panel")->group(function () {
        route::get("/", [FrontUserPanleController::class, "index"])->name("front.panel.index");
        route::get("/edit", [FrontUserPanleController::class, "edit"])->name("front.panel.edit");
        route::get("/update", [FrontUserPanleController::class, "update"])->name("front.panel.update");
        route::get("/change-password", [FrontUserPanleController::class, "editpass"])->name("front.panel.edit.password");
        route::post("/change-password", [FrontUserPanleController::class, "updatepass"])->name("front.panel.update.password");

        route::prefix("work-samples-categories")->group(function () {
            route::get("/", [WorkSampleCategory::class, "index"])->name("front.project.categories");
        });
    });

    route::prefix("work-samples")->group(function () {
        route::get("/show/{id}", [WorkSampleController::class, "show"])->name("front.project.show");

        route::prefix("work-samples-categories")->group(function () {
            route::get("/", [WorkSampleCategory::class, "index"])->name("front.project.categories");
        });
    });

    route::prefix("courses")->group(function () {
        route::get("/show/{id}", [CourseController::class, "show"])->name("front.courses.show");
        route::get("/", [CourseController::class, "index"])->name("front.courses.all");
    });

    route::prefix("service_prices")->group(function () {
        route::get("/", [FrontServicePrice::class, "index"])->name("front.project.serviceprice.category");
    });
    // need more work
    route::prefix("comment")->group(function () {
        route::post("/store", [AdminCommentController::class, "store"])->name("front.project.comments.store");
    });
    // route::prefix("service")->group(function () {
    route::get("service/{slug}", [FrontServiceController::class, "index"])->name("front.services");
    // });
    route::get("about_us", [AboutUsController::class, "index"])->name("front.about_us");
    route::prefix("articles")->group(function () {
        route::get("/", [ArticleController::class, "index"])->name("front.articles.index");
        route::get("/{id}/{slug}", [ArticleController::class, "show"])->name("front.articles.show");
    });
    Route::get('/search', [FrontSearchController::class, "searchTitle"])->name('search');
});

// admin routing
route::prefix("admin")->middleware("auth", "admin")->group(function () {
    route::get("/home", [AdminDashboard::class, "index"])->name("admin.home");
    route::post("/order/{type}", [AdminDashboard::class, "order"])->name("admin.order");

    // admin can do users operation throw this routes##
    route::prefix("users")->group(function () {
        route::get("/", [AdminUserController::class, "index"])->name("admin.users");
        route::post("/store", [AdminUserController::class, "store"])->name("admin.users.store");
        route::post("/update/{id}", [AdminUserController::class, "update"])->name("admin.users.update");
        route::post("/status/block/{id}", [AdminUserController::class, "block"])->name("admin.users.block");
        route::post("/status/unblock/{id}", [AdminUserController::class, "unblock"])->name("admin.users.unblock");
        // dadane dastresi admin
        route::post("/promotetoadmin/{id}", [AdminUserController::class, "promotetoadmin"])->name("admin.promote");

        // hazfe dastresi admin
        route::post("/demoteadmin/{id}", [AdminUserController::class, "demoteadmin"])->name("admin.demote");

        // hazfe dastresi writer
        route::post("/demotewriter/{id}", [AdminUserController::class, "demotewriter"])->name("writer.demote");

        // dadane dastresi writer
        route::post("/promotetowriter/{id}", [AdminUserController::class, "promotetowriter"])->name("writer.promote");

        // hazfe tamame dastresi ha
        route::post("/clearroles/{id}", [AdminUserController::class, "clearroles"])->name("admin.user.clear.roles");

        route::delete("/destroy/{id}", [AdminUserController::class, "destroy"])->name("admin.users.destroy");
        route::prefix("normal")->group(function () {
            route::get("/", [AdminUserController::class, "normal"])->name("admin.normal.users");
        });
        route::prefix("writer")->group(function () {
            route::get("/", [AdminUserController::class, "writer"])->name("admin.writer.users");
        });
        route::prefix("admin")->group(function () {
            route::get("/", [AdminUserController::class, "admin"])->name("admin.admin.users");
        });
    });
    // ##

    //route for articles
    route::prefix("article")->group(function () {
        route::get("/{lang}", [AdminArticleController::class, "index"])->name("admin.articles.index");
        route::get("/create/{lang}", [AdminArticleController::class, "create"])->name("admin.articles.create");
        route::post("/store", [AdminArticleController::class, "store"])->name("admin.articles.store");
        route::get("/edit/{id}", [AdminArticleController::class, "edit"])->name("admin.articles.edit");
        route::patch("update/{id}", [AdminArticleController::class, "update"])->name("admin.articles.update");
        route::delete("destroy/{id}", [AdminArticleController::class, "destroy"])->name("admin.articles.destroy");
        route::post("articles/updateimage/{id}", [AdminArticleController::class, "updateimage"])->name("admin.article.update.image");
    });

    // routes for footer
    route::prefix("footer")->group(function () {
        route::get("/", [AdminFooterController::class, "index"])->name("admin.footer.index");

        // route for titles of footer
        route::prefix("titles")->group(function () {
            route::get("/{lang}", [AdminFooterTitleController::class, "index"])->name("admin.footer.titles.index");
            route::post("/unblock/{id}", [AdminFooterTitleController::class, "block"])->name("admin.footer.titles.block");
            route::post("/block/{id}", [AdminFooterTitleController::class, "unblock"])->name("admin.footer.titles.unblock");
            route::delete("/destroy/{id}", [AdminFooterTitleController::class, "destroy"])->name("admin.footer.titles.destroy");
            route::post("/update/{id}", [AdminFooterTitleController::class, "update"])->name("admin.footer.titles.update");
            route::post("/store", [AdminFooterTitleController::class, "store"])->name("admin.footer.titles.store");
        });

        // route for content of footer
        route::prefix("content")->group(function () {
            route::get("/{lang}", [AdminFooterContentController::class, "index"])->name("admin.footer.content.index");
            route::get("/show/{id}/{lang}", [AdminFooterContentController::class, "show"])->name("admin.footer.content.show");
            route::delete("/destroy/{id}", [AdminFooterContentController::class, "destroy"])->name("admin.footer.content.destroy");
            route::post("/update/{id}", [AdminFooterContentController::class, "update"])->name("admin.footer.content.update");
            route::post("/store", [AdminFooterContentController::class, "store"])->name("admin.footer.content.store");
        });

        // route for links of social media for footer
        route::prefix("links")->group(function () {
            route::get("/{lang}", [AdminFooterLinkController::class, "index"])->name("admin.footer.links.index");
            route::delete("/destroy/{id}", [AdminFooterLinkController::class, "destroy"])->name("admin.footer.links.destroy");
            route::post("/update/{id}", [AdminFooterLinkController::class, "update"])->name("admin.footer.links.update");
            route::post("/store", [AdminFooterLinkController::class, "store"])->name("admin.footer.links.store");
        });
    });

    // routes for our team
    route::prefix("ourteam")->group(function () {
        route::get("/{lang}", [AdminOurTeamController::class, "index"])->name("admin.ourteam.index");
        route::post("/store", [AdminOurTeamController::class, "store"])->name("admin.ourteam.store");
        route::post("/updateimage/{id}", [AdminOurTeamController::class, "updateimage"])->name("admin.ourteam.update.image");
        route::post("/update/{id}", [AdminOurTeamController::class, "update"])->name("admin.ourteam.update");
        route::delete("/destroy/{id}", [AdminOurTeamController::class, "destroy"])->name("admin.ourteam.destroy");
        // route for slider of ourteam page
        route::prefix("slider")->group(function () {
            route::get("/{lang}", [AdminOurTeamSliderController::class, "index"])->name("admin.ourteam.slider.index");
            route::post("/store", [AdminOurTeamSliderController::class, "store"])->name("admin.ourteam.slider.store");
            route::post("/update/{id}", [AdminOurTeamSliderController::class, "update"])->name("admin.ourteam.slider.update");
            route::delete("/destroy/{id}", [AdminOurTeamSliderController::class, "destroy"])->name("admin.ourteam.slider.destroy");
        });
    });

    // routes for courses
    route::prefix("courses")->group(function () {
        route::get("/{lang}", [AdminCoursesController::class, "index"])->name("admin.courses.index");
        route::get("/create/{lang}", [AdminCoursesController::class, "create"])->name("admin.courses.create");
        route::get("/edit/{id}", [AdminCoursesController::class, "edit"])->name("admin.courses.edit");
        route::post("/store", [AdminCoursesController::class, "store"])->name("admin.courses.store");
        route::post("/updateimage/{id}", [AdminCoursesController::class, "updateimage"])->name("admin.courses.update.image");
        route::post("/update/{id}", [AdminCoursesController::class, "update"])->name("admin.courses.update");
        route::delete("/destroy/{id}", [AdminCoursesController::class, "destroy"])->name("admin.courses.destroy");
        route::post("/update/{id}", [AdminCoursesController::class, "update"])->name("admin.courses.update");

        // route for slider of ourteam page
        route::prefix("slider")->group(function () {
            route::get("/{lang}", [AdminCoursesSliderController::class, "index"])->name("admin.courses.slider.index");
            route::post("/store", [AdminCoursesSliderController::class, "store"])->name("admin.courses.slider.store");
            route::post("/update/{id}", [AdminCoursesSliderController::class, "update"])->name("admin.courses.slider.update");
            route::delete("/destroy/{id}", [AdminCoursesSliderController::class, "destroy"])->name("admin.courses.slider.destroy");
        });
    });

    //route for about_us
    // Route::resource("about_us", AdminAboutUsController::class);
    route::prefix("about_us")->group(function () {
        route::get("/{lang}", [AdminAboutUsController::class, "index"])->name("admin.about_us.index");
        route::get("/create/{lang}", [AdminAboutUsController::class, "create"])->name("admin.about_us.create");
        route::post("/store", [AdminAboutUsController::class, "store"])->name("admin.about_us.store");
        route::get("/edit/{id}", [AdminAboutUsController::class, "edit"])->name("admin.about_us.edit");
        route::patch("update/{id}", [AdminAboutUsController::class, "update"])->name("admin.about_us.update");
        route::delete("destroy/{id}", [AdminAboutUsController::class, "destroy"])->name("admin.about_us.destroy");
        route::post("/updateimage/{id}", [AdminAboutUsController::class, "updateimage"])->name("admin.about_us.update.image");
        // route::post("about_us/updateimage/{id}", [AdminAboutUsController::class, "updateimage"])->name("admin.about_us.update.image");
    });
    //route for services
    route::prefix("services")->group(function () {
        route::get("/{lang}", [AdminServiceController::class, "index"])->name("admin.services.index");
        route::get("/create/{lang}", [AdminServiceController::class, "create"])->name("admin.services.create");
        route::post("/store", [AdminServiceController::class, "store"])->name("admin.services.store");
        route::get("/edit/{id}", [AdminServiceController::class, "edit"])->name("admin.services.edit");
        route::patch("update/{id}", [AdminServiceController::class, "update"])->name("admin.services.update");
        route::delete("destroy/{id}", [AdminServiceController::class, "destroy"])->name("admin.services.destroy");
        route::post("/updateimage/{id}", [AdminServiceController::class, "updateimage"])->name("admin.services.update.image");
        //



        //create services categories route
        route::prefix("categories")->group(function () {
            route::get("/{lang}", [AdminServiceCategoryController::class, "index"])->name("admin.services_categories.index");
            route::get("/create/{lang}", [AdminServiceCategoryController::class, "create"])->name("admin.services_categories.create");
            route::post("/store", [AdminServiceCategoryController::class, "store"])->name("admin.services_categories.store");
            route::get("/edit/{id}", [AdminServiceCategoryController::class, "edit"])->name("admin.services_categories.edit");
            route::patch("update/{id}", [AdminServiceCategoryController::class, "update"])->name("admin.services_categories.update");
            route::delete("destroy/{id}", [AdminServiceCategoryController::class, "destroy"])->name("admin.services_categories.destroy");
        });

        //create service sub categories route
        route::prefix("sub_categories")->group(function () {
            route::get("/{lang}", [AdminServiceSubCategory::class, "index"])->name("admin.services_sub_categories.index");
            route::get("/create/{lang}", [AdminServiceSubCategory::class, "create"])->name("admin.services_sub_categories.create");
            route::post("/store", [AdminServiceSubCategory::class, "store"])->name("admin.services_sub_categories.store");
            route::get("/edit/{id}", [AdminServiceSubCategory::class, "edit"])->name("admin.services_sub_categories.edit");
            route::patch("update/{id}", [AdminServiceSubCategory::class, "update"])->name("admin.services_sub_categories.update");
            route::delete("destroy/{id}", [AdminServiceSubCategory::class, "destroy"])->name("admin.services_sub_categories.destroy");
        });
    });
    //

    // routes for services prices
    route::prefix("service-prices")->group(function () {
        route::get("/create/{id}", [AdminServicePriceController::class, "create"])->name("admin.services.price.create");
        route::post("/store", [AdminServicePriceController::class, "store"])->name("admin.services.price.store");
        route::get("/edit/{id}", [AdminServicePriceController::class, "edit"])->name("admin.services.price.edit");
        route::get("/show/{id}", [AdminServicePriceController::class, "show"])->name("admin.services.price.show");
        route::post("/update/{id}", [AdminServicePriceController::class, "update"])->name("admin.services.price.update");
        route::delete("/destroy/{id}", [AdminServicePriceController::class, "destroy"])->name("admin.services.price.destroy");
        route::post("/showinmenu/{id}", [AdminServicePriceController::class, "showinenu"])->name("admin.services.price.showinenu");
        route::post("/unshow/{id}", [AdminServicePriceController::class, "unshow"])->name("admin.services.price.unshow");

        // route for service price categories
        route::prefix("service-prices-category")->group(function () {
            route::get("/{lang}", [AdminServicePriceCategoryController::class, "index"])->name("admin.services.price.category.index");
            route::get("/create/{lang}", [AdminServicePriceCategoryController::class, "create"])->name("admin.services.price.category.create");
            route::post("/store", [AdminServicePriceCategoryController::class, "store"])->name("admin.services.price.category.store");
            route::get("/edit/{id}", [AdminServicePriceCategoryController::class, "edit"])->name("admin.services.price.category.edit");
            route::post("/update/{id}", [AdminServicePriceCategoryController::class, "update"])->name("admin.services.price.category.update");
            route::delete("/destroy/{id}", [AdminServicePriceCategoryController::class, "destroy"])->name("admin.services.price.category.destroy");
        });

        // route for service price subcategories
        route::prefix("service-prices-subcategory")->group(function () {
            route::get("/", [AdminServicePriceSubcategoryController::class, "index"])->name("admin.services.price.subcategory.index");
            route::get("/create/{id}", [AdminServicePriceSubcategoryController::class, "create"])->name("admin.services.price.subcategory.create");
            route::post("/store", [AdminServicePriceSubcategoryController::class, "store"])->name("admin.services.price.subcategory.store");
            route::get("/edit/{id}", [AdminServicePriceSubcategoryController::class, "edit"])->name("admin.services.price.subcategory.edit");
            route::get("/show/{id}", [AdminServicePriceSubcategoryController::class, "show"])->name("admin.services.price.subcategory.show");
            route::post("/update/{id}", [AdminServicePriceSubcategoryController::class, "update"])->name("admin.services.price.subcategory.update");
            route::delete("/destroy/{id}", [AdminServicePriceSubcategoryController::class, "destroy"])->name("admin.services.price.subcategory.destroy");
        });
    });

    // routes for comments
    route::prefix("comments")->group(function () {
        route::get("/", [AdminCommentController::class, "index"])->name("admin.comments.index");
        route::post("/accept/{id}", [AdminCommentController::class, "accept"])->name("admin.comments.accept");
        route::post("/store", [AdminCommentController::class, "store"])->name("admin.comments.store");
        route::post("/decline/{id}", [AdminCommentController::class, "decline"])->name("admin.comments.decline");
        route::delete("/destroy/{id}", [AdminCommentController::class, "destroy"])->name("admin.comments.destroy");
    });

    // routes for services prices
    route::prefix("work_samples")->group(function () {
        route::get("/", [AdminWorkSample::class, "index"])->name("admin.work_samples.index");
        route::get("/create/{id}", [AdminWorkSample::class, "create"])->name("admin.work_samples.create");
        route::get("/edit/{id}", [AdminWorkSample::class, "edit"])->name("admin.work_samples.edit");
        route::post("/update/{id}", [AdminWorkSample::class, "update"])->name("admin.work_samples.update");
        route::post("/finished/{id}", [AdminWorkSample::class, "finished"])->name("admin.work_samples.finished");
        route::post("/inprogress/{id}", [AdminWorkSample::class, "inprogress"])->name("admin.work_samples.inprogress");
        route::post("/updateimage/{id}", [AdminWorkSample::class, "updateimage"])->name("admin.work_samples.update.image");
        route::post("/store", [AdminWorkSample::class, "store"])->name("admin.work_samples.store");
        route::delete("/destroy/{id}", [AdminWorkSample::class, "destroy"])->name("admin.work_samples.destroy");

        // route for service price categories
        route::prefix("categories")->group(function () {
            route::get("/{lang}", [AdminWorkSampleCategory::class, "index"])->name("admin.work_samples.category.index");
            route::post("/store", [AdminWorkSampleCategory::class, "store"])->name("admin.work_samples.category.store");
            route::post("/update/{id}", [AdminWorkSampleCategory::class, "update"])->name("admin.work_samples.category.update");
            route::get("/show/{id}", [AdminWorkSampleCategory::class, "show"])->name("admin.work_samples.category.show");
            route::delete("/destroy/{id}", [AdminWorkSampleCategory::class, "destroy"])->name("admin.work_samples.category.destroy");
        });

         // route for slider of work_samples page
         route::prefix("slider")->group(function () {
            route::get("/{lang}", [AdminWorkSamplesSliderController::class, "index"])->name("admin.work_samples.slider.index");
            route::post("/store", [AdminWorkSamplesSliderController::class, "store"])->name("admin.work_samples.slider.store");
            route::post("/update/{id}", [AdminWorkSamplesSliderController::class, "update"])->name("admin.work_samples.slider.update");
            route::delete("/destroy/{id}", [AdminWorkSamplesSliderController::class, "destroy"])->name("admin.work_samples.slider.destroy");
        });
    });
});
