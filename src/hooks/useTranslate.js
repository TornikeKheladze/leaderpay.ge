import { useSelector } from "react-redux";

export const useTranslate = (
  translateObj = {},
  anotherObj = {},
  thirdObj = {}
) => {
  const concatedObj = { ...translateObj, ...anotherObj, ...thirdObj };
  const { lang } = useSelector((state) => state.lang);

  const t = (key) => {
    if (concatedObj[key]) {
      return concatedObj[key][lang] || key;
    } else {
      return key;
    }
  };

  return { t };
};
