var _createClass = function () {function defineProperties(target, props) {for (var i = 0; i < props.length; i++) {var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ("value" in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);}}return function (Constructor, protoProps, staticProps) {if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;};}();function _classCallCheck(instance, Constructor) {if (!(instance instanceof Constructor)) {throw new TypeError("Cannot call a class as a function");}}var Input = function () {
    function Input(input, placeholder) {_classCallCheck(this, Input);
        this.isFocused = false;
        this.size = 0;
        this.animation = "zoomIn";
        $(input).addClass("input");
        this.$element = $(document.createElement("div"));
        this.$element.addClass("textZone");
        this.$element.attr("tabindex", 0);
        $(input).append(this.$element);
        this.cursor = new Cursor(this);
        this.setEvents();
        Keyboard.readCharacters(this);
        Keyboard.readSpecialCharacters(this);
        this.placeholder = new Placeholder(placeholder, this);
    }_createClass(Input, [{ key: "setEvents", value: function setEvents()

        {
            var input = this;

            this.$element.on("click", function (event) {
                input.focus();
                event.stopPropagation();
            });

            $(document).on("click", function (event) {
                input.unfocus();
            });
        } }, { key: "focus", value: function focus()

        {
            if (this.size == 0) {
                this.$element.prepend(this.cursor.$element);
            } else {
                this.cursor.$element.insertAfter(this.$element.children().last());
            }
            this.cursor.show();
            this.isFocused = true;
        } }, { key: "unfocus", value: function unfocus()

        {
            if (this.size == 0) {
                this.placeholder.show();
            }
            this.cursor.hide();
            this.isFocused = false;
        } }, { key: "write", value: function write(

        character) {
            this.size++;
            this.placeholder.hide();
            character.setEvents(this);
            character.$element.insertAfter(this.cursor.$element);
            character.animate(this.animation);
            this.cursor.move("right");
        } }, { key: "erase", value: function erase()

        {
            var last = this.cursor.$element.prev();
            if (last.length && this.size > 0) {
                this.size--;
                this.cursor.move("left");
                last.remove();
                if (this.size == 0) {
                    this.placeholder.show();
                }
            }
        } }, { key: "suppress", value: function suppress()

        {
            var next = this.cursor.$element.next();
            if (next.length && this.size > 0) {
                this.size--;
                next.remove();
                if (this.size == 0) {
                    this.placeholder.show();
                }
            }
        } }]);return Input;}();var


Placeholder = function () {
    function Placeholder(placeholder, input) {_classCallCheck(this, Placeholder);
        this.input = input;
        this.$element = $(document.createElement("div"));
        this.$element.text(placeholder);
        this.$element.addClass("placeholder");
        this.show();
    }_createClass(Placeholder, [{ key: "show", value: function show()

        {
            this.input.$element.append(this.$element);
        } }, { key: "hide", value: function hide()

        {
            this.$element.remove();
        } }]);return Placeholder;}();var




Keyboard = function () {function Keyboard() {_classCallCheck(this, Keyboard);}_createClass(Keyboard, null, [{ key: "readCharacters", value: function readCharacters(









        input) {
            input.$element.on("keypress", function (event) {
                event.preventDefault();
                input.write(new Character(String.fromCharCode(event.which)));
            });
        } }, { key: "readSpecialCharacters", value: function readSpecialCharacters(

        input) {
            input.$element.on("keydown", function (event) {
                switch (event.keyCode) {
                    case Keyboard.backspace:
                        event.preventDefault();
                        input.erase();
                        break;
                    case Keyboard.leftArrow:
                        input.cursor.move("left");
                        break;
                    case Keyboard.rightArrow:
                        input.cursor.move("right");
                        break;
                    case Keyboard.suppress:
                        input.suppress();
                        break;
                    case Keyboard.top:
                        input.cursor.goTo("top");
                        break;
                    case Keyboard.end:
                        input.cursor.goTo("end");
                        break;
                    default:
                        break;}

            });
        } }]);return Keyboard;}();Keyboard.space = 32;Keyboard.backspace = 8;Keyboard.leftArrow = 37;Keyboard.rightArrow = 39;Keyboard.suppress = 46;Keyboard.top = 36;Keyboard.end = 35;var


Cursor = function () {
    function Cursor(input) {_classCallCheck(this, Cursor);
        this.$element = $(document.createElement("div"));
        this.$element.addClass("cursor");
        this.$element.addClass("hidden");
        input.$element.prepend(this.$element);
    }_createClass(Cursor, [{ key: "show", value: function show()

        {
            this.$element.removeClass("hidden");
        } }, { key: "hide", value: function hide()

        {
            this.$element.addClass("hidden");
        } }, { key: "move", value: function move(

        direction) {
            var offSet = this.$element.get(0).offsetLeft;
            var textZone = this.$element.parent();

            if (direction == "right") {
                var next = this.$element.next();
                this.$element.insertAfter(next);
                if (offSet > textZone.width() * 0.99) {
                    var scroll = textZone.scrollLeft();
                    textZone.animate({ scrollLeft: scroll + '100' }, 1000);
                }
            } else if (direction == "left") {
                var prev = this.$element.prev();
                this.$element.insertBefore(prev);
            }
        } }, { key: "goTo", value: function goTo(

        point) {
            if (point == "top") {
                this.$element.parent().prepend(this.$element);
            } else if (point == "end") {
                this.$element.parent().append(this.$element);
            }
        } }]);return Cursor;}();var


