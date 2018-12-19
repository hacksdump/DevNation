@extends('layout')

@section('title')
    Ask
    @stop

@section('header-tags')
    @php($languages = ['python', 'php', 'javascript', 'css', 'go'])
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.42.0/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.42.0/theme/icecoder.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.42.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.42.0/keymap/sublime.min.js"></script>
    @foreach ($languages as $language)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.42.0/mode/{{$language}}/{{$language}}.min.js"></script>
    @endforeach

@stop

@section('content')
    <div class="container ask">
        <button id="displayAdditionalOptions" class="btn btn-sm btn-primary float-right">More options &#9662;</button>
        {!! Form::open(['url' => 'ask', 'files' => true,  'id' => 'form'])!!}
        {!! Form::label('query', 'Ask your question', ['class' => 'control-label ask-heading float-left']) !!}
        {!! Form::text('query', '', ['class' => 'form-control question-field', 'required' => true]) !!}
        <div class="hidden card collapsed" id="additionalOptions">
            <div class="image-portion">
                <h3>Upload Image</h3>
                {!! Form::label('uploadImage', 'Image file', ['class' => 'control-label']) !!}
                <input type="file" class="btn upload-btn" id="uploadImage" name="uploadImage" accept="image">
            </div>
            <div class="code-portion">
                <h3>
                    Upload code
                </h3>
                {!! Form::label('language', 'Select Language', ['class' => 'control-label']) !!}
                {!! Form::select('language', ['none' => 'Select',
                                               'python' => 'Python',
                                                'php' => 'PHP',
                                                 'js' => "JavaScript",
                                                  'go' => 'Golang',
                                                  'css' => 'CSS'
                                                   ] , null, ['id' => 'languageSelector'] ) !!}

                <div id="codeOptions" class="hidden">
                    {!! Form::radio('codeType', 'file',  null, ['id' => 'codeType', 'checked' => true]) !!}
                    <span>File</span>
                    {!! Form::radio('codeType', 'code',  null, ['id' => 'codeType', '']) !!}
                    <span>Code</span>
                    <div id="codeFile">
                        {!! Form::label('uploadCode', 'File containing code', ['class' => 'control-label']) !!}
                        {!! Form::file('text', ['name' => 'uploadCode', 'id' => 'uploadCode', 'class' => 'btn']) !!}
                    </div>
                    <div id="codeText" class="hidden">
                        {!! Form::label('code', 'Type code here', ['class' => 'control-label']) !!}
                        <textarea style="text-align: center" rows="4" cols="50" name="code" id="codesnippet_editable"></textarea>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-success submit']) !!}
        {!! Form::close() !!}
    </div>


    <script>
        let optionsHidden = 1;
        let toggleButton = $('#displayAdditionalOptions');
        let languageSelector = $('#languageSelector');
        let codeOptions = $('#codeOptions');
        let codeRadio = $('input[name=codeType]');
        toggleButton.on('click',  function (event) {
            let options = $('#additionalOptions');
            if(optionsHidden){
                toggleButton.text('Less options \u25BC');
                options.slideDown(1000);
            }
            else {
                toggleButton.text('More options \u25B2');
                options.slideUp(500);
            }
            optionsHidden = !optionsHidden;
            event.preventDefault();
            return false;
        });
        languageSelector.on('change', function (event) {
            if(languageSelector.val() !== "none"){
                codeOptions.slideDown(400);
                let codeMirrorLanguage;
                switch (languageSelector.val()) {
                    case 'js':
                        codeMirrorLanguage = 'javascript';
                        break;
                    case 'php':
                        codeMirrorLanguage = 'php';
                        break;
                    case 'python':
                        codeMirrorLanguage = 'python';
                        break;
                }
                if(this.editor){
                    this.editor.setOption("mode", codeMirrorLanguage);
                }
                else {
                    this.editor = CodeMirror.fromTextArea(document.getElementById('codesnippet_editable'), {
                        mode: codeMirrorLanguage,
                        theme: "icecoder",
                        lineNumbers: true,
                    });
                }
            }
            else {
                codeOptions.slideUp(300);
            }
        });
        codeRadio.on('click', function (event) {
            let selection = $(this).val();
            if(selection === 'code'){
                $('#codeFile').slideUp(200);
                $('#codeText').slideDown(300);
            }
            if(selection === 'file'){
                $('#codeText').slideUp(200);
                $('#codeFile').slideDown(300);
            }
            return true;
        });
    </script>
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.2/ace.js"></script>
    <script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/javascript");
        editor.setShowPrintMargin(false);

    </script-->
@stop
