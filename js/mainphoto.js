;($( '#div_imgurl_input').DDSort({
	target: '.movebox',
	floatStyle: {
		'position':'absolute',
		'border': '1px solid #ccc',
		'background-color': '#fff',
	},
});
function setimgtagurl(id,url){
	$('#'+id).prev().attr('src',url);
}
function addimgtagurl(id,url){
	var name=$('#'+id).attr('name');
	//说明是刊登图片
	//alert(name.indexOf('imgurl')+"--"+name.indexOf('imgshow')+"--"+name.indexOf('rollingimg'));
	if(name.indexOf('imgurl')>=0){
		Addimgurl_input(url);
	}//特效图片
	else if(name.indexOf('imgshow')>=0){
		Addimgurl_input2(url);
	}//图片轮播
	else if(name.indexOf('rollingimg')>=0){
		Addimgurl_input3(url);
	}//多属性图片
    else if(name.indexOf('picture')>=0){
		var obj=$('#'+id).next().next().next();
		addimgurl(obj,url);
	}
}
function setimgtagurl(id,url){
	$('#'+id).prev().attr('src',url);
}
function imgurl_input_blur(obj){
    var t=$(obj).val();
    if(t.indexOf('{-BINDPRODUCTPICTURE-}')>=0){
        t= t.replace('{-BINDPRODUCTPICTURE-}',$('#bindproductpicture_val').val());
    }
    //一个多属性可以加多张图
    //$(obj).parent().children('img').attr('src',t);
    $(obj).prev().attr('src',t);
}

 //上移

function moveup(obj){
	var img=$(obj).parent().children('img').attr('src');
	var upimg=$(obj).parent().prev().children('img').attr('src');
	var va=$(obj).parent().children('input[type=text]').val();
	var upva=$(obj).parent().prev().children('input[type=text]').val();
	$(obj).parent().children('input[type=text]').val(upva);
	$(obj).parent().prev().children('input[type=text]').val(va);
	$(obj).parent().children('img').attr('src',upimg);
	$(obj).parent().prev().children('img').attr('src',img);
}
//下移
function movedown(obj){
	var img=$(obj).parent().children('img').attr('src');
	var downimg=$(obj).parent().next().children('img').attr('src');
	var va=$(obj).parent().children('input[type=text]').val();
	var downva=$(obj).parent().next().children('input[type=text]').val();
	$(obj).parent().children('input[type=text]').val(downva);
	$(obj).parent().next().children('input[type=text]').val(va);
	$(obj).parent().children('img').attr('src',downimg);
	$(obj).parent().next().children('img').attr('src',img);
}
//删除
function removeaway(obj){
	var div=$(obj).parent();
	if(div.nextAll().length==0&&div.prevAll().length!=0)
	{
		div.prev().children('a:last-child').remove();
	}
	if(div.prevAll().length==0&&div.nextAll().length!=0)
	{
		div.next().children('a')[1].remove();
	}
	$(obj).parent().remove();
	return false;
}
//选择商品
function opengoodswindow(vvalue,siteid)
{
//	alert(vvalue+"&"+siteid);
	//把SKU的input的id值(动态)传给隐藏input
	$("#childwintoparentwin").val(vvalue);
	$("#setnext_text").val(siteid);
	window.open('/index.php/goods/selectmygoodstovar','selectGoods','width=850,height=500,menubar=no,scrollbars=yes','true');
}

//增加行
function addRows(){
	var num=$('#number').val();
    for(var i=0;i<num;i++){
    	addRow();
    }
}
function addRow(obj)
{
	vtr=$('#variation_table').find('tr:last').clone().find('input[type=text]').val('').removeAttr('readonly').end();
	iii=parseInt(vtr.find('.vskubox').attr('id').replace('variationsku',''));
	iii++;
	vtr.find('input[name^=newattribute]').each(function (){
		var oldname=$(this).prev().attr('name');
		$(this).attr('name',oldname);
		$(this).prev().remove();
	});

	//vtr.find('input:first').attr('onkeyup','imgshuxing('+iii+')');
	if(typeof(glindex)!='undefined'){
		name=$.trim($('#variation_table').find('tr').eq(0).find('th').eq(glindex).find('input').eq(1).val());
		nname = name.replace(/\'/g,"%1122%");
		vname = name.replace(/\s/g,"");
		vname =vname.replace(/\&/g,"");
		vtr.find('input[type=text]').eq(glindex).attr('onkeyup','imgshuxing('+iii+','+glindex+',\"'+vname+'\")');

		//vtr.find('input').eq(glindex).attr('onblur','imgshuxing('+iii+','+glindex+','+name+');addrelationshuxing('+iii+','+glindex+');');
	}
	var delname=name+iii;
	vtr.attr('id',iii);
	vtr.find('td:last').html("<input type='button' onclick='delduoshuxin("+iii+",\""+delname+"\",this);' value='删除'>");
	vtr.find('.vskubox').attr('id','variationsku'+iii.toString());
	vtr.find('.vskubtn').attr('id','selected'+iii.toString());
	vtr.find('label').attr('id', 'setprice_eps'+iii.toString());

	vtr.find('.vskubtn').removeAttr("onclick");
	/*vtr.find('.vskubtn').bind('click', function(){
		opengoodswindow('variationsku'+iii.toString(), 'setprice_eps'+iii.toString());
	});*/
	var variationsku_num = 'variationsku'+iii.toString();
	var setprice_eps_num = 'setprice_eps'+iii.toString();
	vtr.find('.vskubtn').attr('onclick', 'opengoodswindow("'+variationsku_num+'","'+setprice_eps_num+'")');
	vtr.appendTo('#variation_table');
	addimgRow(iii);
}
//删除行
function delduoshuxin(i,id,obj){
	//$("#"+id).remove();
	$(obj).parent().parent().remove();
	$('table[name=variationimg]').each(function (){
		var name=$.trim($(this).attr('id'))+i;
		delimg(name);
	});

}
//修改关联属性触发改变组合属性列的onkeup
function  xiugaishijian(index,name){
	//$('#variation_table').find('tr:last').find('input').eq(glindex).removeAttr('onkeyup');
	$('#variation_table').find('tr').each(function (){
         $(this).find('input').eq(glindex).removeAttr('onkeyup');

	});
	glindex=index;
	//$('#variation_table').find('tr:last').find('input').eq(glindex).attr('onkeyup','imgshuxing('+iii+','+glindex+')');
	$('#variation_table').find('tr').each(function (i){
		a=i-1;
		nname = name.replace(/\'/g,"%1122%");
         $(this).find('input[type=text]').eq(glindex).attr("onkeyup","imgshuxing("+a+","+glindex+",\""+nname+"\")");
	});

}
//给新增图片的名称列赋值
function imgshuxing(id,index,name){
    var tr_name=name+id;
    //缺陷 #10176 B_在线listing多属性-增加项后，图片关联属性的部分，属性不会自动填写，手动也无法填写
    tr_name = tr_name.replace(/\s/g,"");
    tr_name =tr_name.replace(/\(/g,"\\(");
    tr_name =tr_name.replace(/\)/g,"\\)");
    tr_name =tr_name.replace(/\[/g,"\\[");
    tr_name =tr_name.replace(/\]/g,"\\]");
    tr_name =tr_name.replace(/\:/g,"\\:");
    tr_name =tr_name.replace(/\//g,"\\/");
    tr_name =tr_name.replace(/\%1122%/g,"\\'");
    tr_name =tr_name.replace(/\#/g,"\\#");
	var val=$("#"+id).find('input[type=text]').eq(index).val();
	$("#"+tr_name.replace(/(^\s*)|(\s*$)/g, "")).find('input:first').val(val);
	setnewimgvalue($("#"+tr_name).find('input:first'), val);
}
//增加关联属性的值
function addrelationshuxing(id, index){
	var val=$("#"+id).find('input').eq(index).val();
	val = '"'+val+'"';
	var text = $('#variation_table').find('input[type=hidden]').eq(index).val();
	var value = $('#text'+text).val();
	$('#text'+text).text(value.replace(']}', ","+val+"]}"));
	$('#text'+text).attr('name','varvalue');
}
//根据listing所支持的ean等添加属性
function  addcolean(){
		var val=$('#tishi').text().split(',');
		for(v in val){
			 if(val[v].indexOf('MPN')>=0){
				 eanaddcol('MPN');
	           }
	           if(val[v].indexOf('EAN')>=0){
	        	   eanaddcol('EAN');
	           }
	           if(val[v].indexOf('ISBN')>=0){
	        	   eanaddcol('ISBN');
	           }
	           if(val[v].indexOf('UPC')>=0){
	        	   eanaddcol('UPC');
	           }
		}
}
//增加属性ean等
function eanaddcol(name)
{
	var table = document.getElementById("variation_table");
	var oth=document.createElement('th');
	oth.innerHTML="<input type='text'name='nvl_name[]'  value='"+name+"' /><img src='/link/img/action/delete.png' style='cursor: pointer;' name='deletecol' onclick='deleteCol(this)'>";
	var length=table.rows[0].childNodes.length;
	table.rows[0].insertBefore(oth,table.rows[0].childNodes[length-4]);
	var b = new Base64();
    name=b.encode(name);
	for(var i=1;i<table.rows.length;i++){
		var otd=document.createElement('td');
		otd.innerHTML="<input type='text' name='"+name+"[]' />";
		table.rows[i].insertBefore(otd,table.rows[i].childNodes[length-4]);
	}
}
//增加列
function addcol(obj)
{
	var random=Math.round((Math.random())*100000000);
	var table = document.getElementById("variation_table");
	var oth=document.createElement('th');
	oth.innerHTML="<input piclabelid='"+random+"' type='text'name='nvl_name[]' onblur='updateattr(this)'/><img src='/link/img/action/delete.png' style='cursor: pointer;' name='deletecol' onclick='deleteCol(this)'>";
	var length=table.rows[0].childNodes.length;
	table.rows[0].insertBefore(oth,table.rows[0].childNodes[length-6]);
	//关联图片table
	var pictable='<table piclabelid="'+random+'" class="ebay_table" name="variationimg" style="width: 100%; display: none;"><tbody>';
	pictable+='<tr><th></th><th>图片地址</th></tr>';
	for(var i=1;i<table.rows.length;i++){
		var otd=document.createElement('td');
		otd.innerHTML="<input type='text' />";
		table.rows[i].insertBefore(otd,table.rows[i].childNodes[length-6]);

		var iiiids="";
		for(iid=0;iid<10;iid++){
			iiiids=iiiids+Math.round(Math.random()*10);
		}
		var  trnum=parseInt($('#variation_table').find('tr[uname=zhi]').eq(i-1).find('.vskubox').attr('id').replace('variationsku',''));
		var imgselectid="imgselect"+iiiids;
		pictable+='<tr trnum="'+trnum+'">'
						+'<th>'
							+'<strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong>'
						+'</th>'
						+'<td>'
							+'<img src="" style="width:50px;height:50px;"/>'
							+'<input id="'+imgselectid+'" size="140" class="property_pic" onblur="imgurl_input_blur(this)" name="imgselect" value="" type="text"/>'
							+'<label class="main_pic"></label><input onclick="selectPicture(\''+imgselectid+'\')" iid="xuantu" value="选择图片" type="button"/>'
							+'<input onclick="bdupload(this)" value="本地上传图片" type="button"/><input value="添加图片" onclick="addimgurl(this)" type="button"/>'
						+'</td>'
				  +'</tr>';
	}
	pictable+="</tbody></table>";
	//增加属性后 还需要增该属性对应的图片选项
	var countlabel=$('#variation_table').find('tr').eq(0).children('th').length-5;
	$('#pic_and_attribute').children('label:last').before('<label><input id="'+random+'" name="variationspecificname"  value="" onclick="changename($(this),'+countlabel+')" type="radio"></label>');
	//创建关联图片table;

	$('#pic_and_attribute').children('table:last').before(pictable);
}
//删除列
function  deleteCol(obj){
    //获取当前td在table下tr中的index
    var index="";
    $('#variation_table').find('tr:eq(0)').find('th').each(function (i){
        if($(this).find('img').attr('name')=="deletecol"){
            index=i;
        }
    });

    if(index!=""){
     //执行删除
     var pic_label_id;
     $('#variation_table').find('tr').each(function (e){
         if(e==0){
        	 pic_label_id=$(this).find('th').eq(index).find('input').attr('piclabelid');
        	 $(this).find('th').eq(index).remove();
         }else{
        	 $(this).find('td').eq(index).remove();
         }

     });
     //删除之后  还需要把关联的图片项删除
     $('#'+pic_label_id).parent().remove();
     $('.ebay_table[piclabelid='+pic_label_id+']').remove();
    }else{
         alert("系统错误   请联系管理员");
    }
}
function updateattr(obj)
{
	var value = $(obj).val();
	var piclabelid=$(obj).attr('piclabelid');
	//获得当前节点是在第几个input中
	var num=0;
	$('#variation_table tr:eq(0)').find('input[type="text"]:visible').each(function(i){
		if($(this).val()==value){
			num = i;
		}
	});
	//如果为0就是没找到要报错，以免客户改错数据了
	if(num!=0){
		$('#variation_table tr:gt(0)').each(function(){
			 var b = new Base64();
			 var values= b.encode(obj.value)+"[]";
			$(this).find('input[type="text"]:visible').eq(num).attr('name',values);
		});
		//属性改掉后  需要把名称添加到图片关联选项
		$('#'+piclabelid).val(value);
		$('#'+piclabelid).parent().html(document.getElementById(piclabelid).outerHTML+value);
		$('.ebay_table[piclabelid='+piclabelid+']').find('tr').eq(0).find('th').eq(0).html(value);
		//名称每变化一次   相应的关联图片相关的也需要变化一下
		$('.ebay_table[piclabelid='+piclabelid+']').find('tr').each(function (inum){
			if(inum!=0){
				trid = value.replace(/\s/g,"");
				trid = trid.replace(/\&amp;/g,"");
				$(this).attr('id',trid+$(this).attr('trnum'));
			}
		});
	}else{
		alert('请联系客服');
	}
}
//js 实现base64_encode()
function Base64() {
    // private property
    _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

    // public method for encoding
    this.encode = function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;
        input = _utf8_encode(input);
        while (i < input.length) {
            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);
            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;
            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }
            output = output +
            _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
            _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
        }
        return output;
    }
    // private method for UTF-8 encoding
    _utf8_encode = function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);
            if (c < 128) {
                utftext += String.fromCharCode(c);
            } else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            } else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }

        }
        return utftext;
    }
}
//增加图片行
function addimgRow(imgid)
{
	//vtr=$('#variation_table').find('tr:last').clone().find('input[type=text]').val('').removeAttr('readonly').end();

	$('table[name=variationimg]').each(function (){
		var trid1=$(this).find('tr th').html();
		var trid=$.trim(trid1)+imgid;
		//缺陷 #10176 B_在线listing多属性-增加项后，图片关联属性的部分，属性不会自动填写，手动也无法填写
		trid = trid.replace(/\s/g,"");
		trid = trid.replace(/\&amp;/g,"");
// 		vtr='<tr id="'+trid+'"><th><strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong></th>'+
// 	        '<td><input name="" id="" value="" size="150" class="property_pic"> <label class="processing_pic"></label><input type="button" value="添加图片" onclick="addimgurl(this)" value="添加图片"></td></tr>';
//		$(this).find('tr:last').end().append(vtr);
		var obj=$(this).find('tr:last').end();
		$.ajax({
            url:'/index.php/muban/getpicselect',
            type:'post',
            data:'class=property_pic&size=140',
            success:function (res){
            	obj.append('<tr id="'+trid+'"><th><strong><input type="text" size="14" readonly="readonly" onblur="setnewimgvalue($(this),$(this).val())"></strong></th><td><img src="" style="width:50px;height:50px;">'+res+'<input type="button" onclick="bdupload(this)" value="本地上传图片"><input type="button" value="添加图片" onclick="addimgurl(this)" value="添加图片"></td></tr>');

             },
		});
	});
	imgid++;
}
//删除图片行
function delimg(id){
	$("#"+id).remove();
}
//$(this).parent().parent().parent().children(\'td\').children(\'input\').val($(this).val())
function setnewimgvalue(obj,v){
	$(obj).parent().parent().parent().children('td').children('input').attr("name","picture["+v+"][]");
	//$(obj).parent().parent().parent().children('td').children('input').attr("id","picture"+v);
}

