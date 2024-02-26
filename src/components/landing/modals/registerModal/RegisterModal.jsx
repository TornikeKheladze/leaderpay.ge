import { useForm, useWatch } from "react-hook-form";
import Modal from "../../../shared/modal/Modal";
import { useMutation } from "@tanstack/react-query";
import {
  getSmsForRegister,
  registerPartner,
} from "../../../../services/landing";
import toast, { Toaster } from "react-hot-toast";
import BootstrapLoader from "../../../shared/loader/BootstrapLoader";

const RegisterModal = ({ setClose }) => {
  const {
    register,
    handleSubmit,
    formState: { errors },
    control,
    setError,
  } = useForm({
    mode: "all",
  });

  const phoneInput = useWatch({
    name: "phone",
    control: control,
  });

  const passwordInput = useWatch({
    name: "password",
    control: control,
  });

  const passwordConfirmInput = useWatch({
    name: "confirm_password",
    control: control,
  });

  const {
    mutate: smsCodeMutation,
    isLoading: smsIsLoading,
    // error: smsIsError,
  } = useMutation({
    mutationFn: getSmsForRegister,
    onSuccess: () => {
      toast.success("სმს კოდი გამოიგზავნა წარმატებით");
    },
    onError: () => {
      toast.error("სმს კოდის გაგზავნა ვერ მოხერხდა");
    },
  });

  const { mutate: registerMutate, isLoading: registerIsLoading } = useMutation({
    mutationFn: registerPartner,
    onSuccess: () => {
      toast.success("პარტნიორი წარმატებით დაემატა");
      setTimeout(() => {
        setClose();
      }, 1500);
    },
    onError: (error) => {
      toast.error(error.response.data.message);
    },
  });

  const getSmsCodeHandler = async () => {
    smsCodeMutation({ phone: phoneInput });
  };

  const submitHandler = async (data) => {
    if (passwordInput !== passwordConfirmInput) {
      setError("password", {
        type: "custom",
        message: "პაროლები უნდა ემთხვეოდეს",
      });
      return;
    }

    registerMutate(data);
  };

  return (
    <>
      <Toaster position="bottom-right" reverseOrder={true} />

      <Modal setClose={setClose}>
        <>
          <span className="close" onClick={setClose}>
            <i className="bi bi-x"></i>
          </span>
          <h3>რეგისტრაცია</h3>
          <form onSubmit={handleSubmit(submitHandler)} className="auth-form">
            <div className="form-group">
              <i className="bi bi-building-fill"></i>
              <input
                {...register("company_name", {
                  required: "ეს ველი აუცილებელია",
                })}
                type="text"
                name="company_name"
                placeholder="კომპანიის დასახელება"
              />
            </div>
            <p className="error-text">
              {errors["company_name"]?.message || ""}{" "}
            </p>
            <div className="form-group">
              <i className="bi bi-1-square-fill"></i>

              <input
                {...register("identification_number", {
                  required: "ეს ველი აუცილებელია",
                  pattern: {
                    value: /^[0-9]+$/,
                    message: "შეიყვანეთ მხოლოდ ციფრები",
                  },
                })}
                type="text"
                name="identification_number"
                placeholder="საიდენტიფიკაციო ნომერი"
              />
            </div>
            <p className="error-text">
              {errors["identification_number"]?.message || ""}{" "}
            </p>

            <div className="form-group">
              <i className="bi bi-telephone-fill"></i>
              <input
                {...register("phone", {
                  required: "ეს ველი აუცილებელია",
                  pattern: {
                    value: /^(79\d{7}|5\d{8})$/,
                    message: "შეიყვანეთ ქართული ნომერი",
                  },
                })}
                type="text"
                name="phone"
                placeholder="ტელეფონის ნომერი"
              />
            </div>
            <p className="error-text">{errors["phone"]?.message || ""} </p>

            <div className="sms-button-wrapper">
              <button
                disabled={errors["phone"] || phoneInput === undefined}
                onClick={getSmsCodeHandler}
                className="sms-button"
                type="button"
              >
                სმს კოდის მიღება
              </button>
              {smsIsLoading && (
                <div className="spinner-border spinner-border-sm" role="status">
                  <span className="sr-only"></span>
                </div>
              )}
            </div>

            <div className="form-group">
              <i className="bi bi-chat-left-dots-fill"></i>{" "}
              <input
                {...register("sms", {
                  required: "ეს ველი აუცილებელია",
                  pattern: {
                    value: /^[0-9]+$/,
                    message: "შეიყვანეთ მხოლოდ ციფრები",
                  },
                })}
                type="text"
                name="sms"
                placeholder="შეიყვანეთ სმს კოდი"
              />
            </div>
            <p className="error-text">{errors["sms"]?.message || ""} </p>

            <div className="form-group">
              <i className="bi bi-geo-alt-fill"></i>
              <input
                {...register("address", {
                  required: "ეს ველი აუცილებელია",
                })}
                type="text"
                name="address"
                placeholder="მისამართი"
              />
            </div>
            <p className="error-text">{errors["address"]?.message || ""} </p>

            <div className="form-group">
              <i className="bi bi-envelope-at-fill"></i>
              <input
                {...register("email", {
                  required: "ეს ველი აუცილებელია",
                  pattern: {
                    value: /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                    message: "შეიყვანეთ სწორი მეილი",
                  },
                })}
                type="text"
                id="email"
                name="email"
                placeholder="ელ-ფოსტა"
              />
            </div>
            <p className="error-text">{errors["email"]?.message || ""} </p>

            <div className="form-group">
              <i className="bi bi-lock-fill"></i>

              <input
                {...register("password", {
                  required: "ეს ველი აუცილებელია",
                  minLength: { value: 4, message: "მინიმუმ 4 სიმბოლო" },
                })}
                type="password"
                id="password"
                name="password"
                placeholder="პაროლი"
              />
            </div>
            <p className="error-text">{errors["password"]?.message || ""} </p>

            <div className="form-group">
              <i className="bi bi-lock-fill"></i>

              <input
                {...register("confirm_password", {
                  required: "ეს ველი აუცილებელია",
                  minLength: { value: 4, message: "მინიმუმ 4 სიმბოლო" },
                })}
                type="password"
                name="confirm_password"
                placeholder="გაიმეორე პაროლი"
              />
            </div>

            <button className="submit-button" type="submit">
              {registerIsLoading ? <BootstrapLoader /> : "რეგისტრაცია"}
            </button>
          </form>
        </>
      </Modal>
    </>
  );
};

export default RegisterModal;
