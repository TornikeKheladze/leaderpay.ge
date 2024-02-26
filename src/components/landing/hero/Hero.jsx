// import { useQuery } from "@tanstack/react-query";
// import { getHeroContent } from "../../../services/landing";
// import BootstrapLoader from "../../shared/loader/BootstrapLoader";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";

const Hero = ({ data = { data: {} } }) => {
  const { t } = useTranslate(landingTranslations);
  const registerRoute = "https://dev.leaderpay.ge/register";

  return (
    <section id="hero" className="hero d-flex align-items-center">
      <div className="container">
        <div className="row">
          <div className="col-lg-6 d-flex flex-column justify-content-center">
            <h1 className="english-font" data-aos="fade-up">
              {data.data.title}
            </h1>
            <h2 data-aos="fade-up" data-aos-delay="400">
              {data.data.slogan}
            </h2>
            <div data-aos="fade-up" data-aos-delay="600">
              <div className="text-center text-lg-start">
                <a
                  href={registerRoute}
                  target="_blank"
                  className="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center"
                >
                  <span>{t("register")}</span>
                  <i className="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
          <div
            className="col-lg-6 hero-img"
            data-aos="zoom-out"
            data-aos-delay="200"
          >
            <img src={data.data.image} className="img-fluid" alt="" />
          </div>
        </div>
      </div>
    </section>
  );
};

export default Hero;
