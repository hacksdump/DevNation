@extends('layout')

@section('title')
    Ask
    @stop

@section('header-tags')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@stop

@section('content')
    @php
        $supportedFileFormats = [];
        @endphp
    <div class="container">
        {!! Form::open(['url' => 'ask', 'files' => true,  'id' => 'form'])!!}
        {!! Form::label('query', 'Question', ['class' => 'control-label']) !!}
        {!! Form::textarea('query', '', ['class' => 'form-control', 'required' => true]) !!}
        <button id="displayAdditionalOptions">More options</button>
        <div class="d-none" id="additionalOptions">
            {!! Form::label('uploadImage', 'Image', ['class' => 'control-label']) !!}
            <input type="file" class="btn" id="uploadImage" name="uploadImage" accept="image">
            <div>
                <h4>
                    Upload code
                </h4>
                {!! Form::label('language', 'Select Language', ['class' => 'control-label']) !!}
                {!! Form::select('language', ['none' => 'Select',
                                               'python' => 'Python',
                                                'php' => 'PHP',
                                                 'js' => "JavaScript",
                                                  'go' => 'Golang',
                                                   ] , null, ['id' => 'languageSelector'] ) !!}

                <div id="codeOptions" class="d-none">
                    {!! Form::radio('codeType', 'file',  null, ['id' => 'codeType', 'checked' => true]) !!}
                    <span>File</span>
                    {!! Form::radio('codeType', 'code',  null, ['id' => 'codeType', '']) !!}
                    <span>Code</span>
                    <div id="codeFile">
                        {!! Form::label('uploadCode', 'File containing code', ['class' => 'control-label']) !!}
                        {!! Form::file('text', ['name' => 'uploadCode', 'id' => 'uploadCode', 'class' => 'btn']) !!}
                    </div>
                    <div id="codeText" class="d-none">
                        {!! Form::label('code', 'Type code here', ['class' => 'control-label']) !!}
                        {!! Form::textarea('code', '', ['class' => 'form-control', 'id' => 'codeArea']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::submit('Submit', ['class' => 'form-control']) !!}
        {!! Form::close() !!}
    </div>

    <script>
        let optionsHidden = 1;
        let toggleButton = $('#displayAdditionalOptions');
        let languageSelector = $('#languageSelector');
        let codeOptions = $('#codeOptions');
        let codeArea = $('#codeArea');
        let codeRadio = $('input[name=codeType]');
        toggleButton.on('click',  function (event) {
            let options = $('#additionalOptions');
            if(optionsHidden){
                toggleButton.text('Less options');
                options.removeClass('d-none');
                optionsHidden = !optionsHidden;
            }
            else {
                toggleButton.text('More options');
                options.addClass('d-none');
                optionsHidden = !optionsHidden;
            }
            event.preventDefault();
            return false;
        });
        languageSelector.on('change', function (event) {
            if(languageSelector.val() !== "none"){
                codeOptions.removeClass('d-none');
            }
            else {
                codeOptions.addClass('d-none');
            }
        });
        codeRadio.on('click', function (event) {
            let selection = $(this).val();
            if(selection === 'code'){
                $('#codeFile').addClass('d-none');
                $('#codeText').removeClass('d-none');
            }
            if(selection === 'file'){
                $('#codeText').addClass('d-none');
                $('#codeFile').removeClass('d-none');
            }
            return true;
        })
    </script>
@stop
