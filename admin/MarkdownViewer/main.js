// class Ht extends HTMLElement{
//     constructor(){
//         super()
//         //this.style="span{color:red;}"
        
//     }
//     connectedCallback(){
//         setTimeout(() => {
//             //this.innerHTML = "<span>" + this.innerHTML + "</span>";
//           }, 0);
        
        
//     }

// }
// customElements.define("md-ht1",Ht)
// customElements.define("md-ht2",Ht)
// customElements.define("md-ht3",Ht)
// customElements.define("md-ht4",Ht)
// customElements.define("md-ht5",Ht)
// customElements.define("md-ht6",Ht)
// var markdownContent=`# 一级标题

// ## 二级标题

// ### 三级标题

// #### 四级标题

// > 引用一下
// > 
// >> 11111
// >> 
// >>> 11111

// 有些步骤：

// 1. 吃饭
// 2. 睡觉
// 3. 起床

// 吃什么：

// - 水果
// - 蔬菜

// 需要做的：

// - [ ] 接水

// - [ ] 吃饭

// 代码：

// **123**
// *456*
// 1234567==123456==134534643
// <u>xs1</u>
// `

// window.onload=function(){
//     document.body.innerHTML=markdownContent
//     console.log(markdownContent)
// }


class MdTag{
    constructor(tagName,Reg,copyTag){
        this.tagName=tagName
        this.Reg=Reg
        this.copyTag=copyTag
    }
}

var mdTags=[
    new MdTag("md-ht1",/^#\s(.*)$/gm,"# "),
    new MdTag("md-ht2",/^##\s(.*)$/gm,"## "),
    new MdTag("md-ht3",/^###\s(.*)$/gm,"### "),
    new MdTag("md-ht4",/^####\s(.*)$/gm,"#### "),
    new MdTag("md-ht5",/^#####\s(.*)$/gm,"##### "),
    new MdTag("md-ht6",/^######\s(.*)$/gm,"###### "),

]



function action(){
    var tagEle=document.getElementById('main')
    var show=document.getElementById('show')
    var markdownContent=tagEle.innerText

    mdTags.forEach(tag => {
        markdownContent = markdownContent.replace(tag.Reg ,`<${tag.tagName}>$1</${tag.tagName}>`)
    });

// markdownContent = markdownContent.replace(/^#\s(.*)$/gm ,"<md-ht n='1'>$1</md-ht>")
// markdownContent = markdownContent.replace(/^##\s(.*)$/gm ,"<md-ht n='2'>$1</md-ht>")
// markdownContent = markdownContent.replace(/^###\s(.*)$/gm ,"<md-ht n='3'>$1</md-ht>")
// markdownContent = markdownContent.replace(/^####\s(.*)$/gm ,"<md-ht n='4'>$1</md-ht>")
// markdownContent = markdownContent.replace(/^#####\s(.*)$/gm ,"<md-ht n='5'>$1</md-ht>")
// markdownContent = markdownContent.replace(/^######\s(.*)$/gm ,"<md-ht n='6'>$1</md-ht>")
markdownContent = markdownContent.replace(/^>\s(.*)$/gm ,"<md-q>$1</md-q>")
markdownContent = markdownContent.replace(/^>>\s(.*)$/gm ,"<md-q><md-q>$1</md-q></md-q>")
markdownContent = markdownContent.replace(/^>>>\s(.*)$/gm ,"<md-q><md-q><md-q>$1</md-q></md-q></md-q>")
markdownContent = markdownContent.replace(/\n/gm ,'<br/>')
markdownContent = markdownContent.replace(/__(.*)__/gm,'<strong>$1</strong>') ;
markdownContent = markdownContent.replace(/\*\*(.*)\*\*/gm,'<strong>$1</strong>') ;

markdownContent = markdownContent.replace(/\*(.*)\*/gm,'<em>$1</em>') ;
markdownContent = markdownContent.replace(/_(.*)_/gm,'<em>$1</em>') ;
markdownContent = markdownContent.replace(/~~(.*)~~/gm, '<del>$1</del>');
markdownContent = markdownContent.replace(/==(.*)==/gm,'<marked>$1</marked>') ;

// 处理链接和图片
markdownContent = markdownContent.replace(/!\[(.*?)\]\((.*?)\)/gm, '<img src="$2" alt="$1">');
markdownContent = markdownContent.replace(/\[(.*?)\]\((.*?)\)/gm, '<a href="$2" rel="external nofollow" >$1</a>');


// 处理行内代码和代码块
markdownContent = markdownContent.replace(/`(.*?)`/gm, '<code>$1</code>');
markdownContent = markdownContent.replace(/```([\s\S]*?)```/gm, '<pre>$1</pre>');


show.innerHTML=markdownContent
}
window.onload=function(){
    // var show=document.getElementById('show')
    var editableDiv=document.getElementById('main')
    editableDiv.addEventListener('input', action);
    action()
}

// var markdownContent=""
// action()