var menuOffX=0	//菜单距连接文字最左端距离
var menuOffY=18	//菜单距连接文字顶端距离
var fo_shadows=new Array()
var linkset=new Array()
var ie4=document.all&&navigator.userAgent.indexOf("Opera")==-1
var ns6=document.getElementById&&!document.all
var ns4=document.layers
function openScript(url, width, height){
	var Win = window.open(url,"openScript",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=no' );
}
function showmenu(e,vmenu,mod){
	if (!document.all&&!document.getElementById&&!document.layers)
		return
	which=vmenu
	clearhidemenu()
	ie_clearshadow()
	menuobj=ie4? document.all.popmenu : ns6? document.getElementById("popmenu") : ns4? document.popmenu : ""
	menuobj.thestyle=(ie4||ns6)? menuobj.style : menuobj
	
	if (ie4||ns6)
		menuobj.innerHTML=which
	else{
		menuobj.document.write('<layer name=gui bgColor=#E6E6E6 width=165 onmouseover="clearhidemenu()" onmouseout="hidemenu()">'+which+'</layer>')
		menuobj.document.close()
	}
	menuobj.contentwidth=(ie4||ns6)? menuobj.offsetWidth : menuobj.document.gui.document.width
	menuobj.contentheight=(ie4||ns6)? menuobj.offsetHeight : menuobj.document.gui.document.height
	
	eventX=ie4? event.clientX : ns6? e.clientX : e.x
	eventY=ie4? event.clientY : ns6? e.clientY : e.y
	
	var rightedge=ie4? document.body.clientWidth-eventX : window.innerWidth-eventX
	var bottomedge=ie4? document.body.clientHeight-eventY : window.innerHeight-eventY
		if (rightedge<menuobj.contentwidth)
			menuobj.thestyle.left=ie4? document.body.scrollLeft+eventX-menuobj.contentwidth+menuOffX : ns6? window.pageXOffset+eventX-menuobj.contentwidth : eventX-menuobj.contentwidth
		else
			menuobj.thestyle.left=(ie4? ie_x(event.srcElement)+menuOffX : ns6? window.pageXOffset+eventX : eventX)+'px'
		
		if (bottomedge<menuobj.contentheight&&mod!=0)
			menuobj.thestyle.top=ie4? document.body.scrollTop+eventY-menuobj.contentheight-event.offsetY+menuOffY-23 : ns6? window.pageYOffset+eventY-menuobj.contentheight-10 : eventY-menuobj.contentheight
		else
			menuobj.thestyle.top=ie4? ie_y(event.srcElement)+menuOffY : ns6? window.pageYOffset+eventY+10 : eventY
	menuobj.thestyle.visibility="visible"
	ie_dropshadow(menuobj,"#999999",3)
	return false
}

function ie_y(e){  
	var t=e.offsetTop;  
	while(e=e.offsetParent){  
		t+=e.offsetTop;  
	}  
	return t;  
}  
function ie_x(e){  
	var l=e.offsetLeft;  
	while(e=e.offsetParent){  
		l+=e.offsetLeft;  
	}  
	return l;  
}  
function ie_dropshadow(el, color, size)
{
	var i;
	for (i=size; i>0; i--)
	{
		var rect = document.createElement('div');
		var rs = rect.style
		rs.position = 'absolute';
		rs.left = (el.style.posLeft + i) + 'px';
		rs.top = (el.style.posTop + i) + 'px';
		rs.width = el.offsetWidth + 'px';
		rs.height = el.offsetHeight + 'px';
		rs.zIndex = el.style.zIndex - i;
		rs.backgroundColor = color;
		var opacity = 1 - i / (i + 1);
		rs.filter = 'alpha(opacity=' + (100 * opacity) + ')';
		fo_shadows[fo_shadows.length] = rect;
	}
}
function ie_clearshadow()
{
	for(var i=0;i<fo_shadows.length;i++)
	{
		if (fo_shadows[i])
			fo_shadows[i].style.display="none"
	}
	fo_shadows=new Array();
}


function contains_ns6(a, b) {
	while (b.parentNode)
		if ((b = b.parentNode) == a)
			return true;
	return false;
}

function hidemenu(){
	if (window.menuobj)
		menuobj.thestyle.visibility=(ie4||ns6)? "hidden" : "hide"
	ie_clearshadow()
}

function dynamichide(e){
	if (ie4&&!menuobj.contains(e.toElement))
		hidemenu()
	else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
		hidemenu()
}

function delayhidemenu(){
	if (ie4||ns6||ns4)
		delayhide=setTimeout("hidemenu()",500)
}

function clearhidemenu(){
	if (window.delayhide)
		clearTimeout(delayhide)
}

function highlightmenu(e,state){
	if (document.all)
		source_el=event.srcElement
	else if (document.getElementById)
		source_el=e.target
	if (source_el.className=="menuitems"){
		source_el.id=(state=="on")? "mouseoverstyle" : ""
	}
	else{
		while(source_el.id!="popmenu"){
			source_el=document.getElementById? source_el.parentNode : source_el.parentElement
			if (source_el.className=="menuitems"){
				source_el.id=(state=="on")? "mouseoverstyle" : ""
			}
		}
	}
}

if (ie4||ns6)
document.onclick=hidemenu
function doSClick() {
	var targetId, srcElement, targetElement, imageId, imageElement;
	srcElement = window.event.srcElement;
	targetId = srcElement.id + "content";
	targetElement = document.all(targetId);
	imageId = srcElement.id;
	imageId = imageId.charAt(0);
	imageElement = document.all(imageId);
	if (targetElement.style.display == "none") {

		targetElement.style.display = "";
	} else {
		targetElement.style.display = "none";
	}
}
function doClick() {
	var targetId, srcElement, targetElement;
	srcElement = window.event.srcElement;
	targetId = srcElement.id + "_content";
	targetElement = document.all(targetId);
	if (targetElement.style.display == "none") {
		targetElement.style.display = "";
	} else {
		targetElement.style.display = "none";
	}
}

//HTML过滤函数
function HTMLEncode(text)
{
	text = text.replace(/&/g, "&amp;") ;
	text = text.replace(/"/g, "&quot;") ;
	text = text.replace(/</g, "&lt;") ;
	text = text.replace(/>/g, "&gt;") ;
	text = text.replace(/'/g, "&#146;") ;

	return text ;
}
function bbimg(o){
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;
}
function Dvbbs_ViewCode(replyid)
{
	var bodyTag="<html><head><style type=text/css>.quote{margin:5px 20px;border:1px solid #CCCCCC;padding:5px; background:#F3F3F3 }\nbody{boder:0px}.HtmlCode{margin:5px 20px;border:1px solid #CCCCCC;padding:5px;background:#FDFDDF;font-size:14px;font-family:Tahoma;font-style : oblique;line-height : normal ;font-weight:bold;}\nbody{boder:0px}</style></head><BODY bgcolor=\"#FFFFFF\" >";
	bodyTag+=document.getElementById('scode'+replyid).CodeText.value
	bodyTag+="</body></html>"
	preWin=window.open('preview','','left=0,top=0,width=550,height=400,resizable=1,scrollbars=1, status=1, toolbar=1, menubar=0');
	preWin.document.open();
	preWin.document.write(bodyTag);
	preWin.document.close();
	//preWin.document.title="查看贴子内容";
	preWin.document.charset="UTF-8";
}
function overbg(tdbg){
tdbg.style.background='url(images/item_over.gif)'
tdbg.style.border=' #9CA6C6 1px solid'
}
function outbg(tdbg){
tdbg.style.background='url(.images/item_out.gif)'
tdbg.style.border=''
}
var sysmenu='<table width="80"><tr><td id="library" onMouseOver=overbg(library) onMouseOut=outbg(library)><a href="index.php?m=Home&c=Sysset&a=library&method=modify">图书馆信息</a></td></tr>\
<tr><td id="manager" onMouseOver=overbg(manager) onMouseOut=outbg(manager)><a href="index.php?m=Home&c=User&a=manager">管理员设置</a></td></tr>\
<tr><td id="para" onMouseOver=overbg(para) onMouseOut=outbg(para)><a href="index.php?m=Home&c=Sysset&a=parameter&method=modify">参数设置</a></td></tr>\
<tr><td id="booktype" onMouseOver=overbg(booktype) onMouseOut=outbg(booktype)><a href="index.php?m=Home&c=Sysset&a=booktype">图书类型设置</a></td></tr>\
<tr><td id="publishing" onMouseOver=overbg(publishing) onMouseOut=outbg(publishing)><a href="index.php?m=Home&c=Sysset&a=publishing">出版社设置</a></td></tr>\
<tr><td id="bookcase" onMouseOver=overbg(bookcase) onMouseOut=outbg(bookcase)><a href="index.php?m=Home&c=Sysset&a=bookcase">书架设置</a></td></tr></table>'

var readermenu='<table width="90"><tr><td id=readerType onMouseOver=overbg(readerType) onMouseOut=outbg(readerType)><a href="index.php?m=Home&c=Reader&a=rtype">读者类型管理</a></td></tr>\
<tr><td id=reader onMouseOver=overbg(reader) onMouseOut=outbg(reader)><a href="index.php?m=Home&c=Reader&a=index">读者档案管理</a></td></tr></table>'

var borrowmenu='<table width="60"><tr><td id=Borrow onMouseOver=overbg(Borrow) onMouseOut=outbg(Borrow)><a href="index.php?m=Home&c=Bbb&a=borrow">图书借阅</a></td></tr>\
<tr><td id=renew onMouseOver=overbg(renew) onMouseOut=outbg(renew)><a href="index.php?m=Home&c=Bbb&a=renew">图书续借</a></td></tr>\
<tr><td id=giveback onMouseOver=overbg(giveback) onMouseOut=outbg(giveback)><a href="index.php?m=Home&c=Bbb&a=bookback">图书归还</a></td></tr></table>'

var querymenu='<table width="90"><tr><td id="bookQuery" onMouseOver=overbg(bookQuery) onMouseOut=outbg(bookQuery)><a href="index.php?m=Home&c=Query&a=book">图书档案查询</a></td></tr>\
<tr><td id="borrowQuery" onMouseOver=overbg(borrowQuery) onMouseOut=outbg(borrowQuery)><a href="index.php?m=Home&c=Query&a=borrow">图书借阅查询</a></td></tr>\
<tr><td id="givebackQuery" onMouseOver=overbg(givebackQuery) onMouseOut=outbg(givebackQuery)><a href="index.php?m=Home&c=Query&a=bremind">借阅到期提醒</a></td></tr></table>'
