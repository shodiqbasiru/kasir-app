import "./bootstrap";
import { createApp } from "vue";
// import router from "./router";

import App from "./App.vue";
const app = createApp({
    components: {
        App,
    },
});
app.mount("#app");
// app.use(router);
