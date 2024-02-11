import DropDown from "./components/Dropdown.vue";
import DropDownInput from "./components/DropdownInput.vue";
/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install(Vue) {
    Vue.component("drop-down", DropDown);
    Vue.component("drop-down-input", DropDownInput);
  }
};

export default GlobalComponents;
