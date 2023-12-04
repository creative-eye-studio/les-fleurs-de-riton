<template>
  <div class="row" data-aos="fade-up">
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
          <div v-for="image in images" :key="image.id" class="col-2 col-sm-3 col-xs-5 no-marge">
            <figure class="thumb" v-if="image.service === data.id" @click="openLightbox(image)">
              <img :alt="image.name" :src="getImagePath(image.name)" />
            </figure>
          </div>
        </div>
      </section>
    </div>
  </div>
  <div class="content-lightbox">
    <vue-easy-lightbox 
        :visible="lightboxVisible" 
        :imgs="lightboxImages" 
        :index="lightboxIndex"
        @hide="closeLightbox"></vue-easy-lightbox>  
  </div>
  
</template>
  
<script>
import VueEasyLightbox from 'vue-easy-lightbox'

export default {
  components: {
    VueEasyLightbox,
  },
  data() {
    return {
      datas: null,
      images: null,
      selectedImageSrc: '',
      lightboxVisible: false,
      lightboxImages: [],
      lightboxIndex: 0,
      staticImagePath: '../uploads/images/services/',
      lightboxTransform: 'none', 
    };
  },
  mounted() {
    this.getDatas();
    this.getImages();
  },
  methods: {

    async fetchData(apiEndpoint, dataProperty, errorMessage) {
      try {
        const response = await fetch(apiEndpoint);

        if (!response.ok) {
          throw new Error('La requête a échoué');
        }

        const responseData = await response.json();
        this[dataProperty] = responseData.map((item, index) => ({ ...item, isActive: index === 0 }));

      } catch (error) {
        console.error(`Une erreur s'est produite lors de la récupération des ${errorMessage} : `, error);
      }
    },

    async getDatas() {
      await this.fetchData('/api/services', 'datas', 'données');
    },

    async getImages() {
      await this.fetchData('/api/services-images', 'images', 'images');
    },

    getImagePath(imageName) {
      return this.staticImagePath + imageName;
    },

    openLightbox(image) {
      this.lightboxVisible = true;
      this.lightboxImages = this.images.filter(img => img.service === image.service).map(img => ({ src: this.getImagePath(img.name) }));
      this.lightboxIndex = this.lightboxImages.findIndex(img => img.src === this.getImagePath(image.name));
      const lightboxContent = document.querySelector('.content-lightbox');
      document.querySelector('body').append(lightboxContent);
    },

    closeLightbox() {
      this.lightboxVisible = false;
      this.lightboxImages = [];
      this.lightboxIndex = 0;
    },

    selectTab(selectedData) {
      this.datas.forEach(data => {
        data.isActive = data.id === selectedData.id ? !data.isActive : false;
      });
    }
  },
};
</script>