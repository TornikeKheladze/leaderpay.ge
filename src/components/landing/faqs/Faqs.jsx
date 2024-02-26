import {
  useQuery,
  // useMutation,
  // useQueryClient,
  // QueryClient,
  // QueryClientProvider,
} from "@tanstack/react-query";
import { getFaqs } from "../../../services/landing";
import { useEffect, useState } from "react";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import { arraySplitter } from "../../../helpers/arraySplitter";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";

const Faqs = () => {
  const { t } = useTranslate(landingTranslations);
  const [faqs, setFaqs] = useState([]);
  const [firstFaqs, setFirstFaqs] = useState([]);
  const [secondFaqs, setSecondFaqs] = useState([]);
  const { lang } = useSelector((state) => state.lang);

  useQuery({
    queryKey: ["faqs"],
    queryFn: getFaqs,
    onSuccess: (data) => {
      setFaqs(data.data);
    },
  });

  useEffect(() => {
    if (faqs?.length > 0) {
      const filteredFaqs = faqs?.filter((faq) => faq?.publish === 1);
      const devidedFaqs = arraySplitter(filteredFaqs);
      if (devidedFaqs?.length > 0) {
        setFirstFaqs(devidedFaqs[0]);
        setSecondFaqs(devidedFaqs[1]);
      }
    }
  }, [faqs]);

  return (
    <section id="faq" className="faq">
      <div className="container" data-aos="fade-up">
        <header className="section-header">
          <h2>F.A.Q</h2>
          <p>{t("faq")}</p>
        </header>

        <div className="row">
          <div className="col-lg-6">
            <div className="accordion accordion-flush" id="faqlist1">
              {firstFaqs?.map((faq) => (
                <div key={faq.id} className="accordion-item">
                  <h2 className="accordion-header">
                    <button
                      className="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target={`#faq-content-${faq.id}`}
                    >
                      {faq ? faq[`title_${lang}`] : ""}
                    </button>
                  </h2>
                  <div
                    id={`faq-content-${faq.id}`}
                    className="accordion-collapse collapse"
                    data-bs-parent="#faqlist1"
                  >
                    <div className="accordion-body">
                      {faq ? faq[`text_${lang}`] : ""}
                      non.
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="col-lg-6">
            <div className="accordion accordion-flush" id="faqlist2">
              {secondFaqs?.map((faq) => (
                <div key={faq.id} className="accordion-item">
                  <h2 className="accordion-header">
                    <button
                      className="accordion-button collapsed"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target={`#faq2-content-${faq.id}`}
                    >
                      {faq ? faq[`title_${lang}`] : ""}
                    </button>
                  </h2>
                  <div
                    id={`faq2-content-${faq.id}`}
                    className="accordion-collapse collapse"
                    data-bs-parent="#faqlist2"
                  >
                    <div className="accordion-body">
                      {faq ? faq[`text_${lang}`] : ""}
                      non.
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Faqs;
