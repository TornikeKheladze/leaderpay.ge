import { useEffect, useState } from "react";
import { useSelector } from "react-redux";

const useHeader = () => {
  const [isHeaderSticky, setIsHeaderSticky] = useState(false);
  const { lang } = useSelector((state) => state.lang);
  useEffect(() => {
    // Function to handle header sticky behavior
    const handleScroll = () => {
      if (window.scrollY > 100) {
        setIsHeaderSticky(true);
      } else {
        setIsHeaderSticky(false);
      }
    };

    // Attach the scroll event listener
    window.addEventListener("scroll", handleScroll);

    // Remove the event listener when the component unmounts
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  useEffect(() => {
    // Define the navbar links using querySelectorAll
    const navbarlinks = document.querySelectorAll("#navbar .scrollto");

    const navbarlinksActive = () => {
      const position = window.scrollY + 200;
      navbarlinks.forEach((navbarlink) => {
        if (!navbarlink.hash) return;
        const section = document.querySelector(navbarlink.hash);
        if (!section) return;
        if (
          position >= section.offsetTop &&
          position <= section.offsetTop + section.offsetHeight
        ) {
          navbarlink.classList.add("active");
        } else {
          navbarlink.classList.remove("active");
        }
      });
    };

    // Run the function when the component mounts
    navbarlinksActive();

    // Add scroll event listener to run the function when scrolling
    window.addEventListener("scroll", navbarlinksActive);

    // Cleanup by removing the event listener when the component unmounts
    return () => {
      window.removeEventListener("scroll", navbarlinksActive);
    };
  }, []);

  useEffect(() => {
    // Toggle mobile navigation
    const handleMobileNavToggle = (e) => {
      const navbar = document.querySelector("#navbar");
      navbar.classList.toggle("navbar-mobile");
      e.currentTarget.classList.toggle("bi-list");
      e.currentTarget.classList.toggle("bi-x");
    };

    // Add event listener to the mobile nav toggle
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    mobileNavToggle.addEventListener("click", handleMobileNavToggle);

    // Cleanup by removing the event listener when the component unmounts
    return () => {
      mobileNavToggle.removeEventListener("click", handleMobileNavToggle);
    };
  }, []);

  useEffect(() => {
    // Mobile nav dropdowns activation
    const handleMobileNavDropdown = (e) => {
      const navbar = document.querySelector("#navbar");
      if (navbar.classList.contains("navbar-mobile")) {
        e.preventDefault();
        e.currentTarget.nextElementSibling.classList.toggle("dropdown-active");
      }
    };

    // Add event listener to mobile nav dropdowns
    const mobileNavDropdowns = document.querySelectorAll(
      ".navbar .dropdown > a"
    );
    mobileNavDropdowns.forEach((el) => {
      el.addEventListener("click", handleMobileNavDropdown, true);
    });

    // Cleanup by removing event listeners when the component unmounts
    return () => {
      mobileNavDropdowns.forEach((el) => {
        el.removeEventListener("click", handleMobileNavDropdown, true);
      });
    };
  }, []);

  useEffect(() => {
    // Function to handle smooth scrolling
    const scrollto = (el) => {
      let header = document.querySelector("#header");
      let offset = header ? header.offsetHeight : 0;

      if (header && !header.classList.contains("header-scrolled")) {
        offset -= 10;
      }

      const element = document.querySelector(el);

      if (element) {
        const elementPos = element.offsetTop;
        window.scrollTo({
          top: elementPos - offset,
          behavior: "smooth",
        });
      }
    };

    // Add event listener to elements with the "scrollto" class
    const scrolltoLinks = document.querySelectorAll(".scrollto");
    scrolltoLinks.forEach((link) => {
      link.addEventListener(
        "click",
        (e) => {
          scrollto(link.hash);
          e.preventDefault();
        },
        true
      );
    });

    // Cleanup by removing event listeners when the component unmounts
    return () => {
      scrolltoLinks.forEach((link) => {
        link.removeEventListener("click", () => {});
      });
    };
  }, []);

  useEffect(() => {
    // Function to handle smooth scrolling
    const scrollto = (el) => {
      let header = document.querySelector("#header");
      let offset = header ? header.offsetHeight : 0;

      if (header && !header.classList.contains("header-scrolled")) {
        offset -= 10;
      }

      const element = document.querySelector(el);

      if (element) {
        const elementPos = element.offsetTop;
        window.scrollTo({
          top: elementPos - offset,
          behavior: "smooth",
        });
      }
    };

    // Add event listener to elements with the "scrollto" class
    const scrolltoLinks = document.querySelectorAll(".scrollto");
    scrolltoLinks.forEach((link) => {
      link.addEventListener(
        "click",
        (e) => {
          scrollto(link.hash);
          e.preventDefault();
        },
        true
      );
    });

    // Handle smooth scroll on page load if there's a hash in the URL
    if (window.location.hash && document.querySelector(window.location.hash)) {
      scrollto(window.location.hash);
    }
  }, []);

  return { isHeaderSticky, lang };
};

export default useHeader;
