webpackJsonp([1],{

/***/ 125:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(148)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(150)
/* template */
var __vue_template__ = __webpack_require__(161)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4931cae4"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/pages/Canal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4931cae4", Component.options)
  } else {
    hotAPI.reload("data-v-4931cae4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 148:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(149);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("bee04172", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 149:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.page-header[data-v-4931cae4] {\n  margin: 0;\n}\n.page-header .page-title[data-v-4931cae4] {\n  margin-top: 0;\n  position: relative;\n  margin-bottom: 30px;\n}\n.page-header .page-title[data-v-4931cae4]:after {\n  width: 15%;\n  height: 2px;\n  content: '';\n  background: var(--color);\n  display: block;\n  position: absolute;\n  bottom: -10px;\n}\n[data-v-4931cae4]:root {\n  --background: var(--color);\n}\naside > header > h3[data-v-4931cae4] {\n  margin-top: 5px;\n  font-size: 18px;\n}\n", ""]);

// exports


/***/ }),

/***/ 150:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue__ = __webpack_require__(151);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue__ = __webpack_require__(156);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__http_js__ = __webpack_require__(5);


function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

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





var http = new __WEBPACK_IMPORTED_MODULE_3__http_js__["a" /* default */]();

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'canal',
    components: { NavCanal: __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue___default.a, SidebarCanal: __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue___default.a },
    data: function data() {
        return {
            title: '',
            descricao: null,
            idCanal: null,
            options: null,
            color: '#1e78c2',
            hasCategories: false
        };
    },
    created: function created() {},
    mounted: function mounted() {
        this.getCanal();
    },

    watch: {
        '$route': function $route(to, from) {
            this.getCanal();
        }
    },
    methods: {
        getCanal: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
                var url, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                url = '/canais/slug/' + this.$route.params.slug;
                                _context.next = 3;
                                return http.getDataFromUrl(url);

                            case 3:
                                resp = _context.sent;


                                if (resp.data.success) {
                                    this.idCanal = resp.data.canal.id;
                                    this.title = resp.data.canal.name;
                                    this.options = resp.data.canal.options;
                                    this.color = this.options.color;
                                    this.hasCategories = this.options.has_categories;
                                    localStorage.setItem('idCanal', this.idCanal);
                                }

                            case 5:
                            case 'end':
                                return _context.stop();
                        }
                    }
                }, _callee, this);
            }));

            function getCanal() {
                return _ref.apply(this, arguments);
            }

            return getCanal;
        }()
    }
});

/***/ }),

/***/ 151:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(152)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(154)
/* template */
var __vue_template__ = __webpack_require__(155)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-69ec2f9e"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/NavCanalComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69ec2f9e", Component.options)
  } else {
    hotAPI.reload("data-v-69ec2f9e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 152:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(153);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("67e6eaac", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69ec2f9e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./NavCanalComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69ec2f9e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./NavCanalComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 153:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 154:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'NavCanal'

});

/***/ }),

/***/ 155:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", [
    _c(
      "ul",
      { staticClass: "nav nav-pills" },
      [
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Inicio", params: { slug: _vm.$route.params.slug } }
            }
          },
          [_c("a", [_vm._v("Home")])]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Listar", params: { slug: _vm.$route.params.slug } }
            }
          },
          [_c("a", [_vm._v("Listar")])]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Sobre", params: { slug: _vm.$route.params.slug } }
            }
          },
          [_c("a", [_vm._v("Sobre")])]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: {
                name: "Formulario",
                params: { slug: _vm.$route.params.slug }
              }
            }
          },
          [_c("a", [_vm._v("Formulario")])]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-69ec2f9e", module.exports)
  }
}

/***/ }),

/***/ 156:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(157)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(159)
/* template */
var __vue_template__ = __webpack_require__(160)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-92b465d2"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/SidebarCanalComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-92b465d2", Component.options)
  } else {
    hotAPI.reload("data-v-92b465d2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 157:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(158);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("f1d1eaba", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-92b465d2\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarCanalComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-92b465d2\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarCanalComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 158:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 159:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'SidebarCanal'

});

/***/ }),

/***/ 160:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", [
    _c(
      "ul",
      { staticClass: "nav nav-pills nav-stacked" },
      [
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Listar", query: { category: "todos" } },
              exact: ""
            }
          },
          [_c("a", [_vm._v("Todos")])]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Listar", query: { category: "1" } },
              exact: ""
            }
          },
          [_c("a", [_vm._v("Matematicas")])]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-92b465d2", module.exports)
  }
}

/***/ }),

/***/ 161:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", { staticClass: "container-fluid heigth" }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "aside",
        { staticClass: "col-sm-3" },
        [_vm._m(0), _vm._v(" "), _c("SidebarCanal")],
        1
      ),
      _vm._v(" "),
      _c("article", { staticClass: "col-sm-9" }, [
        _c(
          "header",
          { staticClass: "page-header" },
          [
            _c(
              "h1",
              {
                staticClass: "page-title",
                style: "--color:" + _vm.color,
                attrs: { stylepseudo: "after:" }
              },
              [
                _vm._v(
                  "\n                    " +
                    _vm._s(_vm.title) +
                    "\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c("NavCanal")
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "section",
          [
            _c(
              "transition",
              {
                attrs: {
                  name: "custom-classes-transition",
                  "enter-active-class": "animated fadeIn",
                  "leave-active-class": "animated fadeOut",
                  mode: "out-in"
                }
              },
              [_c("router-view", { attrs: { color: _vm.color } })],
              1
            )
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-center" }, [
      _c("h3", [_vm._v("Filtro")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4931cae4", module.exports)
  }
}

/***/ })

});