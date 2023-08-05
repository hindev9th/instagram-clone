"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pages_ProfilePage_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _functiton__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../functiton */ "./resources/js/functiton.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "ProfilePage",
  data: function data() {
    return {
      page: 1
    };
  },
  created: function created() {
    this.fetchProfile(this.$route.params.username);
    this.fetchPosts(this.$route.params.username);
  },
  computed: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapGetters)('profile', ['getProfile', 'getPosts'])), (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapGetters)('user', ['getAuth'])),
  methods: _objectSpread(_objectSpread({
    getImage: _functiton__WEBPACK_IMPORTED_MODULE_0__.getImage
  }, (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapActions)('profile', ['fetchProfile', 'fetchPosts', "fetchMorePosts"])), {}, {
    infiniteLoad: function infiniteLoad($state) {
      var _this = this;
      setTimeout(function () {
        _this.page++;
        _this.fetchMorePosts({
          'username': _this.$route.params.username,
          'page': _this.page
        }).then(function (e) {
          if (_this.page === _this.getPosts.last_page) {
            $state.complete();
          } else {
            $state.loaded();
          }
        });
      }, 1000);
    }
  })
});

/***/ }),

/***/ "./resources/js/components/pages/ProfilePage.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/pages/ProfilePage.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true& */ "./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true&");
/* harmony import */ var _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProfilePage.vue?vue&type=script&lang=js& */ "./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "a644de9c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pages/ProfilePage.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProfilePage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProfilePage_vue_vue_type_template_id_a644de9c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pages/ProfilePage.vue?vue&type=template&id=a644de9c&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "box-main" }, [
    _c("div", { staticClass: "container" }, [
      _vm.getProfile.profile
        ? _c("div", { staticClass: "row pb-5 border-bottom" }, [
            _c("div", { staticClass: "col-sm-3" }, [
              _c("img", {
                staticClass: "rounded-circle",
                attrs: {
                  src: _vm.getImage(_vm.getProfile.profile.image),
                  width: "200px",
                  height: "200px",
                },
              }),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-sm-9 pt-4" }, [
              _c("div", { staticClass: "container" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "d-flex" }, [
                    _c("h2", {
                      staticClass: "pr-3",
                      domProps: {
                        textContent: _vm._s(_vm.getProfile.username),
                      },
                    }),
                    _vm._v(" "),
                    _vm.getProfile.id === _vm.getAuth.id
                      ? _c(
                          "a",
                          {
                            staticClass: "btn btn-primary",
                            staticStyle: { height: "fit-content" },
                            attrs: { href: "#", title: "Edit profile" },
                          },
                          [_vm._v("Edit profile")]
                        )
                      : _c(
                          "div",
                          [
                            _c("follow-button", {
                              staticClass: "btn btn-primary text-right",
                              attrs: {
                                "user-id": _vm.getProfile.id,
                                follows: _vm.getProfile.isFollowed,
                              },
                            }),
                            _vm._v(" "),
                            _c(
                              "router-link",
                              {
                                staticClass: "btn btn-primary ml-2",
                                attrs: { to: { name: "chat" } },
                              },
                              [
                                _vm._v(
                                  "\n                                    Message\n                                "
                                ),
                              ]
                            ),
                          ],
                          1
                        ),
                  ]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row pb-3" }, [
                  _c("div", { staticClass: "pr-5" }, [
                    _c("strong", [_vm._v(_vm._s(_vm.getProfile.posts_count))]),
                    _vm._v(" posts"),
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "pr-5 d-flex" },
                    [
                      _c("strong", [
                        _vm._v(_vm._s(_vm.getProfile.followers_count)),
                      ]),
                      _vm._v("  \n                            "),
                      _c("show-user-button", {
                        attrs: {
                          action: "#",
                          title: "followers",
                          text: "followers",
                        },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "pr-5 d-flex" },
                    [
                      _c("strong", [
                        _vm._v(_vm._s(_vm.getProfile.following_count)),
                      ]),
                      _vm._v("  \n                            "),
                      _c("show-user-button", {
                        attrs: {
                          action: "#",
                          title: "following",
                          text: "following",
                        },
                      }),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c("strong", [_vm._v(_vm._s(_vm.getProfile.profile.title))]),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _vm._v(_vm._s(_vm.getProfile.profile.description)),
                ]),
              ]),
            ]),
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "tab-content" }, [
        _vm.getPosts
          ? _c(
              "div",
              { staticClass: "tab-pane active", attrs: { id: "POSTS" } },
              [
                _c(
                  "div",
                  { staticClass: "row" },
                  _vm._l(_vm.getPosts.data, function (post) {
                    return _c("div", { staticClass: "col-4 p-1" }, [
                      _c("a", { attrs: { href: "#" } }, [
                        _c("img", {
                          staticClass: "w-100",
                          attrs: { src: "/storage/" + post.image, alt: "" },
                        }),
                      ]),
                    ])
                  }),
                  0
                ),
                _vm._v(" "),
                _c("infinite-loading", { on: { infinite: _vm.infiniteLoad } }),
              ],
              1
            )
          : _vm._e(),
      ]),
    ]),
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);