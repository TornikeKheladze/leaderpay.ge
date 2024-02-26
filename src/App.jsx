import { useSelector } from "react-redux";
import Home from "./Home";

function App() {
  const { lang } = useSelector((state) => state.lang);
  return (
    <div
      className={` ${
        lang === "en" || lang === "ru" ? "english-font" : "georgian-font"
      }`}
    >
      <Home />
    </div>
  );
}

export default App;
