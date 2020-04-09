jQuery(document).ready(function($){
  var myOptions = {
      // you can declare a default color here,
      // or in the data-default-color attribute on the input
      defaultColor: false,
      // a callback to fire whenever the color changes to a valid color
      change: function(event, ui){},
      // a callback to fire when the input is emptied or an invalid color
      clear: function() {},
      // hide the color picker controls on load
      hide: true,
      // show a group of common colors beneath the square
      // or, supply an array of colors to customize further
      palettes: true
  };

  $('.my-color-field').wpColorPicker(myOptions);


  $('#logo_file_button').click(function() {

    var send_attachment_bkp = wp.media.editor.send.attachment;

    wp.media.editor.send.attachment = function(props, attachment) {
      $('#logo_file').val(attachment.url);
      $('#meta-image-preview').attr('src',attachment.url);
      $('#meta-image-preview').text(attachment.url);
      wp.media.editor.send.attachment = send_attachment_bkp;
    }

    wp.media.editor.open();
    return false;
  }); // End on click


  $('#remove_logo_file').click(function() {
      $('#logo_file').attr('value', '');
      $('#meta-image-preview').attr('src','');
  });

  var editor = CodeMirror.fromTextArea(document.getElementById("themes_js"), {
    lineNumbers: true,
    styleActiveLine: true,
    matchBrackets: true,
    theme: 'material',
  });


  var cssEditor = CodeMirror.fromTextArea(document.getElementById("themes_css"), {
  	lineNumbers: true,
  	mode: 'css',
  	theme: 'material',
  });


  var mixedMode = {
    name: "htmlmixed",
    scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                   mode: null},
                  {matches: /(text|application)\/(x-)?vb(a|script)/i,
                   mode: "vbscript"}]
  };
  var editor = CodeMirror.fromTextArea(document.getElementById("themes_analytics"), {
    mode: mixedMode,
    tabMode: "indent",
    lineNumbers: true,
    theme: 'material',
  });

});
