(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./resources/js/components/Button.js":
/*!*******************************************!*\
  !*** ./resources/js/components/Button.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_2__);
var _excluded = ["sm", "success", "children"];

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }





function Button(_ref) {
  var sm = _ref.sm,
      success = _ref.success,
      children = _ref.children,
      otherProps = _objectWithoutProperties(_ref, _excluded);

  var buttonClass = classnames__WEBPACK_IMPORTED_MODULE_1___default()({
    btn: true,
    "btn-sm": sm ? true : false,
    "btn-success": success ? true : false
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", _extends({
    className: buttonClass
  }, otherProps), children);
}

Button.propTypes = {
  sm: prop_types__WEBPACK_IMPORTED_MODULE_2___default.a.bool,
  success: prop_types__WEBPACK_IMPORTED_MODULE_2___default.a.bool,
  children: prop_types__WEBPACK_IMPORTED_MODULE_2___default.a.array
};
/* harmony default export */ __webpack_exports__["default"] = (Button);

/***/ }),

/***/ "./resources/js/components/Form/DebounceInput.jsx":
/*!********************************************************!*\
  !*** ./resources/js/components/Form/DebounceInput.jsx ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
var _excluded = ["value", "onChange", "debounce"];

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }



var DebounceInput = function DebounceInput(_ref) {
  var initialValue = _ref.value,
      onChange = _ref.onChange,
      _ref$debounce = _ref.debounce,
      debounce = _ref$debounce === void 0 ? 500 : _ref$debounce,
      otherProps = _objectWithoutProperties(_ref, _excluded);

  var _useState = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(initialValue),
      _useState2 = _slicedToArray(_useState, 2),
      value = _useState2[0],
      setValue = _useState2[1];

  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(function () {
    setValue(initialValue);
  }, [initialValue]);
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(function () {
    var timeout = setTimeout(function () {
      onChange(value);
    }, debounce);
    return function () {
      return clearTimeout(timeout);
    };
  }, [value]);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
    value: value,
    onChange: function onChange(evt) {
      return setValue(evt.target.value);
    }
  }, otherProps));
};

/* harmony default export */ __webpack_exports__["default"] = (DebounceInput);

/***/ }),

/***/ "./resources/js/components/Form/FormCol.js":
/*!*************************************************!*\
  !*** ./resources/js/components/Form/FormCol.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_1__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }




function FormCol(_ref) {
  var sm = _ref.sm,
      className = _ref.className,
      children = _ref.children,
      style = _ref.style;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", _extends({
    className: "col-sm-".concat(sm)
  }, className, {
    style: style
  }), children);
}

FormCol.propTypes = {
  sm: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.string,
  className: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.string,
  children: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.any,
  style: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.object
};
/* harmony default export */ __webpack_exports__["default"] = (FormCol);

/***/ }),

/***/ "./resources/js/components/Form/FormRow.js":
/*!*************************************************!*\
  !*** ./resources/js/components/Form/FormRow.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_2__);
var _excluded = ["endOfForm", "children"];

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }





function FormRow(_ref) {
  var endOfForm = _ref.endOfForm,
      children = _ref.children,
      otherProps = _objectWithoutProperties(_ref, _excluded);

  var formClass = classnames__WEBPACK_IMPORTED_MODULE_1___default()({
    "form-row": true,
    "form-row-end": endOfForm
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", _extends({
    className: formClass
  }, otherProps), children);
}

FormRow.propTypes = {
  endOfForm: prop_types__WEBPACK_IMPORTED_MODULE_2___default.a.bool,
  children: prop_types__WEBPACK_IMPORTED_MODULE_2___default.a.any
};
/* harmony default export */ __webpack_exports__["default"] = (FormRow);

/***/ }),

/***/ "./resources/js/components/Form/errorMessage.js":
/*!******************************************************!*\
  !*** ./resources/js/components/Form/errorMessage.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ErrorMessage; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

function ErrorMessage(_ref) {
  var message = _ref.message;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: "flex items-center font-medium tracking-wide text-danger text-xs mt-1 mb-2 ml-1"
  }, message);
}

/***/ }),

/***/ "./resources/js/components/Form/index.js":
/*!***********************************************!*\
  !*** ./resources/js/components/Form/index.js ***!
  \***********************************************/
/*! exports provided: OptionGroup, Options, ErrorMessage, UploadComponent, UploadedFileComponent, FormRow, FormCol */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _optiongroup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./optiongroup */ "./resources/js/components/Form/optiongroup.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "OptionGroup", function() { return _optiongroup__WEBPACK_IMPORTED_MODULE_0__["default"]; });

/* harmony import */ var _options__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./options */ "./resources/js/components/Form/options.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "Options", function() { return _options__WEBPACK_IMPORTED_MODULE_1__["default"]; });

/* harmony import */ var _errorMessage__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./errorMessage */ "./resources/js/components/Form/errorMessage.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "ErrorMessage", function() { return _errorMessage__WEBPACK_IMPORTED_MODULE_2__["default"]; });

/* harmony import */ var _upload__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./upload */ "./resources/js/components/Form/upload/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "UploadComponent", function() { return _upload__WEBPACK_IMPORTED_MODULE_3__["default"]; });

/* harmony import */ var _uploadedFile__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./uploadedFile */ "./resources/js/components/Form/uploadedFile/index.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "UploadedFileComponent", function() { return _uploadedFile__WEBPACK_IMPORTED_MODULE_4__["default"]; });

/* harmony import */ var _FormRow__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./FormRow */ "./resources/js/components/Form/FormRow.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "FormRow", function() { return _FormRow__WEBPACK_IMPORTED_MODULE_5__["default"]; });

/* harmony import */ var _FormCol__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./FormCol */ "./resources/js/components/Form/FormCol.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "FormCol", function() { return _FormCol__WEBPACK_IMPORTED_MODULE_6__["default"]; });










/***/ }),

/***/ "./resources/js/components/Form/optiongroup.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/Form/optiongroup.js ***!
  \*****************************************************/
