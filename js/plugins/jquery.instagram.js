/*
 * Instagram jQuery plugin
 * v0.2.1
 * http://potomak.github.com/jquery-instagram/
 * Copyright (c) 2012 Giovanni Cappellotto
 * Licensed MIT
 */

(function ($){
  $.fn.instagram = function (options) {
    var that = this,
        apiEndpoint = "https://api.instagram.com/v1",
        settings = {
            hash: null
            ,userId: null
            ,locationId: null
            ,search: null
            ,accessToken: null
            ,clientId: null
            ,show: null
            ,onLoad: null
            ,onComplete: null
            ,maxId: null
            ,minId: null
            ,next_url: null
            ,image_size: null
            ,photoLink: true
        };
        
    options && $.extend(settings, options);
    
    function createPhotoElement(data) {

      var imageUrl = data.images.thumbnail.url;
      if (settings.image_size == 'low_resolution') {
        imageUrl = data.images.low_resolution.url;
      }
      else if (settings.image_size == 'thumbnail') {
        imageUrl = data.images.thumbnail.url;
      }
      else if (settings.image_size == 'standard_resolution') {
        imageUrl = data.images.standard_resolution.url;
      }

      
      var imageHtml = $('<img>')
        .addClass('instagram-image')
        .attr('src', imageUrl);


      if (settings.photoLink) {
        imageHtml = $('<a>')
          .addClass('instagram-thumbnail')
          .attr('target', '_blank')
          .attr('href', data.link)
          .append(imageHtml);
      }

     
      var captionHtml = '';
      if(data.caption.text){
        captionHtml = $('<p>')
        .addClass('small grey avenir instagram-caption')
        .html(data.caption.text);
      }

      var metaHtml = $('<div>')
          .addClass('instagram-meta')
          .append(captionHtml);
      
      var innerHtml = $('<div>')
        .addClass('inner')
        .append(imageHtml)
        .append(metaHtml);

      return $('<div>')
        .addClass('striped-border bottom equal-height instagram-container')
        .attr('id', data.id)
        .append(innerHtml);
    }
    
    function createEmptyElement() {
      return $('<div>')
        .addClass('instagram-placeholder')
        .attr('id', 'empty')
        .append($('<p>').html('No photos for this query'));
    }
    
    function composeRequestURL() {

      var url = apiEndpoint,
          params = {};
      
      if (settings.next_url != null) {
        return settings.next_url;
      }

      if (settings.hash != null) {
        url += "/tags/" + settings.hash + "/media/recent";
      }
      else if (settings.search != null) {
        url += "/media/search";
        params.lat = settings.search.lat;
        params.lng = settings.search.lng;
        settings.search.max_timestamp != null && (params.max_timestamp = settings.search.max_timestamp);
        settings.search.min_timestamp != null && (params.min_timestamp = settings.search.min_timestamp);
        settings.search.distance != null && (params.distance = settings.search.distance);
      }
      else if (settings.userId != null) {
        url += "/users/" + settings.userId + "/media/recent";
      }
      else if (settings.locationId != null) {
        url += "/locations/" + settings.locationId + "/media/recent";
      }
      else {
        url += "/media/popular";
      }
      
      settings.accessToken != null && (params.access_token = settings.accessToken);
      settings.clientId != null && (params.client_id = settings.clientId);
      settings.minId != null && (params.min_id = settings.minId);
      settings.maxId != null && (params.max_id = settings.maxId);
      settings.show != null && (params.count = settings.show);

      url += "?" + $.param(params)
      
      return url;
    }
    
    settings.onLoad != null && typeof settings.onLoad == 'function' && settings.onLoad();
    
    $.ajax({
      type: "GET",
      dataType: "jsonp",
      cache: false,
      url: composeRequestURL(),
      success: function (res) {
        var length = typeof res.data != 'undefined' ? res.data.length : 0;
        var limit = settings.show != null && settings.show < length ? settings.show : length;
        
        if (limit > 0) {
          for (var i = 0; i < limit; i++) {
            that.append(createPhotoElement(res.data[i]));
          }
        }
        else {
          that.append(createEmptyElement());
        }

        settings.onComplete != null && typeof settings.onComplete == 'function' && settings.onComplete(res.data, res);
      }
    });
    
    return this;
  };
})(jQuery);
