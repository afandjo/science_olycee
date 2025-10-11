# Configuration de l'envoi d'emails

## ✅ Modifications effectuées

1. **Email de destination changé** : `scienceolycee@gmail.com`
2. **Email amélioré** avec :
   - Nom et prénoms de l'utilisateur
   - Numéro de téléphone
   - Montant du paiement (5000 FCFA)
   - Date et heure du paiement
   - Bouton pour gérer les paiements

## 📧 Configuration Gmail requise

Pour que les emails fonctionnent, vous devez configurer votre fichier `.env` :

### Option 1 : Utiliser Gmail (Recommandé)

1. **Créer un mot de passe d'application Gmail** :
   - Allez sur https://myaccount.google.com/apppasswords
   - Connectez-vous avec `scienceolycee@gmail.com`
   - Créez un mot de passe d'application pour "Laravel"
   - Copiez le mot de passe généré (16 caractères)

2. **Modifier votre fichier `.env`** :
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=scienceolycee@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_application_16_caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=scienceolycee@gmail.com
MAIL_FROM_NAME="Science Olycée"
```

### Option 2 : Tester en local (pour développement)

Si vous voulez juste tester sans envoyer de vrais emails :

```env
MAIL_MAILER=log
```

Les emails seront enregistrés dans `storage/logs/laravel.log`

## 🔄 Redémarrer le serveur

Après avoir modifié `.env`, redémarrez votre serveur :
```bash
# Arrêter le serveur (Ctrl+C)
# Puis relancer
php artisan serve
```

## 🧪 Tester l'envoi d'email

1. Connectez-vous en tant qu'utilisateur
2. Effectuez un paiement pour un chapitre
3. L'admin recevra un email sur `scienceolycee@gmail.com`

## 📋 Contenu de l'email

L'email contiendra :
- **Nom** : Nom de l'utilisateur
- **Prénom(s)** : Prénoms de l'utilisateur
- **Email** : Email de l'utilisateur
- **Chapitre** : Titre du chapitre acheté
- **Montant** : 5000 FCFA
- **Méthode** : Orange Money / MTN Mobile Money / Moov Money
- **Numéro** : Numéro de téléphone utilisé
- **Date** : Date et heure du paiement (format: JJ/MM/AAAA à HH:MM)
- **Bouton** : Lien direct vers la page de gestion des paiements

## ⚠️ Important

- Activez l'authentification à deux facteurs sur Gmail
- N'utilisez JAMAIS votre mot de passe Gmail principal
- Utilisez uniquement un mot de passe d'application
- Ne partagez jamais votre fichier `.env`
