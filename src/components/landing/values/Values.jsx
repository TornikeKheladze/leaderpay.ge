// import { getServicesContent } from "../../../services/landing";
// import BootstrapLoader from "../../shared/loader/BootstrapLoader";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useSelector } from "react-redux";
import CashDeskIcon from "../../../assets/icons/CashDeskIcon";
import Counter from "../counts/Counter";
import ServiceIcon from "../../../assets/icons/ServiceIcon";
import TransactionIcon from "../../../assets/icons/TransactionIcon";
import CustomersIcon from "../../../assets/icons/CustomersIcon";

const Values = ({
  data = { data: [{ lang: {} }] },
  countsData = { data: {} },
}) => {
  const { t } = useTranslate(landingTranslations);
  const { lang } = useSelector((state) => state.lang);

  const walletUrl = "https://wallet.leaderpay.ge/";

  return (
    <section id="values" className="values">
      <div className="container" data-aos="fade-up">
        <header className="section-header">
          <h2>{t("our_services")}</h2>
          {/* <p>Odit est perspiciatis laborum et dicta</p> */}
        </header>

        <div className="service-list">
          {data.data.map((item) => {
            let languageKey = lang === "ge" ? "ka" : lang;
            return (
              <div
                key={item.id + Math.random()}
                className="col-lg-3"
                data-aos="fade-up"
                data-aos-delay="200"
              >
                <div className="box">
                  <a href={`${walletUrl}guest/services/category/${item.id}`}>
                    <div className="imageWrapper">
                      <img src={item.image} className="img-fluid" alt="" />
                    </div>
                    <h3>{item.lang[languageKey]}</h3>
                  </a>
                  {/* <p>{service && service[`subtitle_${lang}`]}</p> */}
                </div>
              </div>
            );
          })}
          {/* {isLoading ? (
            <BootstrapLoader />
          ) : (
            servicesContent?.data?.map((service, index) => (
              <div
                key={service.id}
                className="col-lg-4"
                data-aos="fade-up"
                data-aos-delay="200"
              >
                <div className="box">
                  <img
                    src={`assets/img/values-${index + 1}.png`}
                    className="img-fluid"
                    alt=""
                  />
                  <h3>{service && service[`title_${lang}`]}</h3>
                  <p>{service && service[`subtitle_${lang}`]}</p>
                </div>
              </div>
            ))
          )} */}
        </div>
        <div className="counts">
          <div className="count-box">
            <CustomersIcon />
            <div>
              <Counter end={countsData.data.users} />
              <p>{t("user")}</p>
            </div>
          </div>

          <div className="count-box">
            <TransactionIcon />
            <div>
              <Counter end={countsData.data.operations} />
              <p>{t("transaction")}</p>
            </div>
          </div>

          <div className="count-box">
            <ServiceIcon />
            <div>
              <Counter end={countsData.data.services} />
              <p>{t("service")}</p>
            </div>
          </div>

          <div className="count-box">
            <CashDeskIcon />
            <div>
              <Counter end={countsData.data.cashdesks} />
              <p>{t("cashdesk")}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Values;
