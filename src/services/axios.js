import axios from "axios";

const instance = axios.create({
  baseURL: "https://dev.back.leaderpay.ge/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

export default instance;