Character = function () {
    function Character(character) {_classCallCheck(this, Character);
        this.$element = $(document.createElement("div"));
        if (character != " ") {
            this.$element.addClass("character");
            this.$element.text(character);
        } else {
            this.$element.addClass("space");
        }
    }_createClass(Character, [{ key: "setEvents", value: function setEvents(

        input) {
            var character = this;
            this.$element.on("click", function (event) {
                input.cursor.$element.insertBefore(character.$element);
                if (!input.isFocused) {
                    input.cursor.show();
                }
                event.stopPropagation();
            });
        } }, { key: "animate", value: function animate(

        animation) {
            this.$element.css("animation", animation + " 500ms, colorTransition 500ms");
        } }]);return Character;}();var


Selector = function () {
    function Selector(selector, options, defaultOption, callback) {_classCallCheck(this, Selector);
        this.$element = $(selector);
        this.$element.addClass("selector");
        this.$selection = $(document.createElement("div"));
        this.$selection.addClass("selection");
        var i = 0;
        this.current = i;
        this.$selection.text(options[i]);
        for (i = 0; i < options.length; i++) {if (window.CP.shouldStopExecution(1)) break;
            if (options[i] == defaultOption) {
                this.current = i;
                this.$selection.text(options[i]);
            }
        }window.CP.exitedLoop(1);
        this.$element.append(this.$selection);
        this.options = options;
        this.setEvents();
        this.setArrows();
        this.animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.callback = callback;
        this.selecting = false;
        callback(options[this.current]);
    }_createClass(Selector, [{ key: "setArrows", value: function setArrows()

        {
            var selector = this;
            this.$upArrow = $(document.createElement("div"));
            this.$upArrow.addClass("upArrow");
            this.$element.append(this.$upArrow);
            this.$upArrow.on("click", function () {
                if (!selector.isFirst() && !selector.selecting) {
                    selector.select("Down");
                }
            });
            this.$downArrow = $(document.createElement("div"));
            this.$downArrow.addClass("downArrow");
            this.$element.append(this.$downArrow);
            this.$downArrow.on("click", function () {
                if (!selector.isLast() && !selector.selecting) {
                    selector.select("Up");
                }
            });
            this.updateArrows();
        } }, { key: "setEvents", value: function setEvents()

        {
            var selector = this;
            this.$element.on("wheel", function (event) {
                if (event.originalEvent.deltaY > 0) {
                    if (!selector.isLast() && !selector.selecting) {
                        selector.select("Up");
                    }
                } else {
                    if (!selector.isFirst() && !selector.selecting) {
                        selector.select("Down");
                    }
                }
            });
        } }, { key: "isFirst", value: function isFirst()

        {
            return this.current == 0;
        } }, { key: "isLast", value: function isLast()

        {
            return this.current == this.options.length - 1;
        } }, { key: "select", value: function select(

        direction) {
            this.selecting = true;
            this.current = direction == "Up" ? this.current + 1 : this.current - 1;
            var selector = this;
            this.$selection.addClass("fadeOut" + direction).on(this.animationEnd, function () {
                selector.$selection.removeClass("fadeOut" + direction);
                selector.$selection.text(selector.options[selector.current]);
                selector.$selection.addClass("fadeIn" + direction).on(selector.animationEnd, function () {
                    selector.$selection.removeClass("fadeIn" + direction);
                    selector.callback(selector.options[selector.current]);
                    selector.selecting = false;
                    selector.updateArrows();
                });
            });
        } }, { key: "updateArrows", value: function updateArrows()

        {
            this.$upArrow.removeClass("upWhiteArrow");
            this.$upArrow.removeClass("upGreyArrow");
            this.$downArrow.removeClass("downWhiteArrow");
            this.$downArrow.removeClass("downGreyArrow");

            if (this.current == 0) {
                this.$upArrow.addClass("upGreyArrow");
                if (this.options.length < 2) {
                    this.$downArrow.addClass("downGreyArrow");
                } else {
                    this.$downArrow.addClass("downWhiteArrow");
                }
            } else if (this.current == this.options.length - 1) {
                this.$upArrow.addClass("upWhiteArrow");
                this.$downArrow.addClass("downGreyArrow");
            } else {
                this.$upArrow.addClass("upWhiteArrow");
                this.$downArrow.addClass("downWhiteArrow");
            }
        } }]);return Selector;}();


var input = new Input("#myInput", "Try me!");
new Selector("#selector", [
"bounce",
"fadeIn",
"fadeInDown",
"fadeInUp",
"fadeInLeft",
"fadeInRight",
"flash",
"jello",
"lightSpeedIn",
"pulse",
"rollIn",
"rotateIn",
"rotateInDownLeft",
"rotateInDownRight",
"rotateInUpLeft",
"rotateInUpRight",
"rubberBand",
"shake",
"slideInDown",
"slideInUp",
"slideInLeft",
"slideInRight",
"swing",
"tada",
"wobble",
"zoomIn"],
"rubberBand", function (selection) {
    input.animation = selection;
});
//# sourceURL=pen.js