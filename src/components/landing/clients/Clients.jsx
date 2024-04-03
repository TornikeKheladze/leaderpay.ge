import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";

const Clients = ({ data = { data: [{ lang: {} }] } }) => {
  var settings = {
    dots: false,
    arrows: false,
    infinite: true,
    // speed: 500,
    slidesToShow: 6,
    slidesToScroll: 1,
    initialSlide: 0,
    autoplay: true,
    speed: 4000,
    autoplaySpeed: 2000,
    cssEase: "linear",
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true,
          speed: 8000,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          initialSlide: 2,
          speed: 8000,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          speed: 8000,
        },
      },
    ],
  };
  const { t } = useTranslate(landingTranslations);
  return (
    <section id="clients" className="clients">
      <div className="container" data-aos="fade-up">
        <header className="section-header">
          <h2>{t("ourPartners")}</h2>
          {/* <p>Temporibus omnis officia</p> */}
        </header>

        <div className="clients-slider swiper">
          <div className="swiper-wrapper align-items-center">
            <Slider {...settings}>
              {data.data.map((item) => {
                return (
                  <div
                    key={item.image + Math.random()}
                    className="swiper-slide"
                  >
                    <img src={item.image} className="img-fluid" alt="" />
                  </div>
                );
              })}
            </Slider>
          </div>
          {/* <div className="swiper-pagination"></div> */}
        </div>
      </div>
    </section>
  );
};

export default Clients;
