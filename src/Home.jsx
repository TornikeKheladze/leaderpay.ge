import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import "remixicon/fonts/remixicon.css";
import Header from "./components/landing/header/Header";
import Hero from "./components/landing/hero/Hero";
import About from "./components/landing/about/About";
import Values from "./components/landing/values/Values";
import Counts from "./components/landing/counts/Counts";
// import Features from "./components/landing/features/Features";
// import Services from "./components/landing/services/Services";
// import Pricing from "./components/landing/pricing/Pricing";
// import Faqs from "./components/landing/faqs/Faqs";
// import Portfolio from "./components/landing/portfolio/Portfolio";
// import Testimonials from "./components/landing/testimonials/Testimonials";
// import { AnimatePresence } from "framer-motion";
import { useEffect, useState } from "react";
import AOS from "aos";
import "aos/dist/aos.css";
// import Team from "./components/landing/team/Team";
// import RecentPosts from "./components/landing/recentPosts/RecentPosts";
import Contact from "./components/landing/contact/Contact";
import Footer from "./components/landing/footer/Footer";
import Clients from "./components/landing/clients/Clients";
import {
  // useQuery,
  useQueries,
  // useMutation,
  // useQueryClient,
  // QueryClient,
  // QueryClientProvider,
} from "@tanstack/react-query";
import {
  getContactInfo,
  getHeroData,
  getPartners,
  getServiceCategories,
  getStats,
} from "./services/wallet";
import { Toaster } from "react-hot-toast";

const Home = () => {
  useEffect(() => {
    AOS.init({
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      mirror: false,
    });
  }, []);

  // const { lang } = useSelector((state) => state.lang);

  const [
    { data: statsData },
    { data: partnersData },
    { data: heroData },
    { data: serviceData },
    { data: contactData },
  ] = useQueries({
    queries: [
      { queryKey: ["getStats"], queryFn: getStats, staleTime: Infinity },
      {
        queryKey: ["getPartners"],
        queryFn: getPartners,
        staleTime: Infinity,
      },
      {
        queryKey: ["getHeroData"],
        queryFn: getHeroData,
        staleTime: Infinity,
      },
      {
        queryKey: ["getServiceCategories"],
        queryFn: getServiceCategories,
        staleTime: Infinity,
      },
      {
        queryKey: ["getContactInfo"],
        queryFn: getContactInfo,
        staleTime: Infinity,
      },
    ],
  });

  return (
    <>
      <Toaster position="bottom-right" />
      <Header />
      <Hero data={heroData} />
      <main id="main">
        {/* <AnimatePresence>
          {showLoginModal && (
            <LoginModal
              isOpen={showLoginModal}
              setOpen={openLoginModal}
              setClose={closeLoginModal}
              registerOpen={openRegisterModal}
            />
          )}
          {showRegisterModal && <RegisterModal setClose={closeRegisterModal} />}
        </AnimatePresence> */}

        {/* <About /> */}
        <Values countsData={statsData} data={serviceData} />
        {/* <Counts data={statsData} /> */}
        {/* <Features /> */}
        {/* <Services /> */}
        {/* <Pricing /> */}
        {/* <Faqs /> */}
        {/* <Portfolio /> */}
        {/* <Testimonials /> */}
        {/* <Team /> */}
        <Clients data={partnersData} />
        {/* <RecentPosts /> */}
        <Contact data={contactData} />
      </main>
      <Footer data={contactData} />
    </>
  );
};

export default Home;
