(function ($) {
        var err;
        $.fn.formValidate = function () {
            var ret = this.each(function () {
                        var selObj = this; // the original select object.
                        var $selObj = $(this); // the original select object.
                        var sumo = {
                            init: function () {
                                var that = this;
                                var count = 0;
                                $selObj.focusout(function () {
                                    if ($(this).val()) {
                                        if ($(this).attr("data-type"))
                                            err = that.validateType($(this).attr("data-type"));
                                        else if ($(this).attr("data-chars"))
                                            err = that.validate($(this).attr("data-chars"));
                                        else
                                            err = that.validate(null);
                                        if (err !== true && jQuery.type(err) === "string") {
                                            var place;
                                            if ($selObj.parents(".form-group").parent().length > 1 && $selObj.parents(".form-group").parent().parent().length > 1) {
                                                var position = $selObj.parents(".form-group").parent().position();
                                                var par_x_length = $selObj.parents(".form-group").parent().parent().width();
                                                if ((position.left / par_x_length) > 0.8)
                                                    place = "left";
                                                else if ((position.left / par_x_length) < 0.2)
                                                    place = "right";
                                                else
                                                    place = "bottom";
                                            }
                                            else {
                                                place = "bottom";
                                            }
                                            $selObj.css("background-color", "#f2dede");
                                            $selObj.popover({
                                                placement: place,
                                                content: function () {
                                                    return err;
                                                }
                                            }).popover('show');
                                            $selObj.addClass("alert-danger");
                                        }
                                        else {
                                            err = null;
                                            $selObj.css("background-color", "#ffffff");
                                            $selObj.popover("hide");
                                            $selObj.removeClass("alert-danger");
                                        }
                                    }
                                    else {
                                        $selObj.css("background-color", "#ffffff");
                                        $selObj.popover("hide");
                                        $selObj.removeClass("alert-danger");
                                    }
                                }).focus(function () {
                                    $selObj.css("background-color", "#ffffff");
                                    $selObj.popover("hide");
                                    $selObj.removeClass("alert-danger");
                                }).change(function () {
                                    if ($selObj.is("select")) {
                                        $selObj.css("background-color", "#ffffff");
                                        $selObj.popover("hide");
                                        $selObj.removeClass("alert-danger");
                                    }
                                });
                            },

                            validate: function (chars) {
                                var that = this;
                                var chars = JSON.parse(chars);
                                var alphaExp = '[0-9a-zA-Z\S';
                                if (chars) {
                                    for (key in chars) {
                                        alphaExp += '\\' + chars[key];
                                    }
                                }
                                alphaExp += ']';
                                var str = $selObj.val().replace(new RegExp(alphaExp, 'g'), "");
                                if (/\S/.test(str))
                                    return "This field contains invalid characters. Please remove the following characters: " + $selObj.val().replace(new RegExp(alphaExp, 'g'), "");
                                else
                                    return true;
                            },

                            validateType: function (type) {
                                var that = this;
                                switch (type) {
                                    case "email":
                                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($selObj.val()))
                                            return true;
                                        else
                                            return "Your email is not in the right format. Please provide a correct email.";
                                        break;
                                    case "zip":
                                        if (/^[0-9]{5}$/.test($selObj.val()))
                                            return true;
                                        else
                                            return "The field only allows 5 integers.";
                                        break;
                                    case "integer":
                                        if (that.isInteger($selObj.val()))
                                            return true;
                                        else
                                            return "The field only allows integers.";
                                        break;
                                    case "double":
                                        if ($.isNumeric($selObj.val()))
                                            return true;
                                        else
                                            return "The field is only allows numeric characters.";
                                        break;
                                    case "url":
                                        if (/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/.test($selObj.val()))
                                            return true;
                                        else
                                            return "The url you have entered is not valid. Please enter a valid url.";
                                        break;
                                }

                            },
                            isInteger: function (x) {
                                return x % 1 === 0;
                            }
                        }
                        sumo.init();


                    }
                );

        }
    }
    (jQuery)
)
;