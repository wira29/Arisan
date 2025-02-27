<form action="{{ $action }}" method="POST" id="delete-modal">
    @csrf
    @method('DELETE')
</form>