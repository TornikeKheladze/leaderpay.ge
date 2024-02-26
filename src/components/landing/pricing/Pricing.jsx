import { useQuery } from "@tanstack/react-query";
import { getPricingContent } from "../../../services/landing";
import BootstrapLoader from "../../shared/loader/BootstrapLoader";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";

const Pricing = () => {
  const { t } = useTranslate(landingTranslations);
  const { lang } = useSelector((state) => state.lang);
  const { data: pricingContent, isLoading } = useQuery({
    queryKey: ["pricingContent"],
    queryFn: getPricingContent,
  });
  return (
    <section id="pricing" className="pricing">
      <div className="container" data-aos="fade-up">
        <header className="section-header">
          <h2>{t("pricing")}</h2>
          <p>{t("check_our_pricing")}</p>
        </header>

        <div
          className="row gy-3 gap-5 mx-auto justify-content-center ri"
          data-aos="fade-left"
        >
          {pricingContent?.data?.map((item, index) => (
            <div
              key={item.id}
              className="col-lg-3 col-md-6"
              data-aos="zoom-in"
              data-aos-delay="200"
            >
              <div className="box ">
                {/* <span className="featured">Featured</span> */}
                <h3 style={{ color: "#65c600" }}>
                  {item ? item[`title_${lang}`] : ""}
                </h3>
                <div className="price">
                  <sup>₾</sup>
                  {item.price_gel}
                  <span> / mo</span>
                </div>
                <img
                  src={
                    index < 3
                      ? `assets/img/pricing-${index}.png`
                      : `assets/img/pricing-0.png`
                  }
                  className="img-fluid"
                  alt="priceimg"
                />
                <ul>
                  {isLoading ? (
                    <BootstrapLoader />
                  ) : (
                    item[`features_${lang}`]?.map((ft, index) => (
                      <li key={index}>{ft}</li>
                    ))
                  )}
                </ul>
                <a href="#" className="btn-buy">
                  {t("buyNow")}
                </a>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Pricing;
