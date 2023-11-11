<template>
    <form :id="contact-form" class="margin-top-on-md">
        <p><em>* Champs obligatoires</em></p>
        <p class="form-input">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" id="nom" required>
        </p>
        <p class="form-input">
            <label for="prenom">Prénom *</label>
            <input type="text" name="prenom" id="prenom" required>
        </p>
        <p class="form-input">
            <label for="mail">Adresse E-Mail *</label>
            <input type="email" name="mail" id="mail" required>
        </p>
        <p class="form-input">
            <label for="telephone">Téléphone</label>
            <input type="tel" name="telephone" id="telephone">
        </p>
        <p class="form-input">
            <label for="object">Objet du message *</label>
            <input type="text" name="object" id="object" required>
        </p>
        <p class="form-input">
            <label for="message">Message *</label>
            <textarea name="message" id="message" rows="10" required></textarea>
        </p>
        <p class="form-input checkbox">
            <input type="checkbox" name="rgpd" id="rgpd" required>
            <label for="rgpd">En soumettant ce formulaire, j'accepte que mes données soient utilisées à des fins de relation client tout en sachant que je peux faire une demande de modification ou de suppression de mes données. Le formulaire est protégé par Google ReCaptcha</label>
        </p>
        <button type="submit">Envoyer</button>
    </form>
</template>

<script>
export default {
    
}
</script>