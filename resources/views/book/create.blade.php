@extends('layouts.app')

@section('title')
PageGuild | {{ __("Vender Livro") }}
@endsection

@section('content')
    <div class="container card">
        <div class="card-header">
            <h2>{{ __("Livro que pretendes vender") }}</h2>
        </div>
        <div class="card-body">
            <form class="col-auto" method="POST" action="{{ route('book.create') }}">
                @csrf
                <div class="row">
                    <div class="col-4 book-cover">
                        <img src="../../images/bookimg.webp" class="img-fluid book-cover" alt="Photo of book:">
                    </div>

                    <div class="col-3">
                        <h3>{{ __("Detalhes do Produto") }}</h3>
                        <label class="row">
                            <span class="bold">{{ __("Título") }}:</span>
                            <input type="text" class="@error('title') is-invalid @enderror" name="title" placeholder="{{ __("Título") }}" value="{{ old('title') }}"/>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label class="row">
                            <span class="bold">{{ __("Autores") }}:</span>
                            <select name="authors" class="@error('authors') is-invalid @enderror">
                                <option disabled selected value="-1" value> -- {{ __("Selecione um autor") }} -- </option>
                                @foreach($possibleAuthors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach
                            </select>
                            @error('authors')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label class="row">
                            <span class="bold">{{ __("Preço") }}:</span>
                            <input type="number" class="@error('price') is-invalid @enderror" min="0" step="0.01" name="price" placeholder="Preço" value="{{ old('height') }}"/>
                        </label>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror

                        <label class="row">
                            <span class="bold">{{ __("Sinopse") }}:</span>
                            <textarea type="text" class="@error('synopsis') is-invalid @enderror" rows="4" name="synopsis">{{ old('synopsis') }}</textarea>
                        </label>
                        @error('synopsis')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror

                        <label class="row">
                            <span class="bold">{{ __("Dimensões do produto") }}:</span>
                            <div class="col-auto">
                                <input type="number" class="@error('height') is-invalid @enderror" min="0" step="0.01" name="height" value="{{ old('height') }}" placeholder="{{ __("Altura") }}"/><span class="text-secondary">cm</span>
                                @error('height')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                                <input type="number" class="@error('length') is-invalid @enderror" min="0" step="0.01" name="length" value="{{ old('length') }}" placeholder="{{ __("Comprimento") }}"/><span class="text-secondary">cm</span>
                                @error('length')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                                <input type="number" class="@error('width') is-invalid @enderror" min="0" step="0.01" name="width"  value="{{ old('width') }}" placeholder="{{ __("Largura") }}"/><span class="text-secondary">cm</span>
                                @error('width')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                            </div>
                        </label>
                    </div>

                    <div class="col-1"></div>

                    <div class="col-4">
                        <h3>{{ __("Detalhes do Livro") }}</h3>
                        <label class="row">
                            <span class="bold">
                                {{ __("ISBN") }}:
                            </span>
                            <input type="text" class="int-only @error('isbn') is-invalid @enderror" name="isbn" maxlength="13" minlength="10" value="{{ old('isbn') }}"/>
                            @error('isbn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <label class="row">
                            <span class="bold">
                                {{ __("Ano de publicação") }}:
                            </span>
                            <input type="number" class="int-only @error('publication_year') is-invalid @enderror" min="0" max="{{ (date('Y')) }}" maxlength="4"
                                   placeholder="{{ (date('Y')) }}" step="1" name="publication_year"
                            value="{{ old('publication_year') }}"/>
                            @error('publication_year')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <label class="row">
                            <span class="bold">
                                {{ __("Editora") }}:
                            </span>
                            <select class="selector rounded form-select-sm @error('publisher_id') is-invalid @enderror" name="publisher_id">
                                <option disabled @if(!old('publisher_id') or old('publisher_id') == -1) selected @endif value="-1"> {{ __("Selecione um editor") }} </option>
                                @foreach($possiblePublishers as $publisher)
                                    <option value="{{ $publisher->id }}" @if(old('publisher_id') == $publisher->id) selected @endif>{{ $publisher->name }}</option>
                                @endforeach
                            </select>
                            @error('publisher_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <label class="row">
                            <span class="bold">
                                {{ __("Língua") }}:
                            </span>
                            <select class="selector rounded form-select-sm @error('language_id') is-invalid @enderror" name="language_id">
                                <option disabled @if(!old('language_id') or old('language_id') == -1) selected @endif value="-1"> {{ __("Selecione uma língua") }} </option>
                                @foreach($possibleLanguages as $language)
                                    <option value="{{ $language->id }}" @if(old('language_id') == $publisher->id) selected @endif>{{ $language->name }}</option>
                                @endforeach
                            </select>
                            @error('language_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label class="row">
                            <span class="bold">
                                {{ __("Encadernação") }}:
                            </span>
                            <input type="text" name="bookbinding" class="@error('bookbinding') is-invalid @enderror" value="{{ old('bookbinding') }}">
                            @error('bookbinding')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <label class="row">
                            <span class="bold">
                                {{ __("Número de páginas") }}:
                            </span>
                            <input type="number" class="int-only @error('num_pages') is-invalid @enderror" name="num_pages" value="{{ old('num_pages') }}">
                            @error('num_pages')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label class="row">
                            <span class="bold">
                                {{ __("Gêneros") }}:
                            </span>
                            <select class="selector multi-select @error('genres') is-invalid @enderror" name="genres" multiple="multiple">
                                <option disabled selected value="-1" > {{ __("Selecione um gênero") }} </option>
                                @foreach($possibleGenres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                            @error('genres')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <div class="row row-cols-auto mt-3">
                            <input class="btn-primary rounded" type="submit" value="{{ __("Submeter") }}"/>
                        </div>

                        @if(session('message'))
                            <div class="alert-info m-5">
                                <span class="bold">{{ session('message') }}}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.int-only').on('blur keyup change paste', function () {
                var $this = $(this);
                var val = $this.val();
                var valLength = val.length;
                var maxCount = $this.attr('maxlength');
                $this.val($this.val().replace(/[^0-9]/g,''));
                if(valLength>maxCount){
                    $this.val($this.val().substring(0,maxCount));
                }
            })
        })
    </script>
@endsection
