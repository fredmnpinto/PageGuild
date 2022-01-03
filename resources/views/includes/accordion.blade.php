<div class="accordion-item">
    <h2 class="accordion-header" id="heading{{ $filterName }}">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $filterName }}" aria-expanded="true" aria-controls="collapse{{ $filterName }}">
            {{ $filterName }}
        </button>
    </h2>
    <div id="collapse{{ $filterName }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $filterName }}">
        <div class="accordion-body">
            {{-- A forma como os href são preenchidos muda consoante o tipo de filtro do accordion --}}
            @switch ($filterName)
                @case('Author')
                    @foreach ($options as $filterResult)
                        @php $url['filters']['author'] = $filterResult->id @endphp
                        <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters']['author'] }}/{{ $url['filters']['publisher'] }}/{{ $url['filters']['genre'] }}/{{ $url['filters']['year'] }}/{{ $url['order_by'] }}/{{ $url['order_direction'] }}">
                            <p class="text-dark">{{ $filterResult->name }} ({{ $filterResult->count }})</p>
                        </a>
                    @endforeach
                    @break

                @case('Publisher')
                    @foreach ($options as $filterResult)
                        @php $url['filters']['publisher'] = $filterResult->id @endphp
                        <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters']['author'] }}/{{ $url['filters']['publisher'] }}/{{ $url['filters']['genre'] }}/{{ $url['filters']['year'] }}/{{ $url['order_by'] }}/{{ $url['order_direction'] }}">
                            <p class="text-dark">{{ $filterResult->name }} ({{ $filterResult->count }})</p>
                        </a>
                    @endforeach
                    @break

                @case('Genre')
                    @foreach ($options as $filterResult)
                        @php $url['filters']['genre'] = $filterResult->id @endphp
                        <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters']['author'] }}/{{ $url['filters']['publisher'] }}/{{ $url['filters']['genre'] }}/{{ $url['filters']['year'] }}/{{ $url['order_by'] }}/{{ $url['order_direction'] }}">
                            <p class="text-dark">{{ $filterResult->name }} ({{ $filterResult->count }})</p>
                        </a>
                    @endforeach
                    @break
                
                @case('Publication_year')
                    @foreach ($options as $filterResult)
                        @php $url['filters']['year'] = $filterResult->publication_year @endphp
                        <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters']['author'] }}/{{ $url['filters']['publisher'] }}/{{ $url['filters']['genre'] }}/{{ $url['filters']['year'] }}/{{ $url['order_by'] }}/{{ $url['order_direction'] }}">
                            <p class="text-dark">{{ $filterResult->publication_year }} ({{ $filterResult->count }})</p>
                        </a>
                    @endforeach
                    @break
            @endswitch
        </div>
    </div>
</div>
