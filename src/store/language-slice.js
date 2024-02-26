import { createSlice } from "@reduxjs/toolkit";

const languageSlice = createSlice({
  name: "lang",
  initialState: { lang: localStorage.getItem("lang") || "ge" },
  reducers: {
    setLanguage: (state, { payload }) => {
      state.lang = payload;
    },
  },
});

export const { setLanguage } = languageSlice.actions;

export default languageSlice;
