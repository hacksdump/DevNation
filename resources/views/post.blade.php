@extends('layout')

@section('title')
    Discuss
    @stop

@section('content')

    <div class="container col-lg-6">
        <div class="card">
            <h1 class="card-header">
                {{ $post['question'] }}
            </h1>
            <p class="card-body">
                asked by {{ $post['user']['name'] }} on {{ $post['created_at'] }}
            </p>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        @if(Auth::check())
            <div class="card">
                <div class="row">
                    <input type="text" id="answerBox">
                    <button class="btn btn-outline-primary col-2" id="postAnswer">Post</button>
                </div>
            </div>
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                const answerBox = $('#answerBox');
                answerBox.on('keypress', function(event) {
                    if(event.which === 13){
                        postAnswer();
                    }
                });
                $('#postAnswer').click(function () {
                    postAnswer();
                });
                function postAnswer(){
                    let answer = answerBox.val();
                    answerBox.val('');
                    answerBox.blur();
                    if(answer.length > 0){
                        dataToSend = {
                            answer: answer,
                            question: '{{ $post['id'] }}'
                        };

                        $.ajax({
                            url: '/answer',
                            type: 'POST',
                            data: dataToSend,
                            dataType: 'JSON',
                        }).done(function (response) {
                            populateAnswers(response);
                        });
                    }
                }


            </script>
        @else
            <a href="/login"> Login </a> to answer
        @endif
        <h4>Discussion</h4>
        <div id="answersContainer"></div>
    </div>
    <script>
        const updateAnswers = function(){
            $.ajax({
                url: '/answer/{{ $post['id'] }}',
                type: 'GET',
                dataType: 'JSON',
            }).done(function (response) {
                populateAnswers(response);
            });
        };
        const populateAnswers = function(answerArray){
            answersContainer = $('#answersContainer');
            answersContainer.children().remove();
            $.each(answerArray, function(i, item) {
                answersContainer.append('<div class="card">' + '<p>' + answerArray[i]['answer'] + '</p>answered by ' + answerArray[i]['name'] + '</div>');
            });
        };
        $(window).on('load', function () {
            updateAnswers();
        });
        setInterval(function () {
            updateAnswers();
        }, 5000);

    </script>

@stop
