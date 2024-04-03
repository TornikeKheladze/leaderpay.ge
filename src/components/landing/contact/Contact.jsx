import { useMutation, useQuery } from "@tanstack/react-query";
import { useForm } from "react-hook-form";
import BootstrapLoader from "../../shared/loader/BootstrapLoader";
import { useTranslate } from "../../../hooks/useTranslate";
import { landingTranslations } from "../../../data/lang/landingTranslations";
import { sendMessage } from "../../../services/wallet";
import LocationIcon from "../../../assets/icons/LocationIcon";
import PhoneIcon from "../../../assets/icons/PhoneIcon";
import MailIcon from "../../../assets/icons/MailIcon";
import ClockIcon from "../../../assets/icons/ClockIcon";

import toast from "react-hot-toast";

const Contact = ({ data = { data: { data: {} } } }) => {
  const { t } = useTranslate(landingTranslations);
  const { register, handleSubmit } = useForm();
  const { mutate: messageMutate, isLoading: messageLoading } = useMutation({
    mutationFn: sendMessage,
    onSuccess: () => {
      toast.success("თქვენი მეილი წარმატებით გაიგზავნა");
    },
    onError: () => {
      toast.error("მეილის გაგზავნა ვერ მოხერხდა");
    },
  });

  const submitHandler = (data) => {
    messageMutate(data);
  };

  return (
    <section id="contact" className="contact">
      <div className="container-sm" data-aos="fade-up">
        <header className="section-header">
          <h2>{t("contact")}</h2>
          {/* <p>{t("contact_us")}</p> */}
        </header>

        <div className="row gy-4">
          <div className="col-lg-6">
            <div className="row gy-4 align-items-center ">
              <div className="col-md-6">
                <div className="info-box">
                  <LocationIcon />
                  {/* <h3>{t("address")}</h3> */}
                  <p>{data.data.data.address}</p>
                </div>
              </div>
              <div className="col-md-6">
                <div className="info-box">
                  <PhoneIcon />
                  {/* <h3>{t("call_us")}</h3> */}
                  <p>{data.data.data.phone}</p>
                </div>
              </div>
              <div className="col-md-6">
                <div className="info-box">
                  <MailIcon />
                  {/* <h3>{t("email_us")}</h3> */}
                  <p>{data.data.data.email}</p>
                </div>
              </div>
              <div className="col-md-6">
                <div className="info-box">
                  <ClockIcon />
                  {/* <h3>{t("open_hours")}</h3> */}
                  <div>
                    <p>ორშაბათი-პარასკევი</p>
                    <p>11:00AM-08:00PM</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="col-lg-6">
            <form
              onSubmit={handleSubmit(submitHandler)}
              action="forms/contact.php"
              className="php-email-form"
            >
              <div className="row gy-4">
                <div className="col-md-6">
                  <input
                    {...register("name")}
                    type="text"
                    className="form-control"
                    placeholder={t("your_name")}
                    required
                  />
                </div>

                <div className="col-md-6">
                  <input
                    {...register("email")}
                    type="email"
                    className="form-control"
                    placeholder={t("your_email")}
                    required
                  />
                </div>

                {/* <div className="col-md-12">
                  <input
                    {...register("title")}
                    type="text"
                    className="form-control"
                    name="title"
                    placeholder={t("subject")}
                    required
                  />
                </div> */}

                <div className="col-md-12">
                  <textarea
                    {...register("text")}
                    className="form-control"
                    rows="4"
                    placeholder={t("message")}
                    required
                  ></textarea>
                </div>

                <div className="col-md-12 text-center">
                  <div className="loading">Loading</div>
                  <div className="error-message"></div>
                  <div className="sent-message">
                    Your message has been sent. Thank you!
                  </div>

                  <button className="email-send-button" type="submit">
                    {messageLoading ? <BootstrapLoader /> : t("send")}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Contact;
