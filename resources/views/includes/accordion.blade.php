<div class="accordion-item">
    <h2 class="accordion-header" id="heading{{ $filterName }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $filterName }}" aria-expanded="true" aria-controls="collapse{{ $filterName }}">
            {{ $filterName }}
        </button>
    </h2>
    <div id="collapse{{ $filterName }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $filterName }}">
        <div class="accordion-body">
            {{-- A forma como os href são preenchidos muda consoante o tipo de filtro do accordion --}}
            @foreach ($options as $opt)
                @php($chosen_filter_url = $url['filters'][ $filterName] = $opt->filter_option)
                <a class="navbar-brand" href="/search/results/orderFilter/{{ $chosen_filter_url['searchQuery'] ?: 'null'}}/{{ $chosen_filter_url['filters']['author'] ?: '0' }}/{{ $chosen_filter_url['filters']['publisher'] ?: '0' }}/{{ $chosen_filter_url['filters']['genre'] ?: '0' }}/{{ $chosen_filter_url['filters']['year'] ?: '0' }}/{{ $chosen_filter_url['order_by'] ?: 'null' }}/{{ $chosen_filter_url['order_direction'] ?: 'asc' }}">
                    <p class="text-dark">{{ $opt->option_desc }} ({{ $options->count}})</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
