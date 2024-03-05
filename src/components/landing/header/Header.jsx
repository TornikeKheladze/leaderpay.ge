import { useDispatch } from "react-redux";
// import "../../../../public/assets/js/main.js";
import { setLanguage } from "../../../store/language-slice";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import useHeader from "./useHeader";
import "bootstrap/dist/css/bootstrap.min.css";
import studypaylogo from "../../../assets/images/logo.png";

const Header = () => {
  const { isHeaderSticky, lang } = useHeader();
  const dispatch = useDispatch();
  const { t } = useTranslate(landingTranslations);

  const active = {
    backgroundColor: "#fcd535",
    color: "#1e2329",
  };

  const black = "#1e2329";
  const yellow = "#fcd535";

  const loginRoute = "https://wallet.leaderpay.ge/";

  const toggleMobileNavbar = () => {
    const toggleButton = document.querySelector(".mobile-nav-toggle");
    const navbar = document.querySelector("#navbar");
    navbar.classList.toggle("navbar-mobile");
    toggleButton.classList.toggle("bi-list");
    toggleButton.classList.toggle("bi-x");
  };

  return (
    <header
      id="header"
      className={`header fixed-top ${isHeaderSticky ? "header-scrolled" : ""} ${
        lang === "en" || lang === "ru" ? "english-font" : "georgian-font"
      }`}
    >
      <div className="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a
          style={{
            // backgroundColor: "gray",
            borderRadius: "5px",
            padding: "2px",
            paddingLeft: "5px",
            paddingRight: "5px",
          }}
          href="#hero"
          className="logo d-flex align-items-center"
        >
          <div
            style={{
              // backgroundColor: "gray",
              borderRadius: "5px",
            }}
          >
            <img src={studypaylogo} alt="logo" />
          </div>
          <span className="english-font">LeaderPay</span>
        </a>

        <nav id="navbar" className="navbar">
          <ul>
            <li onClick={toggleMobileNavbar}>
              <a className="nav-link scrollto active" href="#hero">
                {t("home")}
              </a>
            </li>
            <li onClick={toggleMobileNavbar}>
              <a className="nav-link scrollto" href="#values">
                {t("services")}
              </a>
            </li>
            {/* <li>
              <a className="nav-link scrollto" href="#services">
                {t("services")}
              </a>
            </li> */}
            {/* <li>
              <a className="nav-link scrollto" href="#portfolio">
                Portfolio
              </a>
            </li> */}
            {/* <li>
              <a className="nav-link scrollto" href="#team">
                {t("team")}
              </a>
            </li> */}

            <li onClick={toggleMobileNavbar}>
              <a className="nav-link scrollto" href="#contact">
                {t("contact")}
              </a>
            </li>
            {/* ენები */}

            {/* <li className="dropdown">
              <a>
                <span>
                  {lang === "ge"
                    ? "ქართული"
                    : lang === "en"
                    ? "English"
                    : "Russian"}
                </span>
                <i className="bi bi-chevron-down"></i>
              </a>
              <ul
                style={{
                  backgroundColor: "#1e2329",
                }}
              >
                <li style={lang === "ge" ? { backgroundColor: yellow } : {}}>
                  <button
                    style={lang === "ge" ? { color: black } : {}}
                    onClick={() => {
                      dispatch(setLanguage("ge"));
                      localStorage.setItem("lang", "ge");
                    }}
                  >
                    ქართული
                  </button>
                </li>
                <li style={lang === "en" ? { backgroundColor: yellow } : {}}>
                  <button
                    style={lang === "en" ? { color: black } : {}}
                    onClick={() => {
                      dispatch(setLanguage("en"));
                      localStorage.setItem("lang", "en");
                    }}
                  >
                    English
                  </button>
                </li>
                <li style={lang === "ru" ? { backgroundColor: yellow } : {}}>
                  <button
                    style={lang === "ru" ? { color: black } : {}}
                    onClick={() => {
                      dispatch(setLanguage("ru"));
                      localStorage.setItem("lang", "ru");
                    }}
                  >
                    Russian
                  </button>
                </li>
              </ul>
            </li> */}

            <li>
              <a href={loginRoute} target="_blank" className="getstarted">
                <span>{t("authorization")}</span>
              </a>
            </li>
          </ul>
          <i className="bi bi-list mobile-nav-toggle"></i>
        </nav>
      </div>

      {/* <div className="modal-wrapper"> */}
      {/* <div className="modal">aaa</div> */}
      {/* </div> */}
    </header>
  );
};

export default Header;
