/*
  StilusChecker.js
  Main javascript functionality.
  Bind openPost() function to the stilus button to perform the post to mystylus API.
*/

jQuery(document).ready(function ($){
    jQuery("#stilusButton").on('click', openPost);
    UpdateButtonStatus("");  // Update status enabled|disabled of the stilus button
    // And update when we change the editor
    jQuery("#content-tmce").on('click', function(){UpdateButtonStatus("tmce");});
    jQuery("#content-html").on('click', function(){UpdateButtonStatus("html");});
});

/*
 * OnClick function which launch the request
 */
function openPost(){
    if(visualEditorIsOpen()){
        var content = getWordPressEditorContent();

        var css = getWordPressCssHeader();
        var htmlHeader = "<!DOCTYPE html><html><head><meta charset='UTF-8'>";

        var id = 'st_PostForm'+Math.floor(Math.random()*1001);
        document.getElementById('st_PostForm').target = id;
        //document.getElementById('st_txt').value = content; //simple version
        document.getElementById('st_txt').value = htmlHeader + css + "<body>" + content + "</body></html>"; //with css included
        popup(st_popupUrl, 1100, 700, id); //popupUrl var comes form php
    }
} //openPost

var realTitle = "";
function UpdateButtonStatus(clicked){
    if((!visualEditorIsOpen() || clicked == "html")&& !jQuery("#stilusButton").hasClass('disabled')){
        realTitle = jQuery("#stilusButton").attr('title');
        jQuery("#stilusButton").addClass('disabled');
        jQuery("#stilusButton").attr('onclick', "event.preventDefault();alert('"+st_plainTextEditorAlert+"')");
        jQuery("#stilusButton").attr('title', st_plainTextEditorAlert);
    }
    else if((visualEditorIsOpen() || clicked == "tmce") && jQuery("#stilusButton").hasClass('disabled')){
        jQuery("#stilusButton").removeClass('disabled');
        jQuery("#stilusButton").attr('onclick', "event.preventDefault();");
        jQuery("#stilusButton").attr('title', realTitle);
    }
}
/***  Aux functions ***/

function popup(url,w,h,id) {
    var winl=(screen.width-w)/2;
    var wint=(screen.height-h)/2;
    var page=(window.open(url,id,
              "marginheight=no,marginwidth=no,menubar=no,toolbar=no,status=yes,scrollbars=yes,resizable=yes,"
              +"width="+w+",height="+h+",top="+wint+",left="+winl));
    if(parseInt(navigator.appVersion)>=4) page.window.focus();
}

function visualEditorIsOpen(){
    return jQuery("#wp-content-wrap").hasClass('tmce-active');
}

function openVisualEditor(){
    jQuery("#content-tmce").click();
}

function getWordPressEditorContent(){
    return jQuery("#content_ifr").contents().find("#tinymce")[0].innerHTML;
}

function getWordPressEditorCss(){
    return jQuery("#content_ifr").contents().find("#mceDefaultStyles")[0].innerHTML;
}

function getWordPressCssHeader(){
    return    "<head><style id='mceDefaultStyles' type='text/css'>" +
              getWordPressEditorCss() +
              "</style></head>";
}
