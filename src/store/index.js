// import { configureStore } from "@reduxjs/toolkit";
import { configureStore } from "@reduxjs/toolkit";
import languageSlice from "./language-slice";

const store = configureStore({
  reducer: {
    lang: languageSlice.reducer,
  },
});

export default store;