/*! exports provided: replaceSpace, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "replaceSpace", function() { return replaceSpace; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }


var replaceSpace = function replaceSpace(str) {
  return str.replace(/\s/g, "_");
};

var OptionGroup = function OptionGroup(_ref, ref) {
  var name = _ref.name,
      options = _ref.options,
      defaultChecked = _ref.defaultChecked,
      register = _ref.register;
  return options.map(function (item, i) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      key: "index-".concat(i),
      className: "form-check form-check-inline"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      ref: ref,
      className: "form-check-input",
      type: "radio",
      name: name,
      value: item.value,
      defaultChecked: defaultChecked === item.value
    }, register(replaceSpace(name).toLowerCase()))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
      className: "form-check-label",
      htmlFor: "inlineRadio1"
    }, item.label)));
  });
};

/* harmony default export */ __webpack_exports__["default"] = (OptionGroup);

/***/ }),

/***/ "./resources/js/components/Form/options.js":
/*!*************************************************!*\
  !*** ./resources/js/components/Form/options.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
var _excluded = ["label", "data", "onChange", "value", "readOnly", "optionValue", "optionLabel", "disableArrowDown"];

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }



var Options = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.forwardRef(function (_ref, ref) {
  var _ref$label = _ref.label,
      label = _ref$label === void 0 ? "" : _ref$label,
      _ref$data = _ref.data,
      data = _ref$data === void 0 ? [] : _ref$data,
      onChange = _ref.onChange,
      value = _ref.value,
      _ref$readOnly = _ref.readOnly,
      readOnly = _ref$readOnly === void 0 ? false : _ref$readOnly,
      _ref$optionValue = _ref.optionValue,
      optionValue = _ref$optionValue === void 0 ? "id" : _ref$optionValue,
      _ref$optionLabel = _ref.optionLabel,
      optionLabel = _ref$optionLabel === void 0 ? "name" : _ref$optionLabel,
      _ref$disableArrowDown = _ref.disableArrowDown,
      disableArrowDown = _ref$disableArrowDown === void 0 ? false : _ref$disableArrowDown,
      otherProps = _objectWithoutProperties(_ref, _excluded);

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, label && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, label), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", _extends({
    ref: ref,
    className: "form-control",
    onChange: onChange,
    readOnly: readOnly,
    style: {
      borderRight: '10px transparent solid',
      borderBottom: '15px'
    }
  }, otherProps), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
    value: ""
  }, "Pilih Opsi"), data.length > 0 && data.map(function (option, id) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
      key: "option-".concat(id),
      value: option[optionValue]
    }, lodash__WEBPACK_IMPORTED_MODULE_1___default.a.capitalize(option[optionLabel]));
  })));
});
/* harmony default export */ __webpack_exports__["default"] = (Options);

/***/ }),

/***/ "./resources/js/components/Form/upload/index.js":
/*!******************************************************!*\
  !*** ./resources/js/components/Form/upload/index.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


var UploadComponent = function UploadComponent(_ref) {
  var validationMessage = _ref.validationMessage,
      onChange = _ref.onChange;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "mt-1 flex w-80 lg:w-full bg-white justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "space-y-1 text-center"
  }, !!validationMessage && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: "font-semibold text-red-500"
  }, "Tipe File tidak didukung"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("svg", {
    width: "48",
    height: "48",
    className: "mx-auto h-4 w-4 text-gray-400",
    stroke: "currentColor",
    fill: "none",
    viewBox: "0 0 48 48",
    "aria-hidden": "true"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("path", {
    d: "M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02",
    strokeWidth: "2",
    strokeLinecap: "round",
    strokeLinejoin: "round"
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "flex text-sm text-gray-600 justify-center"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "file-upload",
    className: "relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: "text-center btn badge badge-primary"
  }, "Upload Foto/Gambar"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "file-upload",
    name: "file-upload",
    type: "file",
    className: "w-full sr-only",
    onChange: onChange
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    className: "text-xs text-center text-gray-500"
  }, "PNG, JPG ukuran Maksimal 3MB")));
};

/* harmony default export */ __webpack_exports__["default"] = (UploadComponent);

/***/ }),

/***/ "./resources/js/components/Form/uploadedFile/index.js":
/*!************************************************************!*\
  !*** ./resources/js/components/Form/uploadedFile/index.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


var UploadedFileComponent = function UploadedFileComponent(_ref) {
  var file = _ref.file,
      onClickRemove = _ref.onClickRemove;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "mt-2 flex w-80 lg:w-full justify-center px-6 pt-2 pb-3 border-2 border-gray-300 border-dashed rounded-md",
    style: {
      display: "flex",
      width: "100%",
      justifyContent: "center",
      border: "dashed 2px #FAFAFA"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "relative",
    style: {
      position: "relative"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "absolute -right-5 -top-2",
    style: {
      position: "absolute",
      top: '-2',
      right: "-5"
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    className: "text-red-600 hover:text-red-500",
    style: {
      color: "red"
    },
    href: "#",
    onClick: onClickRemove
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("svg", {
    width: "12",
    height: "12",
    className: "h-4 w-4 fill-current stroke-1",
    xmlns: "http://www.w3.org/2000/svg",
    x: "0",
    y: "0",
    enableBackground: "new 0 0 252 252",
    version: "1.1",
    viewBox: "0 0 252 252",
    xmlSpace: "preserve"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("path", {
    d: "M126 0C56.523 0 0 56.523 0 126s56.523 126 126 126 126-56.523 126-126S195.477 0 126 0zm0 234c-59.551 0-108-48.449-108-108S66.449 18 126 18s108 48.449 108 108-48.449 108-108 108z"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("path", {
    d: "M164.612 87.388a9 9 0 00-12.728 0L126 113.272l-25.885-25.885a9 9 0 00-12.728 0 9 9 0 000 12.728L113.272 126l-25.885 25.885a9 9 0 006.364 15.364 8.975 8.975 0 006.364-2.636L126 138.728l25.885 25.885c1.757 1.757 4.061 2.636 6.364 2.636s4.606-.879 6.364-2.636a9 9 0 000-12.728L138.728 126l25.885-25.885a9 9 0 00-.001-12.727z"
  })))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("img", {
    src: file,
    width: "100",
    height: "100"
  })));
};

/* harmony default export */ __webpack_exports__["default"] = (UploadedFileComponent);

/***/ }),

