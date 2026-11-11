@if(session('status'))
    <div id="carrello-msg" class="carrello-msg carrello-msg-success show">{{ session('status') }}</div>
@elseif($errors->any())
    <div id="carrello-msg" class="carrello-msg carrello-msg-errore show">{{ $errors->first() }}</div>
@endif
