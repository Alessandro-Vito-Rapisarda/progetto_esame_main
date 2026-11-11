<form method="post" action="{{ url('shopping/add') }}" class="add-to-cart-form">
    @csrf
    <input type="hidden" name="prodotto_id" value="{{ $prodotto->id }}">
    <input type="hidden" name="quantita" value="1">
    <button type="submit" class="prodotto-btn add-to-cart-btn">Aggiungi al carrello</button>
</form>