/***/ "./resources/js/components/Layout/Card.js":
/*!************************************************!*\
  !*** ./resources/js/components/Layout/Card.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


function Card(_ref) {
  var title = _ref.title,
      children = _ref.children;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "iq-card"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "iq-card-header d-flex justify-content-between"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "iq-header-title"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h4", {
    className: "card-title"
  }, title))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "iq-card-body"
  }, children));
}

/* harmony default export */ __webpack_exports__["default"] = (Card);

/***/ }),

/***/ "./resources/js/components/Layout/Container.js":
/*!*****************************************************!*\
  !*** ./resources/js/components/Layout/Container.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


function Container(props) {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-12 col-lg-12"
  }, props.children));
}

/* harmony default export */ __webpack_exports__["default"] = (Container);

/***/ }),

/***/ "./resources/js/components/Table/index.jsx":
/*!*************************************************!*\
  !*** ./resources/js/components/Table/index.jsx ***!
  \*************************************************/
/*! exports provided: TableFilter, TableActions, TableSearch */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableFilter", function() { return TableFilter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableActions", function() { return TableActions; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableSearch", function() { return TableSearch; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


var TableFilter = function TableFilter() {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row mt-4 mb-4 d-flex justify-content-center border-bottom"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group pr-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, "Periode"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "date",
    className: "form-control",
    max: new Date().toISOString().substring(0, 10)
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group pr-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, "\xA0"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "date",
    className: "form-control",
    max: new Date().toISOString().substring(0, 10)
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group pr-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", null, "\xA0"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    id: "btn-filter-project",
    type: "button",
    className: "btn btn-lg btn-block btn-primary px-6 position-relative",
    style: {
      height: '45px'
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
    className: "ri-filter-line pr-1"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("strong", null, "Filter"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: "badge bg-light ml-2 position-absolute top-0 start-100 rounded-circle text-dark translate-middle d-none"
  }, "4"))))));
};

var TableActions = function TableActions(_ref) {
  var isShow = _ref.isShow;
  return isShow ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    id: "action-tags",
    className: "col-md-3 text-center d-flex align-items-center justify-content-start"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    id: "action-tag-view",
    "data-id": "",
    className: "tag mr-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
    className: "fa fa-eye pt-2 h5",
    "aria-hidden": "true"
  }))) : null;
};

var TableSearch = function TableSearch() {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-md-3"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "searchFilter",
    className: "form-control form-control-sm pl-3",
    type: "text",
    placeholder: "Filter"
  })));
};



/***/ }),

/***/ "./resources/js/containers/Hse/safetyInduction/form-steps.jsx":
/*!********************************************************************!*\
  !*** ./resources/js/containers/Hse/safetyInduction/form-steps.jsx ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/umd/index.production.js");
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var formik__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! formik */ "./node_modules/formik/dist/formik.esm.js");
/* harmony import */ var _services__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./services */ "./resources/js/containers/Hse/safetyInduction/services.js");
/* harmony import */ var _slice__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./slice */ "./resources/js/containers/Hse/safetyInduction/slice.js");
/* harmony import */ var _validation__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./validation */ "./resources/js/containers/Hse/safetyInduction/validation.js");
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }








var selectStyles = {
  borderRight: '10px transparent solid'
};

