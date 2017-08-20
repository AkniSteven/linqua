!function(t,i){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],i):"object"==typeof module&&module.exports?module.exports=i(require("outlayer"),require("get-size")):t.Masonry=i(t.Outlayer,t.getSize)}(window,function(t,i){"use strict";var e=t.create("masonry");return e.compatOptions.fitWidth="isFitWidth",e.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0},e.prototype.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],e=t&&t.element;this.columnWidth=e&&i(e).outerWidth||this.containerWidth}var o=this.columnWidth+=this.gutter,h=this.containerWidth+this.gutter,s=h/o,n=o-h%o,r=n&&n<1?"round":"floor";s=Math[r](s),this.cols=Math.max(s,1)},e.prototype.getContainerWidth=function(){var t=this._getOption("fitWidth")?this.element.parentNode:this.element,e=i(t);this.containerWidth=e&&e.innerWidth},e.prototype._getItemLayoutPosition=function(t){t.getSize();var i=t.size.outerWidth%this.columnWidth,e=i&&i<1?"round":"ceil",o=Math[e](t.size.outerWidth/this.columnWidth);o=Math.min(o,this.cols);for(var h=this._getColGroup(o),s=Math.min.apply(Math,h),n=h.indexOf(s),r={x:this.columnWidth*n,y:s},a=s+t.size.outerHeight,u=this.cols+1-h.length,l=0;l<u;l++)this.colYs[n+l]=a;return r},e.prototype._getColGroup=function(t){if(t<2)return this.colYs;for(var i=[],e=this.cols+1-t,o=0;o<e;o++){var h=this.colYs.slice(o,o+t);i[o]=Math.max.apply(Math,h)}return i},e.prototype._manageStamp=function(t){var e=i(t),o=this._getElementOffset(t),h=this._getOption("originLeft")?o.left:o.right,s=h+e.outerWidth,n=Math.floor(h/this.columnWidth);n=Math.max(0,n);var r=Math.floor(s/this.columnWidth);r-=s%this.columnWidth?0:1,r=Math.min(this.cols-1,r);for(var a=(this._getOption("originTop")?o.top:o.bottom)+e.outerHeight,u=n;u<=r;u++)this.colYs[u]=Math.max(a,this.colYs[u])},e.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},e.prototype._getContainerFitWidth=function(){for(var t=0,i=this.cols;--i&&0===this.colYs[i];)t++;return(this.cols-t)*this.columnWidth-this.gutter},e.prototype.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},e});