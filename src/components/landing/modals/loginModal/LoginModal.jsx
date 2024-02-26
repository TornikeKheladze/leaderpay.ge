import { useForm } from "react-hook-form";
import Modal from "../../../shared/modal/Modal";
import { useMutation } from "@tanstack/react-query";
import { login } from "../../../../services/landing";
import BootstrapLoader from "../../../shared/loader/BootstrapLoader";

const LoginModal = ({ setClose, registerOpen }) => {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm();

  const { mutate, isLoading } = useMutation({
    mutationFn: login,
    onSuccess: () => {
      console.log("მომხმარებელი წარმატებით დალოგინდა");
    },
    onError: (error) => {
      console.log(error);
    },
  });

  const submitHandler = async (data) => {
    mutate(data);
  };

  return (
    <Modal setClose={setClose}>
      <>
        <span className="close" onClick={setClose}>
          <i className="bi bi-x"></i>
        </span>
        <h3>ავტორიზაცია</h3>
        <form onSubmit={handleSubmit(submitHandler)} className="auth-form">
          <div className="form-group">
            <i className="bi bi-person-fill bi-5x"></i>
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
              placeholder="ელ-ფოსტა/იდენტიფიკატორი"
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
          <button className="submit-button" type="submit">
            {isLoading ? <BootstrapLoader /> : "შესვლა"}
          </button>
        </form>

        <button className="forgot-password">დაგავიწყდა პაროლი?</button>

        <div className="not-registered">
          არ ხარ რეგისტირებული?
          <button
            onClick={() => {
              setClose();
              registerOpen();
            }}
          >
            დარეგისტრიდი
          </button>
        </div>
      </>
    </Modal>
  );
};

export default LoginModal;