var Step1 = function Step1(_ref) {
  var _errors$step8, _touched$step6, _errors$step9, _errors$step10, _errors$step11, _touched$step7, _errors$step12;

  var setFieldValue = _ref.setFieldValue,
      errors = _ref.errors,
      touched = _ref.touched,
      values = _ref.values,
      isValid = _ref.isValid,
      validateForm = _ref.validateForm;
  var dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();

  var _useState = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(0),
      _useState2 = _slicedToArray(_useState, 2),
      roleId = _useState2[0],
      setRoleId = _useState2[1];

  var deptId = 3;
  var jobRoles = Object(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__["useQuery"])(['jobRoles', deptId], function () {
    return Object(_services__WEBPACK_IMPORTED_MODULE_4__["getJobRolesFromDepartmentId"])(deptId);
  }, {
    refetchOnWindowFocus: false
  });
  var employees = Object(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__["useQuery"])(['employeeFromJobRole', parseInt(values.step1.jobRoles)], function () {
    return Object(_services__WEBPACK_IMPORTED_MODULE_4__["getEmployeeFromJobRoleId"])(values.step1.jobRoles);
  }, {
    refetchOnWindowFocus: false,
    enabled: parseInt(values.step1.jobRoles) > 0
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h5", {
    className: "modal-title mb-4"
  }, "surat pengantar HRD"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-6"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step1.nomsurat"
  }, function (_ref2) {
    var _errors$step, _touched$step, _errors$step2, _touched$step2, _errors$step3;

    var field = _ref2.field,
        form = _ref2.form,
        meta = _ref2.meta;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "form-group with-validation"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
      htmlFor: "colFormLabel"
    }, "Nomor Dokumen"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      type: "text",
      id: "step1.nomsurat",
      name: "step1.nomsurat",
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step = errors.step1) !== null && _errors$step !== void 0 && _errors$step.nomsurat && touched !== null && touched !== void 0 && (_touched$step = touched.step1) !== null && _touched$step !== void 0 && _touched$step.nomsurat ? 'is-invalid' : '', "\n                                    ")
    }, field)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "invalid-feedback"
    }, errors !== null && errors !== void 0 && (_errors$step2 = errors.step1) !== null && _errors$step2 !== void 0 && _errors$step2.nomsurat && touched !== null && touched !== void 0 && (_touched$step2 = touched.step1) !== null && _touched$step2 !== void 0 && _touched$step2.nomsurat ? errors === null || errors === void 0 ? void 0 : (_errors$step3 = errors.step1) === null || _errors$step3 === void 0 ? void 0 : _errors$step3.nomsurat : ''));
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-6"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step1.conductDate"
  }, function (_ref3) {
    var _errors$step4, _touched$step3, _errors$step5, _touched$step4, _errors$step6;

    var field = _ref3.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "form-group with-validation"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
      htmlFor: "colFormLabel"
    }, "Tanggal pelaksanaan induksi"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      type: "date",
      id: "step1.conductDate",
      name: "step1.conductDate",
      max: new Date().toISOString().substring(0, 10),
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step4 = errors.step1) !== null && _errors$step4 !== void 0 && _errors$step4.conductDate && touched !== null && touched !== void 0 && (_touched$step3 = touched.step1) !== null && _touched$step3 !== void 0 && _touched$step3.conductDate ? 'is-invalid' : '', "\n                        ")
    }, field)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "invalid-feedback"
    }, errors !== null && errors !== void 0 && (_errors$step5 = errors.step1) !== null && _errors$step5 !== void 0 && _errors$step5.conductDate && touched !== null && touched !== void 0 && (_touched$step4 = touched.step1) !== null && _touched$step4 !== void 0 && _touched$step4.conductDate ? errors === null || errors === void 0 ? void 0 : (_errors$step6 = errors.step1) === null || _errors$step6 === void 0 ? void 0 : _errors$step6.conductDate : ''));
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-6"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Job Roles"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step1.jobRoles"
  }, function (_ref4) {
    var _jobRoles$data;

    var field = _ref4.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", _extends({
      className: "form-control",
      style: selectStyles,
      value: roleId,
      onChange: function onChange(evt) {
        setRoleId(evt.target.value, setRoleId);
      }
    }, field), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
      value: "0"
    }, jobRoles !== null && jobRoles !== void 0 && jobRoles.isLoading ? 'Loading data ...' : ''), jobRoles === null || jobRoles === void 0 ? void 0 : (_jobRoles$data = jobRoles.data) === null || _jobRoles$data === void 0 ? void 0 : _jobRoles$data.map(function (role) {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
        key: role.id,
        value: role.id
      }, role.nm_jabatan);
    }));
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-6"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Employees"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step1.employees"
  }, function (_ref5) {
    var _errors$step7, _touched$step5, _employees$data;

    var field = _ref5.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", _extends({
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step7 = errors.step1) !== null && _errors$step7 !== void 0 && _errors$step7.employees && touched !== null && touched !== void 0 && (_touched$step5 = touched.step1) !== null && _touched$step5 !== void 0 && _touched$step5.employees ? 'is-invalid' : '', "\n                                ")
    }, field), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
      value: 0
    }, employees !== null && employees !== void 0 && employees.isFetching ? 'Loading data ...' : ''), employees === null || employees === void 0 ? void 0 : (_employees$data = employees.data) === null || _employees$data === void 0 ? void 0 : _employees$data.map(function (employee) {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
        key: employee.id,
        value: employee.id
      }, employee.nm_lengkap);
    }));
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step8 = errors.step1) !== null && _errors$step8 !== void 0 && _errors$step8.employees && touched !== null && touched !== void 0 && (_touched$step6 = touched.step1) !== null && _touched$step6 !== void 0 && _touched$step6.employees ? errors === null || errors === void 0 ? void 0 : (_errors$step9 = errors.step1) === null || _errors$step9 === void 0 ? void 0 : _errors$step9.employees : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Upload File"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "file",
    id: "step1.file",
    name: "step1.file",
    onChange: function onChange(evt) {
      return setFieldValue('step1.file', evt.currentTarget.files[0]);
    },
    className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step10 = errors.step1) !== null && _errors$step10 !== void 0 && _errors$step10.file ? 'is-invalid' : '')
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step11 = errors.step1) !== null && _errors$step11 !== void 0 && _errors$step11.file || touched !== null && touched !== void 0 && (_touched$step7 = touched.step1) !== null && _touched$step7 !== void 0 && _touched$step7.file ? errors === null || errors === void 0 ? void 0 : (_errors$step12 = errors.step1) === null || _errors$step12 === void 0 ? void 0 : _errors$step12.file : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-12"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    type: "button" // disabled={!isValid}
    ,
    onClick: function onClick() {
      return dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["setModalActiveStep"])(1));
    },
    className: "btn btn-lg btn-next-step btn-block btn-primary"
  }, "Next"))));
};

var Step2 = function Step2(_ref6) {
  var _errors$step14, _touched$step9, _errors$step15, _errors$step16, _touched$step10, _errors$step17, _touched$step11, _errors$step18;

  var setFieldValue = _ref6.setFieldValue,
      errors = _ref6.errors,
      touched = _ref6.touched;
  var dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  console.log(errors);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h4", null, "Form safety induction"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Nomor Dokumen"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step2.nomsurat"
  }, function (_ref7) {
    var _errors$step13, _touched$step8;

    var field = _ref7.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      type: "text",
      name: "step2.nomsurat",
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step13 = errors.step2) !== null && _errors$step13 !== void 0 && _errors$step13.nomsurat && touched !== null && touched !== void 0 && (_touched$step8 = touched.step2) !== null && _touched$step8 !== void 0 && _touched$step8.nomsurat ? 'is-invalid' : '', "\n                                    ")
    }, field));
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step14 = errors.step2) !== null && _errors$step14 !== void 0 && _errors$step14.nomsurat && touched !== null && touched !== void 0 && (_touched$step9 = touched.step2) !== null && _touched$step9 !== void 0 && _touched$step9.nomsurat ? errors === null || errors === void 0 ? void 0 : (_errors$step15 = errors.step2) === null || _errors$step15 === void 0 ? void 0 : _errors$step15.nomsurat : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Upload File"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "file",
    name: "step2.file",
    className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step16 = errors.step2) !== null && _errors$step16 !== void 0 && _errors$step16.file || touched !== null && touched !== void 0 && (_touched$step10 = touched.step2) !== null && _touched$step10 !== void 0 && _touched$step10.file ? 'is-invalid' : ''),
    onChange: function onChange(evt) {
      return setFieldValue('step2.file', evt.currentTarget.files[0]);
    }
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step17 = errors.step2) !== null && _errors$step17 !== void 0 && _errors$step17.file || touched !== null && touched !== void 0 && (_touched$step11 = touched.step2) !== null && _touched$step11 !== void 0 && _touched$step11.file ? errors === null || errors === void 0 ? void 0 : (_errors$step18 = errors.step2) === null || _errors$step18 === void 0 ? void 0 : _errors$step18.file : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-12"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    type: "button" // disabled={!isValid}
    ,
    onClick: function onClick() {
      return dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["setModalActiveStep"])(2));
    },
    className: "btn btn-lg btn-next-step btn-block btn-primary"
  }, "Next"))));
};

