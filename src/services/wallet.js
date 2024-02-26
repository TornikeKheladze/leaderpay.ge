import instance from "./axios";

export const getStats = async () => {
  return instance.post("/landing/stat");
};

export const getPartners = async () => {
  return instance.post("/landing/partners");
};

export const sendMessage = async (data) => {
  return instance.post("/landing/contact", data);
};

export const getHeroData = async () => {
  return instance.post("/landing/slide");
};

export const getServiceCategories = async () => {
  return instance.post("/billing/categories");
};

export const getContactInfo = async () => {
  return instance.post("/pages/contact");
};
