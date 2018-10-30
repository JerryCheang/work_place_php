jQuery(document).ready(function(){
	jQuery(document.body).customBind();
});

/* dynamic load effect */
jQuery.fn.loadIt = function(url, params, callBack) {
	$(this).html('<span class=loadIt>...数据载入中...</span>').addClass('loadIt');
	$(this).load(url, params, function(data) {
		$(this).customBind().removeClass('loadIt');
		if (callBack) {
			callBack(data);
		}
	});
	return this;
}
jQuery.fn.customBind = function (){
	jQuery(this)
		.find('.confirm').click(function(){
			return confirm('确认'+$(this).attr('title')+'？');
		}).end()
		.find('a[type=window]').facebox().end()
		.find('a[type=popup]').click(function(){
            var left=(screen.width-1000)/2;
            var top=(screen.height-600)/2;
			window.open($(this).attr('href'),'',"width=1000,height=600,scrollbars=yes,location=no,top="+top+",left="+left);
			return false;
		}).end()
	return this;
}
function dump (obj,rr){
	var r;
	for (i in obj){
		r=r+ i+ "=" + obj[i]+"\n";
	}
	if (rr){
		return r;
	}else{
		alert(r);
	}
}

function getCookie( name ) { 
    var start = document.cookie.indexOf( name + "=" ); 
    var len = start + name.length + 1; 
    if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) { 
        return null; 
    } 
    if ( start == -1 ) return null; 
    var end = document.cookie.indexOf( ';', len ); 
    if ( end == -1 ) end = document.cookie.length; 
    return unescape( document.cookie.substring( len, end ) ); 
}
/**
 * 设置cookie
 * @param name
 * @param value
 * @param expires 单位是秒
 * @param path
 * @param domain
 * @param secure
 * @return
 */
function setCookie( name, value, expires, path, domain, secure ) { 
    var today = new Date(); 
    today.setTime( today.getTime() ); 
    if ( expires ) { 
        expires = expires * 1000 ; 
    } 
    var expires_date = new Date( today.getTime() + (expires) ); 
    document.cookie = name+'='+escape( value ) + 
        ( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) + //expires.toGMTString() 
        ( ( path ) ? ';path=' + path : '' ) + 
        ( ( domain ) ? ';domain=' + domain : '' ) + 
        ( ( secure ) ? ';secure' : '' );
} 
 
function deleteCookie( name, path, domain ) { 
    if ( getCookie( name ) ) document.cookie = name + '=' + 
            ( ( path ) ? ';path=' + path : '') + 
            ( ( domain ) ? ';domain=' + domain : '' ) + 
            ';expires=Thu, 01-Jan-1970 00:00:01 GMT'; 
} 

function urlencode(str) {
    return escape(str).replace('+', '%2B').replace('%20', '+').replace('*', '%2A').replace('/', '%2F').replace('@', '%40');
}

function urldecode(str) {
    return unescape(str.replace('+', ' '));
}
/** 
 * 全选按钮组建，用法参考  toebay/items
 * btn unities */
function selectBtnInti(btnSelector,chkSelector){
	$(btnSelector).live('change',function(){
		if ($(this).is(":checked")){
			$(chkSelector).attr('checked','checked');
		}else{
			$(chkSelector).removeAttr('checked');
		}
	});
	$(chkSelector).live('change',function(){
		console.log($(chkSelector).find(':checked').length);
		console.log($(chkSelector).length);
		
		if($(chkSelector).parent().find(':checked').length == $(chkSelector).length){
			$(btnSelector).attr('checked','checked');
		}else {
			$(btnSelector).removeAttr('checked');
		}
	});
}
