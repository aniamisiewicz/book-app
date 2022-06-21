"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.slice.js */ "./node_modules/core-js/modules/es.array.slice.js");
/* harmony import */ var core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_slice_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");





/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you import will output into a single css file (app.css in this case)
 // start the Stimulus application
// import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
  // Get all "navbar-burger" elements
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll(".navbar-burger"), 0); // Check if there are any navbar burgers

  if ($navbarBurgers.length > 0) {
    // Add a click event on each of them
    $navbarBurgers.forEach(function (el) {
      el.addEventListener("click", function () {
        // Get the target from the "data-target" attribute
        var target = el.dataset.target;
        var $target = document.getElementById(target); // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"

        el.classList.toggle("is-active");
        $target.classList.toggle("is-active");
      });
    });
  }
});
document.addEventListener("DOMContentLoaded", function () {
  // Functions to open and close a modal
  function openModal($el) {
    $el.classList.add("is-active");
  }

  function closeModal($el) {
    $el.classList.remove("is-active");
  }

  function closeAllModals() {
    (document.querySelectorAll(".modal") || []).forEach(function ($modal) {
      closeModal($modal);
    });
  } // Add a click event on buttons to open a specific modal


  (document.querySelectorAll(".modal-button") || []).forEach(function ($trigger) {
    var modal = $trigger.dataset.target;
    var $target = document.getElementById(modal);
    console.log($target);
    $trigger.addEventListener("click", function () {
      openModal($target);
    });
  }); // Add a click event on various child elements to close the parent modal

  (document.querySelectorAll(".modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button") || []).forEach(function ($close) {
    var $target = $close.closest(".modal");
    $close.addEventListener("click", function () {
      closeModal($target);
    });
  }); // Add a keyboard event to close all modals

  document.addEventListener("keydown", function (event) {
    var e = event || window.event;

    if (e.keyCode === 27) {
      // Escape key
      closeAllModals();
    }
  });
});

/***/ }),

