var config=new Object();var tt_Debug=true
var tt_Enabled=true
var TagsToTip=true
config.Above=false
config.BgColor='#3C3C3C'
config.BgImg=''
config.BorderColor='#FF0000'
config.BorderStyle='solid'
config.BorderWidth=1
config.CenterMouse=false
config.ClickClose=false
config.ClickSticky=false
config.CloseBtn=false
config.CloseBtnColors=['#990000','#FFFFFF','#DD3333','#FFFFFF']
config.CloseBtnText='&nbsp;X&nbsp;'
config.CopyContent=true
config.Delay=400
config.Duration=0
config.FadeIn=300
config.FadeOut=300
config.FadeInterval=30
config.Fix=null
config.FollowMouse=true
config.FontColor='#000044'
config.FontFace='Verdana,Geneva,sans-serif'
config.FontSize='8pt'
config.FontWeight='normal'
config.Height=0
config.JumpHorz=false
config.JumpVert=true
config.Left=false
config.OffsetX=14
config.OffsetY=8
config.Opacity=100
config.Padding=3
config.Shadow=false
config.ShadowColor='#C0C0C0'
config.ShadowWidth=5
config.Sticky=false
config.TextAlign='left'
config.Title=''
config.TitleAlign='left'
config.TitleBgColor=''
config.TitleFontColor='#FFFFFF'
config.TitleFontFace=''
config.TitleFontSize=''
config.TitlePadding=2
config.Width=0
function Tip()
{tt_Tip(arguments,null);}
function TagToTip()
{var t2t=tt_GetElt(arguments[0]);if(t2t)
tt_Tip(arguments,t2t);}
function UnTip()
{tt_OpReHref();if(tt_aV[DURATION]<0&&(tt_iState&0x2))
tt_tDurt.Timer("tt_HideInit()",-tt_aV[DURATION],true);else if(!(tt_aV[STICKY]&&(tt_iState&0x2)))
tt_HideInit();}
var tt_aElt=new Array(10),tt_aV=new Array(),tt_sContent,tt_scrlX=0,tt_scrlY=0,tt_musX,tt_musY,tt_over,tt_x,tt_y,tt_w,tt_h;function tt_Extension()
{tt_ExtCmdEnum();tt_aExt[tt_aExt.length]=this;return this;}
function tt_SetTipPos(x,y)
{var css=tt_aElt[0].style;tt_x=x;tt_y=y;css.left=x+"px";css.top=y+"px";if(tt_ie56)
{var ifrm=tt_aElt[tt_aElt.length-1];if(ifrm)
{ifrm.style.left=css.left;ifrm.style.top=css.top;}}}
function tt_HideInit()
{if(tt_iState)
{tt_ExtCallFncs(0,"HideInit");tt_iState&=~0x4;if(tt_flagOpa&&tt_aV[FADEOUT])
{tt_tFade.EndTimer();if(tt_opa)
{var n=Math.round(tt_aV[FADEOUT]/(tt_aV[FADEINTERVAL]*(tt_aV[OPACITY]/tt_opa)));tt_Fade(tt_opa,tt_opa,0,n);return;}}
tt_tHide.Timer("tt_Hide();",1,false);}}
function tt_Hide()
{if(tt_db&&tt_iState)
{tt_OpReHref();if(tt_iState&0x2)
{tt_aElt[0].style.visibility="hidden";tt_ExtCallFncs(0,"Hide");}
tt_tShow.EndTimer();tt_tHide.EndTimer();tt_tDurt.EndTimer();tt_tFade.EndTimer();if(!tt_op&&!tt_ie)
{tt_tWaitMov.EndTimer();tt_bWait=false;}
if(tt_aV[CLICKCLOSE]||tt_aV[CLICKSTICKY])
tt_RemEvtFnc(document,"mouseup",tt_OnLClick);tt_ExtCallFncs(0,"Kill");if(tt_t2t&&!tt_aV[COPYCONTENT])
{tt_t2t.style.display="none";tt_MovDomNode(tt_t2t,tt_aElt[6],tt_t2tDad);}
tt_iState=0;tt_over=null;tt_ResetMainDiv();if(tt_aElt[tt_aElt.length-1])
tt_aElt[tt_aElt.length-1].style.display="none";}}
function tt_GetElt(id)
{return(document.getElementById?document.getElementById(id):document.all?document.all[id]:null);}
function tt_GetDivW(el)
{return(el?(el.offsetWidth||el.style.pixelWidth||0):0);}
function tt_GetDivH(el)
{return(el?(el.offsetHeight||el.style.pixelHeight||0):0);}
function tt_GetScrollX()
{return(window.pageXOffset||(tt_db?(tt_db.scrollLeft||0):0));}
function tt_GetScrollY()
{return(window.pageYOffset||(tt_db?(tt_db.scrollTop||0):0));}
function tt_GetClientW()
{return(document.body&&(typeof(document.body.clientWidth)!=tt_u)?document.body.clientWidth:(typeof(window.innerWidth)!=tt_u)?window.innerWidth:tt_db?(tt_db.clientWidth||0):0);}
function tt_GetClientH()
{return(document.body&&(typeof(document.body.clientHeight)!=tt_u)?document.body.clientHeight:(typeof(window.innerHeight)!=tt_u)?window.innerHeight:tt_db?(tt_db.clientHeight||0):0);}
function tt_GetEvtX(e)
{return(e?((typeof(e.pageX)!=tt_u)?e.pageX:(e.clientX+tt_scrlX)):0);}
function tt_GetEvtY(e)
{return(e?((typeof(e.pageY)!=tt_u)?e.pageY:(e.clientY+tt_scrlY)):0);}
function tt_AddEvtFnc(el,sEvt,PFnc)
{if(el)
{if(el.addEventListener)
el.addEventListener(sEvt,PFnc,false);else
el.attachEvent("on"+sEvt,PFnc);}}
function tt_RemEvtFnc(el,sEvt,PFnc)
{if(el)
{if(el.removeEventListener)
el.removeEventListener(sEvt,PFnc,false);else
el.detachEvent("on"+sEvt,PFnc);}}
var tt_aExt=new Array(),tt_db,tt_op,tt_ie,tt_ie56,tt_bBoxOld,tt_body,tt_ovr_,tt_flagOpa,tt_maxPosX,tt_maxPosY,tt_iState=0,tt_opa,tt_bJmpVert,tt_bJmpHorz,tt_t2t,tt_t2tDad,tt_elDeHref,tt_tShow=new Number(0),tt_tHide=new Number(0),tt_tDurt=new Number(0),tt_tFade=new Number(0),tt_tWaitMov=new Number(0),tt_bWait=false,tt_u="undefined";function tt_Init()
{tt_MkCmdEnum();if(!tt_Browser()||!tt_MkMainDiv())
return;tt_IsW3cBox();tt_OpaSupport();tt_AddEvtFnc(window,"scroll",tt_OnScrl);tt_AddEvtFnc(window,"resize",tt_OnScrl);tt_AddEvtFnc(document,"mousemove",tt_Move);if(TagsToTip||tt_Debug)
tt_SetOnloadFnc();tt_AddEvtFnc(window,"unload",tt_Hide);}
function tt_MkCmdEnum()
{var n=0;for(var i in config)
eval("window."+i.toString().toUpperCase()+" = "+n++);tt_aV.length=n;}
function tt_Browser()
{var n,nv,n6,w3c;n=navigator.userAgent.toLowerCase(),nv=navigator.appVersion;tt_op=(document.defaultView&&typeof(eval("w"+"indow"+"."+"o"+"p"+"er"+"a"))!=tt_u);tt_ie=n.indexOf("msie")!=-1&&document.all&&!tt_op;if(tt_ie)
{var ieOld=(!document.compatMode||document.compatMode=="BackCompat");tt_db=!ieOld?document.documentElement:(document.body||null);if(tt_db)
tt_ie56=parseFloat(nv.substring(nv.indexOf("MSIE")+5))>=5.5&&typeof document.body.style.maxHeight==tt_u;}
else
{tt_db=document.documentElement||document.body||(document.getElementsByTagName?document.getElementsByTagName("body")[0]:null);if(!tt_op)
{n6=document.defaultView&&typeof document.defaultView.getComputedStyle!=tt_u;w3c=!n6&&document.getElementById;}}
tt_body=(document.getElementsByTagName?document.getElementsByTagName("body")[0]:(document.body||null));if(tt_ie||n6||tt_op||w3c)
{if(tt_body&&tt_db)
{if(document.attachEvent||document.addEventListener)
return true;}
else
tt_Err("wz_tooltip.js must be included INSIDE the body section,"
+" immediately after the opening <body> tag.",false);}
tt_db=null;return false;}
function tt_MkMainDiv()
{if(tt_body.insertAdjacentHTML)
tt_body.insertAdjacentHTML("afterBegin",tt_MkMainDivHtm());else if(typeof tt_body.innerHTML!=tt_u&&document.createElement&&tt_body.appendChild)
tt_body.appendChild(tt_MkMainDivDom());if(window.tt_GetMainDivRefs&&tt_GetMainDivRefs())
return true;tt_db=null;return false;}
function tt_MkMainDivHtm()
{return('<div id="WzTtDiV"></div>'+
(tt_ie56?('<iframe id="WzTtIfRm" src="javascript:false" scrolling="no" frameborder="0" style="filter:Alpha(opacity=0);position:absolute;top:0px;left:0px;display:none;"></iframe>'):''));}
function tt_MkMainDivDom()
{var el=document.createElement("div");if(el)
el.id="WzTtDiV";return el;}
function tt_GetMainDivRefs()
{tt_aElt[0]=tt_GetElt("WzTtDiV");if(tt_ie56&&tt_aElt[0])
{tt_aElt[tt_aElt.length-1]=tt_GetElt("WzTtIfRm");if(!tt_aElt[tt_aElt.length-1])
tt_aElt[0]=null;}
if(tt_aElt[0])
{var css=tt_aElt[0].style;css.visibility="hidden";css.position="absolute";css.overflow="hidden";return true;}
return false;}
function tt_ResetMainDiv()
{var w=(window.screen&&screen.width)?screen.width:10000;tt_SetTipPos(-w,0);tt_aElt[0].innerHTML="";tt_aElt[0].style.width=(w-1)+"px";tt_h=0;}
function tt_IsW3cBox()
{var css=tt_aElt[0].style;css.padding="10px";css.width="40px";tt_bBoxOld=(tt_GetDivW(tt_aElt[0])==40);css.padding="0px";tt_ResetMainDiv();}
function tt_OpaSupport()
{var css=tt_body.style;tt_flagOpa=(typeof(css.filter)!=tt_u)?1:(typeof(css.KhtmlOpacity)!=tt_u)?2:(typeof(css.KHTMLOpacity)!=tt_u)?3:(typeof(css.MozOpacity)!=tt_u)?4:(typeof(css.opacity)!=tt_u)?5:0;}
function tt_SetOnloadFnc()
{tt_AddEvtFnc(document,"DOMContentLoaded",tt_HideSrcTags);tt_AddEvtFnc(window,"load",tt_HideSrcTags);if(tt_body.attachEvent)
tt_body.attachEvent("onreadystatechange",function(){if(tt_body.readyState=="complete")
tt_HideSrcTags();});if(/WebKit|KHTML/i.test(navigator.userAgent))
{var t=setInterval(function(){if(/loaded|complete/.test(document.readyState))
{clearInterval(t);tt_HideSrcTags();}},10);}}
function tt_HideSrcTags()
{if(!window.tt_HideSrcTags||window.tt_HideSrcTags.done)
return;window.tt_HideSrcTags.done=true;if(!tt_HideSrcTagsRecurs(tt_body))
tt_Err("There are HTML elements to be converted to tooltips.\nIf you"
+" want these HTML elements to be automatically hidden, you"
+" must edit wz_tooltip.js, and set TagsToTip in the global"
+" tooltip configuration to true.",true);}
function tt_HideSrcTagsRecurs(dad)
{var ovr,asT2t;var a=dad.childNodes||dad.children||null;for(var i=a?a.length:0;i;)
{--i;if(!tt_HideSrcTagsRecurs(a[i]))
return false;ovr=a[i].getAttribute?(a[i].getAttribute("onmouseover")||a[i].getAttribute("onclick")):(typeof a[i].onmouseover=="function")?(a[i].onmouseover||a[i].onclick):null;if(ovr)
{asT2t=ovr.toString().match(/TagToTip\s*\(\s*'[^'.]+'\s*[\),]/);if(asT2t&&asT2t.length)
{if(!tt_HideSrcTag(asT2t[0]))
return false;}}}
return true;}
function tt_HideSrcTag(sT2t)
{var id,el;id=sT2t.replace(/.+'([^'.]+)'.+/,"$1");el=tt_GetElt(id);if(el)
{if(tt_Debug&&!TagsToTip)
return false;else
el.style.display="none";}
else
tt_Err("Invalid ID\n'"+id+"'\npassed to TagToTip()."
+" There exists no HTML element with that ID.",true);return true;}
function tt_Tip(arg,t2t)
{if(!tt_db)
return;if(tt_iState)
tt_Hide();if(!tt_Enabled)
return;tt_t2t=t2t;if(!tt_ReadCmds(arg))
return;tt_iState=0x1|0x4;tt_AdaptConfig1();tt_MkTipContent(arg);tt_MkTipSubDivs();tt_FormatTip();tt_bJmpVert=false;tt_bJmpHorz=false;tt_maxPosX=tt_GetClientW()+tt_scrlX-tt_w-1;tt_maxPosY=tt_GetClientH()+tt_scrlY-tt_h-1;tt_AdaptConfig2();tt_OverInit();tt_ShowInit();tt_Move();}
function tt_ReadCmds(a)
{var i;i=0;for(var j in config)
tt_aV[i++]=config[j];if(a.length&1)
{for(i=a.length-1;i>0;i-=2)
tt_aV[a[i-1]]=a[i];return true;}
tt_Err("Incorrect call of Tip() or TagToTip().\n"
+"Each command must be followed by a value.",true);return false;}
function tt_AdaptConfig1()
{tt_ExtCallFncs(0,"LoadConfig");if(!tt_aV[TITLEBGCOLOR].length)
tt_aV[TITLEBGCOLOR]=tt_aV[BORDERCOLOR];if(!tt_aV[TITLEFONTCOLOR].length)
tt_aV[TITLEFONTCOLOR]=tt_aV[BGCOLOR];if(!tt_aV[TITLEFONTFACE].length)
tt_aV[TITLEFONTFACE]=tt_aV[FONTFACE];if(!tt_aV[TITLEFONTSIZE].length)
tt_aV[TITLEFONTSIZE]=tt_aV[FONTSIZE];if(tt_aV[CLOSEBTN])
{if(!tt_aV[CLOSEBTNCOLORS])
tt_aV[CLOSEBTNCOLORS]=new Array("","","","");for(var i=4;i;)
{--i;if(!tt_aV[CLOSEBTNCOLORS][i].length)
tt_aV[CLOSEBTNCOLORS][i]=(i&1)?tt_aV[TITLEFONTCOLOR]:tt_aV[TITLEBGCOLOR];}
if(!tt_aV[TITLE].length)
tt_aV[TITLE]=" ";}
if(tt_aV[OPACITY]==100&&typeof tt_aElt[0].style.MozOpacity!=tt_u&&!Array.every)
tt_aV[OPACITY]=99;if(tt_aV[FADEIN]&&tt_flagOpa&&tt_aV[DELAY]>100)
tt_aV[DELAY]=Math.max(tt_aV[DELAY]-tt_aV[FADEIN],100);}
function tt_AdaptConfig2()
{if(tt_aV[CENTERMOUSE])
{tt_aV[OFFSETX]-=((tt_w-(tt_aV[SHADOW]?tt_aV[SHADOWWIDTH]:0))>>1);tt_aV[JUMPHORZ]=false;}}
function tt_MkTipContent(a)
{if(tt_t2t)
{if(tt_aV[COPYCONTENT])
tt_sContent=tt_t2t.innerHTML;else
tt_sContent="";}
else
tt_sContent=a[0];tt_ExtCallFncs(0,"CreateContentString");}
function tt_MkTipSubDivs()
{var sCss='position:relative;margin:0px;padding:0px;border-width:0px;left:0px;top:0px;line-height:normal;width:auto;',sTbTrTd=' cellspacing="0" cellpadding="0" border="0" style="'+sCss+'"><tbody style="'+sCss+'"><tr><td ';tt_aElt[0].innerHTML=(''
+(tt_aV[TITLE].length?('<div id="WzTiTl" style="position:relative;z-index:1;">'
+'<table id="WzTiTlTb"'+sTbTrTd+'id="WzTiTlI" style="'+sCss+'">'
+tt_aV[TITLE]
+'</td>'
+(tt_aV[CLOSEBTN]?('<td align="right" style="'+sCss
+'text-align:right;">'
+'<span id="WzClOsE" style="position:relative;left:2px;padding-left:2px;padding-right:2px;'
+'cursor:'+(tt_ie?'hand':'pointer')
+';" onmouseover="tt_OnCloseBtnOver(1)" onmouseout="tt_OnCloseBtnOver(0)" onclick="tt_HideInit()">'
+tt_aV[CLOSEBTNTEXT]
+'</span></td>'):'')
+'</tr></tbody></table></div>'):'')
+'<div id="WzBoDy" style="position:relative;z-index:0;">'
+'<table'+sTbTrTd+'id="WzBoDyI" style="'+sCss+'">'
+tt_sContent
+'</td></tr></tbody></table></div>'
+(tt_aV[SHADOW]?('<div id="WzTtShDwR" style="position:absolute;overflow:hidden;"></div>'
+'<div id="WzTtShDwB" style="position:relative;overflow:hidden;"></div>'):''));tt_GetSubDivRefs();if(tt_t2t&&!tt_aV[COPYCONTENT])
{tt_t2tDad=tt_t2t.parentNode||tt_t2t.parentElement||tt_t2t.offsetParent||null;if(tt_t2tDad)
{tt_MovDomNode(tt_t2t,tt_t2tDad,tt_aElt[6]);tt_t2t.style.display="block";}}
tt_ExtCallFncs(0,"SubDivsCreated");}
function tt_GetSubDivRefs()
{var aId=new Array("WzTiTl","WzTiTlTb","WzTiTlI","WzClOsE","WzBoDy","WzBoDyI","WzTtShDwB","WzTtShDwR");for(var i=aId.length;i;--i)
tt_aElt[i]=tt_GetElt(aId[i-1]);}
function tt_FormatTip()
{var css,w,h,pad=tt_aV[PADDING],padT,wBrd=tt_aV[BORDERWIDTH],iOffY,iOffSh,iAdd=(pad+wBrd)<<1;if(tt_aV[TITLE].length)
{padT=tt_aV[TITLEPADDING];css=tt_aElt[1].style;css.background=tt_aV[TITLEBGCOLOR];css.paddingTop=css.paddingBottom=padT+"px";css.paddingLeft=css.paddingRight=(padT+2)+"px";css=tt_aElt[3].style;css.color=tt_aV[TITLEFONTCOLOR];if(tt_aV[WIDTH]==-1)
css.whiteSpace="nowrap";css.fontFamily=tt_aV[TITLEFONTFACE];css.fontSize=tt_aV[TITLEFONTSIZE];css.fontWeight="bold";css.textAlign=tt_aV[TITLEALIGN];if(tt_aElt[4])
{css=tt_aElt[4].style;css.background=tt_aV[CLOSEBTNCOLORS][0];css.color=tt_aV[CLOSEBTNCOLORS][1];css.fontFamily=tt_aV[TITLEFONTFACE];css.fontSize=tt_aV[TITLEFONTSIZE];css.fontWeight="bold";}
if(tt_aV[WIDTH]>0)
tt_w=tt_aV[WIDTH];else
{tt_w=tt_GetDivW(tt_aElt[3])+tt_GetDivW(tt_aElt[4]);if(tt_aElt[4])
tt_w+=pad;if(tt_aV[WIDTH]<-1&&tt_w>-tt_aV[WIDTH])
tt_w=-tt_aV[WIDTH];}
iOffY=-wBrd;}
else
{tt_w=0;iOffY=0;}
if($(tt_aElt[5]))$(tt_aElt[5]).addClassName('Rounded');css=tt_aElt[5].style;css.top=iOffY+"px";if(wBrd)
{css.borderColor=tt_aV[BORDERCOLOR];css.borderStyle=tt_aV[BORDERSTYLE];css.borderWidth=wBrd+"px";}
if(tt_aV[BGCOLOR].length)
css.background=tt_aV[BGCOLOR];if(tt_aV[BGIMG].length)
css.backgroundImage="url("+tt_aV[BGIMG]+")";css.padding=pad+"px";css.textAlign=tt_aV[TEXTALIGN];if(tt_aV[HEIGHT])
{css.overflow="auto";if(tt_aV[HEIGHT]>0)
css.height=(tt_aV[HEIGHT]+iAdd)+"px";else
tt_h=iAdd-tt_aV[HEIGHT];}
css=tt_aElt[6].style;css.color=tt_aV[FONTCOLOR];css.fontFamily=tt_aV[FONTFACE];css.fontSize=tt_aV[FONTSIZE];css.fontWeight=tt_aV[FONTWEIGHT];css.background="";css.textAlign=tt_aV[TEXTALIGN];if(tt_aV[WIDTH]>0)
w=tt_aV[WIDTH];else if(tt_aV[WIDTH]==-1&&tt_w)
w=tt_w;else
{w=tt_GetDivW(tt_aElt[6]);if(tt_aV[WIDTH]<-1&&w>-tt_aV[WIDTH])
w=-tt_aV[WIDTH];}
if(w>tt_w)
tt_w=w;tt_w+=iAdd;if(tt_aV[SHADOW])
{tt_w+=tt_aV[SHADOWWIDTH];iOffSh=Math.floor((tt_aV[SHADOWWIDTH]*4)/3);css=tt_aElt[7].style;css.top=iOffY+"px";css.left=iOffSh+"px";css.width=(tt_w-iOffSh-tt_aV[SHADOWWIDTH])+"px";css.height=tt_aV[SHADOWWIDTH]+"px";css.background=tt_aV[SHADOWCOLOR];css=tt_aElt[8].style;css.top=iOffSh+"px";css.left=(tt_w-tt_aV[SHADOWWIDTH])+"px";css.width=tt_aV[SHADOWWIDTH]+"px";css.background=tt_aV[SHADOWCOLOR];}
else
iOffSh=0;tt_SetTipOpa(tt_aV[FADEIN]?0:tt_aV[OPACITY]);tt_FixSize(iOffY,iOffSh);}
function tt_FixSize(iOffY,iOffSh)
{var wIn,wOut,h,add,pad=tt_aV[PADDING],wBrd=tt_aV[BORDERWIDTH],i;tt_aElt[0].style.width=tt_w+"px";tt_aElt[0].style.pixelWidth=tt_w;wOut=tt_w-((tt_aV[SHADOW])?tt_aV[SHADOWWIDTH]:0);wIn=wOut;if(!tt_bBoxOld)
wIn-=(pad+wBrd)<<1;tt_aElt[5].style.width=wIn+"px";if(tt_aElt[1])
{wIn=wOut-((tt_aV[TITLEPADDING]+2)<<1);if(!tt_bBoxOld)
wOut=wIn;tt_aElt[1].style.width=wOut+"px";tt_aElt[2].style.width=wIn+"px";}
if(tt_h)
{h=tt_GetDivH(tt_aElt[5]);if(h>tt_h)
{if(!tt_bBoxOld)
tt_h-=(pad+wBrd)<<1;tt_aElt[5].style.height=tt_h+"px";}}
tt_h=tt_GetDivH(tt_aElt[0])+iOffY;if(tt_aElt[8])
tt_aElt[8].style.height=(tt_h-iOffSh)+"px";i=tt_aElt.length-1;if(tt_aElt[i])
{tt_aElt[i].style.width=tt_w+"px";tt_aElt[i].style.height=tt_h+"px";}}
function tt_DeAlt(el)
{var aKid;if(el)
{if(el.alt)
el.alt="";if(el.title)
el.title="";aKid=el.childNodes||el.children||null;if(aKid)
{for(var i=aKid.length;i;)
tt_DeAlt(aKid[--i]);}}}
function tt_OpDeHref(el)
{if(!tt_op)
return;if(tt_elDeHref)
tt_OpReHref();while(el)
{if(el.hasAttribute("href"))
{el.t_href=el.getAttribute("href");el.t_stats=window.status;el.removeAttribute("href");el.style.cursor="hand";tt_AddEvtFnc(el,"mousedown",tt_OpReHref);window.status=el.t_href;tt_elDeHref=el;break;}
el=el.parentElement;}}
function tt_OpReHref()
{if(tt_elDeHref)
{tt_elDeHref.setAttribute("href",tt_elDeHref.t_href);tt_RemEvtFnc(tt_elDeHref,"mousedown",tt_OpReHref);window.status=tt_elDeHref.t_stats;tt_elDeHref=null;}}
function tt_OverInit()
{if(window.event)
tt_over=window.event.target||window.event.srcElement;else
tt_over=tt_ovr_;tt_DeAlt(tt_over);tt_OpDeHref(tt_over);}
function tt_ShowInit()
{tt_tShow.Timer("tt_Show()",tt_aV[DELAY],true);if(tt_aV[CLICKCLOSE]||tt_aV[CLICKSTICKY])
tt_AddEvtFnc(document,"mouseup",tt_OnLClick);}
function tt_Show()
{var css=tt_aElt[0].style;css.zIndex=Math.max((window.dd&&dd.z)?(dd.z+2):0,1010);if(tt_aV[STICKY]||!tt_aV[FOLLOWMOUSE])
tt_iState&=~0x4;if(tt_aV[DURATION]>0)
tt_tDurt.Timer("tt_HideInit()",tt_aV[DURATION],true);tt_ExtCallFncs(0,"Show")
css.visibility="visible";tt_iState|=0x2;if(tt_aV[FADEIN])
tt_Fade(0,0,tt_aV[OPACITY],Math.round(tt_aV[FADEIN]/tt_aV[FADEINTERVAL]));tt_ShowIfrm();}
function tt_ShowIfrm()
{if(tt_ie56)
{var ifrm=tt_aElt[tt_aElt.length-1];if(ifrm)
{var css=ifrm.style;css.zIndex=tt_aElt[0].style.zIndex-1;css.display="block";}}}
function tt_Move(e)
{if(e)
tt_ovr_=e.target||e.srcElement;e=e||window.event;if(e)
{tt_musX=tt_GetEvtX(e);tt_musY=tt_GetEvtY(e);}
if(tt_iState&0x04)
{if(!tt_op&&!tt_ie)
{if(tt_bWait)
return;tt_bWait=true;tt_tWaitMov.Timer("tt_bWait = false;",1,true);}
if(tt_aV[FIX])
{var iY=tt_aV[FIX][1];if(tt_aV[ABOVE])
iY-=tt_h;tt_iState&=~0x4;tt_SetTipPos(tt_aV[FIX][0],tt_aV[FIX][1]);}
else if(!tt_ExtCallFncs(e,"MoveBefore"))
tt_SetTipPos(tt_Pos(0),tt_Pos(1));tt_ExtCallFncs([tt_musX,tt_musY],"MoveAfter")}}
function tt_Pos(iDim)
{var iX,bJmpMode,cmdAlt,cmdOff,cx,iMax,iScrl,iMus,bJmp;if(iDim)
{bJmpMode=tt_aV[JUMPVERT];cmdAlt=ABOVE;cmdOff=OFFSETY;cx=tt_h;iMax=tt_maxPosY;iScrl=tt_scrlY;iMus=tt_musY;bJmp=tt_bJmpVert;}
else
{bJmpMode=tt_aV[JUMPHORZ];cmdAlt=LEFT;cmdOff=OFFSETX;cx=tt_w;iMax=tt_maxPosX;iScrl=tt_scrlX;iMus=tt_musX;bJmp=tt_bJmpHorz;}
if(bJmpMode)
{if(tt_aV[cmdAlt]&&(!bJmp||tt_CalcPosAlt(iDim)>=iScrl+16))
iX=tt_PosAlt(iDim);else if(!tt_aV[cmdAlt]&&bJmp&&tt_CalcPosDef(iDim)>iMax-16)
iX=tt_PosAlt(iDim);else
iX=tt_PosDef(iDim);}
else
{iX=iMus;if(tt_aV[cmdAlt])
iX-=cx+tt_aV[cmdOff]-(tt_aV[SHADOW]?tt_aV[SHADOWWIDTH]:0);else
iX+=tt_aV[cmdOff];}
if(iX>iMax)
iX=bJmpMode?tt_PosAlt(iDim):iMax;if(iX<iScrl)
iX=bJmpMode?tt_PosDef(iDim):iScrl;return iX;}
function tt_PosDef(iDim)
{if(iDim)
tt_bJmpVert=tt_aV[ABOVE];else
tt_bJmpHorz=tt_aV[LEFT];return tt_CalcPosDef(iDim);}
function tt_PosAlt(iDim)
{if(iDim)
tt_bJmpVert=!tt_aV[ABOVE];else
tt_bJmpHorz=!tt_aV[LEFT];return tt_CalcPosAlt(iDim);}
function tt_CalcPosDef(iDim)
{return iDim?(tt_musY+tt_aV[OFFSETY]):(tt_musX+tt_aV[OFFSETX]);}
function tt_CalcPosAlt(iDim)
{var cmdOff=iDim?OFFSETY:OFFSETX;var dx=tt_aV[cmdOff]-(tt_aV[SHADOW]?tt_aV[SHADOWWIDTH]:0);if(tt_aV[cmdOff]>0&&dx<=0)
dx=1;return((iDim?(tt_musY-tt_h):(tt_musX-tt_w))-dx);}
function tt_Fade(a,now,z,n)
{if(n)
{now+=Math.round((z-now)/n);if((z>a)?(now>=z):(now<=z))
now=z;else
tt_tFade.Timer("tt_Fade("
+a+","+now+","+z+","+(n-1)
+")",tt_aV[FADEINTERVAL],true);}
now?tt_SetTipOpa(now):tt_Hide();}
function tt_SetTipOpa(opa)
{tt_SetOpa(tt_aElt[5],opa);if(tt_aElt[1])
tt_SetOpa(tt_aElt[1],opa);if(tt_aV[SHADOW])
{opa=Math.round(opa*0.8);tt_SetOpa(tt_aElt[7],opa);tt_SetOpa(tt_aElt[8],opa);}}
function tt_OnScrl()
{tt_scrlX=tt_GetScrollX();tt_scrlY=tt_GetScrollY();}
function tt_OnCloseBtnOver(iOver)
{var css=tt_aElt[4].style;iOver<<=1;css.background=tt_aV[CLOSEBTNCOLORS][iOver];css.color=tt_aV[CLOSEBTNCOLORS][iOver+1];}
function tt_OnLClick(e)
{e=e||window.event;if(!((e.button&&e.button&2)||(e.which&&e.which==3)))
{if(tt_aV[CLICKSTICKY]&&(tt_iState&0x4))
{tt_aV[STICKY]=true;tt_iState&=~0x4;}
else if(tt_aV[CLICKCLOSE])
tt_HideInit();}}
function tt_Int(x)
{var y;return(isNaN(y=parseInt(x))?0:y);}
Number.prototype.Timer=function(s,iT,bUrge)
{if(!this.value||bUrge)
this.value=window.setTimeout(s,iT);}
Number.prototype.EndTimer=function()
{if(this.value)
{window.clearTimeout(this.value);this.value=0;}}
function tt_SetOpa(el,opa)
{var css=el.style;tt_opa=opa;if(tt_flagOpa==1)
{if(opa<100)
{if(typeof(el.filtNo)==tt_u)
el.filtNo=css.filter;var bVis=css.visibility!="hidden";css.zoom="100%";if(!bVis)
css.visibility="visible";css.filter="alpha(opacity="+opa+")";if(!bVis)
css.visibility="hidden";}
else if(typeof(el.filtNo)!=tt_u)
css.filter=el.filtNo;}
else
{opa/=100.0;switch(tt_flagOpa)
{case 2:css.KhtmlOpacity=opa;break;case 3:css.KHTMLOpacity=opa;break;case 4:css.MozOpacity=opa;break;case 5:css.opacity=opa;break;}}}
function tt_MovDomNode(el,dadFrom,dadTo)
{if(dadFrom)
dadFrom.removeChild(el);if(dadTo)
dadTo.appendChild(el);}
function tt_Err(sErr,bIfDebug)
{if(tt_Debug||!bIfDebug)
alert("Tooltip Script Error Message:\n\n"+sErr);}
function tt_ExtCmdEnum()
{var s;for(var i in config)
{s="window."+i.toString().toUpperCase();if(eval("typeof("+s+") == tt_u"))
{eval(s+" = "+tt_aV.length);tt_aV[tt_aV.length]=null;}}}
function tt_ExtCallFncs(arg,sFnc)
{var b=false;for(var i=tt_aExt.length;i;)
{--i;var fnc=tt_aExt[i]["On"+sFnc];if(fnc&&fnc(arg))
b=true;}
return b;}
tt_Init();;function replaceCheckbox(){var staticRoot='http://static2.4pl.4players.de/dist/htdocs/images/themes/playnow/';var c=0;$$('.checkbox_img').each(function(e){$(e).remove();});$$('input[type=checkbox]').each(function(e)
{e.style.display='none';var img=document.createElement('img');img.id=e.name+'Img';img.className='checkbox_img';if(e.disabled==false)
{img.src=staticRoot+(e.checked?'checkbox_checked.png':'checkbox_unchecked.png');}
else
{img.src=staticRoot+(e.checked?'checkbox_checked_disabled.png':'checkbox_unchecked_disabled.png');}
if(e.disabled==false)
{img.onclick=function()
{e.checked=(e.checked?false:true);this.src=staticRoot+(e.checked?'checkbox_checked.png':'checkbox_unchecked.png');if(e.onchange)
{e.onchange();}};img.onmouseover=function(){this.src=staticRoot+(e.checked?'checkbox_checked.png':'checkbox_highlight.png');};img.onmouseout=function(){this.src=staticRoot+(e.checked?'checkbox_checked.png':'checkbox_unchecked.png');};}
e.parentNode.insertBefore(img,e);c++;});}
function replaceSelect(){var s=0;$$('.SelectDivs').each(function(e){$(e).remove();});Event.observe($('Body'),'mousedown',function(){mouseUpFunc=closeSelect;});Event.observe($('Body'),'mouseup',function(){if($(openedSelect))
{selectTimeout=window.setTimeout(mouseUpFunc,10);}});$$('Select').each(function(e){var f=$(e);f.style.display='none';var optionsDiv=document.createElement('div');optionsDiv.id='OptionsDiv'+s;optionsDiv.className='OptionsDivs';optionsDiv.style.display='none';optionsDiv.style.width=f.style.width;optionsDiv.style.minWidth=f.style.minWidth;optionsDiv.onscroll=function(){mouseUpFunc=null;};var optionList=f.getElementsByTagName('option');var nodes=$A(optionList);var firstSelected=nodes[0];for(i=0,j=nodes.length;i<j;i++){if(nodes[i].selected){firstSelected=nodes[i];}
var optionDiv=document.createElement('div');optionDiv.id='Option'+s+'Div'+i;' '+nodes[i].innerHTML;var strElementStatus=nodes[i].innerHTML.toString();if(strElementStatus.substring(strElementStatus.length-9,strElementStatus.length)==".disabled")
{optionDiv.innerHTML=strElementStatus.replace('.disabled','');optionDiv.setAttribute('disabled','disabled');if($('intSelectionDisabled'))
{optionDiv.onmouseover=function(){$('intSelectionDisabled').value=1;};}}
else
{optionDiv.innerHTML='&nbsp;'+strElementStatus;optionDiv.className=(i%2?'OptionDivs Alt1':'OptionDivs Alt2');optionDiv.onclick=function(){var k=this.id.replace(/Option\d{1,2}Div/,'');f.selectedIndex=parseInt(k);newSelected.innerHTML=nodes[k].innerHTML;if(f.onchange){f.onchange();}};if($('intSelectionDisabled'))
{optionDiv.onmouseover=function(){$('intSelectionDisabled').value=0;};}}
optionsDiv.appendChild(optionDiv);}
var newSelected=document.createElement('div');newSelected.className='SelectedDivs';newSelected.id='SelectedDiv';newSelected.innerHTML=nodes[0].innerHTML.replace('.disabled','');newSelected.innerHTML=firstSelected.innerHTML.replace('.disabled','');if(f.style.width!=''){newSelected.style.width=parseInt(f.style.width.replace(/px/,''))-4+'px';}
newSelected.style.minWidth=f.style.minWidth;var newSelect=document.createElement('div');newSelect.className='SelectDivs';newSelect.style.width=f.style.width;newSelect.style.minWidth=f.style.minWidth;if(f.disabled==false)
{newSelect.onclick=function(){window.clearTimeout(selectTimeout);$$('.OptionsDivs').each(function(e){f.style.display='none';});if($('intSelectionDisabled'))
{if(openedSelect==optionsDiv.id&&$('intSelectionDisabled').value==0)
{closeSelect();}
else
{showSelect(optionsDiv);}}
else
{if(openedSelect==optionsDiv.id)
{closeSelect();}
else
{showSelect(optionsDiv);}}};}
f.parentNode.insertBefore(newSelect,f);newSelect.appendChild(newSelected);newSelect.appendChild(optionsDiv);s++;});}
function closeSelect(){if(openedSelect!='')
{if($(openedSelect))
{$(openedSelect).style.display='none';}}
openedSelect='';}
function showSelect(element){closeSelect();element.style.display='block';openedSelect=element.id;}
function resizeTextareas(){$$('.Textarea').each(function(e){var defaultRows=e.rows;e.onclick=e.onkeyup=e.onfocus=function(){var oldRows=e.rows;var lines=e.value.split('\n');var newRows=lines.length+1;if(newRows>=e.rows){e.rows=newRows;}else{if(e.rows>defaultRows){e.rows=newRows;}else{e.rows=defaultRows;}}};});}
function htmlEntityDecode(str){var ta=document.createElement('textarea');ta.innerHTML=str.replace(/</g,'&lt;').replace(/>/g,'&gt;');return ta.value;}
if(typeof Effect!='undefined'){Effect.Scroll=Class.create();Object.extend(Object.extend(Effect.Scroll.prototype,Effect.Base.prototype),{initialize:function(element){this.element=$(element);if(!this.element)throw(Effect._elementDoesNotExistError);this.start(Object.extend({x:0,y:0},arguments[1]||{}));},setup:function(){var scrollOffsets=(this.element==window)?document.viewport.getScrollOffsets():Element._returnOffset(this.element.scrollLeft,this.element.scrollTop);this.originalScrollLeft=scrollOffsets.left;this.originalScrollTop=scrollOffsets.top;},update:function(pos){this.element.scrollTop=Math.round(this.options.y*pos+this.originalScrollTop);this.element.scrollLeft=Math.round(this.options.x*pos+this.originalScrollLeft);}});}
function MessageCheckAction(message,url){var fRet;fRet=confirm(message);if(fRet)document.location=url;}
function clock(){time=parseInt(time)+1;var date=new Date(time*1000);var day=date.getDate()<10?'0'+date.getDate():date.getDate();var month=date.getMonth()+1;month=month<10?'0'+month:month;var year=date.getFullYear();var hour=date.getHours()<10?'0'+date.getHours():date.getHours();var minute=date.getMinutes()<10?'0'+date.getMinutes():date.getMinutes();var second=date.getSeconds()<10?'0'+date.getSeconds():date.getSeconds();$('Time').update(day+'.'+month+'.'+year+' '+hour+':'+minute+':'+second);}
var tmo;var bShowGameNavi=false;function showGameNavi(){if($('GAMESLINK').hasClassName('linkrollover')){window.clearTimeout(tmo);Effect.SlideDown('GAMESNAVI',{duration:0.3,queue:'end'});}}
function hideGameNavi(){if(!$('GAMESNAVI').hasClassName('navirollover')&&!bShowGameNavi){Effect.DropOut('GAMESNAVI',{duration:0.3,queue:'front',afterFinish:function(){clearStyles();}});}}
function clearStyles(){$('GAMESNAVI').style.overflow='';$('GAMESNAVI').style.left='';$('GAMESNAVI').style.top='';$('GAMESNAVI').style.opacity='';}
if($('GAMESLINK'))
{$('GAMESLINK').onmouseover=function(){$('GAMESLINK').addClassName('linkrollover');window.setTimeout("showGameNavi()",333);}
$('GAMESLINK').onmouseout=function(){$('GAMESLINK').removeClassName('linkrollover');tmo=window.setTimeout("hideGameNavi()",333);}}
if($('GAMESNAVI'))
{$('GAMESNAVI').onmouseover=function(){bShowGameNavi=true;}
$('GAMESNAVI').onmouseout=function(){bShowGameNavi=false;tmo=window.setTimeout("hideGameNavi()",250);}
$('GAMESNAVI').onclick=function(){bShowGameNavi=false;hideGameNavi();}}
function prepareTooltips(){$$('.Tooltip').each(function(e){var title=$(e).readAttribute('title');$(e).setAttribute('title','');if(title){$(e).onmouseover=function(){Tip(title);};$(e).onmouseout=function(){UnTip();};}});}
function formatForUrl(string){if(string)
{string=string.replace(/ /g,'_');string=string.replace(/#/g,'_');string=string.replace(/ä/g,'ae');string=string.replace(/ö/g,'oe');string=string.replace(/ü/g,'ue');string=string.replace(/Ä/g,'Ae');string=string.replace(/Ö/g,'Oe');string=string.replace(/Ü/g,'Ue');string=string.replace(/ß/g,'ss');string=string.replace(/[^A-Za-z0-9_-]/g,'');}
return string;}
function localUrl(params){var url=webRoot+'/';var script='ajax.php/';var page='';var path='';var ext='index.html';$H(params).each(function(pair){if(pair.key=='ssl'){}else if(pair.key=='page'){page=pair.value+'/';}else if(pair.key=='script'){script=pair.value+'/';}else if(pair.key=='ext'){ext=formatForUrl(pair.value)+'.html';}else{path+=pair.value+'/';}});return url+script+page+path+ext;}
function absoluteUrl(params){var ssl=false;return'http://'+serverName+localUrl(params);}
function pageScrollDown(){window.scrollBy(0,100);}
function pageScrollUp(){window.scrollBy(0,-100);}
function sendTeamJoinForm(){if($('TEAMSELECT').value>0){var joinlocation=webRoot+'/index.php/'+$('TEAM_JOIN').mod_join_page.value+'/'+$('TEAM_JOIN').team_id.value+'/'+$('TEAM_JOIN').mod_entry_id.value+'/test/index.html';top.location.href=joinlocation;}else{alert('Bitte ein Team ausw�hlen!');}}
function initFunctions(){replaceCheckbox();resizeTextareas();if($('Time')&&typeof time!='undefined'){clockInterval=setInterval('clock()',1000);}
prepareTooltips();}
function $RF(el,radioGroup){if($(el).type&&$(el).type.toLowerCase()=='radio'){var radioGroup=$(el).name;var el=$(el).form;}else if($(el).tagName.toLowerCase()!='form'){return false;}
var checked=$(el).getInputs('radio',radioGroup).find(function(re){return re.checked;});return(checked)?$F(checked):null;}
function log(object)
{if(typeof console!='undefined')
{console.log(object);}
else
{}}
var Share={openFriends:function(type,id,url){Share.type=type;Share.id=id;Share.url=url;Lightview.show({href:localUrl({page:'member.friendslist'}),rel:'ajax',title:'',caption:'',options:{autosize:true,topclose:true,ajax:{method:'get',evalScripts:true,onComplete:function(){replaceCheckbox();}}}});},markAll:function(){$$('#ShareFriendsList input').each(function(e){e.checked=true;});replaceCheckbox();},markNone:function(){$$('#ShareFriendsList input').each(function(e){e.checked=false;});replaceCheckbox();},send:function(){if($('ShareFriendsList')){var recipients='';$$('#ShareFriendsList input').each(function(e){if(e.checked){recipients+=e.value+',';}});if(recipients!=''){$('ShareFriendsList').update('<img src="{!$staticRoot!}/images/themes/playnow/ajax-loader.gif" alt="" />');new Ajax.Updater('ShareFriendsList',localUrl({page:'member.share'}),{parameters:{recipients:recipients,type:Share.type,id:Share.id,url:Share.url}});}}}};var openedSelect='';var clockInterval=null;var selectTimeout=null;var mouseUpFunc=null;config.BgColor='#3C3C3C';config.BorderColor='#FABF37';config.FontColor='#D9D9D9'
config.BorderWidth=2;Event.observe(window,'load',initFunctions);;var monitor='';var skipUpdate=false;var mem=new Array();var monitorUpdater=null;var messageId=0;Event.observe(document,'dom:loaded',function(){if(playerId>0&&$('Monitor')){monitorUpdater=new Ajax.PeriodicalUpdater('dummy',localUrl({page:'monitor'}),{method:'post',frequency:60,evalScripts:true,onCreate:function(){},onSuccess:function(transport){if(monitor.length!=transport.responseText.length){monitor=transport.responseText;if(!skipUpdate){$('Monitor').update(monitor);new UI.Carousel('Monitor',{'container':'#Messages','direction':'vertical','scrollInc':5,'previousButton':'#MonitorFooter .Scroll.Left','nextButton':'#MonitorFooter .Scroll.Right'});}}
if($('MessageFastChallenge')){fc.start();}}});}
Event.observe(window,'blur',function(){if(playerId>0&&monitorUpdater){monitorUpdater.stop();}});Event.observe(window,'focus',function(){if(playerId>0&&monitorUpdater){monitorUpdater.stop();monitorUpdater.start();}});});function monitorScroll(dir){if(dir=='up'){new Effect.Scroll('Messages',{x:0,y:-68,duration:0.3});}
if(dir=='down'){new Effect.Scroll('Messages',{x:0,y:68,duration:0.3});}}
function openText(id){Effect.Appear(id,{duration:0.6});var img=$(id.replace(/MonitorText/,'Message')).select('.MessageButtonLeft')[0];img.addClassName('Open');skipUpdate=true;new Ajax.Request(webRoot+'/ajax/messages.php',{method:'get',parameters:{read:1,id:id.replace(/MonitorText/,'')}});new Ajax.Request(webRoot+'/ajax/messages.php',{method:'get',parameters:{get_text:1,id:id.replace(/MonitorText/,'')},onSuccess:function(transport){$(id.replace(/Monitor/,'Message')).update(transport.responseText);}});}
function closeText(id){$(id).select('.Text')[0].show();Effect.Fade('MessageAnswer');Effect.Fade(id);if($(id.replace(/MonitorText/,'Message')).hasClassName('MessageSystem')){$(id.replace(/MonitorText/,'Message')).remove();if($('Messages').select('.MessageSystem').length==0){$('Message0').remove();}}
skipUpdate=false;}
function deleteMessage(id){if(confirm('Soll die Nachricht mit dem Betreff "'+$(id).select('span')[0].innerHTML+'" wirklich gelöscht werden?')){$('MessageAnswer').hide();Effect.DropOut(id,{afterFinish:function(){if($(id)){$(id).remove();$(id.replace(/Message/,'MonitorText')).remove();skipUpdate=true;var uneven=true;$$('.Message').each(function(e){if(e.id!='MessageSession'){if(uneven){e.addClassName('Uneven');uneven=false;}else{e.removeClassName('Uneven');uneven=true;}}});}}});Effect.DropOut(id.replace(/Message/,'MonitorText'));new Ajax.Request(webRoot+'/ajax/messages.php',{parameters:{'delete':1,'id':id.replace(/Message/,'')}});}}
function answerMessage(id){messageId=id;Effect.Fade($('MonitorText'+id).select('.Text')[0]);Effect.Appear('MessageAnswer');}
function sendAnswer(){Effect.Fade('MessageAnswer');Effect.Appear($('MonitorText'+messageId).select('.Text')[0]);$('SpanMessageAnswer').update('(Antwort verschickt)');new Ajax.Request(webRoot+'/ajax/messages.php',{parameters:{send:1,to:$('Message'+messageId).select('input')[0].value,subject:'Re: '+$('Message'+messageId).select('span')[0].innerHTML.replace(/^Re: /,''),text:$('TextMessageAnswer').value},onSuccess:function(){$('TextMessageAnswer').value='';}});};var FastChallenge=Class.create({interval:20,progressInterval:500,updater:null,progressor:null,started:false,updateUrl:'',iteration:0,progressIteration:0,progressMaxWidth:0,progressLastMaxWidth:0,map1Count:0,map1CheckedCount:0,map2Count:0,map2CheckedCount:0,debug:'',initialize:function(){},send:function(action,form,successFunction){if($('FastChallengeContainer')){$('FastChallengeContainer').insert({'top':new Element('div',{'class':'LoaderDiv ZTop'})});}
var params=null;if(typeof form=='object')
{params=form;}else if($(form)){params=$(form).serialize(true);}
var gameId=0;if($('FastChallengeAvailable')){gameId=$('FastChallengeAvailable').innerHTML;}
new Ajax.Updater('FastChallengeContainer',localUrl({page:'Ladder:fastchallenge',action:action,gameId:gameId}),{method:'post',parameters:params,onSuccess:successFunction,onComplete:function(){replaceCheckbox();}});},sendRegister:function(){fc.send('register',null,null);},sendSelectType:function(){fc.send('selectType','FormSelectType',null);},sendSelectTeam:function(){fc.send('selectTeam','FormSelectTeam',null);},sendSelectLadder:function(ladderNum){if($('MapContainer'+ladderNum)){$('MapContainer'+ladderNum).insert({'top':new Element('div',{'class':'LoaderDiv ZTop','style':'padding: 0;'})});}
var params=null;new Ajax.Updater('MapContainer'+ladderNum,localUrl({page:'Ladder:fastchallenge_maps',ladderId:$('Ladder'+ladderNum).value,ladderNum:ladderNum}),{method:'post',parameters:params,onComplete:function(){replaceCheckbox();prepareTooltips();fc.checkMaps();if($('Ladder1').value<0&&$('Ladder2').value<0){$('NextButton').hide();}else{$('NextButton').show();}}});},sendSignOn:function(params){fc.iteration=0;fc.progressMaxWidth=0;fc.progressLastMaxWidth=0;fc.progressIteration=0;Cookie.setData('fcIteration',0);Cookie.setData('fcLastMaxWidth',0);Cookie.setData('fcMaxWidth',0);if(typeof params!='object')
{params='FormSignOn';}
fc.send('signOn',params,function(){monitor='';monitorUpdater.stop();monitorUpdater.start();if($('FormSignOn'))
{Cookie.setData('fcRegister',$('FormSignOn').serialize(true));}});},cancel:function(){var gameId=0;if($('FastChallengeAvailable')){gameId=$('FastChallengeAvailable').innerHTML;}
new Ajax.Request(localUrl({page:'Ladder:fastchallenge',action:'cancel',gameId:gameId}),{method:'post',onSuccess:function(transport){if(transport.responseText=='stop'){fc.stop();}
else
{if($('FastChallengeContainer')){$('FastChallengeContainer').update(transport.responseText);}}}});},start:function(extend,hold){if(typeof extend=='undefined')
{extend=false;}
if(typeof hold=='undefined')
{hold=false;}
if(!fc.started)
{fc.started=true;fc.iteration=Cookie.getData('fcIteration')>0?Cookie.getData('fcIteration'):0;fc.progressMaxWidth=Cookie.getData('fcMaxWidth')>0?Cookie.getData('fcMaxWidth'):0;fc.progressLastMaxWidth=Cookie.getData('fcLastMaxWidth')>0?Cookie.getData('fcLastMaxWidth'):0;fc.updater=setInterval('fc.update(false)',fc.interval*1000);fc.update(true);fc.progressor=setInterval('fc.progress()',fc.progressInterval);}},stop:function(){if(fc.started)
{clearInterval(fc.updater);clearInterval(fc.progressor);fc.started=false;}
if($('MessageFastChallenge')){$('MessageFastChallenge').remove();}
if($('FastChallengeContainer')){new Ajax.Updater('FastChallengeContainer',localUrl({page:'Ladder:fastchallenge',action:'register',gameId:$('FastChallengeAvailable').innerHTML}),{});}},showStop:function(){Sound.play('http://static.4players.de/4pl/web/sound/fc/fc-alert2.mp3',{replace:true});Lightview.show({href:localUrl({'page':'Ladder:fastchallenge_stop'}),rel:'ajax',caption:'',options:{autosize:true,ajax:{method:'get',evalScripts:true,onComplete:function(){var register=Cookie.getData('fcRegister');if(register.extend){$('ButtonFcExtend').hide();}
if($('FcDebug'))
{$('FcDebug').update('Debug Meldung: '+fc.debug);}}}}});},update:function(fast){var updateUrl=localUrl({'page':'Ladder:fastchallenge_update'});if(fast){updateUrl=localUrl({'page':'Ladder:fastchallenge_update','fast':1});}
new Ajax.Request(updateUrl,{method:'post',onSuccess:function(transport){var sessionId=0;if(transport.responseJSON.action=='stop'&&fc.started){fc.debug=transport.responseJSON.debug;fc.cancel();fc.showStop();}else if(transport.responseJSON.action=='match'){fc.stop();fc.match(transport.responseJSON.gameSessionId);}else if(transport.responseJSON.action=='update'){fc.iteration=transport.responseJSON.realiteration;fc.progressIteration=0;Cookie.setData('fcIteration',transport.responseJSON.realiteration);}}});},match:function(sessionId){Sound.play('http://static.4players.de/4pl/web/sound/fc/fc-alert1.mp3',{replace:true});Lightview.show({href:localUrl({'page':'Ladder:fastchallenge_match',sessionId:sessionId}),rel:'ajax',caption:'',options:{autosize:true,ajax:{method:'get',evalScripts:true,onComplete:function(){}}}});},progress:function(){fc.progressIteration+=1;if($('MessageFastChallenge')){if(!$('FastChallengeProgress')){var progress=new Element('div',{'id':'FastChallengeProgress','class':'Top Left ZBottom','style':'width: 0%; height: 34px; background: url('+staticRoot+'/images/themes/playnow/fc_progress.gif);'});$('MessageFastChallenge').insert({'top':progress});}else{var maxWidth=100/(parseInt($('FastChallengeRounds').innerHTML)/(fc.iteration+1));if(maxWidth!=fc.progressMaxWidth){fc.progressLastMaxWidth=fc.progressMaxWidth;fc.progressMaxWidth=maxWidth;Cookie.setData('fcLastMaxWidth',fc.progressMaxWidth);Cookie.setData('fcMaxWidth',maxWidth);}
var interWidth=fc.progressMaxWidth-fc.progressLastMaxWidth;var width=fc.progressLastMaxWidth+interWidth/((fc.interval*1000)/fc.progressInterval)*fc.progressIteration;width=width>=maxWidth?maxWidth:width;$('FastChallengeProgress').style.width=width+'%';$('FastChallengeProgressPercent').update(Math.floor(width)+'%');}}},checkMaps:function(){fc.map1Count=0;fc.map1CheckedCount=0;fc.map2Count=0;fc.map2CheckedCount=0;$$('.InputMap1').each(function(e){fc.map1Count+=1;e.onchange=fc.checkMaps;if(e.checked){fc.map1CheckedCount+=1;}});$$('.InputMap2').each(function(e){fc.map2Count+=1;e.onchange=fc.checkMaps;if(e.checked){fc.map2CheckedCount+=1;}});if(fc.map1Count>(fc.map1CheckedCount+1)&&fc.map1Count>1)
{$$('.InputMap1').each(function(e){e.checked=true;});this.checked=false;replaceCheckbox();}
if(fc.map1Count==1&&this.className=='InputMap1')
{this.checked=true;replaceCheckbox();}
if(fc.map2Count>(fc.map2CheckedCount+1)&&fc.map2Count>1)
{$$('.InputMap2').each(function(e){e.checked=true;});this.checked=false;replaceCheckbox();}
if(fc.map2Count==1&&this.className=='InputMap2')
{this.checked=true;replaceCheckbox();}},hold:function(){var params=Cookie.getData('fcRegister');params.hold=1;Cookie.setData('fcRegister',params);fc.sendSignOn(params);Lightview.hide();},extend:function(){var params=Cookie.getData('fcRegister');params.hold=0;params.extend=1;Cookie.setData('fcRegister',params);fc.sendSignOn(params);Lightview.hide();}});var fc=new FastChallenge();Event.observe(document,'dom:loaded',function(){if(playerId>0&&$('FastChallengeAvailable')){fc.sendRegister();}});;var Cookie={data:{},options:{expires:1,domain:".4players.de",path:"/",secure:false},init:function(options,data){Cookie.options=Object.extend(Cookie.options,options||{});var payload=Cookie.retrieve();if(payload){Cookie.data=payload.evalJSON();}
else{Cookie.data=data||{};}
Cookie.store();},getData:function(key){return Cookie.data[key];},setData:function(key,value){Cookie.data[key]=value;Cookie.store();},removeData:function(key){delete Cookie.data[key];Cookie.store();},retrieve:function(){var start=document.cookie.lastIndexOf(Cookie.options.name+"=");if(start==-1){return null;}
if(Cookie.options.name!=document.cookie.substr(start,Cookie.options.name.length)){return null;}
var len=start+Cookie.options.name.length+1;var end=document.cookie.indexOf(';',len);if(end==-1){end=document.cookie.length;}
return unescape(document.cookie.substring(len,end));},store:function(){var expires='';if(Cookie.options.expires){var today=new Date();expires=Cookie.options.expires*86400000;expires=';expires='+new Date(today.getTime()+expires);}
document.cookie=Cookie.options.name+'='+escape(Object.toJSON(Cookie.data))+Cookie.getOptions()+expires;},erase:function(){document.cookie=Cookie.options.name+'='+Cookie.getOptions()+';expires=Thu, 01-Jan-1970 00:00:01 GMT';},getOptions:function(){return(Cookie.options.path?';path='+Cookie.options.path:'')+(Cookie.options.domain?';domain='+Cookie.options.domain:'')+(Cookie.options.secure?';secure':'');}};Cookie.init({name:'playnow_information',expires:365,path:'/'});;function initQuickLinks(){if($('QuickLinksContainer'))
{var types=new Array('home','game','competition');var quickLinksCookie=Cookie.getData('quick_links');var links=new Array();for(i=0,j=types.length;i<j;i++)
{try
{if(typeof quickLinks[types[i]]!='undefined')
{if(quickLinks[types[i]]['name']!='')
{links[i]=new Element('a',{'href':'http://'+serverName+quickLinks[types[i]]['url'],'rel':types[i]}).update(quickLinks[types[i]]['name']);}
else
{if(typeof quickLinksCookie[types[i]]!='undefined')
{if(quickLinksCookie[types[i]]['name']!='')
{links[i]=new Element('a',{'href':'http://'+serverName+quickLinksCookie[types[i]]['url'],'rel':types[i]}).update(quickLinksCookie[types[i]]['name']);quickLinks[types[i]]=quickLinksCookie[types[i]];}}}}}
catch(e)
{}}
$('QuickLinksContainer').insert('<div id="QuickLinks"></div>');for(i=0,j=links.length;i<j;i++)
{$('QuickLinks').insert(links[i]);if(i<links.length-1)
{$('QuickLinks').insert('&nbsp;-&gt;&nbsp;');}}
Cookie.setData('quick_links',quickLinks);}}
document.observe('dom:loaded',initQuickLinks);;if(typeof Prototype=='undefined'||!Prototype.Version.match("1.6"))
throw("Prototype-UI library require Prototype library >= 1.6.0");if(Prototype.Browser.WebKit){Prototype.Browser.WebKitVersion=parseFloat(navigator.userAgent.match(/AppleWebKit\/([\d\.\+]*)/)[1]);Prototype.Browser.Safari2=(Prototype.Browser.WebKitVersion<420);}
if(Prototype.Browser.IE){Prototype.Browser.IEVersion=parseFloat(navigator.appVersion.split(';')[1].strip().split(' ')[1]);Prototype.Browser.IE6=Prototype.Browser.IEVersion==6;Prototype.Browser.IE7=Prototype.Browser.IEVersion==7;}
Prototype.falseFunction=function(){return false};Prototype.trueFunction=function(){return true};var UI={Abstract:{},Ajax:{}};Object.extend(Class.Methods,{extend:Object.extend.methodize(),addMethods:Class.Methods.addMethods.wrap(function(proceed,source){if(!source)return this;if(!source.hasOwnProperty('methodsAdded'))
return proceed(source);var callback=source.methodsAdded;delete source.methodsAdded;proceed(source);callback.call(source,this);source.methodsAdded=callback;return this;}),addMethod:function(name,lambda){var methods={};methods[name]=lambda;return this.addMethods(methods);},method:function(name){return this.prototype[name].valueOf();},classMethod:function(){$A(arguments).flatten().each(function(method){this[method]=(function(){return this[method].apply(this,arguments);}).bind(this.prototype);},this);return this;},undefMethod:function(name){this.prototype[name]=undefined;return this;},removeMethod:function(name){delete this.prototype[name];return this;},aliasMethod:function(newName,name){this.prototype[newName]=this.prototype[name];return this;},aliasMethodChain:function(target,feature){feature=feature.camelcase();this.aliasMethod(target+"Without"+feature,target);this.aliasMethod(target,target+"With"+feature);return this;}});Object.extend(Number.prototype,{snap:function(round){return parseInt(round==1?this:(this/round).floor()*round);}});Object.extend(String.prototype,{camelcase:function(){var string=this.dasherize().camelize();return string.charAt(0).toUpperCase()+string.slice(1);},makeElement:function(){var wrapper=new Element('div');wrapper.innerHTML=this;return wrapper.down();}});Object.extend(Array.prototype,{empty:function(){return!this.length;},extractOptions:function(){return this.last().constructor===Object?this.pop():{};},removeAt:function(index){var object=this[index];this.splice(index,1);return object;},remove:function(object){var index;while((index=this.indexOf(object))!=-1)
this.removeAt(index);return object;},insert:function(index){var args=$A(arguments);args.shift();this.splice.apply(this,[index,0].concat(args));return this;}});Element.addMethods({getScrollDimensions:function(element){return{width:element.scrollWidth,height:element.scrollHeight}},getScrollOffset:function(element){return Element._returnOffset(element.scrollLeft,element.scrollTop);},setScrollOffset:function(element,offset){element=$(element);if(arguments.length==3)
offset={left:offset,top:arguments[2]};element.scrollLeft=offset.left;element.scrollTop=offset.top;return element;},getNumStyle:function(element,style){var value=parseFloat($(element).getStyle(style));return isNaN(value)?null:value;},appendText:function(element,text){element=$(element);text=String.interpret(text);element.appendChild(document.createTextNode(text));return element;}});document.whenReady=function(callback){if(document.loaded)
callback.call(document);else
document.observe('dom:loaded',callback);};Object.extend(document.viewport,{getScrollOffset:document.viewport.getScrollOffsets,setScrollOffset:function(offset){Element.setScrollOffset(Prototype.Browser.WebKit?document.body:document.documentElement,offset);},getScrollDimensions:function(){return Element.getScrollDimensions(Prototype.Browser.WebKit?document.body:document.documentElement);}});(function(){UI.Options={methodsAdded:function(klass){klass.classMethod($w(' setOptions allOptions optionsGetter optionsSetter optionsAccessor '));},setOptions:function(options){if(!this.hasOwnProperty('options'))
this.options=this.allOptions();this.options=Object.extend(this.options,options||{});},allOptions:function(){var superclass=this.constructor.superclass,ancestor=superclass&&superclass.prototype;return(ancestor&&ancestor.allOptions)?Object.extend(ancestor.allOptions(),this.options):Object.clone(this.options);},optionsGetter:function(){addOptionsAccessors(this,arguments,false);},optionsSetter:function(){addOptionsAccessors(this,arguments,true);},optionsAccessor:function(){this.optionsGetter.apply(this,arguments);this.optionsSetter.apply(this,arguments);}};function addOptionsAccessors(receiver,names,areSetters){names=$A(names).flatten();if(names.empty())
names=Object.keys(receiver.allOptions());names.each(function(name){var accessorName=(areSetters?'set':'get')+name.camelcase();receiver[accessorName]=receiver[accessorName]||(areSetters?function(value){return this.options[name]=value}:function(){return this.options[name]});});}})();UI.Carousel=Class.create(UI.Options,{options:{direction:"horizontal",previousButton:".previous_button",nextButton:".next_button",container:".container",scrollInc:6,disabledButtonSuffix:'_disabled',overButtonSuffix:'_over'},initialize:function(element,options){this.setOptions(options);this.element=$(element);this.id=this.element.id;this.container=this.element.down(this.options.container).firstDescendant();this.elements=this.container.childElements();this.previousButton=this.options.previousButton==false?null:this.element.down(this.options.previousButton);this.nextButton=this.options.nextButton==false?null:this.element.down(this.options.nextButton);this.posAttribute=(this.options.direction=="horizontal"?"left":"top");this.dimAttribute=(this.options.direction=="horizontal"?"width":"height");this.elementSize=this.computeElementSize();this.nbVisible=this.currentSize()/this.elementSize;var scrollInc=this.options.scrollInc;var objTimeInterval;if(scrollInc=="auto")
scrollInc=Math.floor(this.nbVisible);[this.previousButton,this.nextButton].each(function(button){if(!button)return;var className=(button==this.nextButton?"next_button":"previous_button")+this.options.overButtonSuffix;button.clickHandler=this.scroll.bind(this,(button==this.nextButton?-1:1)*scrollInc*this.elementSize);button.observe("click",button.clickHandler).observe("mouseover",function(){button.addClassName(className)}.bind(this)).observe("mouseout",function(){button.removeClassName(className)}.bind(this));},this);this.updateButtons();},destroy:function($super){[this.previousButton,this.nextButton].each(function(button){if(!button)return;button.stopObserving("click",button.clickHandler);},this);this.element.remove();this.fire('destroyed');},fire:function(eventName,memo){memo=memo||{};memo.carousel=this;return this.element.fire('carousel:'+eventName,memo);},observe:function(eventName,handler){this.element.observe('carousel:'+eventName,handler.bind(this));return this;},stopObserving:function(eventName,handler){this.element.stopObserving('carousel:'+eventName,handler);return this;},checkScroll:function(position,updatePosition){if(position>0)
position=0;else{var limit=this.elements.last().positionedOffset()[this.posAttribute]+this.elementSize;var carouselSize=this.currentSize();if(position+limit<carouselSize)
position+=carouselSize-(position+limit);position=Math.min(position,0);}
if(updatePosition)
this.container.style[this.posAttribute]=position+"px";return position;},scroll:function(deltaPixel){if(this.animating)
return this;var position=this.currentPosition()+deltaPixel;position=this.checkScroll(position,false);deltaPixel=position-this.currentPosition();if(deltaPixel!=0){this.animating=true;this.fire("scroll:started");var that=this;this.container.morph("opacity:0.5",{duration:0.1,afterFinish:function(){that.container.morph(that.posAttribute+": "+position+"px",{duration:0.2,delay:0.0,afterFinish:function(){that.container.morph("opacity:1",{duration:0.1,afterFinish:function(){that.animating=false;that.updateButtons().fire("scroll:ended",{shift:deltaPixel/that.currentSize()});}});}});}});}
return this;},scrollTo:function(index){if(this.animating||index<0||index>this.elements.length||index==this.currentIndex()||isNaN(parseInt(index)))
return this;return this.scroll((this.currentIndex()-index)*this.elementSize);},updateButtons:function(){this.updatePreviousButton();this.updateNextButton();return this;},updatePreviousButton:function(){var position=this.currentPosition();var previousClassName="previous_button"+this.options.disabledButtonSuffix;if(this.previousButton.hasClassName(previousClassName)&&position!=0){this.previousButton.removeClassName(previousClassName);this.fire('previousButton:enabled');}
if(!this.previousButton.hasClassName(previousClassName)&&position==0){this.previousButton.addClassName(previousClassName);this.fire('previousButton:disabled');}},updateNextButton:function(){var lastPosition=this.currentLastPosition();var size=this.currentSize();var nextClassName="next_button"+this.options.disabledButtonSuffix;if(this.nextButton.hasClassName(nextClassName)&&lastPosition!=size){this.nextButton.removeClassName(nextClassName);this.fire('nextButton:enabled');}
if(!this.nextButton.hasClassName(nextClassName)&&lastPosition==size){this.nextButton.addClassName(nextClassName);this.fire('nextButton:disabled');}},computeElementSize:function(){return this.elements.first().getDimensions()[this.dimAttribute];},currentIndex:function(){return-this.currentPosition()/this.elementSize;},currentLastPosition:function(){if(this.container.childElements().empty())
return 0;return this.currentPosition()+
this.elements.last().positionedOffset()[this.posAttribute]+
this.elementSize;},currentPosition:function(){return this.container.getNumStyle(this.posAttribute);},currentSize:function(){return this.container.parentNode.getDimensions()[this.dimAttribute];},updateSize:function(){this.nbVisible=this.currentSize()/this.elementSize;var scrollInc=this.options.scrollInc;if(scrollInc=="auto")
scrollInc=Math.floor(this.nbVisible);[this.previousButton,this.nextButton].each(function(button){if(!button)return;button.stopObserving("click",button.clickHandler);button.clickHandler=this.scroll.bind(this,(button==this.nextButton?-1:1)*scrollInc*this.elementSize);button.observe("click",button.clickHandler);},this);this.checkScroll(this.currentPosition(),true);this.updateButtons().fire('sizeUpdated');return this;}});UI.Ajax.Carousel=Class.create(UI.Carousel,{options:{elementSize:-1,url:null},initialize:function($super,element,options){if(!options.url)
throw("url option is required for UI.Ajax.Carousel");if(!options.elementSize)
throw("elementSize option is required for UI.Ajax.Carousel");$super(element,options);this.endIndex=0;this.hasMore=true;this.updateHandler=this.update.bind(this);this.updateAndScrollHandler=function(nbElements,transport,json){this.update(transport,json);this.scroll(nbElements);}.bind(this);this.runRequest.bind(this).defer({parameters:{from:0,to:Math.ceil(this.nbVisible)-1},onSuccess:this.updateHandler});},runRequest:function(options){this.requestRunning=true;new Ajax.Request(this.options.url,Object.extend({method:"GET"},options));this.fire("request:started");return this;},scroll:function($super,deltaPixel){if(this.animating||this.requestRunning)
return this;var nbElements=(-deltaPixel)/this.elementSize;if(this.hasMore&&nbElements>0&&this.currentIndex()+this.nbVisible+nbElements-1>this.endIndex){var from=this.endIndex+1;var to=Math.ceil(from+this.nbVisible-1);this.runRequest({parameters:{from:from,to:to},onSuccess:this.updateAndScrollHandler.curry(deltaPixel).bind(this)});return this;}
else
$super(deltaPixel);},update:function(transport,json){this.requestRunning=false;this.fire("request:ended");if(!json)
json=transport.responseJSON;this.hasMore=json.more;this.endIndex=Math.max(this.endIndex,json.to);this.elements=this.container.insert({bottom:json.html}).childElements();return this.updateButtons();},computeElementSize:function(){return this.options.elementSize;},updateSize:function($super){var nbVisible=this.nbVisible;$super();if(Math.floor(this.nbVisible)-Math.floor(nbVisible)>=1&&this.hasMore){if(this.currentIndex()+Math.floor(this.nbVisible)>=this.endIndex){var nbNew=Math.floor(this.currentIndex()+Math.floor(this.nbVisible)-this.endIndex);this.runRequest({parameters:{from:this.endIndex+1,to:this.endIndex+nbNew},onSuccess:this.updateHandler});}}
return this;},updateNextButton:function($super){var lastPosition=this.currentLastPosition();var size=this.currentSize();var nextClassName="next_button"+this.options.disabledButtonSuffix;if(this.nextButton.hasClassName(nextClassName)&&lastPosition!=size){this.nextButton.removeClassName(nextClassName);this.fire('nextButton:enabled');}
if(!this.nextButton.hasClassName(nextClassName)&&lastPosition==size&&!this.hasMore){this.nextButton.addClassName(nextClassName);this.fire('nextButton:disabled');}}});;var tmout;var missingProfImg=new Array(0);var existsProfImg=new Object();var existsProfNames=new Object();var originalProfTitles=new Object();var missingTeamsImg=new Array(0);var existsTeamsImg=new Object();var existsTeamsNames=new Object();var originalTeamsTitles=new Object();function ptt_init(){var tt_pMenuDiv=$(document.createElement("div"));var ulObj=$(document.createElement("ul"));ulObj.addClassName('profile_menu');tt_pMenuDiv.appendChild(ulObj);ptt_setProfileMenu(tt_pMenuDiv);ptt_setTeamsMenu(tt_pMenuDiv);config.FollowMouse=false;config.ClickClose=true;}
function ptt_getValue(userlink,imgPath,profName,originalTitle,tt_pMenuDiv){var suche=/.*\/member.profile\/(\d{1,10})\//i;$(userlink).href.scan(suche,function(found){profileid=found[1];});var imgFullPath;if(!imgPath){imgPath=existsProfImg[profileid];}
if(imgPath==''){imgFullPath='http://static2.4pl.4players.de/dist/htdocs/images/themes/playnow/dummies/user';}else{imgFullPath='http://static.login.4players.de'+imgPath+'/'+profileid;}
if(!profName){profName=existsProfNames[profileid];}
if(typeof profName=='undefined'){profName=originalProfTitles[profileid];}
var ulObj=$(tt_pMenuDiv).childElements()[0];ulObj.update();var li1=$(document.createElement("li"));var li2=$(document.createElement("li"));li1.innerHTML="<a href='javascript:ptt_profile_show(\""+userlink.href+"\");'>Profil anzeigen</a>";li2.innerHTML="<a href='javascript:ptt_profile_send_pn("+profileid+");'>Nachricht senden</a>";ulObj.appendChild(li1);ulObj.appendChild(li2);var profImg='<img src="'+imgFullPath+'_big.jpg" border="0"><br/>';var menuHtml='<div class="ptt_image">'+profImg+'<b style="color:#FABF37;">'+profName+'</b></div>'+tt_pMenuDiv.innerHTML;return menuHtml;}
function ptt_getValueTeams(userlink,imgPath,profName,originalTitle,tt_pMenuDiv){var suche=/.*\/team.info\/(\d{1,10})\//i;$(userlink).href.scan(suche,function(found){teamid=found[1];});var imgFullPath;if(!imgPath){imgPath=existsTeamsImg[teamid];}
if(imgPath==''){imgFullPath='http://static2.4pl.4players.de/dist/htdocs/images/themes/playnow/dummies/team';}else{imgFullPath='http://static.4pl.4players.de'+imgPath+'/'+teamid;}
if(!profName){profName=existsTeamsNames[teamid];}
if(typeof profName=='undefined'){profName=originalTeamsTitles[teamid];}
var ulObj=$(tt_pMenuDiv).childElements()[0];ulObj.update();var li1=$(document.createElement("li"));var li2=$(document.createElement("li"));li1.innerHTML="<a href='javascript:ptt_team_show(\""+userlink.href+"\");'>Team-Profil</a>";li2.innerHTML="<a href='javascript:ptt_team_show(\""+localUrl({script:'index.php',page:'team.memberlist',id:teamid})+"\");'>Team-Mitglieder</a>";ulObj.appendChild(li1);ulObj.appendChild(li2);var profImg='<img src="'+imgFullPath+'_big.jpg" border="0"><br/>';var menuHtml='<div class="ptt_image">'+profImg+'<b style="color:#FABF37;">'+profName+'</b></div>'+tt_pMenuDiv.innerHTML;return menuHtml;}
function ptt_setTeamsMenu(tt_pMenuDiv){var sucheTeamImgPath=/.*\/images\/teams\/([a-z0-9]{2}\/[a-z0-9]{2})\//i;var sucheTeamId=/.*\/team.info\/(\d{1,10})\//i;var originalTitle;$$('a[href*="/team.info/"]').each(function(userlink){$(userlink).href.scan(sucheTeamId,function(foundTid){teamid=foundTid[1];if(missingTeamsImg.indexOf(teamid)==-1){missingTeamsImg[missingTeamsImg.length]=teamid;}
existsTeamsImg[teamid]='';});var elementsInA=userlink.childElements();var imgPath=null;var profName=null;$(elementsInA).each(function(el){var TagName=el.tagName.toLowerCase();if(TagName=='img'){var imgSrc=el.src;imgSrc.scan(sucheTeamImgPath,function(found){imgPath='/images/teams/'+found[1];if(imgPath!=''){var pos=missingTeamsImg.indexOf(teamid);existsTeamsImg[teamid]=imgPath;missingTeamsImg.splice(pos,1);}});}});var userlinkCopy=$(document.createElement("div"));userlinkCopy.update(userlink.innerHTML);$(userlinkCopy).childElements().each(function(el2){var TagName=el2.tagName.toLowerCase();if(TagName=='img'){el2.remove();}});var profName=userlinkCopy.innerHTML;var testProfName=profName.replace(/\s+/g,"");if(testProfName!=''){existsTeamsNames[teamid]=profName.replace(/\s+$/,"").replace(/^\s+/,"");}else{profName='';}
if($(userlink).title!=''){originalTeamsTitles[teamid]=$(userlink).title;}
$(userlink).onmouseout=function(){UnTip();ptt_hideMenu();}
$(userlink).onmouseover=function(){window.clearTimeout(tmout);Tip(ptt_getValueTeams($(userlink),imgPath,profName,originalTitle,tt_pMenuDiv),STICKY,true,ABOVE,'true',PADDING,5,TEXTALIGN,'justify');}});if(missingTeamsImg.length>0){phpfileuri=localUrl({page:'imagespath'});new Ajax.Request(phpfileuri,{method:'post',parameters:{img_pids:missingTeamsImg.toString(),img_type:'teams'},evalJSON:'force',onSuccess:function(transport){var aRespo=transport.responseJSON;for(i=0;i<aRespo.length;i++){existsTeamsImg[aRespo[i].id]=aRespo[i].images_path.substring(0,aRespo[i].images_path.lastIndexOf('/'));if(typeof existsTeamsNames[aRespo[i].id]=='undefined'){existsTeamsNames[aRespo[i].id]=aRespo[i].team_name;}}}});}}
function ptt_setProfileMenu(tt_pMenuDiv){var sucheProfileImgPath=/.*\/images\/player\/([a-z0-9]{2}\/[a-z0-9]{2})\//i;var sucheProfileId=/.*\/member.profile\/(\d{1,10})\//i;var originalTitle;$$('a[href*="/member.profile/"]').each(function(userlink){if(!$(userlink).hasClassName('MonitorProfile'))
{$(userlink).href.scan(sucheProfileId,function(foundPid){profileid=foundPid[1];if(missingProfImg.indexOf(profileid)==-1){missingProfImg[missingProfImg.length]=profileid;}
existsProfImg[profileid]='';});var elementsInA=userlink.childElements();var imgPath=null;var profName=null;$(elementsInA).each(function(el){var TagName=el.tagName.toLowerCase();if(TagName=='img'){var imgSrc=el.src;imgSrc.scan(sucheProfileImgPath,function(found){imgPath='/images/player/'+found[1];if(imgPath!=''){var pos=missingProfImg.indexOf(profileid);existsProfImg[profileid]=imgPath;missingProfImg.splice(pos,1);}});}});var userlinkCopy=$(document.createElement("div"));userlinkCopy.update(userlink.innerHTML);$(userlinkCopy).childElements().each(function(el2){var TagName=el2.tagName.toLowerCase();if(TagName=='img'){el2.remove();}});var profName=userlinkCopy.innerHTML;var testProfName=profName.replace(/\s+/g,"");if(testProfName!=''){existsProfNames[profileid]=profName.replace(/\s+$/,"").replace(/^\s+/,"");}else{profName='';}
if($(userlink).title!=''){originalProfTitles[profileid]=$(userlink).title;}
$(userlink).onmouseout=function(){UnTip();ptt_hideMenu();}
$(userlink).onmouseover=function(){window.clearTimeout(tmout);Tip(ptt_getValue($(userlink),imgPath,profName,originalTitle,tt_pMenuDiv),STICKY,true,ABOVE,'true',PADDING,5,TEXTALIGN,'justify');}}});if(missingProfImg.length>0){phpfileuri=localUrl({page:'imagespath'});new Ajax.Request(phpfileuri,{method:'post',parameters:{img_pids:missingProfImg.toString(),img_type:'profile'},evalJSON:'force',onSuccess:function(transport){var aRespo=transport.responseJSON;for(i=0;i<aRespo.length;i++){existsProfImg[aRespo[i].id]=aRespo[i].images_path;if(typeof existsProfNames[aRespo[i].id]=='undefined'){existsProfNames[aRespo[i].id]=aRespo[i].nick_name;}}}});}}
function ptt_hideMenu(){tmout=window.setTimeout("tt_HideInit()",250);}
function ptt_profile_show(pUrl){window.location.href=pUrl;}
function ptt_team_show(pUrl){window.location.href=pUrl;}
function ptt_profile_send_pn(pId){var pnUrl=localUrl({script:'index.php',page:'member.center.send',id:'-',pid:pId});window.location.href=pnUrl;}
Event.observe(document,'dom:loaded',function(){ptt_init();$('WzTtDiV').onmouseover=function(){if($('WzBoDyI')!=null){$('WzBoDyI').onmouseover=function(){window.clearTimeout(tmout);}}
window.clearTimeout(tmout);}
$('WzTtDiV').onmouseout=function(){ptt_hideMenu();}});;var Lightview={Version:'2.5.2.1',options:{backgroundColor:'#4B4B4B',border:8,buttons:{opacity:{disabled:0.4,normal:0.75,hover:1},side:{display:true},innerPreviousNext:{display:true},slideshow:{display:true},topclose:{side:'right'}},controller:{backgroundColor:'#4d4d4d',border:6,buttons:{innerPreviousNext:true,side:false},margin:18,opacity:0.7,radius:6,setNumberTemplate:'#{position} of #{total}'},cyclic:false,images:'http://static1.4pl.4players.de/dist/htdocs/images/lightview/',imgNumberTemplate:'Bild #{position} von #{total}',keyboard:true,menubarPadding:6,overlay:{background:'#000',close:true,opacity:0.85,display:true},preloadHover:false,radius:8,removeTitles:true,resizeDuration:0.45,slideshowDelay:5,titleSplit:'::',transition:function(pos){return((pos/=0.5)<1?0.5*Math.pow(pos,4):-0.5*((pos-=2)*Math.pow(pos,3)-2));},viewport:true,zIndex:5000,startDimensions:{width:100,height:100},closeDimensions:{large:{width:77,height:22},small:{width:25,height:22}},sideDimensions:{width:16,height:22},defaultOptions:{image:{menubar:'bottom',closeButton:'large'},gallery:{menubar:'bottom',closeButton:'large'},ajax:{width:400,height:300,menubar:'top',closeButton:'small',overflow:'auto'},iframe:{width:400,height:300,menubar:'top',scrolling:true,closeButton:'small'},inline:{width:400,height:300,menubar:'top',closeButton:'small',overflow:'auto'},flash:{width:400,height:300,menubar:'bottom',closeButton:'large'},quicktime:{width:480,height:220,autoplay:true,controls:true,closeButton:'large'}}},classids:{quicktime:'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B',flash:'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'},codebases:{quicktime:'http://www.apple.com/qtactivex/qtplugin.cab#version=7,5,5,0',flash:'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0'},errors:{requiresPlugin:"<div class='message'> The content your are attempting to view requires the <span class='type'>#{type}</span> plugin.</div><div class='pluginspage'><p>Please download and install the required plugin from:</p><a href='#{pluginspage}' target='_blank'>#{pluginspage}</a></div>"},mimetypes:{quicktime:'video/quicktime',flash:'application/x-shockwave-flash'},pluginspages:{quicktime:'http://www.apple.com/quicktime/download',flash:'http://www.adobe.com/go/getflashplayer'},typeExtensions:{flash:'swf',image:'bmp gif jpeg jpg png',iframe:'asp aspx cgi cfm htm html jsp php pl php3 php4 php5 phtml rb rhtml shtml txt',quicktime:'avi mov mpg mpeg movie'}};eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(n(){B l=!!19.aq("3y").5T,2G=1m.1Z.2F&&(n(a){B b=u 4A("9b ([\\\\d.]+)").al(a);J b?4J(b[1]):-1})(3b.4T)<7,2C=(1m.1Z.5a&&!19.45),32=3b.4T.24("6r")>-1&&4J(3b.4T.3T(/6r[\\/\\s](\\d+)/)[1])<3,4k=!!3b.4T.3T(/95/i)&&(2C||32);12.1l(Y,{aw:"1.6.1",bn:"1.8.2",R:{1a:"5u",3q:"V"},5x:n(a){m((bo 20[a]=="8M")||(9.5z(20[a].9m)<9.5z(9["8n"+a]))){9O("Y a9 "+a+" >= "+9["8n"+a]);}},5z:n(a){B v=a.2Z(/8w.*|\\./g,"");v=4w(v+"0".bq(4-v.1p));J a.24("8w")>-1?v-1:v},5G:n(){9.5x("1m");m(!!20.11&&!20.6E){9.5x("6E")}m(/^(9L?:\\/\\/|\\/)/.58(9.y.1e)){9.1e=9.y.1e}W{B b=/V(?:-[\\w\\d.]+)?\\.at(.*)/;9.1e=(($$("av[1t]").6N(n(s){J s.1t.3T(b)})||{}).1t||"").2Z(b,"")+9.y.1e}m(!l){m(19.5K>=8&&!19.6Q.3k){19.6Q.bs("3k","bA:bN-bQ-c2:c3","#5R#79")}W{19.1f("5Y:3P",n(){B a=19.9r();a.9B="3k\\\\:*{9I:3Q(#5R#79)}"})}}},60:n(){9.1z=9.y.1z;9.Q=(9.1z>9.y.Q)?9.1z:9.y.Q;9.1I=9.y.1I;9.1R=9.y.1R;9.4E()}});12.1l(Y,{7p:14,2a:n(){B a=3Z.aJ;a.61++;m(a.61==9.7p){$(19.2e).62("V:3P")}}});Y.2a.61=0;12.1l(Y,{4E:n(){9.V=u I("O",{2S:"V"});B d,3G,4N=1P(9.1R);m(2C){9.V.13=n(){9.F("1h:-3C;1b:-3C;1k:1Q;");J 9};9.V.18=n(){9.F("1k:1u");J 9};9.V.1u=n(){J(9.1H("1k")=="1u"&&4J(9.1H("1b").2Z("H",""))>-7K)}}$(19.2e).M(9.2B=u I("O",{2S:"7V"}).F({2Q:9.y.2Q-1,1a:(!(32||2G))?"4r":"35",29:4k?"3Q("+9.1e+"2B.1s) 1b 1h 3A":9.y.2B.29}).1n(4k?1:9.y.2B.1F).13()).M(9.V.F({2Q:9.y.2Q,1b:"-3C",1h:"-3C"}).1n(0).M(9.84=u I("O",{N:"bJ"}).M(9.4b=u I("3z",{N:"c1"}).M(9.8G=u I("1B",{N:"c7"}).F(3G=12.1l({1M:-1*9.1R.E+"H"},4N)).M(9.4Q=u I("O",{N:"6n"}).F(12.1l({1M:9.1R.E+"H"},4N)).M(u I("O",{N:"1D"})))).M(9.8E=u I("1B",{N:"9w"}).F(12.1l({8z:-1*9.1R.E+"H"},4N)).M(9.4O=u I("O",{N:"6n"}).F(3G).M(u I("O",{N:"1D"}))))).M(9.8x=u I("O",{N:"8v"}).M(9.4F=u I("O",{N:"6n 9Q"}).M(9.9S=u I("O",{N:"1D"})))).M(u I("3z",{N:"a8"}).M(u I("1B",{N:"8u ac"}).M(d=u I("O",{N:"ai"}).F({G:9.Q+"H"}).M(u I("3z",{N:"8r ar"}).M(u I("1B",{N:"8i"}).M(u I("O",{N:"2t"})).M(u I("O",{N:"38"}).F({1h:9.Q+"H"})))).M(u I("O",{N:"8h"})).M(u I("3z",{N:"8r az"}).M(u I("1B",{N:"8i"}).F("1N-1b: "+(-1*9.Q)+"H").M(u I("O",{N:"2t"})).M(u I("O",{N:"38"}).F("1h: "+(-1*9.Q)+"H")))))).M(9.4V=u I("1B",{N:"aP"}).F("G: "+(ba-9.Q)+"H").M(u I("O",{N:"bd"}).M(u I("O",{N:"8d"}).F("1N-1b: "+9.Q+"H").M(9.30=u I("O",{N:"bp"}).1n(0).F("3p: 0 "+9.Q+"H").M(9.85=u I("O",{N:"bz 38"})).M(9.1o=u I("O",{N:"bH 80"}).M(9.2c=u I("O",{N:"1D 7X"}).F(1P(9.y.1I.3e)).F({29:9.y.10}).1n(9.y.1A.1F.3f)).M(9.2P=u I("3z",{N:"8L"}).M(9.6b=u I("1B",{N:"94"}).M(9.1C=u I("O",{N:"97"})).M(9.2m=u I("O",{N:"9i"}))).M(9.6a=u I("O",{N:"9n"}).M(9.48=u I("1B",{N:"9u"}).M(u I("O"))).M(9.4Y=u I("1B",{N:"9x"}).M(9.9y=u I("O",{N:"1D"}).1n(9.y.1A.1F.3f).F({10:9.y.10}).1G(9.1e+"9D.1s",{10:9.y.10})).M(9.9E=u I("O",{N:"1D"}).1n(9.y.1A.1F.3f).F({10:9.y.10}).1G(9.1e+"9F.1s",{10:9.y.10}))).M(9.28=u I("1B",{N:"9K"}).M(9.34=u I("O",{N:"1D"}).1n(9.y.1A.1F.3f).F({10:9.y.10}).1G(9.1e+"7I.1s",{10:9.y.10})))))).M(9.7F=u I("O",{N:"9P "}))))).M(9.3v=u I("O",{N:"7E"}).M(9.9Y=u I("O",{N:"1D"}).F("29: 3Q("+9.1e+"3v.64) 1b 1h 4H-3A")))).M(u I("1B",{N:"8u aa"}).M(d.ab(26))).M(9.1V=u I("1B",{N:"aj"}).13().F("1N-1b: "+9.Q+"H; 29: 3Q("+9.1e+"ak.64) 1b 1h 3A"))))).M(u I("O",{2S:"41"}).13());B f=u 2f();f.1w=n(){f.1w=1m.2z;9.1R={E:f.E,G:f.G};B a=1P(9.1R),3G;9.4b.F({1X:0-(f.G/2).2o()+"H",G:f.G+"H"});9.8G.F(3G=12.1l({1M:-1*9.1R.E+"H"},a));9.4Q.F(12.1l({1M:a.E},a));9.8E.F(12.1l({8z:-1*9.1R.E+"H"},a));9.4O.F(3G);9.2a()}.U(9);f.1t=9.1e+"2u.1s";$w("30 1C 2m 48").3W(n(e){9[e].F({10:9.y.10})}.U(9));B g=9.84.2p(".2t");$w("7o 7n bl br").1d(n(a,i){m(9.1z>0){9.5Z(g[i],a)}W{g[i].M(u I("O",{N:"38"}))}g[i].F({E:9.Q+"H",G:9.Q+"H"}).7g("2t"+a.1K());9.2a()}.U(9));9.V.2p(".8h",".38",".8d").3F("F",{10:9.y.10});B S={};$w("2u 1c 2k").1d(n(s){9[s+"3i"].1J=s;B b=9.1e+s+".1s";m(s=="2k"){S[s]=u 2f();S[s].1w=n(){S[s].1w=1m.2z;9.1I[s]={E:S[s].E,G:S[s].G};B a=9.y.1A.2k.1J,27=12.1l({"5Q":a,1X:9.1I[s].G+"H"},1P(9.1I[s]));27["3p"+a.1K()]=9.Q+"H";9[s+"3i"].F(27);9.8x.F({G:S[s].G+"H",1b:-1*9.1I[s].G+"H"});9[s+"3i"].5N().1G(b).F(1P(9.1I[s]));9.2a()}.U(9);S[s].1t=9.1e+s+".1s"}W{9[s+"3i"].1G(b)}},9);B C={};$w("3e 5M").1d(n(a){C[a]=u 2f();C[a].1w=n(){C[a].1w=1m.2z;9.1I[a]={E:C[a].E,G:C[a].G};9.2a()}.U(9);C[a].1t=9.1e+"6T"+a+".1s"},9);B L=u 2f();L.1w=n(){L.1w=1m.2z;9.3v.F({E:L.E+"H",G:L.G+"H",1X:-0.5*L.G+0.5*9.Q+"H",1M:-0.5*L.E+"H"});9.2a()}.U(9);L.1t=9.1e+"3v.64";B h=u 2f();h.1w=n(a){h.1w=1m.2z;B b={E:h.E+"H",G:h.G+"H"};9.28.F(b);9.34.F(b);9.2a()}.U(9);h.1t=9.1e+"6P.1s";$w("2u 1c").1d(n(s){B S=s.1K(),i=u 2f();i.1w=n(){i.1w=1m.2z;9["3r"+S+"3s"].F({E:i.E+"H",G:i.G+"H"});9.2a()}.U(9);i.1t=9.1e+"9o"+s+".1s";9["3r"+S+"3s"].1V=s},9);$w("28 4Y 48").1d(n(c){9[c].13=9[c].13.1v(n(a,b){9.27.1a="35";a(b);J 9});9[c].18=9[c].18.1v(n(a,b){9.27.1a="9v";a(b);J 9})},9);9.V.2p("*").3F("F",{2Q:9.y.2Q+1});9.V.13();9.2a()},6K:n(){11.2J.2I("V").3W(n(e){e.6F()});9.1S=1E;m(9.q.1O()){9.6w=9.6q;m(9.X&&!9.X.1u()){9.X.F("1k:1Q").18();9.3g.1n(0)}}W{9.6w=1E;9.X.13()}m(4w(9.4F.1H("1X"))<9.1I.2k.G){9.5B(2H)}9.8H();9.8y();u 11.1i({R:9.R,1q:n(){$w("1b 3K").1d(n(a){B b=a.1K();9["3E"+b].2n();B c={};9["3E"+b]=u I("O",{N:"ad"+b}).13();c[a]=9["3E"+b];9.30.M(c)}.U(9))}.U(9)});9.5A();9.1j=1E},5y:n(){m(!9.3J||!9.3V){J}9.3V.M({2W:9.3J.F({2q:9.3J.87})});9.3V.2n();9.3V=1E},18:n(b){9.1y=1E;B c=12.7W(b);m(12.7N(b)||c){m(c&&b.3x("#")){9.18({1g:b,y:12.1l({55:26},3Z[1]||{})});J}9.1y=$(b);m(!9.1y){J}9.1y.aW();9.q=9.1y.22||u Y.3N(9.1y)}W{m(b.1g){9.1y=$(19.2e);9.q=u Y.3N(b)}W{m(12.7v(b)){9.1y=9.4j(9.q.1Y)[b];9.q=9.1y.22}}}m(!9.q.1g){J}9.6K();m(9.q.2i()||9.q.1O()){9.7r(9.q.1Y);9.1j=9.5s(9.q.1Y);m(9.q.1O()){9.2s=9.1j.1p>1?9.7e:0;9.2V=9.1j.bK(n(a){J a.2T()})}}9.3R();9.7c();m(9.q.1g!="#41"&&12.70(Y.4u).6W(" ").24(9.q.17)>=0){m(!Y.4u[9.q.17]){$("41").1x(u 4y(9.8U.8V).45({17:9.q.17.1K(),5l:9.5k[9.q.17]}));B d=$("41").2l();9.18({1g:"#41",1C:9.q.17.1K()+" 98 99",y:d});J 2H}}B e=12.1l({1o:"3K",2k:2H,5j:"9h",3X:9.q.2i()&&9.y.1A.3X.2q,5i:9.y.5i,28:(9.q.2i()&&9.y.1A.28.2q)||(9.2V),2A:"1Q",7Z:9.y.2B.9p,33:9.y.33},9.y.9t[9.q.17]||{});9.q.y=12.1l(e,9.q.y);m(9.q.1O()){9.q.y.2k=(9.1j.1p<=1)}m(!(9.q.1C||9.q.2m||(9.1j&&9.1j.1p>1))&&9.q.y.2k){9.q.y.1o=2H}9.1T="3E"+(9.q.y.1o=="1b"?"7M":"7G");m(9.q.2T()){m(!l&&!9.q.7w){9.q.7w=26;B f=u I("3k:2h",{1t:9.q.1g,2q:"9z"}).F("G:5h;E:5h;");$(19.2e).M(f);I.2n.2X(0.1,f)}m(9.q.2i()||9.q.1O()){9.1a=9.1j.24(9.q);9.74()}9.1W=9.q.4P;m(9.1W){9.4G()}W{9.5d();B f=u 2f();f.1w=n(){f.1w=1m.2z;9.4S();9.1W={E:f.E,G:f.G};9.4G()}.U(9);f.1t=9.q.1g}}W{m(9.q.1O()){9.1a=9.1j.24(9.q)}9.1W=9.q.y.6M?19.33.2l():{E:9.q.y.E,G:9.q.y.G};9.4G()}},4U:(n(){n 5c(a,b,c){a=$(a);B d=1P(c);a.1x(u I("82",{2S:"2w",1t:b,a6:"",a7:"4H"}).F(d))}B k=(n(){n 7f(a,b,c){a=$(a);B d=12.1l({"5Q":"1h"},1P(c));B e=u I("3k:2h",{1t:b,2S:"2w"}).F(d);a.1x(e);e.51=e.51}n 6Z(b,c,d){b=$(b);B f=1P(d),2h=u 2f();2h.1w=n(){3y=u I("3y",f);b.1x(3y);4c{B a=3y.5T("2d");a.ah(2h,0,0,d.E,d.G)}4e(e){5c(b,c,d)}}.U(9);2h.1t=c}m(1m.1Z.2F){J 7f}W{J 6Z}})();J n(){B c=9.8a(9.q.1g),2D=9.1S||9.1W;m(9.q.2T()){B d=1P(2D);9[9.1T].F(d);m(9.1S){k(9[9.1T],9.q.1g,2D)}W{5c(9[9.1T],9.q.1g,2D)}}W{m(9.q.5p()){59(9.q.17){2M"4f":B f=12.5f(9.q.y.4f)||{};B g=n(){9.4S();m(9.q.y.55){9[9.1T].F({E:"1L",G:"1L"});9.1W=9.5b(9[9.1T])}u 11.1i({R:9.R,1q:9.52.U(9)})}.U(9);m(f.4Z){f.4Z=f.4Z.1v(n(a,b){g();a(b)})}W{f.4Z=g}9.5d();u aF.aH(9[9.1T],9.q.1g,f);2v;2M"2x":m(9.1S){2D.G-=9.3a.G}9[9.1T].1x(9.2x=u I("2x",{b1:0,b9:0,1t:9.q.1g,2S:"2w",2b:"bc"+(6z.bf()*bg).2o(),6J:(9.q.y&&9.q.y.6J)?"1L":"4H"}).F(12.1l({Q:0,1N:0,3p:0},1P(2D))));2v;2M"4R":B h=9.q.1g,2g=$(h.5e(h.24("#")+1));m(!2g||!2g.47){J}B i=2g.2l();2g.M({by:9.3V=u I(2g.47).13()});2g.87=2g.1H("2q");9.3J=2g.18();9[9.1T].1x(9.3J);9[9.1T].2p("2p, 3t, 5g").1d(n(b){9.44.1d(n(a){m(a.1y==b){b.F({1k:a.1k})}})}.U(9));m(9.q.y.55){9.1W=i;u 11.1i({R:9.R,1q:9.52.U(9)})}2v}}W{B j={1U:"3t",2S:"2w",E:2D.E,G:2D.G};59(9.q.17){2M"40":12.1l(j,{5l:9.5k[9.q.17],3o:[{1U:"2y",2b:"88",2N:9.q.y.88},{1U:"2y",2b:"8k",2N:"8I"},{1U:"2y",2b:"X",2N:9.q.y.6p},{1U:"2y",2b:"9M",2N:26},{1U:"2y",2b:"1t",2N:9.q.1g},{1U:"2y",2b:"6s",2N:9.q.y.6s||2H}]});12.1l(j,1m.1Z.2F?{8N:9.8O[9.q.17],8P:9.8R[9.q.17]}:{2P:9.q.1g,17:9.6t[9.q.17]});2v;2M"3U":12.1l(j,{2P:9.q.1g,17:9.6t[9.q.17],8W:"8X",5j:9.q.y.5j,5l:9.5k[9.q.17],3o:[{1U:"2y",2b:"8Y",2N:9.q.1g},{1U:"2y",2b:"8Z",2N:"26"}]});m(9.q.y.6D){j.3o.3S({1U:"2y",2b:"96",2N:9.q.y.6D})}2v}9[9.1T].F(1P(2D)).1x(9.5m(j)).F("1k:1Q").18();m(9.q.4v()){(n(){4c{m("6O"6S $("2w")){$("2w").6O(9.q.y.6p)}}4e(e){}}.U(9)).9c()}}}}})(),5b:n(b){b=$(b);B d=b.9d(),5n=[],5o=[];d.3S(b);d.1d(n(c){m(c!=b&&c.1u()){J}5n.3S(c);5o.3S({2q:c.1H("2q"),1a:c.1H("1a"),1k:c.1H("1k")});c.F({2q:"9j",1a:"35",1k:"1u"})});B e={E:b.9k,G:b.9l};5n.1d(n(r,a){r.F(5o[a])});J e},4t:n(){B a=$("2w");m(a){59(a.47.4s()){2M"3t":m(1m.1Z.5a&&9.q.4v()){4c{a.71()}4e(e){}a.9q=""}m(a.72){a.2n()}W{a=1m.2z}2v;2M"2x":a.2n();m(1m.1Z.9s&&20.73.2w){5q 20.73.2w}2v;5R:a.2n();2v}}$w("7G 7M").1d(n(S){9["3E"+S].F("E:1L;G:1L;").1x("").13()},9)},77:1m.K,4G:n(){u 11.1i({R:9.R,1q:9.4o.U(9)})},4o:n(){9.3c();m(!9.q.5r()){9.4S()}m(!((9.q.y.55&&9.q.7h())||9.q.5r())){9.52()}m(!9.q.4l()){u 11.1i({R:9.R,1q:9.4U.U(9)})}m(9.q.y.2k){u 11.1i({R:9.R,1q:9.5B.U(9,26)})}},7l:n(){u 11.1i({R:9.R,1q:9.7q.U(9)});m(9.q.4l()){u 11.1i({2X:0.2,R:9.R,1q:9.4U.U(9)})}m(9.3n){u 11.1i({R:9.R,1q:9.7u.U(9)})}m(9.q.4v()||9.q.9J()){u 11.1i({R:9.R,2X:0.1,1q:I.F.U(9,9[9.1T],"1k:1u")})}},2K:n(){m(11.2J.2I(Y.R.3q).5t.1p){J}9.18(9.2O().2K)},1c:n(){m(11.2J.2I(Y.R.3q).5t.1p){J}9.18(9.2O().1c)},52:n(){9.77();B a=9.5v(),2Y=9.7P();m(9.q.y.33&&(a.E>2Y.E||a.G>2Y.G)){m(9.q.y.6M){9.1S=2Y;9.3c();a=2Y}W{B c=9.7S(),b=2Y;m(9.q.4W()){B d=[2Y.G/c.G,2Y.E/c.E,1].a4();9.1S={E:(9.1W.E*d).2o(),G:(9.1W.G*d).2o()}}W{9.1S={E:c.E>b.E?b.E:c.E,G:c.G>b.G?b.G:c.G}}9.3c();a=12.5f(9.1S);m(9.q.4W()){a.G+=9.3a.G}}}W{9.3c();9.1S=1E}9.5w(a)},3I:n(a){9.5w(a,{23:0})},5w:(n(){B e,4L,4K,8c,8e,2s,b;B f=(n(){B w,h;n 4I(p){w=(e.E+p*4L).3L(0);h=(e.G+p*4K).3L(0)}B a;m(2G){a=n(p){9.V.F({E:(e.E+p*4L).3L(0)+"H",G:(e.G+p*4K).3L(0)+"H"});9.4V.F({G:h-1*9.Q+"H"})}}W{m(32){a=n(p){B v=9.4C(),o=19.33.6o();9.V.F({1a:"35",1M:0,1X:0,E:w+"H",G:h+"H",1h:(o[0]+(v.E/2)-(w/2)).3M()+"H",1b:(o[1]+(v.G/2)-(h/2)).3M()+"H"});9.4V.F({G:h-1*9.Q+"H"})}}W{a=n(p){9.V.F({1a:"4r",E:w+"H",G:h+"H",1M:((0-w)/2).2o()+"H",1X:((0-h)/2-2s).2o()+"H"});9.4V.F({G:h-1*9.Q+"H"})}}}J n(p){4I.3w(9,p);a.3w(9,p)}})();J n(a){B c=3Z[1]||{};e=9.V.2l();b=2*9.Q;E=a.E?a.E+b:e.E;G=a.G?a.G+b:e.G;9.5C();m(e.E==E&&e.G==G){u 11.1i({R:9.R,1q:9.5D.U(9,a)});J}B d={E:E+"H",G:G+"H"};4L=E-e.E;4K=G-e.G;8c=4w(9.V.1H("1M").2Z("H",""));8e=4w(9.V.1H("1X").2Z("H",""));2s=9.X.1u()?(9.2s/2):0;m(!2G){12.1l(d,{1M:0-E/2+"H",1X:0-G/2+"H"})}m(c.23==0){f.3w(9,1)}W{9.5E=u 11.6u(9.V,0,1,12.1l({23:9.y.ax,R:9.R,6v:9.y.6v,1q:9.5D.U(9,a)},c),f.U(9))}}})(),5D:n(a){m(!9.3a){J}B b=9[9.1T],4p;m(9.q.y.2A=="1L"){4p=b.2l()}b.F({G:(a.G-9.3a.G)+"H",E:a.E+"H"});m(9.q.y.2A!="1Q"&&(9.q.5r()||9.q.7h())){m(1m.1Z.2F){m(9.q.y.2A=="1L"){B c=b.2l();b.F("2A:1u");B d={6x:"1Q",6y:"1Q"},5F=0,4n=15;m(4p.G>a.G){d.6y="1L";d.E=c.E-4n;d.aX="6A";5F=4n}m(4p.E-5F>a.E){d.6x="1L";d.G=c.G-4n;d.b2="6A"}b.F(d)}W{b.F({2A:9.q.y.2A})}}W{b.F({2A:9.q.y.2A})}}W{b.F("2A:1Q")}9.3R();9.5E=1E;9.7l()},7q:n(){u 11.1i({R:9.R,1q:9.5C.U(9)});u 11.1i({R:9.R,1q:n(){9[9.1T].18();9.3c();m(9.1o.1u()){9.1o.F("1k:1u").1n(1)}}.U(9)});u 11.b6([u 11.6B(9.30,{6C:26,4m:0,57:1}),u 11.53(9.4b,{6C:26})],{R:9.R,23:0.25,1q:n(){m(9.1y){9.1y.62("V:bh")}}.U(9)});m(9.q.2i()||(9.2V&&9.y.X.1A.1J)){u 11.1i({R:9.R,1q:9.6G.U(9)})}},8y:(n(){n 2W(){9.4t();9.4F.F({1X:9.1I.2k.G+"H"});9.5y()}n 6H(p){9.30.1n(p);9.4b.1n(p)}J n(){m(!9.V.1u()){9.30.1n(0);9.4b.1n(0);9.4t();J}u 11.6u(9.V,1,0,{23:0.2,R:9.R,1q:2W.U(9)},6H.U(9))}})(),6I:n(){$w("6a 2P 6b 1C 2m 48 4Y 28 2c").1d(n(a){I.13(9[a])},9);9.1o.F("1k:1Q").1n(0)},3c:n(){9.6I();m(!9.q.y.1o){9.3a={E:0,G:0};9.5H=0;9.1o.13()}W{9.1o.18()}m(9.q.1C||9.q.2m){9.6b.18();9.2P.18()}m(9.q.1C){9.1C.1x(9.q.1C).18()}m(9.q.2m){9.2m.1x(9.q.2m).18()}m(9.1j&&9.1j.1p>1){m(9.q.1O()){9.2r.1x(u 4y(9.y.X.6L).45({1a:9.1a+1,5I:9.1j.1p}));m(9.X.1H("1k")=="1Q"){9.X.F("1k:1u");m(9.5J){11.2J.2I("V").2n(9.5J)}9.5J=u 11.53(9.3g,{R:9.R,23:0.1})}}W{9.2P.18();m(9.q.2T()){9.6a.18();9.48.18().5N().1x(u 4y(9.y.bF).45({1a:9.1a+1,5I:9.1j.1p}));m(9.q.y.28){9.34.18();9.28.18()}}}}B a=9.q.1O();m((9.q.y.3X||a)&&9.1j.1p>1){B b={2u:(9.y.31||9.1a!=0),1c:(9.y.31||((9.q.2i()||a)&&9.2O().1c!=0))};$w("2u 1c").1d(n(z){B Z=z.1K(),3u=b[z]?"6R":"1L";m(a){9["X"+Z].F({3u:3u}).1n(b[z]?1:9.y.1A.1F.5L)}W{9["3r"+Z+"3s"].F({3u:3u}).1n(b[z]?9.y.1A.1F.3f:9.y.1A.1F.5L)}}.U(9));m(9.q.y.3X||9.y.X.3X){9.4Y.18()}}9.3O.1n(9.2V?1:9.y.1A.1F.5L).F({3u:9.2V?"6R":"1L"});9.6U();m(!9.1o.c4().6N(I.1u)){9.1o.13();9.q.y.1o=2H}9.6V()},6U:n(){B a=9.1I.5M.E,3e=9.1I.3e.E,3d=9.1S?9.1S.E:9.1W.E,4D=8J,E=0,2c=9.q.y.2c||"3e",29=9.y.8K;m(9.q.y.2k||9.q.1O()||!9.q.y.2c){29=1E}W{m(3d>=4D+a&&3d<4D+3e){29="5M";E=a}W{m(3d>=4D+3e){29=2c;E=9.1I[2c].E}}}m(E>0){9.2P.18();9.2c.F({E:E+"H"}).18()}W{9.2c.13()}m(29){9.2c.1G(9.1e+"6T"+29+".1s",{10:9.y.10})}9.5H=E},5d:n(){9.5O=u 11.53(9.3v,{23:0.2,4m:0,57:1,R:9.R})},4S:n(){m(9.5O){11.2J.2I("V").2n(9.5O)}u 11.6X(9.3v,{23:0.2,R:9.R,2X:0.2})},6Y:n(){m(!9.q.2T()){J}B a=(9.y.31||9.1a!=0),1c=(9.y.31||((9.q.2i()||9.q.1O())&&9.2O().1c!=0));9.4Q[a?"18":"13"]();9.4O[1c?"18":"13"]();B b=9.1S||9.1W;9.1V.F({G:b.G+"H",1X:9.Q+(9.q.y.1o=="1b"?9.1o.5P():0)+"H"});B c=((b.E/2-1)+9.Q).3M();m(a){9.1V.M(9.3j=u I("O",{N:"1D 8Q"}).F({E:c+"H"}));9.3j.1J="2u"}m(1c){9.1V.M(9.3h=u I("O",{N:"1D 8S"}).F({E:c+"H"}));9.3h.1J="1c"}m(a||1c){9.1V.18()}},6G:n(){m(!9.q||!9.y.1A.1J.2q||!9.q.2T()){J}9.6Y();9.1V.18()},5C:n(){9.1V.1x("").13();9.4Q.13().F({1M:9.1R.E+"H"});9.4O.13().F({1M:-1*9.1R.E+"H"})},7c:(n(){n 2W(){9.V.1n(1)}m(!2C){2W=2W.1v(n(a,b){a(b);9.V.18()})}J n(){m(9.V.1H("1F")!=0){J}m(9.y.2B.2q){u 11.53(9.2B,{23:0.2,4m:0,57:4k?1:9.y.2B.1F,R:9.R,8T:9.5S.U(9),1q:2W.U(9)})}W{2W.3w(9)}}})(),13:n(){m(1m.1Z.2F&&9.2x&&9.q.4l()){9.2x.2n()}m(2C&&9.q.4v()){B a=$$("3t#2w")[0];m(a){4c{a.71()}4e(e){}}}m(9.V.1H("1F")==0){J}9.2j();9.1V.13();m(!1m.1Z.2F||!9.q.4l()){9.30.13()}m(11.2J.2I("5U").5t.1p>0){J}11.2J.2I("V").1d(n(e){e.6F()});u 11.1i({R:9.R,1q:9.5y.U(9)});u 11.6B(9.V,{23:0.1,4m:1,57:0,R:{1a:"5u",3q:"5U"}});u 11.6X(9.2B,{23:0.16,R:{1a:"5u",3q:"5U"},1q:9.75.U(9)})},75:n(){9.4t();9.V.13();9.30.1n(0).18();9.1V.1x("").13();9.85.1x("").13();9.7F.1x("").13();9.5A();9.76();u 11.1i({R:9.R,1q:9.3I.U(9,9.y.90)});u 11.1i({R:9.R,1q:n(){m(9.1y){9.1y.62("V:1Q")}$w("1y 1j q 1S 2V 91 3E").3W(n(a){9[a]=1E}.U(9))}.U(9)})},6V:n(){9.1o.F("3p:0;");B a={},3d=9[(9.1S?"92":"i")+"93"].E;9.1o.F({E:3d+"H"});9.2P.F({E:3d-9.5H-1+"H"});a=9.5b(9.1o);m(9.q.y.1o){a.G+=9.y.5V;59(9.q.y.1o){2M"3K":9.1o.F("3p:"+9.y.5V+"H 0 0 0");2v;2M"1b":9.1o.F("3p: 0 0 "+9.y.5V+"H 0");2v}}9.1o.F({E:"78%"});9.3a=9.q.y.1o?a:{E:a.E,G:0}},3R:(n(){B a,2s;n 4I(){a=9.V.2l();2s=9.X.1u()?(9.2s/2):0}B b;m(2G){b=n(){9.V.F({1b:"50%",1h:"50%"})}}W{m(2C||32){b=n(){B v=9.4C(),o=19.33.6o();9.V.F({1M:0,1X:0,1h:(o[0]+(v.E/2)-(a.E/2)).3M()+"H",1b:(o[1]+(v.G/2)-(a.G/2)).3M()+"H"})}}W{b=n(){9.V.F({1a:"4r",1h:"50%",1b:"50%",1M:(0-a.E/2).2o()+"H",1X:(0-a.G/2-2s).2o()+"H"})}}}J n(){4I.3w(9);b.3w(9)}})(),7a:n(){9.2j();9.3n=26;9.1c.U(9).2X(0.25);9.34.1G(9.1e+"6P.1s",{10:9.y.10}).13();9.3O.1G(9.1e+"7b.1s",{10:9.y.X.10})},2j:n(){m(9.3n){9.3n=2H}m(9.5W){9a(9.5W)}9.34.1G(9.1e+"7I.1s",{10:9.y.10});9.3O.1G(9.1e+"7d.1s",{10:9.y.X.10})},5X:n(){m(9.q.1O()&&!9.2V){J}9[(9.3n?"4X":"60")+"9e"]()},7u:n(){m(9.3n){9.5W=9.1c.U(9).2X(9.y.9f)}},9g:n(){$$("a[2U~=V], 3B[2U~=V]").1d(n(a){B b=a.22;m(!b){J}m(b.3H){a.7i("1C",b.3H)}a.22=1E})},4j:n(a){B b=a.24("][");m(b>-1){a=a.5e(0,b+1)}J $$(\'a[1Y^="\'+a+\'"], 3B[1Y^="\'+a+\'"]\')},5s:n(a){J 9.4j(a).7j("22")},7k:n(){$(19.2e).1f("2L",9.7m.1r(9));$w("2R 3Y").1d(n(e){9.1V.1f(e,n(a){B b=a.3m("O");m(!b){J}m(9.3j&&9.3j==b||9.3h&&9.3h==b){9.54(a)}}.1r(9))}.U(9));9.1V.1f("2L",n(c){B d=c.3m("O");m(!d){J}B e=(9.3j&&9.3j==d)?"2K":(9.3h&&9.3h==d)?"1c":1E;m(e){9[e].1v(n(a,b){9.2j();a(b)}).U(9)()}}.1r(9));$w("2u 1c").1d(n(s){B S=s.1K(),2j=n(a,b){9.2j();a(b)},42=n(a,b){B c=b.1y().1V;m((c=="2u"&&(9.y.31||9.1a!=0))||(c=="1c"&&(9.y.31||((9.q.2i()||9.q.1O())&&9.2O().1c!=0)))){a(b)}};9[s+"3i"].1f("2R",9.54.1r(9)).1f("3Y",9.54.1r(9)).1f("2L",9[s=="1c"?s:"2K"].1v(2j).1r(9));9["3r"+S+"3s"].1f("2L",9[s=="1c"?s:"2K"].1v(42).1v(2j).1r(9)).1f("2R",I.1n.7s(9["3r"+S+"3s"],9.y.1A.1F.7t).1v(42).1r(9)).1f("3Y",I.1n.7s(9["3r"+S+"3s"],9.y.1A.1F.3f).1v(42).1r(9));9["X"+S].1f("2L",9[s=="1c"?s:"2K"].1v(42).1v(2j).1r(9))},9);B f=[9.2c,9.34];m(!2C){f.1d(n(b){b.1f("2R",I.1n.U(9,b,9.y.1A.1F.7t)).1f("3Y",I.1n.U(9,b,9.y.1A.1F.3f))},9)}W{f.3F("1n",1)}9.34.1f("2L",9.5X.1r(9));9.3O.1f("2L",9.5X.1r(9));m(2C||32){B g=n(a,b){m(9.V.1H("1b").63(0)=="-"){J}a(b)};1i.1f(20,"43",9.3R.1v(g).1r(9));1i.1f(20,"3I",9.3R.1v(g).1r(9))}m(32){1i.1f(20,"3I",9.5S.1r(9))}m(2G){n 65(){m(9.X){9.X.F({1h:((19.7x.9A||0)+19.33.7y()/2).2o()+"H"})}}1i.1f(20,"43",65.1r(9));1i.1f(20,"3I",65.1r(9))}m(9.y.9C){9.7z=n(a){B b=a.3m("a[2U~=V], 3B[2U~=V]");m(!b){J}a.4X();m(!b.22){u Y.3N(b)}9.7A(b)}.1r(9);$(19.2e).1f("2R",9.7z)}},5B:n(a){m(9.7B){11.2J.2I("9G").2n(9.9H)}B b={1X:(a?0:9.1I.2k.G)+"H"};9.7B=u 11.7C(9.4F,{27:b,23:0.16,R:9.R,2X:a?0.15:0})},7D:n(){B a={};$w("E G").1d(n(d){B D=d.1K(),4x=19.7x;a[d]=1m.1Z.2F?[4x["66"+D],4x["43"+D]].9N():1m.1Z.5a?19.2e["43"+D]:4x["43"+D]});J a},5S:n(){m(!32){J}9.2B.F(1P(9.7D()))},7m:(n(){B b=".7X, .8v .1D, .7E, .7H";J n(a){m(9.q&&9.q.y&&a.3m(b+(9.q.y.7Z?", #7V":""))){9.13()}}})(),54:n(a){B b=a.2g,1J=b.1J,w=9.1R.E,66=(a.17=="2R")?0:1J=="2u"?w:-1*w,27={1M:66+"H"};m(!9.46){9.46={}}m(9.46[1J]){11.2J.2I("7J"+1J).2n(9.46[1J])}9.46[1J]=u 11.7C(9[1J+"3i"],{27:27,23:0.2,R:{3q:"7J"+1J,9R:1},2X:(a.17=="3Y")?0.1:0})},2O:n(){m(!9.1j){J}B a=9.1a,1p=9.1j.1p;B b=(a<=0)?1p-1:a-1,1c=(a>=1p-1)?0:a+1;J{2K:b,1c:1c}},5Z:n(a,b){B c=3Z[2]||9.y,1z=c.1z,Q=c.Q;1a={1b:(b.63(0)=="t"),1h:(b.63(1)=="l")};m(l){B d=u I("3y",{N:"9T"+b.1K(),E:Q+"H",G:Q+"H"});d.F("5Q:1h");a.M(d);B e=d.5T("2d");e.9U=c.10;e.9V((1a.1h?1z:Q-1z),(1a.1b?1z:Q-1z),1z,0,6z.9W*2,26);e.9X();e.7L((1a.1h?1z:0),0,Q-1z,Q);e.7L(0,(1a.1b?1z:0),Q,Q-1z)}W{B f=u I("3k:9Z",{a0:c.10,a1:"5h",a2:c.10,a3:(1z/Q*0.5).3L(2)}).F({E:2*Q-1+"H",G:2*Q-1+"H",1a:"35",1h:(1a.1h?0:(-1*Q))+"H",1b:(1a.1b?0:(-1*Q))+"H"});a.M(f);f.51=f.51}},8H:(n(){n 67(){J $$("3t, 5g, 2p")}m(1m.1Z.2F&&19.5K>=8){67=n(){J 19.a5("3t, 5g, 2p")}}J n(){m(9.68){J}B a=67();9.44=[];7O(B i=0,1p=a.1p;i<1p;i++){B b=a[i];9.44.3S({1y:b,1k:b.27.1k});b.27.1k="1Q"}9.68=26}})(),76:n(){9.44.1d(n(a,i){a.1y.27.1k=a.1k});5q 9.44;9.68=2H},5v:n(){J{E:9.1W.E,G:9.1W.G+9.3a.G}},7S:n(){B i=9.5v(),b=2*9.Q;J{E:i.E+b,G:i.G+b}},7P:n(){B a=21,69=2*9.1R.G+a,v=9.4C();J{E:v.E-69,G:v.G-69}},4C:n(){B v=19.33.2l();m(9.X&&9.X.1u()&&9.1j&&9.1j.1p>1){v.G-=9.2s}J v}});(n(){n 7Q(a,b){m(!9.q){J}a(b)}$w("3c 4U").1d(n(a){9[a]=9[a].1v(7Q)},Y)})();n 1P(b){B c={};12.70(b).1d(n(a){c[a]=b[a]+"H"});J c}12.1l(Y,{7R:n(){m(!9.q.y.5i){J}9.4M=9.7T.1r(9);19.1f("7U",9.4M)},5A:n(){m(9.4M){19.ae("7U",9.4M)}},7T:n(a){B b=af.ag(a.2E).4s(),2E=a.2E,3D=(9.q.2i()||9.2V)&&!9.5E,28=9.q.y.28,49;m(9.q.4W()){a.4X();49=(2E==1i.7Y||["x","c"].6c(b))?"13":(2E==37&&3D&&(9.y.31||9.1a!=0))?"2K":(2E==39&&3D&&(9.y.31||9.2O().1c!=0))?"1c":(b=="p"&&28&&3D)?"7a":(b=="s"&&28&&3D)?"2j":1E;m(b!="s"){9.2j()}}W{49=(2E==1i.7Y)?"13":1E}m(49){9[49]()}m(3D){m(2E==1i.am&&9.1j.an()!=9.q){9.18(0)}m(2E==1i.ao&&9.1j.ap()!=9.q){9.18(9.1j.1p-1)}}}});Y.4o=Y.4o.1v(n(a,b){9.7R();a(b)});12.1l(Y,{7r:n(a){B b=9.4j(a);m(!b){J}b.3W(Y.4a)},74:n(){m(9.1j.1p==0){J}B a=9.2O();9.81([a.1c,a.2K])},81:n(c){B d=(9.1j&&9.1j.6c(c)||12.as(c))?9.1j:c.1Y?9.5s(c.1Y):1E;m(!d){J}B e=$A(12.7v(c)?[c]:c.17?[d.24(c)]:c).au();e.1d(n(a){B b=d[a];9.6d(b)},9)},83:n(a,b){a.4P={E:b.E,G:b.G}},6d:n(a){m(a.4P||a.4B||!a.1g){J}B P=u 2f();P.1w=n(){P.1w=1m.2z;a.4B=1E;9.83(a,P)}.U(9);a.4B=26;P.1t=a.1g},7A:n(a){B b=a.22;m(b&&b.4P||b.4B||!b.2T()){J}9.6d(b)}});I.ay({1G:n(a,b){a=$(a);B c=12.1l({86:"1b 1h",3A:"4H-3A",6e:"8k",10:""},3Z[2]||{});a.F(2G?{aA:"aB:aC.aD.aE(1t=\'"+b+"\'\', 6e=\'"+c.6e+"\')"}:{29:c.10+" 3Q("+b+") "+c.86+" "+c.3A});J a}});12.1l(Y,{6f:n(a,b){B c;$w("3U 2h 2x 40").1d(n(t){m(u 4A("\\\\.("+9.aG[t].2Z(/\\s+/g,"|")+")(\\\\?.*)?","i").58(a)){c=t}}.U(9));m(c){J c}m(a.3x("#")){J"4R"}m(19.89&&19.89!=(a).2Z(/(^.*\\/\\/)|(:.*)|(\\/.*)/g,"")){J"2x"}J"2h"},8a:n(a){B b=a.aI(/\\?.*/,"").3T(/\\.([^.]{3,4})$/);J b?b[1]:1E},5m:n(b){B c="<"+b.1U;7O(B d 6S b){m(!["3o","6g","1U"].6c(d)){c+=" "+d+\'="\'+b[d]+\'"\'}}m(u 4A("^(?:3B|aK|aL|br|aM|aN|aO|82|8b|aQ|aR|aS|2y|aT|aU|aV)$","i").58(b.1U)){c+="/>"}W{c+=">";m(b.3o){b.3o.1d(n(a){c+=9.5m(a)}.U(9))}m(b.6g){c+=b.6g}c+="</"+b.1U+">"}J c}});(n(){19.1f("5Y:3P",n(){B c=(3b.6h&&3b.6h.1p);n 4d(a){B b=2H;m(c){b=($A(3b.6h).7j("2b").6W(",").24(a)>=0)}W{4c{b=u aY(a)}4e(e){}}J!!b}m(c){20.Y.4u={3U:4d("aZ b0"),40:4d("6i")}}W{20.Y.4u={3U:4d("8f.8f"),40:4d("6i.6i")}}})})();Y.3N=b3.b4({b5:n(b){m(b.22){J}B c=12.7N(b);m(c&&!b.22){b.22=9;m(b.1C){b.22.3H=b.1C;m(Y.y.8g){b.b7("1C","")}}}9.1g=c?b.b8("1g"):b.1g;m(9.1g.24("#")>=0){9.1g=9.1g.5e(9.1g.24("#"))}B d=b.1Y;m(d){9.1Y=d;m(d.3x("4g")){9.17="4g"}W{m(d.3x("56")){m(d.bb("][")){B e=d.8j("]["),6j=e[1].3T(/([a-be-Z]*)/)[1];m(6j){9.17=6j;B f=e[0]+"]";b.7i("1Y",f);9.1Y=f}}W{9.17=Y.6f(9.1g)}}W{9.17=d}}}W{9.17=Y.6f(9.1g);9.1Y=9.17}$w("4f 3U 4g 2x 2h 4R 40 8l 8m 56").3W(n(a){B T=a.1K(),t=a.4s();m("2h 4g 8m 8l 56".24(a)<0){9["bi"+T]=n(){J 9.17==t}.U(9)}}.U(9));m(c&&b.22.3H){B g=b.22.3H.8j(Y.y.bj).3F("bk");m(g[0]){9.1C=g[0]}m(g[1]){9.2m=g[1]}B h=g[2];9.y=(h&&12.7W(h))?bm("({"+h+"})"):{}}W{9.1C=b.1C;9.2m=b.2m;9.y=b.y||{}}m(9.y.6k){9.y.4f=12.5f(9.y.6k);5q 9.y.6k}},2i:n(){J 9.17.3x("4g")},1O:n(){J 9.1Y.3x("56")},2T:n(){J(9.2i()||9.17=="2h")},5p:n(){J"2x 4R 4f".24(9.17)>=0},4W:n(){J!9.5p()}});Y.4a=n(a){B b=$(a);u Y.3N(a);J b};(n(){n 8o(a){B b=a.3m("a[2U~=V], 3B[2U~=V]");m(!b){J}a.4X();9.4a(b);9.18(b)}n 8p(a){B b=a.3m("a[2U~=V], 3B[2U~=V]");m(!b){J}9.4a(b)}n 8q(a){B b=a.2g,17=a.17,36=a.36;m(36&&36.47){m(17==="5G"||17==="bt"||(17==="2L"&&36.47.4s()==="8b"&&36.17==="bu")){b=36}}m(b.bv==bw.bx){b=b.72}J b}n 8s(a,b){m(!a){J}B c=a.N;J(c.1p>0&&(c==b||u 4A("(^|\\\\s)"+b+"(\\\\s|$)").58(c)))}n 8t(a){B b=8q(a);m(b&&8s(b,"V")){9.4a(b)}}19.1f("V:3P",n(){$(19.2e).1f("2L",8o.1r(Y));m(Y.y.8g&&1m.1Z.2F&&19.5K>=8){$(19.2e).1f("2R",8t.1r(Y))}W{$(19.2e).1f("2R",8p.1r(Y))}})})();12.1l(Y,{4z:n(){B b=9.y.X,Q=b.Q;$(19.2e).M(9.X=u I("O",{2S:"bB"}).F({2Q:9.y.2Q+1,bC:b.1N+"H",1a:"35",1k:"1Q"}).M(9.bD=u I("O",{N:"bE"}).M(u I("O",{N:"4q bG"}).F("1N-1h: "+Q+"H").M(u I("O",{N:"2t"}))).M(u I("O",{N:"6l"}).F({1N:"0 "+Q+"H",G:Q+"H"})).M(u I("O",{N:"4q bI"}).F("1N-1h: -"+Q+"H").M(u I("O",{N:"2t"})))).M(9.3l=u I("O",{N:"6m 80"}).M(9.3g=u I("3z",{N:"bL"}).F("1N: 0 "+Q+"H").M(u I("1B",{N:"bM"}).M(9.2r=u I("O"))).M(u I("1B",{N:"4h bO"}).M(9.bP=u I("O",{N:"1D"}).1G(9.1e+"8A.1s",{10:b.10}))).M(u I("1B",{N:"4h bR"}).M(9.bS=u I("O",{N:"1D"}).1G(9.1e+"bT.1s",{10:b.10}))).M(u I("1B",{N:"4h bU"}).M(9.3O=u I("O",{N:"1D"}).1G(9.1e+"7d.1s",{10:b.10}))).M(u I("1B",{N:"4h 7H"}).M(9.bV=u I("O",{N:"1D"}).1G(9.1e+"bW.1s",{10:b.10}))))).M(9.bX=u I("O",{N:"bY"}).M(u I("O",{N:"4q bZ"}).F("1N-1h: "+Q+"H").M(u I("O",{N:"2t"}))).M(u I("O",{N:"6l"}).F({1N:"0 "+Q+"H",G:Q+"H"})).M(u I("O",{N:"4q c0"}).F("1N-1h: -"+Q+"H").M(u I("O",{N:"2t"})))));$w("2u 1c").1d(n(s){B S=s.1K();9["X"+S].1V=s},9);m(2C){9.X.13=n(){9.F("1h:-3C;1b:-3C;1k:1Q;");J 9};9.X.18=n(){9.F("1k:1u");J 9};9.X.1u=n(){J(9.1H("1k")=="1u"&&4J(9.1H("1b").2Z("H",""))>-7K)}}9.X.2p(".4h O").3F("F",1P(9.8B));B c=9.X.2p(".2t");$w("7o 7n bl br").1d(n(a,i){m(b.1z>0){9.5Z(c[i],a,b)}W{c[i].M(u I("O",{N:"38"}))}c[i].F({E:b.Q+"H",G:b.Q+"H"}).7g("2t"+a.1K())},9);9.X.5N(".6m").F("E:78%;");9.X.F(2G?{1a:"35",1b:"1L",1h:""}:{1a:"4r",1b:"1L",1h:"50%"});9.X.2p(".6l",".6m",".1D",".38").3F("F",{10:b.10});9.2r.1x(u 4y(b.6L).45({1a:8C,5I:8C}));9.2r.F({E:9.2r.7y()+"H",G:9.3g.5P()+"H"});9.8D();9.2r.1x("");9.X.13().F("1k:1u");9.7k();9.2a()},8D:n(){B b,4i,X=9.y.X,Q=X.Q;m(2G){b=9.3g.2l(),4i=b.E+2*Q;9.3g.F({E:b.E+"H",1N:0});9.3l.F("E:1L;");9.3g.F({c5:Q+"H"});9.3l.F({E:4i+"H"});$w("1b 3K").1d(n(a){9["X"+a.1K()].F({E:4i+"H"})},9);9.X.F("1N-1h:-"+(4i/2).2o()+"H")}W{9.3l.F("E:1L");b=9.3l.2l();9.2r.c6().F({8F:b.G+"H",E:9.2r.2l().E+"H"});9.X.F({E:b.E+"H",1M:(0-(b.E/2).2o())+"H"});9.3l.F({E:b.E+"H"});$w("1b 3K").1d(n(a){9["X"+a.1K()].F({E:b.E+"H"})},9)}9.7e=X.1N+b.G+2*Q;9.6q=9.X.5P();9.2r.F({8F:b.G+"H"})}});Y.4z=Y.4z.1v(n(a,b){B c=u 2f();c.1w=n(){c.1w=1m.2z;9.8B={E:c.E,G:c.G};a(b)}.U(9);c.1t=9.1e+"8A.1s";B d=(u 2f()).1t=9.1e+"7b.1s"});Y.4E=Y.4E.1v(n(a,b){a(b);9.4z()});Y.13=Y.13.1v(n(a,b){m(9.q&&9.q.1O()){9.X.13();9.2r.1x("")}a(b)})})();Y.5G();19.1f("5Y:3P",Y.60.U(Y));',62,752,'|||||||||this|||||||||||||if|function|||view||||new||||options|||var|||width|setStyle|height|px|Element|return|||insert|className|div||border|queue|||bind|lightview|else|controller|Lightview||backgroundColor|Effect|Object|hide||||type|show|document|position|top|next|each|images|observe|href|left|Event|views|visibility|extend|Prototype|setOpacity|menubar|length|afterFinish|bindAsEventListener|png|src|visible|wrap|onload|update|element|radius|buttons|li|title|lv_Button|null|opacity|setPngBackground|getStyle|closeDimensions|side|capitalize|auto|marginLeft|margin|isSet|pixelClone|hidden|sideDimensions|scaledInnerDimensions|_contentPosition|tag|prevnext|innerDimensions|marginTop|rel|Browser|window||_view|duration|indexOf||true|style|slideshow|background|_lightviewLoadedEvent|name|closeButton||body|Image|target|image|isGallery|stopSlideshow|topclose|getDimensions|caption|remove|round|select|display|setNumber|controllerOffset|lv_Corner|prev|break|lightviewContent|iframe|param|emptyFunction|overflow|overlay|BROWSER_IS_WEBKIT_419|dimensions|keyCode|IE|BROWSER_IS_IE_LT7|false|get|Queues|previous|click|case|value|getSurroundingIndexes|data|zIndex|mouseover|id|isImage|class|isSetGallery|after|delay|bounds|replace|center|cyclic|BROWSER_IS_FIREFOX_LT3|viewport|slideshowButton|absolute|currentTarget||lv_Fill||menubarDimensions|navigator|fillMenuBar|imgWidth|large|normal|controllerCenter|nextButton|ButtonImage|prevButton|ns_vml|controllerMiddle|findElement|sliding|children|padding|scope|inner|Button|object|cursor|loading|call|startsWith|canvas|ul|repeat|area|9500px|staticGallery|content|invoke|sideNegativeMargin|_title|resize|inlineContent|bottom|toFixed|floor|View|controllerSlideshow|loaded|url|restoreCenter|push|match|flash|inlineMarker|_each|innerPreviousNext|mouseout|arguments|quicktime|lightviewError|blockInnerPrevNext|scroll|overlappingRestore|evaluate|sideEffect|tagName|imgNumber|action|Extend|sideButtons|try|detectPlugin|catch|ajax|gallery|lv_ButtonWrapper|finalWidth|getSet|FIX_OVERLAY_WITH_PNG|isIframe|from|scrollbarWidth|afterShow|contentDimensions|lv_controllerCornerWrapper|fixed|toLowerCase|clearContent|Plugin|isQuicktime|parseInt|ddE|Template|buildController|RegExp|isPreloading|getViewportDimensions|minimum|build|topcloseButtonImage|afterEffect|no|init|parseFloat|hdiff|wdiff|keyboardEvent|sideStyle|nextButtonImage|preloadedDimensions|prevButtonImage|inline|stopLoading|userAgent|insertContent|resizeCenter|isMedia|stop|innerPrevNext|onComplete||outerHTML|resizeWithinViewport|Appear|toggleSideButton|autosize|set|to|test|switch|WebKit|getHiddenDimensions|insertImageUsingHTML|startLoading|substr|clone|embed|1px|keyboard|wmode|pluginspages|pluginspage|createHTML|restore|styles|isExternal|delete|isAjax|getViews|effects|end|getInnerDimensions|_resize|require|restoreInlineContent|convertVersionString|disableKeyboardNavigation|toggleTopClose|hidePrevNext|_afterResize|resizing|corrected|load|closeButtonWidth|total|_controllerCenterEffect|documentMode|disabled|small|down|loadingEffect|getHeight|float|default|maxOverlay|getContext|lightview_hide|menubarPadding|slideTimer|toggleSlideshow|dom|createCorner|start|counter|fire|charAt|gif|centerControllerIELT7|offset|getOverlappingElements|preventingOverlap|safety|innerController|dataText|member|preloadImageDimensions|sizingMethod|detectType|html|plugins|QuickTime|relType|ajaxOptions|lv_controllerBetweenCorners|lv_controllerMiddle|lv_Wrapper|getScrollOffsets|controls|_controllerHeight|Firefox|loop|mimetypes|Tween|transition|controllerHeight|overflowX|overflowY|Math|15px|Opacity|sync|flashvars|Scriptaculous|cancel|showPrevNext|tween|hideData|scrolling|prepare|setNumberTemplate|fullscreen|find|SetControllerVisible|inner_slideshow_stop|namespaces|pointer|in|close_|setCloseButtons|setMenubarDimensions|join|Fade|setPrevNext|insertImageUsingCanvas|keys|Stop|parentNode|frames|preloadSurroundingImages|afterHide|showOverlapping|adjustDimensionsToView|100|VML|startSlideshow|controller_slideshow_stop|appear|controller_slideshow_play|_controllerOffset|insertImageUsingVML|addClassName|isInline|writeAttribute|pluck|addObservers|finishShow|delegateClose|tr|tl|_lightviewLoadedEvents|showContent|extendSet|curry|hover|nextSlide|isNumber|_VMLPreloaded|documentElement|getWidth|_preloadImageHover|preloadImageHover|_topCloseEffect|Morph|getScrollDimensions|lv_Loading|contentBottom|Top|lv_controllerClose|inner_slideshow_play|lightview_side|9500|fillRect|Bottom|isElement|for|getBounds|guard|enableKeyboardNavigation|getOuterDimensions|keyboardDown|keydown|lv_overlay|isString|lv_Close|KEY_ESC|overlayClose|clearfix|preloadFromSet|img|setPreloadedDimensions|container|contentTop|align|_inlineDisplayRestore|autoplay|domain|detectExtension|input|mleft|lv_WrapDown|mtop|ShockwaveFlash|removeTitles|lv_Filler|lv_CornerWrapper|split|scale|external|media|REQUIRED_|handleClick|handleMouseOver|elementIE8|lv_Half|hasClassNameIE8|handleMouseOverIE8|lv_Frame|lv_topButtons|_|topButtons|hideContent|marginRight|controller_prev|controllerButtonDimensions|999|_fixateController|nextSide|lineHeight|prevSide|hideOverlapping|tofit|180|borderColor|lv_Data|undefined|codebase|codebases|classid|lv_PrevButton|classids|lv_NextButton|beforeStart|errors|requiresPlugin|quality|high|movie|allowFullScreen|startDimensions|_openEffect|scaledI|nnerDimensions|lv_DataText|mac|FlashVars|lv_Title|plugin|required|clearTimeout|MSIE|defer|ancestors|Slideshow|slideshowDelay|updateViews|transparent|lv_Caption|block|clientWidth|clientHeight|Version|lv_innerController|inner_|close|innerHTML|createStyleSheet|Gecko|defaultOptions|lv_ImgNumber|relative|lv_NextSide|lv_innerPrevNext|innerPrevButton|none|scrollLeft|cssText|preloadHover|inner_prev|innerNextButton|inner_next|lightview_topCloseEffect|topCloseEffect|behavior|isFlash|lv_Slideshow|https|enablejavascript|max|throw|lv_contentBottom|lv_topcloseButtonImage|limit|topcloseButton|cornerCanvas|fillStyle|arc|PI|fill|loadingButton|roundrect|fillcolor|strokeWeight|strokeColor|arcSize|min|querySelectorAll|alt|galleryimg|lv_Frames|requires|lv_FrameBottom|cloneNode|lv_FrameTop|lv_content|stopObserving|String|fromCharCode|drawImage|lv_Liquid|lv_PrevNext|blank|exec|KEY_HOME|first|KEY_END|last|createElement|lv_HalfLeft|isArray|js|uniq|script|REQUIRED_Prototype|resizeDuration|addMethods|lv_HalfRight|filter|progid|DXImageTransform|Microsoft|AlphaImageLoader|Ajax|typeExtensions|Updater|gsub|callee|base|basefont|col|frame|hr|lv_Center|link|isindex|meta|range|spacer|wbr|blur|paddingRight|ActiveXObject|Shockwave|Flash|frameBorder|paddingBottom|Class|create|initialize|Parallel|setAttribute|getAttribute|hspace|150|include|lightviewContent_|lv_WrapUp|zA|random|99999|opened|is|titleSplit|strip||eval|REQUIRED_Scriptaculous|typeof|lv_WrapCenter|times||add|error|radio|nodeType|Node|TEXT_NODE|before|lv_contentTop|urn|lightviewController|marginBottom|controllerTop|lv_controllerTop|imgNumberTemplate|lv_controllerCornerWrapperTopLeft|lv_MenuBar|lv_controllerCornerWrapperTopRight|lv_Container|all|lv_controllerCenter|lv_controllerSetNumber|schemas|lv_controllerPrev|controllerPrev|microsoft|lv_controllerNext|controllerNext|controller_next|lv_controllerSlideshow|controllerClose|controller_close|controllerBottom|lv_controllerBottom|lv_controllerCornerWrapperBottomLeft|lv_controllerCornerWrapperBottomRight|lv_Sides|com|vml|childElements|paddingLeft|up|lv_PrevSide'.split('|'),0,{}));