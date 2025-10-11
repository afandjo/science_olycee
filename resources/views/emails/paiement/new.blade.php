@component('mail::message')
# 💰 Nouveau paiement en attente

Un nouvel utilisateur a effectué un paiement et attend votre validation.

## Informations de l'utilisateur

**Nom :** {{ $paiement->user->nom }}  
**Prénom(s) :** {{ $paiement->user->prenom }}  
**Email :** {{ $paiement->user->email }}  

## Détails du paiement

**Chapitre :** {{ $paiement->chapter->title }}  
**Montant :** {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA  
**Méthode :** {{ ucfirst($paiement->methode) }}  
**Numéro :** {{ $paiement->numero }}  
**Date :** {{ $paiement->created_at->format('d/m/Y à H:i') }}  

@component('mail::button', ['url' => config('app.url').'/admin/paiements'])
Gérer les paiements
@endcomponent

Merci,  
{{ config('app.name') }}
@endcomponent
