var loader = {};
loader.element = null;
loader.container = '<div id="loader-wraper"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
loader.set = function(el){
    this.element = el;
    //$(this.element).css("overflow","hidden");
    $(this.element).append(this.container);

}

loader.remove = function(){
    //$(this.element).css("overflow","");
    $("#loader-wraper").remove();
}

/* site = {};
site.message.element = "#site-error";
site.message.set = function(message, type, element){
    type = typeof type != "undefined" || type !== "" ? type : 1;
    if(type == 1){
        //this.message.
    }else{

    }
}

site.message.error = function(message){

} */
