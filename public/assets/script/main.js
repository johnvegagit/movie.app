// Import data.js,
import { peopleReviewData } from "./data.js";
import { loadMovie, loadToRatedMovie, loadUpcomingMovie, loadTrendingMovie } from "./tmdb.js";
import { bannerData } from "./data.js";

// Load api from tmdb.js
loadMovie();
loadToRatedMovie();
loadUpcomingMovie();
loadTrendingMovie();


// Onclick show user password...
const showPwds = document.querySelectorAll('.showPwdBtn');
showPwds.forEach(showPwd => {
    showPwd.addEventListener('click', ()=>{
        const input = showPwd.parentElement.querySelector('.form-input-pwd');
        if (input.type === "password") {
            input.type = "text";
            input.nextElementSibling.innerHTML = '<i class="bi bi-eye"></i>';
        } else {
            input.type = "password";
            input.nextElementSibling.innerHTML = '<i class="bi bi-eye-slash"></i>';
        }
    });
});

// Remove error message.
const msgs = document.querySelectorAll('.msg-dng');
msgs.forEach((msg, index) => {
    setTimeout(() => {
        msg.style.display = 'none';
    }, (index + 1) * 3000);
});

// Remove header message.
const headerMsgs = document.querySelectorAll('.h-span-msg');
headerMsgs.forEach((headerMsg, index) => {
    setTimeout(() => {
        headerMsg.style.display = 'none';
    }, (index + 1) * 10000);
});

// Onclick function to scroll trending movie section.
let trendingMovieContainer = document.querySelector('.trending-movie-container');
if (trendingMovieContainer !== null) {
    let scrollValue = 250;
    let countScrollValue = scrollValue;

    function slideTrendingMovieLeft() {
        trendingMovieContainer.scrollBy({ left: -scrollValue, behavior: 'smooth' });
    }
    function slideTrendingMovieRight() {
        trendingMovieContainer.scrollBy({ left: scrollValue, behavior: 'smooth' });
    }

    window.slideTrendingMovieLeft = slideTrendingMovieLeft;
    window.slideTrendingMovieRight = slideTrendingMovieRight;

    setInterval(() => {
        let countScrollValueResult = countScrollValue += scrollValue;
        if (countScrollValueResult <= trendingMovieContainer.scrollWidth) {
            slideTrendingMovieRight();
        } else {
            trendingMovieContainer.scrollBy({ left: -trendingMovieContainer.scrollWidth, behavior: 'smooth' });
            countScrollValue = scrollValue;
        }

    }, 2000);
}

let scrollValue = 250;
const slideMovieBtns = document.getElementById('user-main');
if (slideMovieBtns !== null) {
    slideMovieBtns.addEventListener('click', (e)=>{
        e.preventDefault();
        if (e.target.tagName === 'BUTTON' && e.target.className === 'slide-movie-btn-right') {
            let movieContainerList = e.target.parentElement;
            let movieContainer = movieContainerList.querySelector('.movie-container-list');
            movieContainer.scrollBy({ left: scrollValue, behavior: 'smooth' });
        }
    
        if (e.target.tagName === 'BUTTON' && e.target.className === 'slide-movie-btn-left') {
            let movieContainerList = e.target.parentElement;
            let movieContainer = movieContainerList.querySelector('.movie-container-list');
            movieContainer.scrollBy({ left: -scrollValue, behavior: 'smooth' });
        }
    });
}

// peopleReviewData is imported from data.js.
let htmlData = '';
let insertHtmlData = document.getElementById('people-review-container');
const datas = peopleReviewData.slice(0, 15);
for (let i = 0; i < datas.length; i++) {
    const data = datas[i];

    htmlData += `
        <div class="people-review">
            <div class="people-review-profile">
                <img width="75" src="${data.imgUrl}" alt="" srcset="">
                <span class="">${data.name}</span>
            </div>
            <p>${data.review}</p>
            <div class="people-review-stars">${data.star}</div>
        </div>
    `;

}
if (insertHtmlData !== null) {insertHtmlData.innerHTML = htmlData;}

// Movie banner.
let movieBanner = '';
let insertHtmlDataBanner = document.getElementById('user-banner');
for (let i = 0; i < bannerData.length; i++) {
    const data = bannerData[i];
    movieBanner += `
    <div class="inner-user-banner">
        <img src="${data.img}">
        <div class="inner-user-banner-info" >
            <h2>${data.title}</h2>
            <p>${data.description}</p>
            <a href="view">View movie</a>
        </div>
    </div>`;
}
if (insertHtmlDataBanner !== null) {insertHtmlDataBanner.innerHTML = movieBanner;}

// Chose your paln functions.
function showChosePlanM() {
    if (document.getElementById('showChosePlanM') !== null) {
        document.getElementById('showChosePlanM').classList.add('active-chose-btn');
        document.getElementById('showChosePlanY').classList.remove('active-chose-btn');
    
        // Add month plan data.
        document.getElementById('planPriceBasic').innerText = '$9.00/month';
        document.getElementById('planPriceStandar').innerText = '$18.00/month';
        document.getElementById('planPricePlatino').innerText = '$23.00/month';
    }
}
showChosePlanM();

function showChosePlanY() {
    document.getElementById('showChosePlanM').classList.remove('active-chose-btn');
    document.getElementById('showChosePlanY').classList.add('active-chose-btn');

    // Add year plan data.
    document.getElementById('planPriceBasic').innerText = '$108.00/year';
    document.getElementById('planPriceStandar').innerText = '$216.00/year';
    document.getElementById('planPricePlatino').innerText = '$276.00/year';
}

window.showChosePlanM = showChosePlanM;
window.showChosePlanY = showChosePlanY;

// Header movie slide...
let slideIndex = 0;
slideBannerImg();

function slideBannerImg() {
    let slideContainer = document.getElementById('user-banner');
    if (slideContainer !== null) {
        
        let slides = slideContainer.querySelectorAll('.inner-user-banner');
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }

        slideIndex++;
        if (slideIndex > slides.length) { slideIndex = 1}
        slides[slideIndex-1].style.display = 'block';
        setTimeout(slideBannerImg, 10000);
    }
}
