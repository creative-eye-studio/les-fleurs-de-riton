<template>
  <figure><img alt="" id="image-viewer" src="" /></figure>
  <div class="tabs btn-list col-3 col-sm-12">
    <ul>
      <li v-for="data in datas" :key="data.pos" class="tab service-btn position-relative"
        :class="{ active: data.isActive }" :data-tab="'tab' + data.id">
        <span @click="selectTab(data)">{{ data.label }}</span>
      </li>
    </ul>
  </div>

  <div class="tab-content services-list col-9 col-sm-12" id="services-list">
    <section v-for="data in datas" :key="data.id"
      :class="{ 'tab-pane': true, 'service-block': true, 'active': data.isActive }" :id="'tab' + data.id">
      <h2 class="margin-top-none">{{ data.title }}</h2>
      <div class="content-text" v-html="data.content"></div>
      <div class="service-images row-no-marge">
        <div v-for="image in images" :key="image.id" class="col-2 col-sm-3 col-xs-6 no-marge">
          <figure class="thumb" v-if="image.service === data.id">
            <img :alt="image.name" :src="'../uploads/images/services/' + image.name" />
          </figure>
        </div>
      </div>
    </section>
  </div>
</template>
  
<script>
import Viewer from 'viewerjs';
import 'viewerjs/dist/viewer.css';

export default {
  data() {
    return {
      datas: null,
      images: null,
      gallery: null,
    };
  },
  mounted() {
    this.getDatas();
    this.getImages();
    this.initLightbox();
  },
  methods: {
    initLightbox() {
      const viewer = new Viewer(document.getElementById('image-viewer'), {
        inline: true,
        fullscreen: true,
        viewed: () => {
          viewer.zoomTo(1);
        },
      });

      // Correction : Utilisez le conteneur de la galerie, pas la galerie elle-même
      const gallery = new Viewer(document.getElementById('services-list'));
      console.log("Initialisé");
    },

    async getDatas() {
      try {
        const response = await fetch('https://127.0.0.1:8000/api/services');
        if (!response.ok) {
          throw new Error('La requête a échoué');
        }
        const data = await response.json();
        this.datas = data.map((item, index) => ({ ...item, isActive: index === 0 }));
        console.log(this.datas);
      } catch (error) {
        console.error('Une erreur s\'est produite : ', error);
      }
    },
    async getImages() {
      try {
        const response = await fetch('https://127.0.0.1:8000/api/services-images');
        if (!response.ok) {
          throw new Error('La requête a échoué');
        }
        const images = await response.json();
        this.images = images.map((item, index) => ({ ...item, isActive: index === 0 }));
        console.log(this.images);
      } catch (error) {
        console.error('Une erreur s\'est produite : ', error);
      }
    },
    selectTab(selectedData) {
      this.datas.forEach(data => {
        data.isActive = data.id === selectedData.id ? !data.isActive : false;
      });
    }
  },
};
</script>