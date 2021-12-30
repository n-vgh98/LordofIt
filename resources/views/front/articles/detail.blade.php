@extends('front.layouts.master')
@section('main')

    <!-- {{-- <form class="main-form" action="">

    <input type="text" name="" id="" placeholder="دنبال چی میگردی؟">
    <button type="submit">
        <i class="fa fa-search">
        </i>
    </button>
</form> --}} -->



            <form class="main-form" action="">
                <input type="text" name="" id="" placeholder="دنبال چی میگردی؟">
                <button type="submit">
                    <i class="fa fa-search">
                    </i>
                </button>
            </form> 
            
            <!-- breadcrumb -->
            <section class="breadcrumb-section">
                <ul id="breadcrumbs">
                    <li><a href="#">خانه</a></li>
                    <li><a href="#">آموزش</a></li>
                    <li><a href="#">مقالات</a></li>
                </ul>
            </section>
             <h1 class="main-title-h1"> {{$article->title}} </h1>
            <article class="article-wrapper-content">
                <section class="right-article-wrapper ">
                    
                    <div class="article-img-wrapper">
                        <figure>
                            <img src="{{asset($article->image->path)}}" alt="{{$article->image->alt}}" title="{{$article->image->name}}">
                        </figure>
                    </div>

                    <section class="article-text-wrapper">
                        <div>
                            {!! $article->text_1 !!}
                        </div>
                        <div class="video-1 article-video">
                            {{$article->v_link_1}}
                        </div>
                        <div>
                        {!! $article->text_2 !!}
                        </div>
                        <div class="video-1 article-video">
                            {{$article->v_link_2}}
                        </div>
                        <div>
                        {!! $article->text_3 !!}
                        </div>
                        <div class="video-1 article-video">
                            {{$article->v_link_3}}
                        </div>
                        <div>
                        {!! $article->text_4 !!}
                        </div>
                        <div class="video-1 article-video">
                            {{$article->v_link_4}}
                        </div>

                        <!-- <div class="article-page-wiriter">
                            <p><span>نویسنده:</span> امید فتاحی</p>
                        </div> -->
                    </section>
                </section>

                <section class="left-article-wrapper">
                    <section class="article-input-wrapper">
                        <form class="article-input-group" role="search">
                            <input type="text" placeholder="جستجو ...">
                            <span>
                                <i class="fa fa-search"></i>
                            </span>
                        </form>
                        <div class="article-category">
                            <h4>آخرین مقالات</h4>
                            <div class="article-category-list">
                                <div>
                                    <i class="fa fa-chevron-left "></i>
                                    <span>طراحی سایت</span>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-left "></i>
                                    <span> کسب و کار دیجیتال</span>
                                </div>
                            </div>
                        </div>
                        <div class="article-category">
                            <h4>مقالات مشابه</h4>
                            <div class="article-category-list">
                                <div>
                                    <i class="fa fa-chevron-left "></i>
                                    <span>طراحی سایت</span>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-left "></i>
                                    <span> کسب و کار دیجیتال</span>
                                </div>
                                <div>
                                    <i class="fa fa-chevron-left "></i>
                                    <span> کسب و کار دیجیتال</span>
                                </div>
                            </div>
                        </div>
                        <div class="article-adds">
                            <span class="article-adds-close">
                                <i class="fas fa-times"></i>
                            </span>
                            <h4>تبلیغات</h4>
                            <div class="article-content">
                                <div class="article-content-adds">
                                    <img src="imgs/1629958522www.tahkimghias.comانتقال مال به غیر.jpg" alt="">
                                    <p>عنوان دوره : دوره گرافیک</p>
                                    <span class="article-img-caption">دوره ی آموزش طراحی UI/UX توسعه گران جهان رایانه،
                                        طی 7 جلسه، فراگیر را با طراحی UI/UX آشنا می کند.</span>
                                </div>
                                <div class="article-content-adds">
                                    <img src="imgs/1629958522www.tahkimghias.comانتقال مال به غیر.jpg" alt="">
                                    <p class="article-content-head">عنوان دوره : دوره گرافیک</p>
                                    <span class="article-img-caption">دوره ی آموزش طراحی UI/UX توسعه گران جهان رایانه،
                                        طی 7 جلسه، فراگیر را با طراحی UI/UX آشنا می کند.</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </article>
            <div class="title title-comments">
                <p>نظرات کاربران </p>
            </div>
            <section class="comments">
                <!-- row one comment -->
                <div class="row">
                    <img src="imgs/photo-profile.jpg" alt="profile-photo">
                    <div class="text-comments">
                        بنظرم محتوای خیلی خوبی داشت
                    </div>

                    <div class="parent-amozesh-btn cm-btn">
                        <form action="">
                            <button class="amozesh-btn cm-btn" type="submit">
                                <span>پاسخ</span>
                            </button>
                        </form>

                    </div>
                </div>
                <!-- row two comment-->
                <div class="row">
                    <img src="imgs/photo-profile-2.jpg" alt="profile-photo">
                    <div class="text-comments">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها
                        و متون بلکه روزنامه
                        و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با
                        هدف
                        بهبود ابزارهای
                        کاربردی می باشد.
                    </div>
                    <div class="parent-amozesh-btn cm-btn">
                        <form action="">
                            <button class="amozesh-btn cm-btn" type="submit">
                                <span>پاسخ</span>
                            </button>
                        </form>
                    </div>
                </div>


            </section>
            <section class="pagination-wrapper">
                <ul class="pagination">
                    <li class="page-item">
                        <a href="#" class="pagination-arrow" id="arrowRight-course-btns-pages"><i
                                class="fas fa-arrow-right"></i></a>
                    </li>
                    <li class="page-item">
                        <a href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="active">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="pagination-arrow" id="arrowLeft-course-btns-pages"><i
                                class="fas fa-arrow-left"></i></a>
                    </li>
                </ul>
            </section>



            <div class="parenet-didgah">
                <div class="row-one-didgah">
                    <p>دیدگاه شما...</p>
                    <form>
                        <textarea type="text" name="didgah" class="textare-didgah"></textarea>
                    </form>
                </div>
                <div class="row-two-didgah">

                    <form action="">
                        <input type="text" name="" id="" placeholder="نام خانوادگی">
                        <input type="mail" name="" id="" placeholder="ایمیل">
                        <button class="amozesh-btn cm-btn didgah">
                            <span>ارسال</span>
                        </button>
                    </form>
                </div>


            </div>