$.each([0,1,2,3,4,5],function(i){
    $('#ship'+i).change(function(){
        if(this.checked){
            $('#tobecost'+i).hide();
            $('#tobecost'+i*7).hide();
            $('#tobecost'+i*11).hide();
            $('#tobecost'+i*13).hide();
        }else{
            $('#tobecost'+i).show();
            $('#tobecost'+i*7).show();
            $('#tobecost'+i*11).show();
            $('#tobecost'+i*13).show();
        }
        }
    );})
function inputbox_left(inputId,limitLength){
    var o=document.getElementById(inputId);
    var value=replaceBindInformation(o.value);
    left=limitLength-value.length;
    //left=limitLength-$('#'+inputId).val().length;
    //left=limitLength-$('input[name='+inputId+']').val().length;
    $('#length_'+inputId).html(left);
    if(left>=0){
        $('#length_'+inputId).css({'color':'green'});
    }else{
        $('#length_'+inputId).css({'color':'red'});
    }
}

//键盘监听，自动切换到下一行
document.onkeydown=function(event){
	var e = event || window.event || arguments.callee.caller.arguments[0];
	//Down Arrow监听
	if(e && e.keyCode==40){
		var obj=e.srcElement||e.target;
		var type=$(obj).parent().parent().next().get(0).tagName;
		if(type=='TR'){
			$(obj).blur();
			var inputname=$(obj).attr('name');
			var nexttr=$(obj).parent().parent().next();
			var nextinput=nexttr.find('input[name^='+inputname.substring(0,inputname.length-2)+']');
			nextinput.focus();
		}
	}
	//Up Arrow监听
	if(e && e.keyCode==38){
		var obj=e.srcElement;
		var type=$(obj).parent().parent().prev().prev().get(0).tagName;
		if(type=='TR'){
			$(obj).blur();
			var inputname=$(obj).attr('name');
			var prevtr=$(obj).parent().parent().prev();
			var previnput=prevtr.find('input[name^='+inputname.substring(0,inputname.length-2)+']');
			previnput.focus();
		}
	}
}

function Addimgurl_input(src)
{
  if (typeof(src) == 'undefined')
  {
    src = '';
  }
  var iiiids="";
  for(i=0;i<10;i++){
    iiiids=iiiids+Math.round(Math.random()*10);
  }
  var ress ='<input type="text" id="imgss__'+iiiids+'" size="77" onblur="imgurl_input_blur(this)" class="mainpic"   name="imgurl[]" value="'+src+'">';
  $('#div_imgurl_input').append("<div class='movebox'><img src='"+src+"' width='50' height='50'>"+ress+"<input type='button' value='删除此图片' onclick='javascript:$(this).parent().empty();return false;' ></div>");
})( jQuery );
