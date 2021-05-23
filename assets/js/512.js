(self.webpackChunk=self.webpackChunk||[]).push([[512],{1549:(e,t,r)=>{"use strict";r.d(t,{Z:()=>c});var o=r(5166),n=r(9680),i=r(9038),s=r(5369);const a=(0,o.defineComponent)({props:{isOpen:{type:Boolean,required:!0},"onMouse:enter":{type:Function},"onMouse:leave":{type:Function}},emits:{"mouse:enter":function(){return!0},"mouse:leave":function(){return!0}},setup:function(){var e=(0,o.ref)((0,s.B)().current()),t=(0,o.ref)((0,s.B)().params),r=(0,o.ref)((0,i.qt)()),a=(0,o.ref)((0,i.cI)({_method:"POST"}));return(0,o.watch)(r,(function(){e.value=(0,s.B)().current(),t.value=(0,s.B)().params}),{deep:!0}),{page:r,currentRoute:e,currentRouteParams:t,logout:function(){return a.value.post((0,s.B)("logout"),{onSuccess:function(){return n.Inertia.reload()}})}}},render:function(){var e,t=this;return(0,o.createVNode)("nav",{onMouseenter:function(){return t.$emit("mouse:enter")},onMouseleave:function(){return t.$emit("mouse:leave")},class:["h-full bg-gray-dark flex flex-col text-ghost-white overflow-hidden flex-shrink-0",this.isOpen?"w-56":"w-16"]},[(0,o.createVNode)("div",{class:["text-tertiary w-full h-52 text-center flex flex-col items-center justify-center flex-shrink-0",this.isOpen?"px-6":"px-2"]},[(0,o.createVNode)("i",{class:"far fa-user-circle text-3xl transition-size duration-200 block w-full pt-2"},null),(null===(e=this.$page.props.user)||void 0===e?void 0:e.email)&&(0,o.createVNode)("p",{class:["font-bold pt-4 transition-opacity duration-200",this.isOpen?null:"opacity-0 hidden"]},[this.$page.props.user.email]),(0,o.createVNode)("form",{class:"opacity-75",action:this.$route("logout"),method:"POST",onSubmit:function(e){e.preventDefault(),t.logout()}},[(0,o.createVNode)("button",{class:"px-2 py-1 hover:underline",type:"submit"},[(0,o.createVNode)("i",{class:"fas fa-sign-out-alt"},null),(0,o.createVNode)("span",{class:["ml-2 transition-opacity duration-200",this.isOpen?null:"opacity-0 hidden"]},[(0,o.createTextVNode)("Déconnexion")])])])]),(0,o.createVNode)("ul",{class:["flex flex-col h-full pt-4 text-ghost-white",this.isOpen?"px-6 items-start":"px-2 items-center"]},[(0,o.createVNode)("li",null,[(0,o.createVNode)((0,o.resolveComponent)("inertia-link"),{class:["py-2 px-4 block group hover:opacity-75 text-center transition duration-200","laravel-admin::home"===this.currentRoute?"font-bold":null],href:this.$route("laravel-admin::home")},{default:function(){return[(0,o.createVNode)("i",{class:"fas fa-home tex"},null),(0,o.createVNode)("span",{class:["pl-2 group-hover:pl-4 transition-all duration-200",t.isOpen?null:"opacity-0 hidden"]},[(0,o.createTextVNode)("Home")])]}})]),(0,o.createVNode)("li",{class:"py-2 px-4 uppercase opacity-75 text-center transition duration-200"},[(0,o.createVNode)("i",{class:"fas fa-stream"},null),(0,o.createVNode)("span",{class:["pl-2 text-sm transition-opacity duration-200",this.isOpen?null:"opacity-0 hidden"]},[(0,o.createTextVNode)("Resources")])]),this.$page.props.adminResourceClasses.map((function(e){return(0,o.createVNode)("li",{class:"transition-size duration-200"},["laravel-admin::resources.list"===t.currentRoute&&t.currentRouteParams.resource===e.uriKey?(0,o.createVNode)("p",{class:"py-1 px-4 block opacity-75 text-center transition duration-200 font-bold"},[e.icon&&(0,o.createVNode)("i",{class:"fas ".concat(e.icon)},null),(0,o.createVNode)("span",{class:["pl-4 transition-all duration-200",t.isOpen?null:"opacity-0 hidden"]},[e.plural])]):(0,o.createVNode)((0,o.resolveComponent)("inertia-link"),{class:"py-1 px-4 block group hover:opacity-75 text-center transition duration-200",href:t.$route("laravel-admin::resources.list",{resource:e.uriKey})},{default:function(){return[e.icon&&(0,o.createVNode)("i",{class:"fas ".concat(e.icon)},null),(0,o.createVNode)("span",{class:["pl-2 group-hover:pl-4 transition-all duration-200",t.isOpen?null:"opacity-0 hidden"]},[e.plural])]}})])}))])])}});const l=(0,o.defineComponent)({props:{"onArrow:clicked":{type:Function},isLocked:{type:Boolean,required:!0}},emits:{"arrow:clicked":function(){return!0},arrow:function(){return!0}},setup:function(e,t){var r=t.emit;return{onArrowClick:function(){r("arrow:clicked"),r("arrow")}}},render:function(){return(0,o.createVNode)("div",{class:"w-full h-12 bg-gray-lighter text-gray-dark p-3 flex items-center"},[(0,o.createVNode)("button",{class:"px-2 focus:outline-none",onClick:this.onArrowClick},[(0,o.createVNode)("i",{class:["fas fa-arrow-right transition-transform duration-300 transform",this.isLocked?"rotate-180":null]},null)])])}});const c=(0,o.defineComponent)({setup:function(){return{isOpen:(0,o.ref)(!0),isLocked:(0,o.ref)(!0)}},render:function(){var e=this;return(0,o.createVNode)("div",{class:"z-50 fixed top-0 left-0 h-screen w-screen flex"},[(0,o.createVNode)(a,{"onMouse:enter":function(){e.isOpen||(e.isOpen=!0)},"onMouse:leave":function(){e.isOpen&&!e.isLocked&&(e.isOpen=!1)},isOpen:this.isOpen},null),(0,o.createVNode)("div",{class:"w-full h-full flex-grow overflow-y-auto flex flex-col"},[(0,o.createVNode)(l,{"onArrow:clicked":function(){e.isLocked=!e.isLocked,e.isOpen=e.isLocked},isLocked:this.isLocked},null),this.$slots.default?this.$slots.default():null])])}})},512:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>s});var o=r(5166),n=r(1549);function i(e){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}const s=(0,o.defineComponent)({layout:n.Z,props:{resource:{type:Object,required:!0}},render:function(){var e=this;return(0,o.createVNode)("div",{class:"text-gray p-4"},[(0,o.createVNode)(o.Teleport,{to:"title"},{default:function(){return[e.resource.singular,(0,o.createTextVNode)(" "),e.resource.title,(0,o.createTextVNode)(" - Admin")]}}),(0,o.createVNode)("div",{class:"flex"},[(0,o.createVNode)("h2",{class:"text-2xl font-semibold mb-4"},[this.resource.singular,(0,o.createTextVNode)(" Details: "),this.resource.title]),(0,o.createVNode)("ul",{class:"ml-auto"},[(0,o.createVNode)("li",null,[(0,o.createVNode)((0,o.resolveComponent)("inertia-link"),{class:"text-gray-medium-light hover:text-tertiary bg-gray-lighter py-2 px-3 rounded-md shadow",href:this.$route("laravel-admin::resources.edit",{resource:this.resource.uriKey,id:["number","string"].includes(i(this.resource._id))?"".concat(this.resource._id):JSON.stringify(this.resource._id)})},{default:function(){return[(0,o.createVNode)("i",{class:"fas fa-edit"},null)]}})])])]),this.resource.panels.map((function(e){return(0,o.createVNode)("section",null,[e.showTitle&&(0,o.createVNode)("h3",{class:"mt-6 mb-2 font-semibold text-lg"},[e.name]),(0,o.createVNode)("div",{class:["shadow rounded-md border border-gray-lighter bg-white",e.showTitle?null:"mt-6"]},[e.fields.map((function(e,t){var r=(0,o.resolveComponent)(e.component);return(0,o.createVNode)(r,{field:e},null)}))])])}))])}})},5369:(e,t,r)=>{"use strict";r.d(t,{B:()=>o});var o=window.route}}]);