var Step3 = function Step3(_ref8) {
  var _errors$step20, _touched$step13, _errors$step21, _errors$step22, _touched$step14, _errors$step23, _touched$step15, _errors$step24;

  var setFieldValue = _ref8.setFieldValue,
      errors = _ref8.errors,
      touched = _ref8.touched;
  var dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h4", null, "Job Safety Analysis"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Nomor Dokumen"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step3.nomsurat"
  }, function (_ref9) {
    var _errors$step19, _touched$step12;

    var field = _ref9.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      type: "text",
      name: "step3.nomsurat",
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step19 = errors.step3) !== null && _errors$step19 !== void 0 && _errors$step19.nomsurat && touched !== null && touched !== void 0 && (_touched$step12 = touched.step3) !== null && _touched$step12 !== void 0 && _touched$step12.nomsurat ? 'is-invalid' : '', "\n                                    ")
    }, field));
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step20 = errors.step3) !== null && _errors$step20 !== void 0 && _errors$step20.nomsurat && touched !== null && touched !== void 0 && (_touched$step13 = touched.step3) !== null && _touched$step13 !== void 0 && _touched$step13.nomsurat ? errors === null || errors === void 0 ? void 0 : (_errors$step21 = errors.step3) === null || _errors$step21 === void 0 ? void 0 : _errors$step21.nomsurat : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Upload File"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "file",
    name: "step3.file",
    className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step22 = errors.step3) !== null && _errors$step22 !== void 0 && _errors$step22.file || touched !== null && touched !== void 0 && (_touched$step14 = touched.step3) !== null && _touched$step14 !== void 0 && _touched$step14.file ? 'is-invalid' : ''),
    onChange: function onChange(evt) {
      return setFieldValue('step3.file', evt.currentTarget.files[0]);
    }
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step23 = errors.step3) !== null && _errors$step23 !== void 0 && _errors$step23.file || touched !== null && touched !== void 0 && (_touched$step15 = touched.step3) !== null && _touched$step15 !== void 0 && _touched$step15.file ? errors === null || errors === void 0 ? void 0 : (_errors$step24 = errors.step3) === null || _errors$step24 === void 0 ? void 0 : _errors$step24.file : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-12"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    type: "button",
    onClick: function onClick() {
      return dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["setModalActiveStep"])(3));
    },
    "data-next": "2",
    className: "btn btn-lg btn-next-step btn-block btn-primary"
  }, "Next"))));
};

var Step4 = function Step4(_ref10) {
  var _errors$step26, _touched$step17, _errors$step27, _errors$step28, _touched$step18, _errors$step29, _touched$step19, _errors$step30;

  var setFieldValue = _ref10.setFieldValue,
      errors = _ref10.errors,
      touched = _ref10.touched,
      isValid = _ref10.isValid;
  // const dispatch = useDispatch()
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h4", null, "Quesioner"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Nomor Dokumen"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Field"], {
    name: "step4.nomsurat"
  }, function (_ref11) {
    var _errors$step25, _touched$step16;

    var field = _ref11.field;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
      type: "text",
      name: "step4.nomsurat",
      className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step25 = errors.step4) !== null && _errors$step25 !== void 0 && _errors$step25.nomsurat && touched !== null && touched !== void 0 && (_touched$step16 = touched.step4) !== null && _touched$step16 !== void 0 && _touched$step16.nomsurat ? 'is-invalid' : '', "\n                                    ")
    }, field));
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step26 = errors.step4) !== null && _errors$step26 !== void 0 && _errors$step26.nomsurat && touched !== null && touched !== void 0 && (_touched$step17 = touched.step4) !== null && _touched$step17 !== void 0 && _touched$step17.nomsurat ? errors === null || errors === void 0 ? void 0 : (_errors$step27 = errors.step4) === null || _errors$step27 === void 0 ? void 0 : _errors$step27.nomsurat : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-7"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group with-validation"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "colFormLabel"
  }, "Upload File"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "file",
    name: "step4.file",
    className: "form-control ".concat(errors !== null && errors !== void 0 && (_errors$step28 = errors.step4) !== null && _errors$step28 !== void 0 && _errors$step28.file || touched !== null && touched !== void 0 && (_touched$step18 = touched.step4) !== null && _touched$step18 !== void 0 && _touched$step18.file ? 'is-invalid' : ''),
    onChange: function onChange(evt) {
      return setFieldValue('step4.file', evt.currentTarget.files[0]);
    }
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "invalid-feedback"
  }, errors !== null && errors !== void 0 && (_errors$step29 = errors.step4) !== null && _errors$step29 !== void 0 && _errors$step29.file || touched !== null && touched !== void 0 && (_touched$step19 = touched.step4) !== null && _touched$step19 !== void 0 && _touched$step19.file ? errors === null || errors === void 0 ? void 0 : (_errors$step30 = errors.step4) === null || _errors$step30 === void 0 ? void 0 : _errors$step30.file : '')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-sm-12"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    type: "submit",
    disabled: !isValid,
    className: "btn btn-lg btn-next-step btn-block btn-primary"
  }, "Simpan"))));
};

var FormSteps = function FormSteps() {
  var activeStep = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(function (state) {
    return state.safetySlice.modal.activeStep;
  });
  var induction = Object(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_2__["useMutation"])(function (formData) {
    return Object(_services__WEBPACK_IMPORTED_MODULE_4__["createInduction"])(formData);
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Formik"], {
    initialValues: {
      step1: {
        nomsurat: '',
        jobRoles: '',
        employees: '',
        file: ''
      },
      step2: {
        nomsurat: '',
        file: ''
      },
      step3: {
        nomsurat: '',
        file: ''
      },
      step4: {
        nomsurat: '',
        file: ''
      }
    },
    validationSchema: _validation__WEBPACK_IMPORTED_MODULE_6__["stepsValidation"],
    onSubmit: function onSubmit(values) {
      // same shape as initial values
      // console.log(values);
      // let data = new FormData();

      /*
      step1.nomsurat
      step1.conductDate
      step1.employees
      step1.file
        step2.nomsurat
      step2.file
        step3.nomsurat
      step3.file
        step4.nomsurat
      step4.file
      */
      // data.append('step1_nomsurat', values.step1.file)
      // data.append('step1_conductDate', values.step1.conductDate)
      // data.append('step1_file', values.step1.file)
      // data.append('step2_nomsurat', values.step2.file)                
      // data.append('step2_file', values.step2.file)
      // data.append('step3_nomsurat', values.step3.file)                
      // data.append('step3_file', values.step3.file)
      // data.append('step4_nomsurat', values.step4.file)                
      // data.append('step4_file', values.step4.file)
      induction.mutate(values);
    }
  }, function (props) {
    // console.log(props.errors)
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(formik__WEBPACK_IMPORTED_MODULE_3__["Form"], {
      onSubmit: props.handleSubmit
    }, activeStep == 0 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Step1, props), activeStep == 1 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Step2, props), activeStep == 2 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Step3, props), activeStep == 3 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Step4, props));
  });
};

