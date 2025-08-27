/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./app/wp-content/plugins/mody-base/resources/sass/editor.sass":
/*!*********************************************************************!*\
  !*** ./app/wp-content/plugins/mody-base/resources/sass/editor.sass ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./app/wp-content/plugins/mody-base/resources/scripts/base/color-picker.js":
/*!*********************************************************************************!*\
  !*** ./app/wp-content/plugins/mody-base/resources/scripts/base/color-picker.js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
const ColorPicker = {
  init: () => {
    ColorPicker.action();
  },
  action: () => {
    acf?.addFilter('color_picker_args', (args, field) => {
      if (typeof ModyBase !== 'undefined' && typeof ModyBase.palette !== 'undefined') {
        args.palettes = ModyBase.palette;
        args.disableCustom = true;
      }
      return args;
    });
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ColorPicker);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************************************************************!*\
  !*** ./app/wp-content/plugins/mody-base/resources/scripts/editor.js ***!
  \**********************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_editor_sass__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/editor.sass */ "./app/wp-content/plugins/mody-base/resources/sass/editor.sass");
/* harmony import */ var _base_color_picker__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./base/color-picker */ "./app/wp-content/plugins/mody-base/resources/scripts/base/color-picker.js");


window.addEventListener('load', () => {
  _base_color_picker__WEBPACK_IMPORTED_MODULE_1__["default"].init();
});
})();

/******/ })()
;
//# sourceMappingURL=baseEditor.js.map