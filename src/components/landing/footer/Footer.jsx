import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";
import playStore from "../../../assets/images/play_store.png";
import appStore from "../../../assets/images/app_store.png";
import FooterLPLogo from "../../../assets/icons/FooterLPLogo";
import LinkedinLogo from "../../../assets/icons/LinkedinLogo";
import FacebookIcon from "../../../assets/icons/FacebookIcon";
import TwitterLogo from "../../../assets/icons/TwitterLogo";
import InstagramLogo from "../../../assets/icons/InstagramLogo";
import CopyRignt from "../../../assets/icons/CopyRignt";

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
          <div className="gy-4 footer-container">
            <div className="footer-info">
              <a href="/" className="logo d-flex align-items-center">
                <FooterLPLogo />
              </a>
              {/* <p>
                Cras fermentum odio eu feugiat lide par naso tierra. Justo eget
                nada terra videa magna derita valies darta donna mare fermentum
                iaculis eu non diam phasellus.
              </p> */}

              <div className="mt-3 store-links">
                <a
                  href="https://play.google.com/store/apps/details?id=com.leader.pay.wallet"
                  target="_blank"
                >
                  <img className="" src={playStore} />
                </a>
                <a
                  href="https://apps.apple.com/ge/app/leader-pay/id6478852590"
                  target="_blank"
                >
                  <img className="" src={appStore} />
                </a>
              </div>
            </div>

            <div className="col-lg-2 col-6 footer-links ">
              <h4>{t("usefulLinks")}</h4>
              <ul>
                <li>
                  <a href="#hero">{t("home")}</a>
                </li>
                {/* <li>
                  <i className="bi bi-chevron-right"></i>{" "}
                  <a href="#about">{t("about")}</a>
                </li> */}
                <li>
                  <a href="#values">{t("services")}</a>
                </li>
                <li>
                  <a
                    href="https://wallet.leaderpay.ge/pages/agreements"
                    target="_blank"
                  >
                    {t("termsAndConditions")}
                  </a>
                </li>
              </ul>
            </div>

            <div className="footer-contact ">
              <h4>{t("contact_us")}</h4>
              <p className="contact-infos">
                <span>{data.data.data.address}</span>
                <span>
                  <strong>Phone:</strong>
                  {data.data.data.phone}
                </span>
                <span>
                  <strong>Email:</strong>
                  {data.data.data.email}
                </span>
              </p>
            </div>
            <div className="footer-social ">
              <p>{t("follow_us")}</p>
              <div className="social-links">
                <a
                  href="https://twitter.com/Leaderpay1"
                  target="_blank"
                  className="twitter"
                >
                  <TwitterLogo />
                </a>
                <a
                  href="https://www.facebook.com/Leaderpaywallet"
                  target="_blank"
                  className="facebook"
                >
                  <FacebookIcon />
                </a>
                <a href="#" className="instagram">
                  <InstagramLogo />
                </a>
                <a href="#" className="linkedin">
                  <LinkedinLogo />
                </a>
              </div>
              <div className="copyright">
                <CopyRignt /> Copyright
                <strong>
                  <span>Devspace</span>
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