/* harmony default export */ __webpack_exports__["default"] = (FormSteps);

/***/ }),

/***/ "./resources/js/containers/Hse/safetyInduction/index.jsx":
/*!***************************************************************!*\
  !*** ./resources/js/containers/Hse/safetyInduction/index.jsx ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @tanstack/react-table */ "./node_modules/@tanstack/react-table/build/umd/index.production.js");
/* harmony import */ var _tanstack_react_table__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _tanstack_match_sorter_utils__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @tanstack/match-sorter-utils */ "./node_modules/@tanstack/match-sorter-utils/build/umd/index.production.js");
/* harmony import */ var _tanstack_match_sorter_utils__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_tanstack_match_sorter_utils__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @tanstack/react-query */ "./node_modules/@tanstack/react-query/build/umd/index.production.js");
/* harmony import */ var _tanstack_react_query__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _slice__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./slice */ "./resources/js/containers/Hse/safetyInduction/slice.js");
/* harmony import */ var _components_Layout_Container__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/components/Layout/Container */ "./resources/js/components/Layout/Container.js");
/* harmony import */ var _components_Layout_Card__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/components/Layout/Card */ "./resources/js/components/Layout/Card.js");
/* harmony import */ var _components_Form__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @/components/Form */ "./resources/js/components/Form/index.js");
/* harmony import */ var _components_Button__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @/components/Button */ "./resources/js/components/Button.js");
/* harmony import */ var _components_Table__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @/components/Table */ "./resources/js/components/Table/index.jsx");
/* harmony import */ var _components_Form_DebounceInput__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @/components/Form/DebounceInput */ "./resources/js/components/Form/DebounceInput.jsx");
/* harmony import */ var _form_steps__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./form-steps */ "./resources/js/containers/Hse/safetyInduction/form-steps.jsx");
/* harmony import */ var _step_indicator__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./step-indicator */ "./resources/js/containers/Hse/safetyInduction/step-indicator.jsx");
/* harmony import */ var _services__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./services */ "./resources/js/containers/Hse/safetyInduction/services.js");
var _excluded = ["indeterminate"];

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]; if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }






 // components










var defaultData = [{
  id: '1',
  tanggal: '20/08/2022',
  karyawan: 'Denny R',
  dokumen: 'surat pengantar | kuesioner | JSA',
  approval: 'HSE manager'
}, {
  id: '2',
  tanggal: '20/08/2022',
  karyawan: 'Amzar N',
  dokumen: 'surat pengantar | kuesioner | JSA',
  approval: 'HSE manager'
}];
var columnHelper = Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["createColumnHelper"])();

var fuzzyFilter = function fuzzyFilter(row, columnId, value, addMeta) {
  var itemRank = Object(_tanstack_match_sorter_utils__WEBPACK_IMPORTED_MODULE_2__["rankItem"])(row.getValue(columnId), value);
  addMeta({
    itemRank: itemRank
  });
  return itemRank.passed;
}; // table specific components


var Checkbox = function Checkbox(_ref) {
  var indeterminate = _ref.indeterminate,
      otherProps = _objectWithoutProperties(_ref, _excluded);

  var ref = Object(react__WEBPACK_IMPORTED_MODULE_0__["useRef"])(null);
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(function () {
    if (typeof indeterminate === 'boolean') {
      ref.current.indeterminate = !otherProps.checked && indeterminate;
    }
  }, [ref, indeterminate]);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", _extends({
    ref: ref,
    type: "checkbox"
  }, otherProps));
}; // test modal


var ModalDialog = function ModalDialog(_ref2) {
  var children = _ref2.children;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "modal fade",
    id: "createProjectModal",
    tabIndex: "-1",
    role: "dialog",
    "aria-labelledby": "createProjectModal",
    "aria-modal": "true"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "modal-dialog w600",
    role: "document"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "modal-content"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "modal-body"
  }, children))));
};

var ModalBody = function ModalBody() {
  var dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_4__["useDispatch"])();
  var activeStep = Object(react_redux__WEBPACK_IMPORTED_MODULE_4__["useSelector"])(function (state) {
    return state.safetySlice.modal.activeStep;
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row mb-4"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_step_indicator__WEBPACK_IMPORTED_MODULE_13__["default"], null)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    type: "button",
    className: "absolute-close",
    "data-dismiss": "modal",
    "aria-label": "Close"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
    className: "ri-close-line"
  })), activeStep > 0 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    className: "btn-prev-step",
    onClick: function onClick(evt) {
      evt.preventDefault();
      dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["setModalActiveStep"])(activeStep - 1));
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
    className: "ri-arrow-left-line"
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_form_steps__WEBPACK_IMPORTED_MODULE_12__["default"], null));
};

