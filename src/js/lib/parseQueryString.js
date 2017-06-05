var parseQueryString = {
  geturl: function(url) {
    var urlParams = {};
    url.replace(
      new RegExp("([^?=&]+)(=([^&]*))?", "g"),
      function($0, $1, $2, $3) {
        urlParams[$1] = $3;
      }
    );

    return urlParams;
  },
  getParams: function(){
    var urlParams = window.location.href.split('?')[1];
    if (urlParams === undefined){
      return new Object();
    } else {
      return this.geturl(urlParams);
    }
  }
}

module.exports = parseQueryString;
