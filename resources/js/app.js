import "./bootstrap";
import Alpine from "alpinejs";
import AOS from "aos";
import "aos/dist/aos.css";

window.Alpine = Alpine;
Alpine.start();

AOS.init({
    duration: 800,
    once: true,
    offset: 100,
    easing: "ease-out-cubic",
});
