@component('mail::message')
# Nouveau paiement en attente

**Nom :** {{ $paiement->user->nom }}  
**Prénom(s) :** {{ $paiement->user->prenom }}  
**Email :** {{ $paiement->user->email }}  
**Chapitre :** {{ $paiement->chapter->title }}  
**Méthode :** {{ $paiement->methode }}  
**Numéro :** {{ $paiement->numero }}  

Veuillez approuver ou rejeter ce paiement dans l'admin.
@endcomponent
