/*! For license information please see main.c0d6b395.chunk.js.LICENSE.txt */
(this.webpackJsonppasswdtool=this.webpackJsonppasswdtool||[]).push([[0],{148:function(e,t,n){"use strict";n.r(t);var a=n(111),r=n(98),s=n(0),o=n.n(s),c=n(33),i=n.n(c),l=n(65),d=n(205),u=n(15),j=n(81),b=n(206),h=n(209),g=n(6),m=n(107),p=n.n(m),O=n(198),w=n(203),f=n(210),x=n(211),y=n(204),v=n(207),k=n(199),C=n(200),P=n(212);var T=Object(u.b)({key:"clickedSubmit",default:!1}),A=Object(u.b)({key:"username",default:""}),q=Object(u.b)({key:"newPasswd",default:""}),S=Object(u.b)({key:"newPasswdConfirm",default:""}),D=Object(u.b)({key:"oldPasswd",default:""}),I=Object(u.c)({key:"usernameRequired",get:function(e){var t=e.get;return t(T)&&""===t(A)?"Is required.":""}}),z=Object(u.c)({key:"oldPasswordRequired",get:function(e){var t=e.get;return t(T)&&""===t(D)?"Is required.":""}}),E=Object(u.c)({key:"newPasswordRequired",get:function(e){var t=e.get;return t(T)&&""===t(q)?"Is required.":""}}),N=Object(u.c)({key:"newPasswordConfirmRequired",get:function(e){var t=e.get;return t(T)&&""===t(S)?"Is required.":""}}),L=Object(u.c)({key:"newEqualToOld",get:function(e){var t=e.get;return t(q)&&t(D)&&t(q)===t(D)?"Old and new password must be different.":""}}),W=Object(u.c)({key:"confirmIdentical",get:function(e){var t=e.get;return t(q)&&t(S)&&t(q)!==t(S)?"Passwords do not match.":""}}),B=Object(u.c)({key:"containsSpaces",get:function(e){var t=e.get;return t(q).trim()!==t(q)?"Password cannot have leading or trailing spaces.":""}}),R=Object(u.c)({key:"noNumberOrLetters",get:function(e){var t=e.get;return t(q)&&!/.*?(?:[a-z].*?[0-9]|[0-9].*?[a-z]).*?/.test(t(q))?"Password must contain at least one letter and one number.":""}}),F=Object(u.c)({key:"lessThanFourChars",get:function(e){var t=e.get;return t(q)&&t(q).trim().length<8?"Password needs to be at least 8 characters long.":""}}),U=n(1);function J(){var e=Object(d.a)().t,t=Object(u.d)(T),n=Object(g.a)(t,2),a=n[0],r=n[1],s=Object(u.d)(A),o=Object(g.a)(s,2),c=o[0],i=o[1],l=Object(u.d)(q),j=Object(g.a)(l,2),b=j[0],h=j[1],m=Object(u.d)(S),J=Object(g.a)(m,2),M=J[0],H=J[1],K=Object(u.d)(D),V=Object(g.a)(K,2),_=V[0],Y=V[1],G=Object(u.e)(R),Q=Object(u.e)(B),X=Object(u.e)(F),Z=Object(u.e)(L),$=Object(u.e)(W),ee=Object(u.e)(I),te=Object(u.e)(z),ne=Object(u.e)(E),ae=Object(u.e)(N);return Object(U.jsxs)(U.Fragment,{children:[Object(U.jsx)(O.a,{}),Object(U.jsx)(w.a,{component:"main",container:!0,direction:"column",justifyContent:"center",alignItems:"center",children:Object(U.jsx)(f.a,{elevation:6,sx:{maxWidth:300},children:Object(U.jsxs)(x.a,{sx:{mt:1,mb:1,mr:1,ml:1,flexDirection:"column",alignItems:"flex-start"},children:[Object(U.jsxs)(x.a,{sx:{marginTop:1,display:"flex",flexDirection:"column",alignItems:"center"},children:[Object(U.jsx)(y.a,{sx:{m:1,bgcolor:"secondary.main"},children:Object(U.jsx)(p.a,{})}),Object(U.jsx)(v.a,{variant:"h6",component:"div",align:"center",children:e("Change password")})]}),Object(U.jsxs)(x.a,{component:"form",noValidate:!0,onSubmit:function(e){var t;e.preventDefault(),r(!0),""===G&&""===Q&&""===X&&""===Z&&""===$&&""===ee&&""===te&&""===ne&&""===ae&&(t={username:c,oldPassword:_,newPassword:b,newPasswordConfirm:M},fetch("api/changepw",{method:"POST",headers:{"Horde-Session-Token":globalThis.horde.sessionToken,Accept:"application/json","Content-Type":"multipart/form-data"},body:JSON.stringify(t)}).then((function(e){if(e.ok)return e.json();throw new Error("Response code: ".concat(e.status))})).then((function(e){return console.log(e)})).catch((function(e){console.log(e)})))},onChange:function(){return r(!1)},sx:{mt:2},children:[Object(U.jsx)(k.a,{arrow:!0,placement:"right",title:e("Username of the user whose password you want to change."),children:Object(U.jsx)(C.a,{margin:"dense",size:"small",required:!0,fullWidth:!0,onChange:function(e){return i(e.target.value)},value:c,label:e("Username"),error:Boolean(ee),type:"username",id:"username",autoComplete:"username",helperText:e(ee)})}),Object(U.jsx)(k.a,{arrow:!0,placement:"right",title:e("Old password of the user whose password you want to change."),children:Object(U.jsx)(C.a,{margin:"dense",size:"small",required:!0,fullWidth:!0,onChange:function(e){return Y(e.target.value)},value:_,label:e("Old password"),error:Boolean(te),type:"password",id:"oldPassword",autoComplete:"current-password",helperText:e(te)})}),Object(U.jsx)(k.a,{arrow:!0,placement:"right",title:e("New password of the user whose password you want to change."),children:Object(U.jsx)(C.a,{margin:"dense",size:"small",required:!0,fullWidth:!0,onChange:function(e){return h(e.target.value)},value:b,label:e("New password"),error:Boolean(ne||Q||X||G||Z),type:"password",id:"newPassword",autoComplete:"new-password",helperText:e(ne||Q||X||G||Z)})}),Object(U.jsx)(k.a,{arrow:!0,placement:"right",title:e("Confirm the new password."),children:Object(U.jsx)(C.a,{margin:"dense",size:"small",required:!0,fullWidth:!0,onChange:function(e){return H(e.target.value)},value:M,label:e("Confirm new password"),error:Boolean(ae||$),type:"password",id:"confirmPassword",autoComplete:"new-password",helperText:e(ae||$)})}),Object(U.jsxs)(x.a,{sx:{display:"flex",flexDirection:"row",justifyContent:"center"},children:[Object(U.jsx)(P.a,{size:"small",type:"submit",variant:"contained",sx:{mt:1},children:e("confirm")}),Object(U.jsx)(P.a,{size:"small",onClick:function(){a&&r(!1),i(""),Y(""),h(""),H("")},variant:"outlined",sx:{ml:1,mt:1},children:e("reset")})]})]})]})})})]})}function M(){var e=Object(j.c)().toasty,t=Object(d.a)(),n=t.t,a=t.i18n;return Object(U.jsxs)(U.Fragment,{children:[Object(U.jsx)(j.b,{menuEntries:[],logoutAction:function(){return e.success("Logout complete!")},applicationTitle:Object(U.jsx)(b.a,{href:"",color:"inherit",underline:"hover",children:n("Change password")}),notificationHistory:{pastNotifications:"Past Notifications",noNotificationsYet:"No notifications yet",createdAtFormat:function(e){return new Date(e).toString()}},languageMenu:{entries:[{key:"de-DE",display:"Deutsch"},{key:"en-US",display:"English"}],onLanguageChange:function(t){var n="en"===t?"Switched to English":"Sprache auf Deutsch gestellt";e.success(n),a.changeLanguage(t)},currentLanguage:a.language}}),Object(U.jsx)(h.a,{}),Object(U.jsx)(J,{})]})}function H(){return Object(U.jsx)(u.a,{children:Object(U.jsx)(j.a,{position:"bottom-right",gutter:8,children:Object(U.jsx)(M,{})})})}window.onload=function(){globalThis.horde||(globalThis.horde=window.horde||{appMode:"mock",sessionToken:"1ccAAAAAAcA1cAA-AcAcyA1",currentApp:"passwd",userUid:"mockuser1",appWebroot:"/passwd",languageKey:"de_DE"}),a.a.use(r.a).use(l.e).init({debug:!0,lng:globalThis.horde.languageKey.replace("_","-"),interpolation:{escapeValue:!1},backend:{loadPath:"/locale/{{lng}}/{{ns}}.json"}}),i.a.render(Object(U.jsx)(o.a.StrictMode,{children:Object(U.jsx)(s.Suspense,{fallback:Object(U.jsx)("div",{children:"Loading..."}),children:Object(U.jsx)(H,{})})}),document.getElementById("root"))}}},[[148,1,2]]]);
//# sourceMappingURL=main.c0d6b395.chunk.js.map