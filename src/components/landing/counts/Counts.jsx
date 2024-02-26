import CashDeskIcon from "../../../assets/icons/CashDeskIcon";
import ServiceIcon from "../../../assets/icons/ServiceIcon";
import TransactionIcon from "../../../assets/icons/TransactionIcon";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { useTranslate } from "../../../hooks/useTranslate";
import Counter from "./Counter";

const Counts = ({ data = { data: {} } }) => {
  const { t } = useTranslate(landingTranslations);
  return (
    <section id="counts" className="counts">
      <div className="container" data-aos="fade-up">
        <div className="row gy-4">
          <div className="col-lg-3 col-md-6">
            <div className="count-box">
              <i className="bi bi-emoji-smile"></i>
              <div>
                <Counter end={data.data.users} />
                <p>{t("user")}</p>
              </div>
            </div>
          </div>

          <div className="col-lg-3 col-md-6">
            <div className="count-box">
              <TransactionIcon />
              <div>
                <Counter end={data.data.operations} />
                <p>{t("transaction")}</p>
              </div>
            </div>
          </div>

          <div className="col-lg-3 col-md-6">
            <div className="count-box">
              <ServiceIcon />
              <div>
                <Counter end={data.data.services} />
                <p>{t("service")}</p>
              </div>
            </div>
          </div>

          <div className="col-lg-3 col-md-6">
            <div className="count-box">
              <CashDeskIcon />
              <div>
                <Counter end={data.data.cashdesks} />
                <p>{t("cashdesk")}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Counts;
