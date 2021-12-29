<div class="accordion-item">
    <h2 class="accordion-header" id="heading{{ $filterName }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $filterName }}" aria-expanded="true" aria-controls="collapse{{ $filterName }}">
            {{ $filterName }}
        </button>
    </h2>
    <div id="collapse{{ $filterName }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $filterName }}">
        <div class="accordion-body">
            @foreach ($options as $filterResult)
                <a class="navbar-brand" href="/search/filter/{{ $substring }}{{ $filterResult->id }}">
                    <p class="text-dark">{{ $filterResult->name }} ({{ $filterResult->count }})</p>
                </a>
            @endforeach
        </div>
    </div>
</div>