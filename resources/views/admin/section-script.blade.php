<div id="prompt">
    <div class="prompt-background"></div>
    <div class="prompt-dialog">
        <div class="prompt-message">
            <p><b>Insérer un lien</b></p>
        </div>
        <form class="prompt-form">
            <p>Titre</p>
            <input id="btnedit-title" type="text" style="display: block; width: 80%; margin-right: auto; margin-left: auto;"><br/>
            <p>Lien (http://example.com/)</p>
            <input id="btnedit-url" type="text" style="display: block; width: 80%; margin-right: auto; margin-left: auto;"><br/>
            <button id="btnedit-ok" class="btn-orange" onClick="$('#prompt').show();">OK</button>
            <button id="btnedit-cancel" class="btn-orange" onClick="$('#prompt').hide();">Annuler</button>
        </form>
    </div>
</div>

<style>
    .prompt-background {
        position: absolute;
        top: 0px;
        z-index: 1000;
        opacity: 0.5;
        height: 100%;
        left: 0px;
        width: 100%;
        background-color: #535554;
    }
    .prompt-dialog {
        position: fixed;
        width: 400px;
        z-index: 1001;
        top: 50%;
        left: 50%;
        display: block;
        margin-top: -85.5px;
        margin-left: -215px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        background-color: #fff;
        padding: 15px;
    }
    .prompt-message {
        padding: 5px;
        text-align: center;
    }
    .prompt-message p,
    .prompt-form p {
        margin: 0;
    }
    #prompt {
        display: none;
    }
    .prompt-form {
        padding: 0px;
        margin: 0px;
        float: left;
        width: 100%;
        text-align: center;
        position: relative;
    }
    #content_preview {
        background-color: #f5f5f5;
        height : 100px;
        overflow-y: scroll;
    }
</style>

<script>
    $(document).ready(function() {
        $('#btnedit-link').on("click",function(e) {
            var textArea = $('#section_content'),
                len = textArea.val().length,
                start = textArea[0].selectionStart,
                end = textArea[0].selectionEnd,
                selectedText = textArea.val().substring(start, end);
            $('#btnedit-title').val(selectedText);
            $('#btnedit-url').val('');
            $('#prompt').show();
        });

        $('#btnedit-ok').on("click",function(e) {
            e.preventDefault();
            $('#prompt').hide();
            replacement = '<a title="'+$('#btnedit-title').val()+'" href="'+$('#btnedit-url').val()+'" target="_blank">' + $('#btnedit-title').val() + '</a>';
            wrapLink(replacement);
        });

        $('#btnedit-cancel').on("click",function(e) {
            e.preventDefault();
            $('#prompt').hide();
        });

        $('#btninsert').on("click", function() {
            wrapLink('<br/>');
        });

    });

    function wrapLink(link) {
        var textArea = $('#section_content'),
            len = textArea.val().length,
            start = textArea[0].selectionStart,
            end = textArea[0].selectionEnd,
            selectedText = textArea.val().substring(start, end);
        textArea.val(textArea.val().substring(0, start) + link + textArea.val().substring(end, len));
        $('#section_content').keyup();
    }

    $(function() {
        var value = $('#section_content').val();
        $( '#content_preview' ).html(value);

        $('#section_content').keyup(function(){
            var value = $(this).val();
            $( '#content_preview' ).html(value);
        })
    });
</script>