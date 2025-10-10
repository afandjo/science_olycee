@extends('admin.login.nav')
@section('content')
<h2>Validation des paiements</h2>
<table class="table">
<thead><tr><th>Élève</th><th>Chapitre</th><th>Méthode</th><th>Num</th><th>Statut</th><th>Actions</th></tr></thead>
<tbody>
@foreach($paiements as $p)
<tr>
  <td>{{ $p->user->nom }} {{ $p->user->prenom }} ({{ $p->user->email }})</td>
  <td>{{ $p->chapter->title }}</td>
  <td>{{ $p->methode }}</td>
  <td>{{ $p->numero }}</td>
  <td>{{ $p->statut }}</td>
  <td>
    @if($p->statut == 'en_attente')
      <form action="{{ route('admin.paiements.approuver', $p->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-success">Approuver</button></form>
      <form action="{{ route('admin.paiements.rejeter', $p->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-sm btn-danger">Rejeter</button></form>
    @endif
  </td>
</tr>
@endforeach
</tbody>
</table>

<h3>Uploader une vidéo pour un chapitre</h3>
@foreach(\App\Models\Chapter::all() as $c)
  <div class="mb-3">
    <form action="{{ route('admin.chapters.uploadVideo', $c->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label>{{ $c->title }}</label>
      <input type="file" name="video" accept=".mp4,.mov,.avi" required>
      <button class="btn btn-sm btn-primary">Uploader</button>
    </form>
  </div>
@endforeach
@endsection
