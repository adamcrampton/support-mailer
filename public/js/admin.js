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
	// Listen for changes to 'first_name' and 'last_name' type fields.
	// Populate the hidden 'name' fields with updated values on change.
	var $staff_name = $('#staff_name');
	var $staff_first_name = $('#staff_first_name');
	var $staff_last_name = $('#staff_last_name');

	$staff_first_name.on('change paste keyup', function () {
		$staff_name.val($(this).val() + ' ' + $staff_last_name.val());
	});

	$staff_last_name.on('change paste keyup', function () {
		$staff_name.val($staff_first_name.val() + ' ' + $(this).val());
	});

	$('input[data-update-row]').on('change paste keyup', function () {
		var row_to_find = $(this).attr('data-update-row');
		if ($(this).attr('data-input-type') === 'first_name') {
			$('input[data-update-row="' + row_to_find + '"][data-input-type="name"]').val($(this).val() + ' ' + $('input[data-update-row="' + row_to_find + '"][data-input-type="last_name"]').val());
		} else {
			$('input[data-update-row="' + row_to_find + '"][data-input-type="name"]').val($('input[data-update-row="' + row_to_find + '"][data-input-type="first_name"]').val() + ' ' + $(this).val());
		}
	});
});

/***/ })

/******/ });