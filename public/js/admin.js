/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(5);


/***/ }),

/***/ 5:
/***/ (function(module, exports) {

// Helper functions for the admin front end.
$(document).ready(function () {

	// Update the hidden "something_name" by listening and combining values from first_name and last_name fields.
	var hiddenFieldUpdater = {

		prefixes: ['staff', 'user'],

		init: function init() {
			this.setUpEventListeners();
		},

		setUpEventListeners: function setUpEventListeners() {
			for (index in this.prefixes) {

				// Set up variables.
				var $name = $('#add_form #' + this.prefixes[index] + '_name');
				var $first_name = $('#add_form #' + this.prefixes[index] + '_first_name');
				var $last_name = $('#add_form #' + this.prefixes[index] + '_last_name');

				// For insert fields.
				$first_name.on('change paste keyup', { name: $name, first_name: $first_name, last_name: $last_name }, function (e) {
					e.data.name.val($(this).val() + ' ' + e.data.last_name.val());
				});

				$last_name.on('change paste keyup', { name: $name, first_name: $first_name, last_name: $last_name }, function (e) {
					e.data.name.val(e.data.first_name.val() + ' ' + $(this).val());
				});

				// For update matrix.
				$('#update_form input.form-control').on('change paste keyup', function () {
					var $container = $(this).closest('tr');
					var $name_field = $container.find('.name');
					var first_name_value = $container.find('.first_name').val();
					var last_name_value = $container.find('.last_name').val();

					$name_field.val(first_name_value + ' ' + last_name_value);
				});
			}
		}
	};

	hiddenFieldUpdater.init();
});

/***/ })

/******/ });