/***/ "./assets/styles/app.css":
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_arr-9a33b2"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUFxQyxVQUFDNkIsS0FBRCxFQUFXO0FBQzlDLFFBQU1DLENBQUMsR0FBR0QsS0FBSyxJQUFJRSxNQUFNLENBQUNGLEtBQTFCOztBQUVBLFFBQUlDLENBQUMsQ0FBQ0UsT0FBRixLQUFjLEVBQWxCLEVBQXNCO0FBQ3BCO0FBQ0FYLE1BQUFBLGNBQWM7QUFDZjtBQUNGLEdBUEQ7QUFRRCxDQWpERDs7Ozs7Ozs7Ozs7QUNyQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcz8zZmJhIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogV2UgcmVjb21tZW5kIGluY2x1ZGluZyB0aGUgYnVpbHQgdmVyc2lvbiBvZiB0aGlzIEphdmFTY3JpcHQgZmlsZVxuICogKGFuZCBpdHMgQ1NTIGZpbGUpIGluIHlvdXIgYmFzZSBsYXlvdXQgKGJhc2UuaHRtbC50d2lnKS5cbiAqL1xuXG4vLyBhbnkgQ1NTIHlvdSBpbXBvcnQgd2lsbCBvdXRwdXQgaW50byBhIHNpbmdsZSBjc3MgZmlsZSAoYXBwLmNzcyBpbiB0aGlzIGNhc2UpXG5pbXBvcnQgXCIuL3N0eWxlcy9hcHAuY3NzXCI7XG5cbi8vIHN0YXJ0IHRoZSBTdGltdWx1cyBhcHBsaWNhdGlvblxuLy8gaW1wb3J0IFwiLi9ib290c3RyYXBcIjtcblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcIkRPTUNvbnRlbnRMb2FkZWRcIiwgKCkgPT4ge1xuICAvLyBHZXQgYWxsIFwibmF2YmFyLWJ1cmdlclwiIGVsZW1lbnRzXG4gIGNvbnN0ICRuYXZiYXJCdXJnZXJzID0gQXJyYXkucHJvdG90eXBlLnNsaWNlLmNhbGwoXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIi5uYXZiYXItYnVyZ2VyXCIpLFxuICAgIDBcbiAgKTtcblxuICAvLyBDaGVjayBpZiB0aGVyZSBhcmUgYW55IG5hdmJhciBidXJnZXJzXG4gIGlmICgkbmF2YmFyQnVyZ2Vycy5sZW5ndGggPiAwKSB7XG4gICAgLy8gQWRkIGEgY2xpY2sgZXZlbnQgb24gZWFjaCBvZiB0aGVtXG4gICAgJG5hdmJhckJ1cmdlcnMuZm9yRWFjaCgoZWwpID0+IHtcbiAgICAgIGVsLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCAoKSA9PiB7XG4gICAgICAgIC8vIEdldCB0aGUgdGFyZ2V0IGZyb20gdGhlIFwiZGF0YS10YXJnZXRcIiBhdHRyaWJ1dGVcbiAgICAgICAgY29uc3QgdGFyZ2V0ID0gZWwuZGF0YXNldC50YXJnZXQ7XG4gICAgICAgIGNvbnN0ICR0YXJnZXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCh0YXJnZXQpO1xuXG4gICAgICAgIC8vIFRvZ2dsZSB0aGUgXCJpcy1hY3RpdmVcIiBjbGFzcyBvbiBib3RoIHRoZSBcIm5hdmJhci1idXJnZXJcIiBhbmQgdGhlIFwibmF2YmFyLW1lbnVcIlxuICAgICAgICBlbC5jbGFzc0xpc3QudG9nZ2xlKFwiaXMtYWN0aXZlXCIpO1xuICAgICAgICAkdGFyZ2V0LmNsYXNzTGlzdC50b2dnbGUoXCJpcy1hY3RpdmVcIik7XG4gICAgICB9KTtcbiAgICB9KTtcbiAgfVxufSk7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsICgpID0+IHtcbiAgLy8gRnVuY3Rpb25zIHRvIG9wZW4gYW5kIGNsb3NlIGEgbW9kYWxcbiAgZnVuY3Rpb24gb3Blbk1vZGFsKCRlbCkge1xuICAgICRlbC5jbGFzc0xpc3QuYWRkKFwiaXMtYWN0aXZlXCIpO1xuICB9XG5cbiAgZnVuY3Rpb24gY2xvc2VNb2RhbCgkZWwpIHtcbiAgICAkZWwuY2xhc3NMaXN0LnJlbW92ZShcImlzLWFjdGl2ZVwiKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIGNsb3NlQWxsTW9kYWxzKCkge1xuICAgIChkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiLm1vZGFsXCIpIHx8IFtdKS5mb3JFYWNoKCgkbW9kYWwpID0+IHtcbiAgICAgIGNsb3NlTW9kYWwoJG1vZGFsKTtcbiAgICB9KTtcbiAgfVxuXG4gIC8vIEFkZCBhIGNsaWNrIGV2ZW50IG9uIGJ1dHRvbnMgdG8gb3BlbiBhIHNwZWNpZmljIG1vZGFsXG4gIChkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiLm1vZGFsLWJ1dHRvblwiKSB8fCBbXSkuZm9yRWFjaCgoJHRyaWdnZXIpID0+IHtcbiAgICBjb25zdCBtb2RhbCA9ICR0cmlnZ2VyLmRhdGFzZXQudGFyZ2V0O1xuICAgIGNvbnN0ICR0YXJnZXQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChtb2RhbCk7XG4gICAgY29uc29sZS5sb2coJHRhcmdldCk7XG5cbiAgICAkdHJpZ2dlci5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgKCkgPT4ge1xuICAgICAgb3Blbk1vZGFsKCR0YXJnZXQpO1xuICAgIH0pO1xuICB9KTtcblxuICAvLyBBZGQgYSBjbGljayBldmVudCBvbiB2YXJpb3VzIGNoaWxkIGVsZW1lbnRzIHRvIGNsb3NlIHRoZSBwYXJlbnQgbW9kYWxcbiAgKFxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXG4gICAgICBcIi5tb2RhbC1iYWNrZ3JvdW5kLCAubW9kYWwtY2xvc2UsIC5tb2RhbC1jYXJkLWhlYWQgLmRlbGV0ZSwgLm1vZGFsLWNhcmQtZm9vdCAuYnV0dG9uXCJcbiAgICApIHx8IFtdXG4gICkuZm9yRWFjaCgoJGNsb3NlKSA9PiB7XG4gICAgY29uc3QgJHRhcmdldCA9ICRjbG9zZS5jbG9zZXN0KFwiLm1vZGFsXCIpO1xuXG4gICAgJGNsb3NlLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCAoKSA9PiB7XG4gICAgICBjbG9zZU1vZGFsKCR0YXJnZXQpO1xuICAgIH0pO1xuICB9KTtcblxuICAvLyBBZGQgYSBrZXlib2FyZCBldmVudCB0byBjbG9zZSBhbGwgbW9kYWxzXG4gIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJrZXlkb3duXCIsIChldmVudCkgPT4ge1xuICAgIGNvbnN0IGUgPSBldmVudCB8fCB3aW5kb3cuZXZlbnQ7XG5cbiAgICBpZiAoZS5rZXlDb2RlID09PSAyNykge1xuICAgICAgLy8gRXNjYXBlIGtleVxuICAgICAgY2xvc2VBbGxNb2RhbHMoKTtcbiAgICB9XG4gIH0pO1xufSk7XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiJG5hdmJhckJ1cmdlcnMiLCJBcnJheSIsInByb3RvdHlwZSIsInNsaWNlIiwiY2FsbCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJsZW5ndGgiLCJmb3JFYWNoIiwiZWwiLCJ0YXJnZXQiLCJkYXRhc2V0IiwiJHRhcmdldCIsImdldEVsZW1lbnRCeUlkIiwiY2xhc3NMaXN0IiwidG9nZ2xlIiwib3Blbk1vZGFsIiwiJGVsIiwiYWRkIiwiY2xvc2VNb2RhbCIsInJlbW92ZSIsImNsb3NlQWxsTW9kYWxzIiwiJG1vZGFsIiwiJHRyaWdnZXIiLCJtb2RhbCIsImNvbnNvbGUiLCJsb2ciLCIkY2xvc2UiLCJjbG9zZXN0IiwiZXZlbnQiLCJlIiwid2luZG93Iiwia2V5Q29kZSJdLCJzb3VyY2VSb290IjoiIn0=