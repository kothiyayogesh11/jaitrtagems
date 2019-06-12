/* This script help to display error or success message */
var site = {};

site.errorShowSeconds = 15000;
site.errorElement = "#site-message";
site.tempElement = "";
site.successHtml = function(message){
    html = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="addedRoleMsg">';
    html += message;
    html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    html += '</div>';
    return html;
}

site.errorHtml = function(message){
    html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    html += message;
    html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    html += '</div>';
    return html;
}

site.message = function(message,type){
    message = typeof message != "undefined" && jQuery.trim(message) != "" ? message : "Success!";
    type    = typeof type != "undefined" && jQuery.trim(type) != "" ? type : 1;
    if(type == 1) var html = this.successHtml(message);
    else var html = this.errorHtml(message);
    if(this.tempElement != ""){
        $(this.tempElement).html(html);
        this.tempElement = "";
    }else{
        $(this.errorElement).html(html);
    }
    window.setTimeout(function(){
        $(site.errorElement).html("");
        this.tempElement = "";
    },this.errorShowSeconds);
}