import { useQuery } from "@tanstack/react-query";
import studypaylogo from "../../../assets/images/logo.png";
import { getContactContent } from "../../../services/landing";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";

const Footer = ({ data = { data: { data: {} } } }) => {
  // const { data: contactContent } = useQuery({
  //   queryKey: ["contactContent"],
  //   queryFn: getContactContent,
  // });
  const { t } = useTranslate(landingTranslations);
  const { lang } = useSelector((state) => state.lang);

  return (
    <footer id="footer" className="footer">
      {/* <div className="footer-newsletter">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-lg-12 text-center">
              <h4>Our Newsletter</h4>
              <p>
                Tamen quem nulla quae legam multos aute sint culpa legam noster
                magna
              </p>
            </div>
            <div className="col-lg-6">
              <form action="" method="post">
                <input type="email" name="email" />
                <input type="submit" value="Subscribe" />
              </form>
            </div>
          </div>
        </div>
      </div> */}

      <div className="footer-top">
        <div className="container">
          <div className="row gy-4">
            <div className="col-lg-5 col-md-12 footer-info">
              <a href="/" className="logo d-flex align-items-center">
                <img src={studypaylogo} alt="" />

                <span className="english-font">LeaderPay</span>
              </a>
              {/* <p>
                Cras fermentum odio eu feugiat lide par naso tierra. Justo eget
                nada terra videa magna derita valies darta donna mare fermentum
                iaculis eu non diam phasellus.
              </p> */}
              <div className="social-links mt-3">
                <a
                  href="https://twitter.com/Leaderpay1"
                  target="_blank"
                  className="twitter"
                >
                  <i className="bi bi-twitter"></i>
                </a>
                <a
                  href="https://www.facebook.com/Leaderpaywallet"
                  target="_blank"
                  className="facebook"
                >
                  <i className="bi bi-facebook"></i>
                </a>
                <a href="#" className="instagram">
                  <i className="bi bi-instagram"></i>
                </a>
                <a href="#" className="linkedin">
                  <i className="bi bi-linkedin"></i>
                </a>
              </div>
            </div>

            <div className="col-lg-2 col-6 footer-links ">
              <h4>{t("usefulLinks")}</h4>
              <ul>
                <li>
                  <i className="bi bi-chevron-right"></i>{" "}
                  <a href="#hero">{t("home")}</a>
                </li>
                {/* <li>
                  <i className="bi bi-chevron-right"></i>{" "}
                  <a href="#about">{t("about")}</a>
                </li> */}
                <li>
                  <i className="bi bi-chevron-right"></i>{" "}
                  <a href="#values">{t("services")}</a>
                </li>
                <li>
                  <i className="bi bi-chevron-right"></i>
                  <a
                    href="https://dev.leaderpay.ge/pages/privacyAndSecurity"
                    target="_blank"
                  >
                    {t("privacyAndSecurity")}
                  </a>
                </li>
              </ul>
            </div>

            <div className="col-lg-3 col-md-12 footer-contact text-center text-md-start ">
              <h4>{t("contact_us")}</h4>
              <p>
                {data.data.data.address}
                <br />
                <strong>Phone:</strong>
                {data.data.data.phone}
                <br />
                <strong>Email:</strong>
                {data.data.data.email}
                <br />
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="container">
        <div className="copyright">
          &copy; Copyright{" "}
          <strong>
            <span>Devspace</span>
          </strong>
          . {t("allRightsReserved")}
        </div>
      </div>
    </footer>
  );
};

export default Footer;
