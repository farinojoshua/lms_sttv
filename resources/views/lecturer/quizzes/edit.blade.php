@extends('layouts.app')

@section('title', 'Edit Quiz')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Edit Quiz</h4>
            </div>
            <div class="col-sm-6">
                <ol class="float-right breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lecturer.sections.quizzes.index', $section) }}">Quizzes</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('lecturer.sections.quizzes.update', [$section->id, $quiz->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Quiz Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->title }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $quiz->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_time" class="col-sm-2 col-form-label">Start Time</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ $quiz->start_time ? $quiz->start_time->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_time" class="col-sm-2 col-form-label">End Time</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ $quiz->end_time ? $quiz->end_time->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>

                        <hr>

                        <h5 class="d-inline-block">Edit Questions</h5>

                        <div id="questions-container">
                            @foreach ($quiz->questions as $index => $question)
                                <div class="question-block">
                                    <hr>
                                    <h5 class="d-inline-block">Question {{ $index + 1 }}</h5>
                                    <button type="button" class="float-right btn btn-danger btn-sm remove-question-btn">×</button>
                                    <div class="form-group row">
                                        <label for="question_{{ $index + 1 }}" class="col-sm-2 col-form-label">Question {{ $index + 1 }}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="question_{{ $index + 1 }}" name="questions[{{ $index }}][question]" rows="3" required>{{ $question->question }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="option_{{ $index + 1 }}_1" class="col-sm-2 col-form-label">Option 1</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="option_{{ $index + 1 }}_1" name="questions[{{ $index }}][options][]" value="{{ $question->options[0] }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="option_{{ $index + 1 }}_2" class="col-sm-2 col-form-label">Option 2</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="option_{{ $index + 1 }}_2" name="questions[{{ $index }}][options][]" value="{{ $question->options[1] }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="option_{{ $index + 1 }}_3" class="col-sm-2 col-form-label">Option 3</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="option_{{ $index + 1 }}_3" name="questions[{{ $index }}][options][]" value="{{ $question->options[2] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="option_{{ $index + 1 }}_4" class="col-sm-2 col-form-label">Option 4</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="option_{{ $index + 1 }}_4" name="questions[{{ $index }}][options][]" value="{{ $question->options[3] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correct_answer_{{ $index + 1 }}" class="col-sm-2 col-form-label">Correct Answer</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="correct_answer_{{ $index + 1 }}" name="questions[{{ $index }}][correct_answer]" required>
                                                <option value="" disabled>Select the correct answer</option>
                                                <option value="option_1" {{ $question->correct_answer === 'option_1' ? 'selected' : '' }}>Option 1</option>
                                                <option value="option_2" {{ $question->correct_answer === 'option_2' ? 'selected' : '' }}>Option 2</option>
                                                <option value="option_3" {{ $question->correct_answer === 'option_3' ? 'selected' : '' }}>Option 3</option>
                                                <option value="option_4" {{ $question->correct_answer === 'option_4' ? 'selected' : '' }}>Option 4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-secondary" id="add-question-btn">Add Another Question</button>

                        <div class="mt-4 form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Save Quiz and Questions</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-question-btn').addEventListener('click', function() {
            var questionIndex = document.querySelectorAll('.question-block').length;
            var newQuestionBlock = document.createElement('div');
            newQuestionBlock.classList.add('question-block');

            newQuestionBlock.innerHTML = `
                <hr>
                <h5 class="d-inline-block">Question ${questionIndex + 1}</h5>
                <button type="button" class="float-right btn btn-danger btn-sm remove-question-btn">×</button>
                <div class="form-group row">
                    <label for="question_${questionIndex + 1}" class="col-sm-2 col-form-label">Question ${questionIndex + 1}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="question_${questionIndex + 1}" name="questions[${questionIndex}][question]" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="option_${questionIndex + 1}_1" class="col-sm-2 col-form-label">Option 1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option_${questionIndex + 1}_1" name="questions[${questionIndex}][options][]" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="option_${questionIndex + 1}_2" class="col-sm-2 col-form-label">Option 2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option_${questionIndex + 1}_2" name="questions[${questionIndex}][options][]" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="option_${questionIndex + 1}_3" class="col-sm-2 col-form-label">Option 3</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option_${questionIndex + 1}_3" name="questions[${questionIndex}][options][]">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="option_${questionIndex + 1}_4" class="col-sm-2 col-form-label">Option 4</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="option_${questionIndex + 1}_4" name="questions[${questionIndex}][options][]">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="correct_answer_${questionIndex + 1}" class="col-sm-2 col-form-label">Correct Answer</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="correct_answer_${questionIndex + 1}" name="questions[${questionIndex}][correct_answer]" required>
                            <option value="" disabled selected>Select the correct answer</option>
                            <option value="option_1">Option 1</option>
                            <option value="option_2">Option 2</option>
                            <option value="option_3">Option 3</option>
                            <option value="option_4">Option 4</option>
                        </select>
                    </div>
                </div>
            `;

            document.getElementById('questions-container').appendChild(newQuestionBlock);

            // Tambahkan event listener ke tombol "X"
            newQuestionBlock.querySelector('.remove-question-btn').addEventListener('click', function() {
                newQuestionBlock.remove();
            });
        });

        // Tambahkan event listener ke semua tombol "Remove Question" yang sudah ada
        document.querySelectorAll('.remove-question-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('.question-block').remove();
            });
        });
    </script>
@endsection
