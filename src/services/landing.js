import instance from "./axios";

export const getFaqs = async () => {
  return instance.get("/faqs");
};

export const login = async (data) => {
  return instance.post("/login", data);
};

export const registerPartner = async (data) => {
  return instance.post("/customer/register", data);
};

export const getSmsForRegister = async (data) => {
  return instance.post("/customer/register/sms", data);
};

export const getHeroContent = async () => {
  return instance.get("/main-texts");
};

export const getServicesContent = async () => {
  return instance.get("/services");
};

export const getAboutContent = async () => {
  return instance.get("/about");
};

export const getPricingContent = async () => {
  return instance.get("/pricing");
};

export const getContactContent = async () => {
  return instance.get("/contacts");
};

export const sendEmail = async (data) => {
  return instance.post("/emails", data);
};
