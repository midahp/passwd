(this.webpackJsonppasswdtool = this.webpackJsonppasswdtool || []).push([
    [0],
    {
      149: function (e, t, n) {
        "use strict";
        n.r(t);
        var r = n(92),
          a = n(63),
          s = n(99),
          o = n(111);
        r.a
          .use(s.a)
          .use(o.a)
          .use(a.e)
          .init({
            fallbackLng: "en",
            debug: !1,
            interpolation: { escapeValue: !1 },
          });
        r.a;
        var c = n(0),
          i = n.n(c),
          l = n(33),
          u = n.n(l),
          d = n(15),
          j = n(206),
          b = n(81),
          h = n(207),
          g = n(210),
          m = n(6),
          O = n(108),
          p = n.n(O),
          f = n(199),
          w = n(204),
          x = n(211),
          y = n(212),
          v = n(205),
          k = n(208),
          C = n(200),
          P = n(201),
          q = n(213);
        var S = Object(d.b)({ key: "clickedSubmit", default: !1 }),
          z = Object(d.b)({ key: "username", default: "" }),
          I = Object(d.b)({ key: "newPasswd", default: "" }),
          T = Object(d.b)({ key: "newPasswdConfirm", default: "" }),
          N = Object(d.b)({ key: "oldPasswd", default: "" }),
          D = Object(d.c)({
            key: "usernameRequired",
            get: function (e) {
              var t = e.get;
              return t(S) && "" === t(z) ? "Is required." : "";
            },
          }),
          L = Object(d.c)({
            key: "oldPasswordRequired",
            get: function (e) {
              var t = e.get;
              return t(S) && "" === t(N) ? "Is required." : "";
            },
          }),
          E = Object(d.c)({
            key: "newPasswordRequired",
            get: function (e) {
              var t = e.get;
              return t(S) && "" === t(I) ? "Is required." : "";
            },
          }),
          B = Object(d.c)({
            key: "newPasswordConfirmRequired",
            get: function (e) {
              var t = e.get;
              return t(S) && "" === t(T) ? "Is required." : "";
            },
          }),
          W = Object(d.c)({
            key: "newEqualToOld",
            get: function (e) {
              var t = e.get;
              return t(I) && t(N) && t(I) === t(N)
                ? "Old and new password must be different."
                : "";
            },
          }),
          A = Object(d.c)({
            key: "confirmIdentical",
            get: function (e) {
              var t = e.get;
              return t(I) && t(T) && t(I) !== t(T)
                ? "Passwords do not match."
                : "";
            },
          }),
          F = Object(d.c)({
            key: "containsSpaces",
            get: function (e) {
              var t = e.get;
              return t(I).trim() !== t(I)
                ? "Password cannot have leading or trailing spaces."
                : "";
            },
          }),
          R = Object(d.c)({
            key: "noNumberOrLetters",
            get: function (e) {
              var t = e.get;
              return t(I) && !/.*?(?:[a-z].*?[0-9]|[0-9].*?[a-z]).*?/.test(t(I))
                ? "Password must contain at least one letter and one number."
                : "";
            },
          }),
          J = Object(d.c)({
            key: "lessThanFourChars",
            get: function (e) {
              var t = e.get;
              return t(I) && t(I).trim().length < 8
                ? "Password needs to be at least 8 characters long."
                : "";
            },
          }),
          M = n(1);
        function U() {
          var e = Object(j.a)().t,
            t = Object(d.d)(S),
            n = Object(m.a)(t, 2),
            r = n[0],
            a = n[1],
            s = Object(d.d)(z),
            o = Object(m.a)(s, 2),
            c = o[0],
            i = o[1],
            l = Object(d.d)(I),
            u = Object(m.a)(l, 2),
            b = u[0],
            h = u[1],
            g = Object(d.d)(T),
            O = Object(m.a)(g, 2),
            U = O[0],
            V = O[1],
            H = Object(d.d)(N),
            Y = Object(m.a)(H, 2),
            G = Y[0],
            K = Y[1],
            Q = Object(d.e)(R),
            X = Object(d.e)(F),
            Z = Object(d.e)(J),
            $ = Object(d.e)(W),
            _ = Object(d.e)(A),
            ee = Object(d.e)(D),
            te = Object(d.e)(L),
            ne = Object(d.e)(E),
            re = Object(d.e)(B),
            ae = function () {
              var e;
              (e = {
                username: c,
                oldPassword: G,
                newPassword: b,
                newPasswordConfirm: U,
              }),
                fetch("/api/changepw", {
                  method: "post",
                  headers: {
                    Authorization: "test",
                    Accept: "application/json, text/plain, */*",
                    "Content-Type": "application/json",
                  },
                  body: JSON.stringify(e),
                })
                  .then(function (e) {
                    return e.json();
                  })
                  .then(function (e) {
                    return console.log(
                      "Success",
                      e.success,
                      "Error message",
                      e.msg
                    );
                  });
            };
          return Object(M.jsxs)(M.Fragment, {
            children: [
              Object(M.jsx)(f.a, {}),
              Object(M.jsx)(w.a, {
                component: "main",
                container: !0,
                direction: "column",
                justifyContent: "center",
                alignItems: "center",
                children: Object(M.jsx)(x.a, {
                  elevation: 6,
                  sx: { maxWidth: 300 },
                  children: Object(M.jsxs)(y.a, {
                    sx: {
                      mt: 1,
                      mb: 1,
                      mr: 1,
                      ml: 1,
                      flexDirection: "column",
                      alignItems: "flex-start",
                    },
                    children: [
                      Object(M.jsxs)(y.a, {
                        sx: {
                          marginTop: 1,
                          display: "flex",
                          flexDirection: "column",
                          alignItems: "center",
                        },
                        children: [
                          Object(M.jsx)(v.a, {
                            sx: { m: 1, bgcolor: "secondary.main" },
                            children: Object(M.jsx)(p.a, {}),
                          }),
                          Object(M.jsx)(k.a, {
                            variant: "h6",
                            component: "div",
                            align: "center",
                            children: e("Change password"),
                          }),
                        ],
                      }),
                      Object(M.jsxs)(y.a, {
                        component: "form",
                        noValidate: !0,
                        onSubmit: function (e) {
                          e.preventDefault(),
                            a(!0),
                            console.log({
                              user: c,
                              oldPw: G,
                              newPw: b,
                              confirm: U,
                            }),
                            "" === Q &&
                              "" === X &&
                              "" === Z &&
                              "" === $ &&
                              "" === _ &&
                              "" === ee &&
                              "" === te &&
                              "" === ne &&
                              "" === re &&
                              ae();
                        },
                        onChange: function () {
                          return a(!1);
                        },
                        sx: { mt: 2 },
                        children: [
                          Object(M.jsx)(C.a, {
                            arrow: !0,
                            placement: "right",
                            title: e(
                              "Username of the user whose password you want to change."
                            ),
                            children: Object(M.jsx)(P.a, {
                              margin: "dense",
                              size: "small",
                              required: !0,
                              fullWidth: !0,
                              onChange: function (e) {
                                return i(e.target.value);
                              },
                              value: c,
                              label: e("Username"),
                              error: Boolean(ee),
                              type: "username",
                              id: "username",
                              autoComplete: "username",
                              helperText: e(ee),
                            }),
                          }),
                          Object(M.jsx)(C.a, {
                            arrow: !0,
                            placement: "right",
                            title: e(
                              "Old password of the user whose password you want to change."
                            ),
                            children: Object(M.jsx)(P.a, {
                              margin: "dense",
                              size: "small",
                              required: !0,
                              fullWidth: !0,
                              onChange: function (e) {
                                return K(e.target.value);
                              },
                              value: G,
                              label: e("Old password"),
                              error: Boolean(te),
                              type: "password",
                              id: "oldPassword",
                              autoComplete: "current-password",
                              helperText: e(te),
                            }),
                          }),
                          Object(M.jsx)(C.a, {
                            arrow: !0,
                            placement: "right",
                            title: e(
                              "New password of the user whose password you want to change."
                            ),
                            children: Object(M.jsx)(P.a, {
                              margin: "dense",
                              size: "small",
                              required: !0,
                              fullWidth: !0,
                              onChange: function (e) {
                                return h(e.target.value);
                              },
                              value: b,
                              label: e("New password"),
                              error: Boolean(ne || X || Z || Q || $),
                              type: "password",
                              id: "newPassword",
                              autoComplete: "new-password",
                              helperText: e(ne || X || Z || Q || $),
                            }),
                          }),
                          Object(M.jsx)(C.a, {
                            arrow: !0,
                            placement: "right",
                            title: e("Confirm the new password."),
                            children: Object(M.jsx)(P.a, {
                              margin: "dense",
                              size: "small",
                              required: !0,
                              fullWidth: !0,
                              onChange: function (e) {
                                return V(e.target.value);
                              },
                              value: U,
                              label: e("Confirm new password"),
                              error: Boolean(re || _),
                              type: "password",
                              id: "confirmPassword",
                              autoComplete: "new-password",
                              helperText: e(re || _),
                            }),
                          }),
                          Object(M.jsxs)(y.a, {
                            sx: {
                              display: "flex",
                              flexDirection: "row",
                              justifyContent: "center",
                            },
                            children: [
                              Object(M.jsx)(q.a, {
                                size: "small",
                                type: "submit",
                                variant: "contained",
                                sx: { mt: 1 },
                                children: e("confirm"),
                              }),
                              Object(M.jsx)(q.a, {
                                size: "small",
                                onClick: function () {
                                  r && a(!1), i(""), K(""), h(""), V("");
                                },
                                variant: "outlined",
                                sx: { ml: 1, mt: 1 },
                                children: e("reset"),
                              }),
                            ],
                          }),
                        ],
                      }),
                    ],
                  }),
                }),
              }),
            ],
          });
        }
        function V() {
          var e = Object(b.c)().toasty,
            t = Object(j.a)(),
            n = t.t,
            r = t.i18n;
          return Object(M.jsxs)(M.Fragment, {
            children: [
              Object(M.jsx)(b.b, {
                menuEntries: [],
                logoutAction: function () {
                  return e.success("Logout complete!");
                },
                applicationTitle: Object(M.jsx)(h.a, {
                  href: "",
                  color: "inherit",
                  underline: "hover",
                  children: n("Change password"),
                }),
                notificationHistory: {
                  pastNotifications: "Past Notifications",
                  noNotificationsYet: "No notifications yet",
                  createdAtFormat: function (e) {
                    return new Date(e).toString();
                  },
                },
                languageMenu: {
                  entries: [
                    { key: "de", display: "Deutsch" },
                    { key: "en", display: "English" },
                  ],
                  onLanguageChange: function (t) {
                    var n =
                      "en" === t
                        ? "Switched to English"
                        : "Sprache auf Deutsch gestellt";
                    e.success(n), r.changeLanguage(t);
                  },
                  currentLanguage: "en",
                },
              }),
              Object(M.jsx)(g.a, {}),
              Object(M.jsx)(U, {}),
            ],
          });
        }
        function H() {
          return Object(M.jsx)(b.a, {
            position: "bottom-right",
            gutter: 8,
            children: Object(M.jsx)(V, {}),
          });
        }
        u.a.render(
          Object(M.jsx)(i.a.StrictMode, {
            children: Object(M.jsx)(c.Suspense, {
              fallback: Object(M.jsx)("div", { children: "Loading..." }),
              children: Object(M.jsx)(d.a, { children: Object(M.jsx)(H, {}) }),
            }),
          }),
          document.getElementById("root")
        );
      },
    },
    [[149, 1, 2]],
  ]);
  //# sourceMappingURL=main.c3b96877.chunk.js.map
  