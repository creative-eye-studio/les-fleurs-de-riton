<template>
      <div class="tabs btn-list col-3 col-sm-12">
        <ul>
          <li v-for="data in datas" :key="data.pos" class="tab service-btn position-relative" :class="{ active: data.isActive }" :data-tab="'tab' + data.id">
            <span @click="selectTab(data)">{{ data.label }}</span>
          </li>
        </ul>
      </div>
  
      <div class="tab-content services-list col-9 col-sm-12" id="services-list">
        <section v-for="data in datas" :key="data.id" :class="{ 'tab-pane': true, 'service-block': true, 'active': data.isActive }" :id="'tab' + data.id">
          <h2 class="margin-top-none">{{ data.title }}</h2>
          <div class="content-text" v-html="data.content"></div>
        </section>
      </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        datas: null
      };
    },
    mounted() {
      this.getDatas();
    },
    methods: {
        getDatas() {
            fetch('https://lesfleursderiton.com/api/services')
            .then(response => {
                if (!response.ok) {
                throw new Error('La requête a échoué');
                }
                return response.json();
            })
            .then(data => {
                // Ajoutez la propriété isActive à chaque objet data
                this.datas = data.map((item, index) => ({ ...item, isActive: index === 0 }));
                console.log(this.datas);
            })
            .catch(error => {
                console.error('Une erreur s\'est produite : ', error);
            });
        },
        selectTab(selectedData) {
            this.datas.forEach(data => {
                data.isActive = data.id === selectedData.id ? !data.isActive : false;
            });
        }
    },
  };
  </script>
  