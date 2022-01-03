<div class="modal fade" id="{{ $modal_reference }}" tabindex="-1" aria-labelledby="{{ $modal_reference }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        @yield('header')
      </div>
      <div class="modal-body">
        @yield('body')
      </div>
      <div class="modal-footer">
        @yield('footer')
      </div>
    </div>
  </div>
</div>