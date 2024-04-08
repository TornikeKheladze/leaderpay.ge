import { useDispatch } from "react-redux";
// import "../../../../public/assets/js/main.js";
import { setLanguage } from "../../../store/language-slice";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import useHeader from "./useHeader";
import "bootstrap/dist/css/bootstrap.min.css";
import lpLogo from "../../../assets/images/leaderpayLogo.png";
import GlobeIcon from "../../../assets/icons/GlobeIcon";
import LoginIcon from "../../../assets/icons/LoginIcon";
import DownArrow from "../../../assets/icons/DownArrow";
import { useEffect, useRef, useState } from "react";

const Header = () => {
  const { isHeaderSticky, lang } = useHeader();
  const dispatch = useDispatch();
  const dropdownRef = useRef(null);
  const { t } = useTranslate(landingTranslations);
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);

  const active = {
    backgroundColor: "#fcd535",
    color: "#1e2329",
  };

  const black = "#F6D658";
  const yellow = "#464956";

  const loginRoute = "https://wallet.leaderpay.ge/";

  const toggleMobileNavbar = () => {
    if (window.innerWidth > 1135) return;
    const toggleButton = document.querySelector(".mobile-nav-toggle");
    const navbar = document.querySelector("#navbar");
    navbar.classList.toggle("navbar-mobile");
    toggleButton.classList.toggle("bi-list");
    toggleButton.classList.toggle("bi-x");
  };

  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setIsDropdownOpen(false);
      }
    }
    // Bind the event listener
    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      // Unbind the event listener on clean up
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [dropdownRef]);

  return (
    <header
      id="header"
      className={`header fixed-top ${isHeaderSticky ? "header-scrolled" : ""}`}
    >
      <div className="container-fluid container-sm d-flex align-items-center justify-content-between">
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
              borderRadius: "5px",
            }}
          >
            {/* <LeaderPayLogo /> */}
            <img alt="lpLogo" src={lpLogo} />
          </div>
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

            <li className="authorization">
              <a href={loginRoute} className="getstarted">
                <LoginIcon />
                <span>{t("authorization")}</span>
              </a>
            </li>
            {/* ენები */}

            <li ref={dropdownRef} className="dropdown">
              <a
                onClick={() =>
                  setIsDropdownOpen((prevState) => {
                    return !prevState;
                  })
                }
              >
                <GlobeIcon />
                <span>
                  {lang === "ge" ? "ქარ" : lang === "en" ? "Eng" : "Rus"}
                </span>
                <DownArrow className={isDropdownOpen ? "rotate" : "unrotate"} />
              </a>
              <ul
                style={{
                  backgroundColor: "#3A3C49",
                }}
                className={isDropdownOpen ? "visible" : ""}
              >
                <li>
                  <button
                    style={
                      lang === "ge" ? { color: black } : { color: "#FFFFFF" }
                    }
                    onClick={() => {
                      dispatch(setLanguage("ge"));
                      localStorage.setItem("lang", "ge");
                    }}
                  >
                    ქარ
                  </button>
                </li>
                <li>
                  <button
                    style={
                      lang === "en" ? { color: black } : { color: "#FFFFFF" }
                    }
                    onClick={() => {
                      dispatch(setLanguage("en"));
                      localStorage.setItem("lang", "en");
                    }}
                  >
                    Eng
                  </button>
                </li>
                <li>
                  <button
                    style={
                      lang === "ru" ? { color: black } : { color: "#FFFFFF" }
                    }
                    onClick={() => {
                      dispatch(setLanguage("ru"));
                      localStorage.setItem("lang", "ru");
                    }}
                  >
                    Rus
                  </button>
                </li>
              </ul>
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
