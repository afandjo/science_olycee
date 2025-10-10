<h3>Un nouveau paiement vient d’être enregistré</h3>

<p><strong>Utilisateur :</strong> {{ $paiement->user->nom }} {{ $paiement->user->prenom }}</p>
<p><strong>Chapitre :</strong> {{ $paiement->chapter->title ?? '---' }}</p>
<p><strong>Montant :</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} F</p>
<p><strong>Méthode :</strong> {{ $paiement->methode }}</p>
<p><strong>Numéro :</strong> {{ $paiement->numero }}</p>

<p>Connecte-toi à ton tableau de bord pour l’approuver ou le rejeter.</p>