var IndexPage = function IndexPage() {
  var _Object$keys$;

  var dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_4__["useDispatch"])();
  var isPageLoaded = Object(react_redux__WEBPACK_IMPORTED_MODULE_4__["useSelector"])(function (state) {
    return state.safetySlice.isInductionPageLoaded;
  });
  var inductions = Object(_tanstack_react_query__WEBPACK_IMPORTED_MODULE_3__["useQuery"])(['jobRoles'], _services__WEBPACK_IMPORTED_MODULE_14__["getInductions"]); // console.log(inductions);

  var columns = Object(react__WEBPACK_IMPORTED_MODULE_0__["useMemo"])(function () {
    return [columnHelper.display({
      id: 'actions',
      header: 'actions',
      cell: function cell(_ref3) {
        var row = _ref3.row;
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Checkbox, {
          checked: row.getIsSelected(),
          indeterminate: row.getIsSomeSelected(),
          onChange: row.getToggleSelectedHandler()
        });
      }
    }), columnHelper.accessor('tanggal', {
      cell: function cell(info) {
        return info.getValue();
      }
    }), columnHelper.accessor('karyawan', {
      cell: function cell(info) {
        return info.getValue();
      }
    }), columnHelper.accessor('dokumen', {
      cell: function cell(info) {
        return info.getValue();
      }
    }), columnHelper.accessor(function (row) {
      return row.approval;
    }, {
      id: 'approval',
      cell: function cell(info) {
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", null, info.getValue());
      }
    })];
  }, []);

  var _useState = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(function () {
    return [].concat(defaultData);
  }),
      _useState2 = _slicedToArray(_useState, 2),
      data = _useState2[0],
      setData = _useState2[1];

  var _useState3 = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(0),
      _useState4 = _slicedToArray(_useState3, 2),
      activeIndicatorId = _useState4[0],
      setActiveIndicatorId = _useState4[1];

  var _useState5 = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])({}),
      _useState6 = _slicedToArray(_useState5, 2),
      rowSelection = _useState6[0],
      setRowSelection = _useState6[1];

  var _useState7 = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(''),
      _useState8 = _slicedToArray(_useState7, 2),
      globalFilter = _useState8[0],
      setGlobalFilter = _useState8[1];

  var table = Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["useReactTable"])({
    data: data,
    columns: columns,
    state: {
      globalFilter: globalFilter,
      rowSelection: rowSelection
    },
    enableMultiRowSelection: false,
    onRowSelectionChange: setRowSelection,
    onGlobalFilterChange: setGlobalFilter,
    globalFilterFn: fuzzyFilter,
    getCoreRowModel: Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["getCoreRowModel"])(),
    getFilteredRowModel: Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["getFilteredRowModel"])()
  });
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(function () {
    dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["loadPage"])());
  }, []);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Layout_Container__WEBPACK_IMPORTED_MODULE_6__["default"], null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(ModalDialog, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(ModalBody, null)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Layout_Card__WEBPACK_IMPORTED_MODULE_7__["default"], {
    title: "Report Safety Induction"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Form__WEBPACK_IMPORTED_MODULE_8__["FormRow"], null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Form__WEBPACK_IMPORTED_MODULE_8__["FormCol"], {
    sm: "6"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Button__WEBPACK_IMPORTED_MODULE_9__["default"], {
    success: true,
    onClick: function onClick() {
      return dispatch(Object(_slice__WEBPACK_IMPORTED_MODULE_5__["setUiAction"])('create_new_report'));
    },
    "data-toggle": "modal",
    "data-backdrop": "static",
    "data-target": "#createProjectModal"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("i", {
    className: "las la-plus"
  }), "Create New Report"))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Form__WEBPACK_IMPORTED_MODULE_8__["FormRow"], {
    style: {
      marginTop: '2rem'
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Form__WEBPACK_IMPORTED_MODULE_8__["FormCol"], {
    sm: "12"
  }, isPageLoaded, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Table__WEBPACK_IMPORTED_MODULE_10__["TableFilter"], null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Table__WEBPACK_IMPORTED_MODULE_10__["TableActions"], {
    isShow: (_Object$keys$ = Object.keys(rowSelection)[0]) !== null && _Object$keys$ !== void 0 ? _Object$keys$ : 0
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "flex-grow-1"
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-md-3"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "form-group"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_components_Form_DebounceInput__WEBPACK_IMPORTED_MODULE_11__["default"], {
    className: "form-control form-control-sm pl-3",
    value: globalFilter !== null && globalFilter !== void 0 ? globalFilter : '',
    onChange: function onChange(value) {
      return setGlobalFilter(String(value));
    },
    type: "text",
    placeholder: "Filter"
  })))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "row mt-2"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: "col-12"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("table", {
    className: "table table-data nowrap w-100"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("thead", null, table.getHeaderGroups().map(function (headerGroup) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
      className: "tr-shadow",
      key: headerGroup.id
    }, headerGroup.headers.map(function (header) {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
        key: header.id
      }, Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["flexRender"])(header.column.columnDef.header, header.getContext()));
    }));
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tbody", null, table.getRowModel().rows.map(function (row) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
      key: row.id
    }, row.getVisibleCells().map(function (cell) {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
        key: cell.id
      }, Object(_tanstack_react_table__WEBPACK_IMPORTED_MODULE_1__["flexRender"])(cell.column.columnDef.cell, cell.getContext()));
    }));
  })))))))));
};

IndexPage.propTypes = {};
/* harmony default export */ __webpack_exports__["default"] = (IndexPage);

/***/ }),

/***/ "./resources/js/containers/Hse/safetyInduction/services.js":
/*!*****************************************************************!*\
  !*** ./resources/js/containers/Hse/safetyInduction/services.js ***!
  \*****************************************************************/
/*! exports provided: getJobRolesFromDepartmentId, getEmployeeFromJobRoleId, getInductions, createInduction */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getJobRolesFromDepartmentId", function() { return getJobRolesFromDepartmentId; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getEmployeeFromJobRoleId", function() { return getEmployeeFromJobRoleId; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getInductions", function() { return getInductions; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createInduction", function() { return createInduction; });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

 // import axios from '../../../utils';
// ambil data karyawan berdasarkan departemen proyek (fixed) dan jabatan (jobRole)

var getEmployeeFromJobRoleId = /*#__PURE__*/function () {
  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(jobRoleId) {
    var response;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _context.next = 2;
            return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/safetyInduction/employeesFromJobRoleId/".concat(jobRoleId));

          case 2:
            response = _context.sent;
            return _context.abrupt("return", response.data);

          case 4:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  }));

  return function getEmployeeFromJobRoleId(_x) {
    return _ref.apply(this, arguments);
  };
}();

var getJobRolesFromDepartmentId = /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(departmentId) {
    var response;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            _context2.next = 2;
            return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get("/safetyInduction/jobRoles/".concat(departmentId));

          case 2:
            response = _context2.sent;
            return _context2.abrupt("return", response.data);

          case 4:
          case "end":
            return _context2.stop();
        }
      }
    }, _callee2);
  }));

  return function getJobRolesFromDepartmentId(_x2) {
    return _ref2.apply(this, arguments);
  };
}();

