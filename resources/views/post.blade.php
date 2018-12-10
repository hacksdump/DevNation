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
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                let answersContainer = $('#answersContainer');
                answersContainer.children().remove();
                $.each(answerArray, function(i, item) {
                    answersContainer.append('<div class="card" id="' + answerArray[i]['id'] + '">' +
                        '<div class="row upvote-container">' +
                        '<button onclick="upvote(this)"' + 'class="' + (answerArray[i]['hasUpvoted']? "btn btn-success":"btn") + '"> ^ </button>' +
                        '<span>' + answerArray[i]['upvotes'] + '</span>' +
                        '</div>' +
                        '<p>' + answerArray[i]['answer'] + '</p>' +
                        '<span> answered by ' + answerArray[i]['name'] + '</span>' +
                        '</div>');
                });
            };

            $(window).on('load', function () {
                updateAnswers();
            });

            setInterval(function () {
                updateAnswers();
            }, 5000);
        </script>



        @if(Auth::check())
            <div class="card">
                <div class="row">
                    <input type="text" id="answerBox">
                    <button class="btn btn-outline-primary col-2" id="postAnswer">Post</button>
                </div>
            </div>

            <script>
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

                const upvote = function(answerButton) {
                    const answer_id = answerButton.parentElement.parentElement.getAttribute('id');
                    $.ajax({
                        url: '/upvote',
                        type: 'POST',
                        data: {answer_id: answer_id},
                        dataType: 'JSON',
                    }).done(function (response) {
                        let currentUpvotes = document.getElementById(answer_id).getElementsByTagName('span')[0];
                        currentUpvotes.innerHTML = parseInt(currentUpvotes.innerHTML) + response.result;
                        let currentClass = answerButton.className;
                        if (currentClass.indexOf('success') === -1){
                            answerButton.classList.add('btn-success');
                        }
                        else {
                            answerButton.classList.remove('btn-success');
                        }

                    });
                };

            </script>
        @else
            <a href="/login"> Login </a> to answer
            <script>
                const upvote = function() {
                    location.href = '/login';
                };
            </script>
        @endif

        <h4>Discussion</h4>
        <div id="answersContainer"></div>
    </div>
    <script>


    </script>

@stop
