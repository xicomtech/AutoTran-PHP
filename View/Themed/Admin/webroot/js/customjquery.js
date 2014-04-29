

(function($) {
    /**
    * adding on paste event
    */
    $.fn.pasteEvents = function( delay ) {
        if (delay == undefined) delay = 20;
        return $(this).each(function() {
            var $el = $(this);
            $el.on("paste", function() {
                $el.trigger("prepaste");
                setTimeout(function() {
                    $el.trigger("postpaste");
                }, delay);
            });
        });
    };
    (function($)             {
        $.html_decode = function(h)             {
            return $('<p>'+h+'</p>').text();
        }
    })(jQuery);
   
    /**
     * unserialize jquery form string
     */
    (function($)             {
        $.unserialize = function(serializedString)             {
            var str = decodeURI(serializedString);
            var pairs = str.split('&');
            var obj = {}, p, idx, val;
            for (var i=0, n=pairs.length; i < n; i++) {
                p = pairs[i].split('=');
                idx = p[0];
                
                if (idx.indexOf("[]") == (idx.length - 2)) {
                    // Eh um vetor
                    var ind = idx.substring(0, idx.length-2)
                    if (obj[ind] === undefined) {
                        obj[ind] = [];
                    }
                    obj[ind].push(p[1]);
                }
                else {
                    obj[idx] = p[1];
                }
            }
            return obj;
        };
    })(jQuery);
    /*
     * unserialize php serialized string
     */
    (function($)             {
        
        $.unserializePhp = function(data) {
        
            var that = this;
        
            tmp_arr  = new Array();
            function utf8_decode (str_data) {
                
                i = 0,ac = 0,c1 = 0,c2 = 0,c3 = 0;
 
                str_data += '';
 
                while (i < str_data.length) {
                    c1 = str_data.charCodeAt(i);
                    if (c1 < 128) {
                        tmp_arr[ac++] = String.fromCharCode(c1);
                        i++;
                    } else if (c1 > 191 && c1 < 224) {
                        c2 = str_data.charCodeAt(i + 1);
                        tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
                        i += 2;
                    } else {
                        c2 = str_data.charCodeAt(i + 1);
                        c3 = str_data.charCodeAt(i + 2);
                        tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                        i += 3;
                    }
                } 
                return tmp_arr.join('');
            }
            var utf8Overhead = function (chr) {
                // http://phpjs.org/functions/unserialize:571#comment_95906
                var code = chr.charCodeAt(0);
                if (code < 0x0080) {
                    return 0;
                }
                if (code < 0x0800) {
                    return 1;
                }
                return 2;
            };
        
            var error = function (type, msg, filename, line) {
                throw new that.window[type](msg, filename, line);
            };
            var read_until = function (data, offset, stopchr) {
                var buf = [];
                var chr = data.slice(offset, offset + 1);
                var i = 2;
                while (chr != stopchr) {
                    if ((i + offset) > data.length) {
                        error('Error', 'Invalid');
                    }
                    buf.push(chr);
                    chr = data.slice(offset + (i - 1), offset + i);
                    i += 1;
                }
                return [buf.length, buf.join('')];
            };
            var read_chrs = function (data, offset, length) {
                var buf;
                buf = [];
                for (var i = 0; i < length; i++) {
                    var chr = data.slice(offset + (i - 1), offset + i);
                    buf.push(chr);
                    length -= utf8Overhead(chr);
                }
                return [buf.length, buf.join('')];
            };
            var _unserialize = function (data, offset) {
                var readdata;
                var readData;
                var chrs = 0;
                var ccount;
                var stringlength;
                var keyandchrs;
                var keys;
            
                if (!offset) {
                    offset = 0;
                }
                var dtype = (data.slice(offset, offset + 1)).toLowerCase();
            
                var dataoffset = offset + 2;
                var typeconvert = function (x) {
                    return x;
                };
            
                switch (dtype) {
                    case 'i':
                        typeconvert = function (x) {
                            return parseInt(x, 10);
                        };
                        readData = read_until(data, dataoffset, ';');
                        chrs = readData[0];
                        readdata = readData[1];
                        dataoffset += chrs + 1;
                        break;
                    case 'b':
                        typeconvert = function (x) {
                            return parseInt(x, 10) !== 0;
                        };
                        readData = read_until(data, dataoffset, ';');
                        chrs = readData[0];
                        readdata = readData[1];
                        dataoffset += chrs + 1;
                        break;
                    case 'd':
                        typeconvert = function (x) {
                            return parseFloat(x);
                        };     
                        readData = read_until(data, dataoffset, ';');
                        chrs = readData[0];
                        readdata = readData[1];
                        dataoffset += chrs + 1;
                        break;
                    case 'n':
                        readdata = null;
                        break;
                    case 's':
                        ccount = read_until(data, dataoffset, ':');
                        chrs = ccount[0];
                        stringlength = ccount[1];
                        dataoffset += chrs + 2;
                    
                        readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
                        chrs = readData[0];
                        readdata = readData[1];
                        dataoffset += chrs + 2;
                        if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
                            error('SyntaxError', 'String length mismatch');
                        }
                    
                        // Length was calculated on an utf-8 encoded string
                        // so wait with decoding
                        readdata = utf8_decode(readdata);
                        break;
                    case 'a':
                        readdata = {};
                    
                        keyandchrs = read_until(data, dataoffset, ':');
                        chrs = keyandchrs[0];
                        keys = keyandchrs[1];
                        dataoffset += chrs + 2;
                    
                        for (var i = 0; i < parseInt(keys, 10); i++) {
                            var kprops = _unserialize(data, dataoffset);
                            var kchrs = kprops[1];
                            var key = kprops[2];
                            dataoffset += kchrs;
                            var vprops = _unserialize(data, dataoffset);
                            var vchrs = vprops[1];
                            var value = vprops[2];
                            dataoffset += vchrs;
                            readdata[key] = value;
                        }
                    
                        dataoffset += 1;
                        break;
                    default:
                        error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
                        break;
                }
                return [dtype, dataoffset - offset, typeconvert(readdata)];
            };
        
            return _unserialize((data + ''), 0)[2];
        };
    })(jQuery);

})(jQuery); 