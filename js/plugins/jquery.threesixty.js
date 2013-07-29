(function ($) {
    'use strict';

    var defaults = {},
        dataName = 'threeSixty',
        ThreeSixty = function (object) {
            //set options
            this.element = object;
            this.ready = false;
            this.dragging = false;
            this.pointerStartPosX = 0;
            this.pointerEndPosX = 0;
            this.monitorStartTime = 0;
            this.monitorInt = 10;
            this.pointerDistance = 0;

            this.ticker = 0;
            this.speedMultiplier = 10;
            this.totalFrames = 0;
            this.currentFrame = 0;
            this.frames = [];
            this.endFrame = 0;
            this.loadedImages = 0;

            this.init();
        },
        init = function (options) {
            var settings = $.extend({}, defaults, options);
            return this.each(function () {
                var element = $(this),
                    threeSixty = new ThreeSixty(element, settings);

                element.data(dataName, threeSixty);
            });
        },
        callMethod = function (methodName) {
            if (!(methodName in ThreeSixty.prototype)) {
                $.error('Method ' + methodName + ' does not exist on jQuery.threeSixty');
            }
            var slicedArguments = Array.prototype.slice.call(arguments, 1);

            return this.each(function () {
                var $element = $(this);
                var threeSixty = $element.data(dataName);

                if (!threeSixty) {
                    // This element hasn't had three sixty constructed yet, so skip it
                    return true;
                }
                threeSixty[methodName].apply(threeSixty, slicedArguments);
            });
        };

    ThreeSixty.prototype = {
        init: function(){
            var instance = this,
                element = instance.element,
                items = $('li', element);

            this.totalFrames = items.size();
            this.currentFrame = this.totalFrames;

            element.mousedown(function (e) {
                // Prevents the original event handler behaviour
                e.preventDefault();
                // Stores the pointer x position as the starting position
                instance.pointerStartPosX = instance.getPointerEvent(e).pageX;
                if(!instance.pointerStartPosX ){
                    instance.pointerStartPosX = instance.getPointerEvent(e).clientX;
                }
                // Tells the pointer tracking function that the user is actually dragging the pointer and it needs to track the pointer changes
                element.addClass('grabbing');
                instance.dragging = true;
            });

            /**
            * Adds the jQuery 'mouseup' event to the document. We use the document because we want to let the user to be able to drag
            * the mouse outside the image slider as well, providing a much bigger 'playground'.
            */
            $(document).mouseup(function (e){
                // Prevents the original event handler behaciour
                e.preventDefault();
                // Tells the pointer tracking function that the user finished dragging the pointer and it doesn't need to track the pointer changes anymore
                element.removeClass('grabbing');
                instance.dragging = false;
            });

            /**
            * Adds the jQuery 'mousemove' event handler to the document. By using the document again we give the user a better user experience
            * by providing more playing area for the mouse interaction.
            */
            $(document).mousemove(function (e){
                // Prevents the original event handler behaciour
                e.preventDefault();
                // Starts tracking the pointer X position changes
                instance.trackPointer(e);
            });

            /**
            *
            */
            element.on('touchstart', function (e) {
                // Prevents the original event handler behaciour
                e.preventDefault();
                // Stores the pointer x position as the starting position
                instance.pointerStartPosX = instance.getPointerEvent(e).pageX;
                // Tells the pointer tracking function that the user is actually dragging the pointer and it needs to track the pointer changes
                instance.dragging = true;
            });

            /**
            *
            */
            element.on('touchmove', function (e) {
                // Prevents the original event handler behaciour
                e.preventDefault();
                // Starts tracking the pointer X position changes
                instance.trackPointer(e);
            });

            /**
            *
            */
            element.on('touchend', function (e) {
                // Prevents the original event handler behaviour
                e.preventDefault();
                // Tells the pointer tracking function that the user finished dragging the pointer and it doesn't need to track the pointer changes anymore
                instance.dragging = false;
            });

            items.each(function(){
                instance.frames.push($(this));
            });
            items.filter(':first-child').addClass('current');
            this.load();
        },
        load: function(){
            var instance = this,
                element = this.element,
                images = $('img', element),
                totalImages = images.length;

            element.addClass('loading');
            images.load(function(){
                totalImages--;
                if(totalImages === 1){
                    setTimeout(function(){
                        instance.loaded();
                    }, 1000);
                }
            });

        },
        loaded: function(){
            var instance = this,
                element = this.element,
                items = $('li', element),
                totalItems = items.length;
           
            
            items.each(function(i){
                var item = $(this);

                    
                setTimeout(function(){
                    items.removeClass('current');
                    item.addClass('current');
                    if(i === totalItems - 1){
                        setTimeout(function(){
                            instance.ready = true;
                            element.removeClass('loading');
                        }, 500);
                        items.removeClass('current');
                        instance.showCurrentFrame();
                    }
                }, (i * 30));
            });

        },
        spin: function(){
            var instance = this,
                element = this.element,
                items = $('li', element),
                totalItems = items.length;
           
            instance.ready = false;

            items.each(function(i){
                var item = $(this);

                    
                setTimeout(function(){
                    items.removeClass('current');
                    item.addClass('current');
                    if(i === totalItems - 1){
                        setTimeout(function(){
                            instance.ready = true;
                        }, 500);
                        items.removeClass('current');
                        instance.showCurrentFrame();
                    }
                }, (i * 30));
            });
        },
        render: function(){
        // The rendering function only runs if the 'currentFrame' value hasn't reached the 'endFrame' one
            if(this.currentFrame !== this.endFrame){

                /*
                    Calculates the 10% of the distance between the 'currentFrame' and the 'endFrame'.
                    By adding only 10% we get a nice smooth and eased animation.
                    If the distance is a positive number, we have to ceil the value, if its a negative number, we have to floor it to make sure
                    that the 'currentFrame' value surely reaches the 'endFrame' value and the rendering doesn't end up in an infinite loop.
                */
                var frameEasing = this.endFrame < this.currentFrame ? Math.floor((this.endFrame - this.currentFrame) * 0.1) : Math.ceil((this.endFrame - this.currentFrame) * 0.1);
                // Sets the current image to be hidden
                this.hidePreviousFrame();
                // Increments / decrements the 'currentFrame' value by the 10% of the frame distance
                this.currentFrame += frameEasing;
                // Sets the current image to be visible
                this.showCurrentFrame();
            } else {
                // If the rendering can stop, we stop and clear the ticker
                clearInterval(this.ticker);
                this.ticker = 0;
            }
        },

        refresh: function() {
            // If the ticker is not running already...
            if (this.ticker === 0) {
                // Let's create a new one!
                var instance = this;
                //instance.render();
                this.ticker = setInterval(function(){
                    instance.render();
                }, Math.round(1000 / 60));
            }
        },

        hidePreviousFrame: function() {
            /*
                Replaces the 'current-image' class with the 'previous-image' one on the image.
                It calls the 'getNormalizedCurrentFrame' method to translate the 'currentFrame' value to the 'totalFrames' range (1-180 by default).
            */
            var frame = this.frames[this.getNormalizedCurrentFrame()];
            if(frame){
                frame.removeClass('current');
            }
        },

        /**
        * Displays the current frame
        */
        showCurrentFrame: function() {
            /*
                Replaces the 'current-image' class with the 'previous-image' one on the image.
                It calls the 'getNormalizedCurrentFrame' method to translate the 'currentFrame' value to the 'totalFrames' range (1-180 by default).
            */
            var frame = this.frames[this.getNormalizedCurrentFrame()];
            
            if(frame){
                frame.addClass('current');
            }
        },

        /**
        * Returns the 'currentFrame' value translated to a value inside the range of 0 and 'totalFrames'
        */
        getNormalizedCurrentFrame: function() {
            var c = Math.ceil(this.currentFrame % this.totalFrames);
          
            if (c < 0) {
                c += (this.totalFrames - 1);
            }
            return c;
        },

        /**
        * Returns a simple event regarding the original event is a mouse event or a touch e.
        */
        getPointerEvent: function(e) {
            return e.originalEvent.targetTouches ? e.originalEvent.targetTouches[0] : e;
        },

        /**
        * Tracks the pointer X position changes and calculates the 'endFrame' for the image slider frame animation.
        * This function only runs if the application is ready and the user really is dragging the pointer; this way we can avoid unnecessary calculations and CPU usage.
        */
        trackPointer: function (e) {
            // If the app is ready and the user is dragging the pointer...
            if (this.ready && this.dragging) {
                // Stores the last x position of the pointer
                this.pointerEndPosX = this.getPointerEvent(e).pageX;
                if(!this.pointerEndPosX) {
                    this.pointerEndPosX = this.getPointerEvent(e).clientX;
                }
                // Checks if there is enough time past between this and the last time period of tracking
                if(this.monitorStartTime < new Date().getTime() - this.monitorInt) {

                    // Calculates the distance between the pointer starting and ending position during the last tracking time period
                    this.pointerDistance = this.pointerEndPosX - this.pointerStartPosX;
                    // Calculates the endFrame using the distance between the pointer X starting and ending positions and the 'speedMultiplier' values
                    this.endFrame = this.currentFrame + Math.ceil((this.totalFrames - 1) * this.speedMultiplier * (this.pointerDistance / this.element.width()));
                    // Updates the image slider frame animation
                    this.refresh();

                    // restarts counting the pointer tracking period
                    this.monitorStartTime = new Date().getTime();
                    // Stores the the pointer X position as the starting position (because we started a new tracking period)
                    this.pointerStartPosX = this.getPointerEvent(e).pageX;
                    if(!this.pointerStartPosX) {
                        this.pointerStartPosX = this.getPointerEvent(e).clientX;
                    }
                }
            }
        }
    };
    $.fn.threeSixty = function (method) {
        if (typeof method === 'object' || ! method) {
            return init.apply(this, arguments);
        } else {
            return callMethod.apply(this, arguments);
        }
    };

})(jQuery);