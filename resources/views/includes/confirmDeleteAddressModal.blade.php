<div class="modal fade" id="deleteAddress{{ $address->id }}" tabindex="-1" aria-labelledby="deleteAddress{{ $address->id }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Eliminar address?</h3>
      </div>
      <div class="modal-body">
        <p class="text-black">Tens a certeza que pretendes eliminar {{ $address->address }} ?</p>
        <p class="text-black">Esta operação <strong>não pode</strong> ser revertida!</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('deleteAddress', ['address_id' =>  $address->id]) }}">Eliminar</a>
      </div>
    </div>
  </div>
</div>