// import { useQuery } from "@tanstack/react-query";
// import { getAboutContent } from "../../../services/landing";
// import BootstrapLoader from "../../shared/loader/BootstrapLoader";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";

const About = () => {
  const { t } = useTranslate(landingTranslations);
  const { lang } = useSelector((state) => state.lang);
  // const { data: aboutContent, isLoading } = useQuery({
  //   queryKey: ["aboutContent"],
  //   queryFn: getAboutContent,
  // });
  const dummyObject = {
    created_at: "2023-11-16T13:26:49.000000Z",
    id: 1,
    text_en:
      "Studypay არის ყოვლისმომცველი გადახდის სისტემა,  რომელიც შექმნილია ფინანსური ტრანზაქციების გასამარტივებლად შემეცნებითი დაწესებულებებისთვის, იქნება ეს სკოლაში არსებული წრეების გადასახადები, მუსიკის, ცეკვის, სამხატვრო სტუდიები თუ სხვა.\r\nჩვენი გუნდი უზრუნველყოფს გადახდის შეუფერხებელ და გამარტივებულ პროცესს. კომპანიებს, რომლებსაც სურთ Studypay-ის ინტეგრირება თავიანთ პროექტებში, შეუძლიათ დაგვიკავშირდნენ მათ მოთხოვნებზე მორგებული სრული ინტეგრაციისთვის.",
    text_ge:
      "Studypay არის ყოვლისმომცველი გადახდის სისტემა,  რომელიც შექმნილია ფინანსური ტრანზაქციების გასამარტივებლად შემეცნებითი დაწესებულებებისთვის, იქნება ეს სკოლაში არსებული წრეების გადასახადები, მუსიკის, ცეკვის, სამხატვრო სტუდიები თუ სხვა.\r\nჩვენი გუნდი უზრუნველყოფს გადახდის შეუფერხებელ და გამარტივებულ პროცესს. კომპანიებს, რომლებსაც სურთ Studypay-ის ინტეგრირება თავიანთ პროექტებში, შეუძლიათ დაგვიკავშირდნენ მათ მოთხოვნებზე მორგებული სრული ინტეგრაციისთვის.",
    text_ru:
      "Studypay არის ყოვლისმომცველი გადახდის სისტემა,  რომელიც შექმნილია ფინანსური ტრანზაქციების გასამარტივებლად შემეცნებითი დაწესებულებებისთვის, იქნება ეს სკოლაში არსებული წრეების გადასახადები, მუსიკის, ცეკვის, სამხატვრო სტუდიები თუ სხვა.\r\nჩვენი გუნდი უზრუნველყოფს გადახდის შეუფერხებელ და გამარტივებულ პროცესს. კომპანიებს, რომლებსაც სურთ Studypay-ის ინტეგრირება თავიანთ პროექტებში, შეუძლიათ დაგვიკავშირდნენ მათ მოთხოვნებზე მორგებული სრული ინტეგრაციისთვის.",
    updated_at: "2023-11-28T08:21:08.000000Z",
  };
  return (
    <section id="about" className="about">
      <div className="container" data-aos="fade-up">
        <div className="row gx-0">
          <div
            className="col-lg-6 d-flex flex-column justify-content-center"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            <div className="content">
              <h3>{t("who_we_are")}</h3>
              {/* {isLoading ? (
                <BootstrapLoader />
              ) : (
                <p>{aboutContent?.data[0][`text_${lang}`]}</p>
              )} */}
              {<p>{dummyObject[`text_${lang}`]}</p>}
            </div>
          </div>

          <div
            className="col-lg-6 d-flex align-items-center"
            data-aos="zoom-out"
            data-aos-delay="200"
          >
            <img src="assets/img/about.jpg" className="img-fluid" alt="" />
          </div>
        </div>
      </div>
    </section>
  );
};

export default About;
