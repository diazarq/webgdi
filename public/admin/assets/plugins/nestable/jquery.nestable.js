/*!
 * Enhanced Nestable2 - Hierarchical Drag & Drop Menu Builder
 * Supports both Free Drag & Drop Nesting and Programmatic Indent / Outdent
 */
;(function($, window, document, undefined) {
    var hasTouch = 'ontouchstart' in window;

    var defaults = {
        listNodeName    : 'ol',
        itemNodeName    : 'li',
        rootClass       : 'dd',
        listClass       : 'dd-list',
        itemClass       : 'dd-item',
        dragClass       : 'dd-dragel',
        handleClass     : 'dd-handle',
        collapsedClass  : 'dd-collapsed',
        placeClass      : 'dd-placeholder',
        noDragClass     : 'dd-nodrag',
        emptyClass      : 'dd-empty',
        expandBtnHTML   : '<button class="dd-expand" data-action="expand" type="button"><i class="bi bi-plus"></i></button>',
        collapseBtnHTML : '<button class="dd-collapse" data-action="collapse" type="button"><i class="bi bi-dash"></i></button>',
        group           : 0,
        maxDepth        : 3,
        threshold       : 25
    };

    function Plugin(element, options) {
        this.w = $(document);
        this.el = $(element);
        this.options = $.extend({}, defaults, options);
        this.init();
    }

    Plugin.prototype = {
        init: function() {
            var self = this;
            self.reset();
            self.el.data('nestable-id', new Date().getTime());

            self.placeEl = $('<' + self.options.itemNodeName + ' class="' + self.options.placeClass + '"></' + self.options.itemNodeName + '>');

            // Scan items and set parents
            self.el.find(self.options.itemNodeName).each(function() {
                self.setParent($(this));
            });

            // Expand / Collapse click handler
            self.el.on('click', 'button[data-action]', function(e) {
                if (self.dragEl) return;
                var btn = $(e.currentTarget);
                var action = btn.data('action');
                var item = btn.closest(self.options.itemNodeName);
                if (action === 'collapse') {
                    self.collapseItem(item);
                } else if (action === 'expand') {
                    self.expandItem(item);
                }
            });

            // Mouse / Touch Start
            var onStartEvent = function(e) {
                var target = $(e.target);

                // Ignore if clicked on no-drag elements (buttons, links, inputs)
                if (target.closest('.' + self.options.noDragClass).length || target.is('a, button, input, textarea, select')) {
                    return;
                }

                var handle = target.closest('.' + self.options.handleClass);
                if (!handle.length) {
                    // Fallback to item if handleClass not found
                    handle = target.closest('.' + self.options.itemClass);
                }

                if (!handle.length || self.dragEl) {
                    return;
                }

                self.isTouch = /^touch/.test(e.type);
                if (self.isTouch && e.touches.length !== 1) {
                    return;
                }

                e.preventDefault();
                self.dragStart(e.touches ? e.touches[0] : e);
            };

            var onMoveEvent = function(e) {
                if (self.dragEl) {
                    e.preventDefault();
                    self.dragMove(e.touches ? e.touches[0] : e);
                }
            };

            var onEndEvent = function(e) {
                if (self.dragEl) {
                    e.preventDefault();
                    self.dragStop(e.touches ? e.touches[0] : e);
                }
            };

            if (hasTouch) {
                self.el[0].addEventListener('touchstart', onStartEvent, false);
                window.addEventListener('touchmove', onMoveEvent, { passive: false });
                window.addEventListener('touchend', onEndEvent, false);
                window.addEventListener('touchcancel', onEndEvent, false);
            }

            self.el.on('mousedown', onStartEvent);
            self.w.on('mousemove', onMoveEvent);
            self.w.on('mouseup', onEndEvent);
        },

        reset: function() {
            this.mouse = {
                offsetX: 0,
                offsetY: 0,
                startX: 0,
                startY: 0,
                lastX: 0,
                lastY: 0
            };
            this.isTouch = false;
            this.dragEl = null;
            this.dragDepth = 1;
            this.dragRootEl = null;
        },

        serialize: function() {
            var self = this;
            var step = function(level) {
                var array = [];
                var items = level.children(self.options.itemNodeName);
                items.each(function() {
                    var li = $(this);
                    var item = { id: li.attr('data-id') || li.data('id') };
                    var sub = li.children(self.options.listNodeName);
                    if (sub.length && sub.children(self.options.itemNodeName).length) {
                        item.children = step(sub);
                    }
                    array.push(item);
                });
                return array;
            };
            return step(this.el.find(this.options.listNodeName).first());
        },

        collapseItem: function(li) {
            var lists = li.children(this.options.listNodeName);
            if (lists.length) {
                li.addClass(this.options.collapsedClass);
                li.children('[data-action="collapse"]').hide();
                li.children('[data-action="expand"]').show();
                lists.hide();
            }
        },

        expandItem: function(li) {
            var lists = li.children(this.options.listNodeName);
            if (lists.length) {
                li.removeClass(this.options.collapsedClass);
                li.children('[data-action="collapse"]').show();
                li.children('[data-action="expand"]').hide();
                lists.show();
            }
        },

        collapseAll: function() {
            var self = this;
            self.el.find(self.options.itemNodeName).each(function() {
                self.collapseItem($(this));
            });
        },

        expandAll: function() {
            var self = this;
            self.el.find(self.options.itemNodeName).each(function() {
                self.expandItem($(this));
            });
        },

        setParent: function(li) {
            if (li.children(this.options.listNodeName).length && li.children(this.options.listNodeName).children(this.options.itemNodeName).length) {
                if (!li.children('[data-action]').length) {
                    li.prepend($(this.options.expandBtnHTML).hide());
                    li.prepend($(this.options.collapseBtnHTML));
                }
            } else {
                this.unsetParent(li);
            }
        },

        unsetParent: function(li) {
            li.removeClass(this.options.collapsedClass);
            li.children('[data-action]').remove();
            li.children(this.options.listNodeName).remove();
        },

        // Helper: Indent an item to become a submenu of previous item
        indentItem: function(item) {
            var $item = $(item).closest(this.options.itemNodeName);
            var $prev = $item.prev(this.options.itemNodeName);
            if (!$prev.length) return false;

            var depth = $item.parents(this.options.listNodeName).length;
            if (depth >= this.options.maxDepth) return false;

            var $subList = $prev.children(this.options.listNodeName);
            if (!$subList.length) {
                $subList = $('<' + this.options.listNodeName + ' class="' + this.options.listClass + '"></' + this.options.listNodeName + '>');
                $prev.append($subList);
            }
            $subList.append($item);
            this.setParent($prev);
            this.el.trigger('change');
            return true;
        },

        // Helper: Outdent an item to promote to parent level
        outdentItem: function(item) {
            var $item = $(item).closest(this.options.itemNodeName);
            var $parentList = $item.parent(this.options.listNodeName);
            var $parentItem = $parentList.closest(this.options.itemNodeName);
            if (!$parentItem.length) return false;

            $parentItem.after($item);
            if (!$parentList.children(this.options.itemNodeName).length) {
                this.unsetParent($parentItem);
            }
            this.el.trigger('change');
            return true;
        },

        dragStart: function(e) {
            var mouse = this.mouse;
            var target = $(e.target);
            var dragItem = target.closest(this.options.itemNodeName);

            this.dragRootEl = this.el;

            // Height of placeholder
            this.placeEl.css('height', dragItem.outerHeight());

            mouse.offsetX = e.pageX - dragItem.offset().left;
            mouse.offsetY = e.pageY - dragItem.offset().top;
            mouse.startX = mouse.lastX = e.pageX;
            mouse.startY = mouse.lastY = e.pageY;

            // Calculate depth of dragging subtree
            this.dragDepth = 1;
            var childDepth = 0;
            dragItem.find(this.options.itemNodeName).each(function() {
                var d = $(this).parents(dragItem.find(this.options.listNodeName)).length + 1;
                if (d > childDepth) childDepth = d;
            });
            this.dragDepth += childDepth;

            // Create floating clone
            this.dragEl = $('<' + this.options.listNodeName + ' class="' + this.options.listClass + ' ' + this.options.dragClass + '"></' + this.options.listNodeName + '>');
            this.dragEl.css({
                'width': dragItem.outerWidth(),
                'position': 'absolute',
                'z-index': 9999,
                'pointer-events': 'none',
                'opacity': 0.95
            });

            dragItem.after(this.placeEl);
            dragItem.detach().appendTo(this.dragEl);
            $(document.body).append(this.dragEl);

            this.dragEl.css({
                'left': e.pageX - mouse.offsetX,
                'top': e.pageY - mouse.offsetY
            });
        },

        dragMove: function(e) {
            var mouse = this.mouse;
            var opt = this.options;

            this.dragEl.css({
                'left': e.pageX - mouse.offsetX,
                'top': e.pageY - mouse.offsetY
            });

            var mouseX = e.pageX;
            var mouseY = e.pageY;

            // 1. Horizontal Indent (Make Sub-menu)
            var prev = this.placeEl.prev(opt.itemNodeName);
            if (prev.length) {
                var prevLeft = prev.offset().left;
                // If cursor is shifted to the right of prev's left edge by 30px
                if (mouseX - prevLeft >= opt.threshold + 15) {
                    var currentDepth = this.placeEl.parents(opt.listNodeName).length;
                    if (currentDepth + this.dragDepth <= opt.maxDepth) {
                        var subList = prev.children(opt.listNodeName);
                        if (!subList.length) {
                            subList = $('<' + opt.listNodeName + ' class="' + opt.listClass + '"></' + opt.listNodeName + '>');
                            prev.append(subList);
                        }
                        subList.append(this.placeEl);
                        this.setParent(prev);
                    }
                }
            }

            // 2. Horizontal Outdent (Promote back to parent level)
            var currentList = this.placeEl.parent(opt.listNodeName);
            var parentItem = currentList.closest(opt.itemNodeName);
            if (parentItem.length) {
                var parentLeft = parentItem.offset().left;
                // If cursor is moved left towards parent's left boundary
                if (mouseX <= parentLeft + 20) {
                    parentItem.after(this.placeEl);
                    if (!currentList.children(opt.itemNodeName).length) {
                        this.unsetParent(parentItem);
                    }
                }
            }

            // 3. Vertical Reordering
            // Find element under cursor (temporarily hide dragEl if needed)
            this.dragEl.hide();
            var elemBelow = document.elementFromPoint(
                mouseX - (window.pageXOffset || document.documentElement.scrollLeft),
                mouseY - (window.pageYOffset || document.documentElement.scrollTop)
            );
            this.dragEl.show();

            if (!elemBelow) return;

            var $targetItem = $(elemBelow).closest('.' + opt.itemClass);
            if ($targetItem.length && !$targetItem.is(this.placeEl) && !$targetItem.closest(this.dragEl).length) {
                var targetOffset = $targetItem.offset();
                var isTopHalf = mouseY < (targetOffset.top + $targetItem.outerHeight() / 2);

                if (isTopHalf) {
                    $targetItem.before(this.placeEl);
                } else {
                    $targetItem.after(this.placeEl);
                }
            }

            mouse.lastX = mouseX;
            mouse.lastY = mouseY;
        },

        dragStop: function(e) {
            var item = this.dragEl.children(this.options.itemNodeName).first();
            item.detach();
            this.placeEl.replaceWith(item);
            this.dragEl.remove();

            // Refresh parent state
            var self = this;
            self.el.find(self.options.itemNodeName).each(function() {
                self.setParent($(this));
            });

            this.el.trigger('change');
            this.reset();
        }
    };

    $.fn.nestable = function(params) {
        var retval = this;
        var args = Array.prototype.slice.call(arguments, 1);

        this.each(function() {
            var plugin = $(this).data('nestable');
            if (!plugin) {
                $(this).data('nestable', new Plugin(this, params));
            } else {
                if (typeof params === 'string' && typeof plugin[params] === 'function') {
                    retval = plugin[params].apply(plugin, args);
                }
            }
        });

        return retval || this;
    };

})(window.jQuery || window.$, window, document);
