/*!
 * Includes EditableSelect.js
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2019-12-23 T21:04Z
 */
/*! jQuery Editable Select - v2.2.5 - https://github.com/indrimuska/jquery-editable-select - (c) 2016 Indri Muska - MIT */ + function(a) {
    EditableSelect = function(b, c) {
        this.options = c, this.$select = a(b), this.$input = a('<input type="text" autocomplete="off">'), this.$list = a('<ul class="es-list">'), this.utility = new EditableSelectUtility(this), ["focus", "manual"].indexOf(this.options.trigger) < 0 && (this.options.trigger = "focus"), ["default", "fade", "slide"].indexOf(this.options.effects) < 0 && (this.options.effects = "default"), isNaN(this.options.duration) && ["fast", "slow"].indexOf(this.options.duration) < 0 && (this.options.duration = "fast"), this.$select.replaceWith(this.$input), this.$list.appendTo(this.options.appendTo || this.$input.parent()), this.utility.initialize(), this.utility.initializeList(), this.utility.initializeInput(), this.utility.trigger("created")
    }, EditableSelect.DEFAULTS = {
        filter: !0,
        effects: "default",
        duration: "fast",
        trigger: "focus"
    }, EditableSelect.prototype.filter = function() {
        var b = 0,
            c = this.$input.val().toLowerCase().trim();
        this.$list.find("li").addClass("es-visible").show(), this.options.filter && (b = this.$list.find("li").filter(function(b, d) {
            return a(d).text().toLowerCase().indexOf(c) < 0
        }).hide().removeClass("es-visible").length, this.$list.find("li").length == b && this.hide())
    }, EditableSelect.prototype.show = function() {
        if (this.$list.css({
                top: this.$input.position().top + this.$input.outerHeight() - 1,
                left: this.$input.position().left,
                width: this.$input.outerWidth()
            }), !this.$list.is(":visible") && this.$list.find("li.es-visible").length > 0) {
            var b = {
                    "default": "show",
                    fade: "fadeIn",
                    slide: "slideDown"
                },
                c = b[this.options.effects];
            this.utility.trigger("show"), this.$input.addClass("open"), this.$list[c](this.options.duration, a.proxy(this.utility.trigger, this.utility, "shown"))
        }
    }, EditableSelect.prototype.hide = function() {
        var b = {
                "default": "hide",
                fade: "fadeOut",
                slide: "slideUp"
            },
            c = b[this.options.effects];
        this.utility.trigger("hide"), this.$input.removeClass("open"), this.$list[c](this.options.duration, a.proxy(this.utility.trigger, this.utility, "hidden"))
    }, EditableSelect.prototype.select = function(a) {
        this.$list.has(a) && a.is("li.es-visible:not([disabled])") && (this.$input.val(a.text()), this.options.filter && this.hide(), this.filter(), this.utility.trigger("select", a))
    }, EditableSelect.prototype.add = function(b, c, d, e) {
        var f = a("<li>").html(b),
            g = a("<option>").text(b),
            h = this.$list.find("li").length;
        c = isNaN(c) ? h : Math.min(Math.max(0, c), h), 0 == c ? (this.$list.prepend(f), this.$select.prepend(g)) : (this.$list.find("li").eq(c - 1).after(f), this.$select.find("option").eq(c - 1).after(g)), this.utility.setAttributes(f, d, e), this.utility.setAttributes(g, d, e), this.filter()
    }, EditableSelect.prototype.remove = function(a) {
        var b = this.$list.find("li").length;
        a = isNaN(a) ? b : Math.min(Math.max(0, a), b - 1), this.$list.find("li").eq(a).remove(), this.$select.find("option").eq(a).remove(), this.filter()
    }, EditableSelect.prototype.clear = function() {
        this.$list.find("li").remove(), this.$select.find("option").remove(), this.filter()
    }, EditableSelect.prototype.destroy = function() {
        this.$list.off("mousemove mousedown mouseup"), this.$input.off("focus blur input keydown"), this.$input.replaceWith(this.$select), this.$list.remove(), this.$select.removeData("editable-select")
    }, EditableSelectUtility = function(a) {
        this.es = a
    }, EditableSelectUtility.prototype.initialize = function() {
        var b = this;
        b.setAttributes(b.es.$input, b.es.$select[0].attributes, b.es.$select.data()), b.es.$input.addClass("es-input").data("editable-select", b.es), b.es.$select.find("option").each(function(c, d) {
            var e = a(d).remove();
            b.es.add(e.text(), c, d.attributes, e.data()), e.attr("selected") && b.es.$input.val(e.text())
        }), b.es.filter()
    }, EditableSelectUtility.prototype.initializeList = function() {
        var b = this;
        b.es.$list.on("mousemove", "li:not([disabled])", function() {
            b.es.$list.find(".selected").removeClass("selected"), a(this).addClass("selected")
        }).on("mousedown", "li", function(c) {
            a(this).is("[disabled]") ? c.preventDefault() : b.es.select(a(this))
        }).on("mouseup", function() {
            b.es.$list.find("li.selected").removeClass("selected")
        })
    }, EditableSelectUtility.prototype.initializeInput = function() {
        var b = this;
        switch (this.es.options.trigger) {
            default:
                case "focus":
                b.es.$input.on("focus", a.proxy(b.es.show, b.es)).on("blur", a.proxy(b.es.hide, b.es));
            break;
            case "manual":
        }
        b.es.$input.on("input keydown", function(a) {
            switch (a.keyCode) {
                case 38:
                    var c = b.es.$list.find("li.es-visible:not([disabled])"),
                        d = c.index(c.filter("li.selected"));
                    b.highlight(d - 1), a.preventDefault();
                    break;
                case 40:
                    var c = b.es.$list.find("li.es-visible:not([disabled])"),
                        d = c.index(c.filter("li.selected"));
                    b.highlight(d + 1), a.preventDefault();
                    break;
                case 13:
                    b.es.$list.is(":visible") && (b.es.select(b.es.$list.find("li.selected")), a.preventDefault());
                    break;
                case 9:
                case 27:
                    b.es.hide();
                    break;
                default:
                    b.es.filter(), b.highlight(0)
            }
        })
    }, EditableSelectUtility.prototype.highlight = function(a) {
        var b = this;
        b.es.show(), setTimeout(function() {
            var c = b.es.$list.find("li.es-visible"),
                d = b.es.$list.find("li.selected").removeClass("selected"),
                e = c.index(d);
            if (c.length > 0) {
                var f = (c.length + a) % c.length,
                    g = c.eq(f),
                    h = g.position().top;
                g.addClass("selected"), f < e && h < 0 && b.es.$list.scrollTop(b.es.$list.scrollTop() + h), f > e && h + g.outerHeight() > b.es.$list.outerHeight() && b.es.$list.scrollTop(b.es.$list.scrollTop() + g.outerHeight() + 2 * (h - b.es.$list.outerHeight()))
            }
        })
    }, EditableSelectUtility.prototype.setAttributes = function(b, c, d) {
        a.each(c || {}, function(a, c) {
            b.attr(c.name, c.value)
        }), b.data(d)
    }, EditableSelectUtility.prototype.trigger = function(a) {
        var b = Array.prototype.slice.call(arguments, 1),
            c = [a + ".editable-select"];
        c.push(b), this.es.$select.trigger.apply(this.es.$select, c), this.es.$input.trigger.apply(this.es.$input, c)
    }, Plugin = function(b) {
        var c = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var d = a(this),
                e = d.data("editable-select"),
                f = a.extend({}, EditableSelect.DEFAULTS, d.data(), "object" == typeof b && b);
            e || (e = new EditableSelect(this, f)), "string" == typeof b && e[b].apply(e, c)
        })
    }, a.fn.editableSelect = Plugin, a.fn.editableSelect.Constructor = EditableSelect
}(jQuery);