import $ from 'jquery';
window.$ = window.jQuery = $;
import 'slick-carousel';
import breakpoint from "../../../js/components/Breakpoint";


class CardsClass {
    constructor(el) {
        this.el = el;
        this.region = this.el.find('.b-Cards__region');

        this.state = {
            initialized: false,
        }
    }

    events() {
        window.onresize = () => {
            this.sliderInitControl();
        };
    }

    sliderInitControl () {
        const windowWidth = window.innerWidth;
        this.initSlider( windowWidth < breakpoint.sizes.md )
    }

    initSlider( state ) {

        if (state) {
            if (!this.state.initialized) {
                console.log(state);
                this.state.initialized = state;
                this.region.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    fade: false,
                    speed: 1000,
                    loop: false,
                    infinite: false,
                    autoplay: false,
                    adaptiveHeight: false,
                    pauseOnHover: false,
                    arrows: false,
                });

            }

        } else if (this.state.initialized) {
            console.log(state);
            this.state.initialized = state;
            this.region.slick('unslick');


        }

    }

    init() {
        this.sliderInitControl();
        this.events();
    }
}

const $Cards = $('.b-Cards');
const Cards = [];
$Cards.each((i, item) => {
    Cards[i] = new CardsClass($(item));
    Cards[i].init();
});
