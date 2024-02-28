import axios from "axios";

const instance = axios.create({
  baseURL: "https://api.apw.ge/walletApi/api",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

export default instance;
