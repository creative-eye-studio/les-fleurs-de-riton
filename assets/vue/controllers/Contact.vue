<template>
    <form :id="contact-form" class="margin-top-on-md">
        <p><em>* Champs obligatoires</em></p>
        <p class="form-input">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" id="nom" v-model="nom" required>
        </p>
        <p class="form-input">
            <label for="prenom">Prénom *</label>
            <input type="text" name="prenom" id="prenom" v-model="prenom" required>
        </p>
        <p class="form-input">
            <label for="mail">Adresse E-Mail *</label>
            <input type="email" name="mail" id="mail" v-model="email" required>
        </p>
        <p class="form-input">
            <label for="telephone">Téléphone</label>
            <input type="tel" name="telephone" id="telephone" v-model="tel">
        </p>
        <p class="form-input">
            <label for="object">Objet du message *</label>
            <input type="text" name="object" id="object" v-model="objet" required>
        </p>
        <p class="form-input">
            <label for="message">Message *</label>
            <textarea name="message" id="message" rows="10" v-model="message" required></textarea>
        </p>
        <p class="form-input checkbox">
            <input type="checkbox" name="rgpd" id="rgpd" v-model="rgpd" required>
            <label for="rgpd">En soumettant ce formulaire, j'accepte que mes données soient utilisées à des fins de relation client tout en sachant que je peux faire une demande de modification ou de suppression de mes données. Le formulaire est protégé par Google ReCaptcha</label>
        </p>
        <p id="mail-response"></p>
        <button @click="sendMail">Envoyer</button>
    </form>
</template>

<script>
export default {
    el: '#contact-form',
    data() {
        return {
            nom: '',
            prenom: '',
            email: '',
            tel: '',
            objet: '',
            message: '',
            rgpd: '',
            jsonData: null
        }
    },
    methods: {
        sendMail(e) {
            e.preventDefault();
            var response = document.querySelector('#mail-response');
            const formData = {
                nom: this.nom,
                prenom: this.prenom,
                email: this.email,
                tel: this.tel,
                objet: this.objet,
                message: this.message
            }
            console.log(formData);
            if (this.nom && this.prenom && this.email && this.objet && this.message && this.rgpd) {
                const requestOptions = {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                };
                fetch('https://lesfleursderiton.com/api/contact-form', requestOptions)
                      .then(fetchResponse => {
                          if (!fetchResponse.ok) {
                              throw new Error(`La requête a échoué avec le code : ${fetchResponse.status}`);
                          }
                          return fetchResponse.clone().json(); // Clonez la réponse avant de l'analyser
                      })
                      .then(data => {
                          console.log(data);
                          response.classList.remove('response-danger');
                          response.classList.add('response-success');
                          response.innerHTML = "Votre message a bien été envoyé";
                      })
                      .catch(error => {
                          console.error(error);
                          response.classList.remove('response-success');
                          response.classList.add('response-danger');
                          response.innerHTML = "Votre message n'a pas été envoyé ! Une erreur s'est produite";
                      });
            } else {
                response.classList.remove('response-success');
                response.classList.add('response-danger');
                response.innerHTML = "Tous les champs obligatoires ne sont pas remplis !";
            }
        }
    }
}
</script>