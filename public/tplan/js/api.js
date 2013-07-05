twttr.augmentString("twttr.api", {
    defaultAjaxOptions: {
        type: "POST",
        dataType: "json",
        url: "#",
        data: {
            authenticity_token: "",
            twttr: true
        },
        success: function () {},
        error: function () {},
        beforeSend: function () {}
    },
    tweet: function (B, C, A) {
        twttr.User.findById(B, this, function (D) {
            var H = A.success;
            var F = {
                status: C
            };
            var G = function (I) {
                D.update("latest_status", I.text);
                H(I)
            };
            var E = "/status/update";
            this._sendRequest(twttr.merge(A, {
                url: E,
                success: G,
                data: F
            }, true))
        })
    },
    autocomplete: function (B, C, A) {
        twttr.User.findById(B, this, function (D) {
            var F = {
                user_id: B,
                sn: C
            };
            var E = "/users/autocomplete";
            this._sendRequest(twttr.merge(A, {
                url: E,
                data: F
            }, true))
        })
    },
    follow: function (B, A) {
        twttr.User.findById(B, this, function (C) {
            var F = A.success;
            var E = function (G) {
                C.updateAll({
                    do_not_follow: false,
                    do_you_follow: true,
                    sees_retweets: true
                });
                F(G)
            };
            var D = "/friendships/create/" + B;
            this._sendRequest(twttr.merge(A, {
                url: D,
                success: E
            }, true))
        })
    },
    unfollow: function (B, A) {
        twttr.User.findById(B, this, function (C) {
            var F = A.success;
            var E = function (G) {
                C.updateAll({
                    do_not_follow: true,
                    do_you_follow: false,
                    gets_device_updates: false,
                    sees_replies: false,
                    sees_retweets: false
                });
                F(G)
            };
            var D = "/friendships/destroy/" + B;
            this._sendRequest(twttr.merge(A, {
                url: D,
                success: E
            }, true))
        })
    },
    block: function (B, A) {
        twttr.User.findById(B, this, function (C) {
            var F = A.success;
            var E = function (G) {
                C.updateAll({
                    is_not_blocking: false,
                    is_blocking: true,
                    do_not_follow: true,
                    do_you_follow: false,
                    does_follow_you: false,
                    gets_device_updates: false,
                    sees_replies: false,
                    sees_retweets: false
                });
                F(G)
            };
            var D = "/blocks/create/" + B;
            this._sendRequest(twttr.merge(A, {
                url: D,
                success: E
            }, true))
        })
    },
    unblock: function (B, A) {
        twttr.User.findById(B, this, function (C) {
            var F = A.success;
            var E = function (G) {
                C.updateAll({
                    is_not_blocking: true,
                    is_blocking: false,
                    do_not_follow: true,
                    do_you_follow: false,
                    does_follow_you: false,
                    gets_device_updates: false,
                    sees_replies: false,
                    sees_retweets: false
                });
                F(G)
            };
            var D = "/blocks/destroy/" + B;
            this._sendRequest(twttr.merge(A, {
                url: D,
                success: E
            }, true))
        })
    },
    reportForSpam: function (B, A) {
        twttr.User.findById(B, this, function (C) {
            var F = A.success;
            var E = function (G) {
                C.updateAll({
                    is_not_blocking: false,
                    is_blocking: true,
                    do_not_follow: true,
                    do_you_follow: false,
                    does_follow_you: false,
                    gets_device_updates: false,
                    sees_replies: false,
                    sees_retweets: false
                });
                F(G)
            };
            var D = "/user_spam_reports/" + B;
            this._sendRequest(twttr.merge(A, {
                url: D,
                success: E
            }, true))
        })
    },
    reportSpam: function (B, A) {
        this.reportSpam.apply(arguments)
    },
    setDeviceAlerts: function (B, D, A) {
        var C = {
            user_ids: B,
            value: D
        };
        var E = function (F) {
            twttr.User.findById(B, function (G) {
                G.update("gets_device_updates", D == "on")
            })
        };
        this._sendRequest(twttr.merge(A, {
            url: "/friendships/set_sms",
            data: C,
            success: E
        }, true))
    },
    setRetweetVisibility: function (B, D, A) {
        var C = {
            user_ids: B,
            value: D
        };
        var E = function (F) {
            twttr.User.findById(B, function (G) {
                G.update("sees_retweets", D == "on")
            })
        };
        this._sendRequest(twttr.merge(A, {
            url: "/friendships/set_shares",
            data: C,
            success: E
        }, true))
    },
    setMentions: function (B, D, A) {
        var C = {
            user_ids: B,
            value: D
        };
        var E = function (F) {
            twttr.User.findById(B, function (G) {
                G.update("sees_replies", D == "on")
            })
        };
        this._sendRequest(twttr.merge(A, {
            url: "/friendships/set_replies",
            data: C,
            success: E
        }, true))
    },
    reverseGeocode: function (A) {
        var B = {
            type: "GET",
            url: "/1/geo/reverse_geocode.json"
        };
        this._sendRequest(twttr.merge(A, B, true))
    },
    search: function (A) {
        var B = {
            type: "GET",
            url: "/1/geo/search.json"
        };
        this._sendRequest(twttr.merge(A, B, true))
    },
    createPlace: function (A) {
        var B = {
            type: "POST",
            url: "/1/geo/place.json"
        };
        this._sendRequest(twttr.merge(A, B, true))
    },
    similarPlaces: function (B) {
        var A = {
            type: "GET",
            url: "/1/geo/similar_places.json"
        };
        this._sendRequest(twttr.merge(B, A, true))
    },
    getPlaceDetails: function (A) {
        var B = {
            type: "GET",
            url: "/1/geo/id/" + A.place_id + ".json"
        };
        this._sendRequest(twttr.merge(A, B, true))
    },
    _sendRequest: function (B) {
        var C = {};
        if (twttr.form_authenticity_token) {
            C.authenticity_token = twttr.form_authenticity_token
        }
        var A = twttr.merge({}, twttr.api.defaultAjaxOptions, {
            data: C
        }, B, true);
        $.ajax(A)
    }
});