var getInductions = /*#__PURE__*/function () {
  var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
    var response;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
      while (1) {
        switch (_context3.prev = _context3.next) {
          case 0:
            _context3.next = 2;
            return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get('/safetyInduction/inductions');

          case 2:
            response = _context3.sent;
            return _context3.abrupt("return", response.data);

          case 4:
          case "end":
            return _context3.stop();
        }
      }
    }, _callee3);
  }));

  return function getInductions() {
    return _ref3.apply(this, arguments);
  };
}();

var createInduction = /*#__PURE__*/function () {
  var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4(formData) {
    var response;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
      while (1) {
        switch (_context4.prev = _context4.next) {
          case 0:
            _context4.next = 2;
            return axios__WEBPACK_IMPORTED_MODULE_1___default.a.post('/safetyInduction/induction', formData, {
              headers: {
                ContentType: 'application/json'
              }
            });

          case 2:
            response = _context4.sent;
            return _context4.abrupt("return", response.data);

          case 4:
          case "end":
            return _context4.stop();
        }
      }
    }, _callee4);
  }));

  return function createInduction(_x3) {
    return _ref4.apply(this, arguments);
  };
}();



/***/ }),

/***/ "./resources/js/containers/Hse/safetyInduction/step-indicator.jsx":
/*!************************************************************************!*\
  !*** ./resources/js/containers/Hse/safetyInduction/step-indicator.jsx ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");



var Indicator = function Indicator(_ref) {
  var activeIndicatorId = _ref.activeIndicatorId,
      items = _ref.items;
  return items.map(function (item, id) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      key: "item-".concat(id),
      className: "col-3"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "indicator-step ".concat(activeIndicatorId === id ? 'active' : '')
    }));
  });
};

var StepsIndicator = function StepsIndicator() {
  var activeStep = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(function (state) {
    return state.safetySlice.modal.activeStep;
  });
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Indicator, {
    items: [0, 1, 2, 3],
    activeIndicatorId: activeStep
  });
};

/* harmony default export */ __webpack_exports__["default"] = (StepsIndicator);

/***/ }),

/***/ "./resources/js/containers/Hse/safetyInduction/validation.js":
/*!*******************************************************************!*\
  !*** ./resources/js/containers/Hse/safetyInduction/validation.js ***!
  \*******************************************************************/
/*! exports provided: stepsValidation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "stepsValidation", function() { return stepsValidation; });
/* harmony import */ var yup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! yup */ "./node_modules/yup/es/index.js");


var getExtension = function getExtension(filename) {
  if (typeof filename !== 'undefined') {
    return filename.split('.').pop();
  }
};

var stepsValidation = yup__WEBPACK_IMPORTED_MODULE_0__["object"]().shape({
  step1: yup__WEBPACK_IMPORTED_MODULE_0__["object"]().shape({
    nomsurat: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().required('nomor dokumen wajib diisi!'),
    conductDate: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().required('Tanggal pelaksanaan induksi wajib diisi'),
    employees: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().min(1).required('wajib mengisi nama karyawan yang akan diinduksi'),
    file: yup__WEBPACK_IMPORTED_MODULE_0__["mixed"]().test({
      message: 'upload dokumen wajib diisi',
      test: function test(file, context) {
        var isValid = typeof file !== 'undefined';
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'type file yang disupport hanya png, pdf',
      test: function test(file, context) {
        var isValid = ['pdf', 'png'].includes(getExtension(file === null || file === void 0 ? void 0 : file.name));
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'ukuran maksimal 1 MB',
      test: function test(file) {
        // console.log('file size in MB ', file?.size / 1024 / 1024)
        var isValid = (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024 < 1;
        return isValid;
      }
    })
  }),
  step2: yup__WEBPACK_IMPORTED_MODULE_0__["object"]().shape({
    nomsurat: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().required('nomor dokumen wajib diisi!'),
    file: yup__WEBPACK_IMPORTED_MODULE_0__["mixed"]().test({
      message: 'upload dokumen wajib diisi',
      test: function test(file, context) {
        var isValid = typeof file !== 'undefined';
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'type file yang disupport hanya png, pdf',
      test: function test(file, context) {
        var isValid = ['pdf', 'png'].includes(getExtension(file === null || file === void 0 ? void 0 : file.name));
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'ukuran maksimal 1 MB',
      test: function test(file) {
        console.log('file size in MB ', (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024);
        var isValid = (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024 < 1;
        return isValid;
      }
    })
  }),
  step3: yup__WEBPACK_IMPORTED_MODULE_0__["object"]().shape({
    nomsurat: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().required('nomor dokumen wajib diisi!'),
    file: yup__WEBPACK_IMPORTED_MODULE_0__["mixed"]().test({
      message: 'upload dokumen wajib diisi',
      test: function test(file, context) {
        var isValid = typeof file !== 'undefined';
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'type file yang disupport hanya png, pdf',
      test: function test(file, context) {
        var isValid = ['pdf', 'png'].includes(getExtension(file === null || file === void 0 ? void 0 : file.name));
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'ukuran maksimal 1 MB',
      test: function test(file) {
        console.log('file size in MB ', (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024);
        var isValid = (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024 < 1;
        return isValid;
      }
    })
  }),
  step4: yup__WEBPACK_IMPORTED_MODULE_0__["object"]().shape({
    nomsurat: yup__WEBPACK_IMPORTED_MODULE_0__["string"]().required('nomor dokumen wajib diisi!'),
    file: yup__WEBPACK_IMPORTED_MODULE_0__["mixed"]().test({
      message: 'upload dokumen wajib diisi',
      test: function test(file, context) {
        var isValid = typeof file !== 'undefined';
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'type file yang disupport hanya png, pdf',
      test: function test(file, context) {
        var isValid = ['pdf', 'png'].includes(getExtension(file === null || file === void 0 ? void 0 : file.name));
        if (!isValid) context === null || context === void 0 ? void 0 : context.createError();
        return isValid;
      }
    }).test({
      message: 'ukuran maksimal 1 MB',
      test: function test(file) {
        console.log('file size in MB ', (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024);
        var isValid = (file === null || file === void 0 ? void 0 : file.size) / 1024 / 1024 < 1;
        return isValid;
      }
    })
  })
});

/***/ })

}]);