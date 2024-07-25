<main id="welcome-main">

    <div id="choose-your-plan">

        <div class="header-info">
            <h2>Choose your plan</h2>
            <p>Enjoy iconic movies, novel originals, and family favorites.</p>
        </div>

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

        <div class="chose-plan-dis">
            <p>
                *Full HD, 4K Ultra HD, and Dolby Atmos are not available on all content on each plan. Live content on
                the
                Standard and Platinum plans may contain advertising. Downloads may be limited according to the type of
                content. For more information, visit <a href="#">help.moovie.com/plans</a>
            </p>
        </div>

    </div>

</main>

<script>
    function showChosePlanM() {
        document.getElementById('showChosePlanM').classList.add('active-chose-btn');
        document.getElementById('showChosePlanY').classList.remove('active-chose-btn');

        //
        document.getElementById('planPriceBasic').innerText = 'C$169.00/mes';
        document.getElementById('planPriceStandar').innerText = 'C$219.00/mes';
        document.getElementById('planPricePlatino').innerText = 'C$269.00/mes';
    }
    showChosePlanM();
</script>