<?php
function home_page()
{
    if (isset($_SESSION['user_id'])) {
        echo '
          <main id="user-main">

            <section id="user-banner"></section>

            <section class="movie-container-section">
                <h3 class="index">Trending movies</h3>

                <div class="movie-container">
                    <button class="slide-movie-btn-left"><i class="bi bi-arrow-left-short"></i></button>
                    <button class="slide-movie-btn-right"><i class="bi bi-arrow-right-short"></i></button>
                    <div id="movie-trending" class="movie-container-list"></div>
                </div>

            </section>

            <section class="movie-container-section">
                <h3 class="index">Top Rated</h3>

                <div class="movie-container">
                    <button class="slide-movie-btn-left"><i class="bi bi-arrow-left-short"></i></button>
                    <button class="slide-movie-btn-right"><i class="bi bi-arrow-right-short"></i></button>
                    <div id="movie-topRated" class="movie-container-list"></div>
                </div>
        
            </section>

            <section class="movie-container-section">
                <h3 class="index">Upcoming</h3>

                <div class="movie-container">
                    <button class="slide-movie-btn-left"><i class="bi bi-arrow-left-short"></i></button>
                    <button class="slide-movie-btn-right"><i class="bi bi-arrow-right-short"></i></button>
                    <div id="movie-upcoming" class="movie-container-list"></div>
                </div>
        
            </section>

          </main>
          ';
    } else {
        echo '
          <main id="welcome-main">
            <section id="banner">
                <div class="banner-info">

                    <div class="inner-banner-info">
                        <h1>MUCH MORE TO SEE</h1>
                        <h2>Plans start from <span>$19.00</span> / mes</h2>
                        <a href="' . URLPATH . 'subscribe">SUBSCRIBE NOW</a>
                    </div>

                </div>
            </section>

            <section id="trending">
                <h3 id="movieCount" class="index"></h3>

                <div id="trending-movie">
                    <button onclick="slideTrendingMovieLeft()"><i class="bi bi-arrow-left-short"></i></button>
                    <button onclick="slideTrendingMovieRight()"><i class="bi bi-arrow-right-short"></i></button>
                    <div id="trending-movie-container" class="trending-movie-container"></div>
                </div>

            </section>

            <section id="people-review">
                <h3 class="index">People review</h3>

                <div class="people-review-container">
                    <div style="--t:50s" id="people-review-container" class="inner-people-review-container"></div>
                </div>

            </section>

            <section id="chose-plan">
                <h3 class="index">Chose your plan</h3>

                <div class="chose-plan-container">

                    <div id="chose-plan-btn" class="chose-plan-btn-container">
                        <button onclick="showChosePlanM()" id="showChosePlanM">monthly</button>
                        <button onclick="showChosePlanY()" id="showChosePlanY">yearly</button>
                    </div>

                    <div class="inner-chose-plan-container">

                        <!--  -->
                        <div class="inner-chose-plan-container-info">

                        <h3>Basic with Ads</h3>

                        <ul>
                            <li>2 devices at once</li>
                            <li>Full HD resolution</li>
                        </ul>

                        <div class="chose-plan-price-container">
                            <h4 id="planPriceBasic"></h4>
                            <a href="#">CHOOSE THIS PLAN</a>
                        </div>

                    </div>

                    <div class="inner-chose-plan-container-info">

                        <h3>Standard</h3>

                        <ul>
                            <li>2 devices at once</li>
                            <li>Full HD resolution</li>
                            <li>30 downloads to enjoy offline</li>
                        </ul>

                        <div class="chose-plan-price-container">
                            <h4 id="planPriceStandar"></h4>
                            <a href="#">CHOOSE THIS PLAN</a>
                        </div>

                    </div>

                    <div class="inner-chose-plan-container-info">

                        <h3>Platinum</h3>

                        <ul>
                            <li>4 devices at once</li>
                            <li>4K Ultra HD resolution*</li>
                            <li>Dolby Atmos Audio*</li>
                            <li>100 downloads to enjoy offline</li>
                        </ul>

                        <div class="chose-plan-price-container">
                            <h4 id="planPricePlatino"></h4>
                            <a href="#">CHOOSE THIS PLAN</a>
                        </div>

                    </div>
                        <!--  -->

                    </div>

                </div>
            </section>
        </main>
          ';
    }
}

home_page();