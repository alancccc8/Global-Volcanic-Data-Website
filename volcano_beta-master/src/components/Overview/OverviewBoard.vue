<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<template>
 <div class="category">
   <!--el-scrollbar height="811px" -->
     <div class="card card-1" @click="setActiveCard(0)"
          :class="activedCard===0 ? 'is-active' : ''"
     >
       <div class="title">Volcano Composition</div>
       <div class="card__content">
         <div>
           <div class="features">{{ features[index] }}</div>
         </div>
         <div class="title countries">Common Distribution Countries</div>
         <div class="countries-box">
           <div v-for="(countryImg, index) in countries[index]" :key="index">
             <img :src="countryImg" alt="country" class="icon-country" />
           </div>
         </div>
       </div>
      </div>
      <!-- eslint-disable-next-line -->
     <div class="card card-2" @click="setActiveCard(1)"
          :class="activedCard===1 ? 'is-active' : ''"
     >
      <div class="title">Emission Frequency</div>
       <div class="card__content">
         <div>
           This chart shows the number of eruptions of the current type of volcano in the last 200 years.
         </div>
         <eruption-line-chart
           v-if="isMobile ? true : showChart"
           :key="index"
           :raw-data="data"
           chart-title="1"
           class="dynamic-chart"
         />
       </div>
     </div>
     <div class="card card-3" @click="setActiveCard(2)"
          :class="activedCard===2 ? 'is-active' : ''"
     >
       <div class="title">Volcano Elevation</div>
       <div class="card__content">
         <div>
           This chart shows the 3 highest and the 3 lowest volcanoes of the current type.
         </div>
         <div class="chart-container-2" v-if="isMobile? true : activedCard===2">
           <component :is="elevationList[index]" />
         </div>
       </div>
      </div>
     <div class="cPhoto-box">
<!--        <img v-if='!showChart' :src="imgList[index][0]" alt="" class="cPhoto" />-->
<!--        <img v-else :src="imgList[index][1]" alt="" class="cPhoto__chart" />-->
       <img :src="volcanoImgList[index]" alt="" class="cPhoto__chart" />
     </div>
   <!--/el-scrollbar -->
 </div>
</template>

<script>
import China from '@/assets/Overview/countries/011-china.png';
import Mexico from '@/assets/Overview/countries/033-mexico.png';
import Russia from '@/assets/Overview/countries/044-russia.png';
import Indonesia from '@/assets/Overview/countries/185-indonesia.png';
import US from '@/assets/Overview/countries/186-united states.png';
import Chile from '@/assets/Overview/countries/212-chile.png';
import Ecuador from '@/assets/Overview/countries/214-ecuador.png';
import NZ from '@/assets/Overview/countries/215-new zealand.png';
import Kenya from '@/assets/Overview/countries/234-kenya.png';
import Japan from '@/assets/Overview/countries/241-japan.png';

import Strato from '@/assets/Overview/volcano/Stratovolcano.png';
import Shield from '@/assets/Overview/volcano/Shield.png';
import Caldera from '@/assets/Overview/volcano/Caldera.png';
import Cone from '@/assets/Overview/volcano/PyroclasticCone.png';

import EruptionLineChart from '@/components/Overview/EruptionLineChart.vue';
import CompareElevationStra from '@/components/Overview/CompareElevationStra.vue';
import CompareElevationShield from '@/components/Overview/CompareElevationShield.vue';
import CompareElevationCaldera from '@/components/Overview/CompareElevationCaldera.vue';
import CompareElevationCone from '@/components/Overview/CompareElevationCone.vue';

export default {
  name: 'OverviewBoard',
  props: {
    index: Number,
    data: Array,
  },
  components: {
    EruptionLineChart,
    CompareElevationStra,
    CompareElevationShield,
    CompareElevationCaldera,
    CompareElevationCone,
  },
  data() {
    return {
      features: [
        'Stratovolcano, also known as a composite volcano, is a conical volcano built up by many layers (strata) of hardened lava and tephra. Stratovolcanoes are characterized by a steep profile with a summit crater and periodic intervals of explosive eruptions and effusive eruptions, although some have collapsed summit craters called calderas.',
        'A shield volcano is a type of volcano named for its low profile. Shield volcanoes are usually constructed almost entirely of basaltic and/or andesitic lava flows which were very fluid when erupted. They are built by repeated eruptions that occurred intermittently over vast periods of time (up to a million years or longer). Shield volcanoes are much wider than they are tall.',
        'A caldera is a large depression formed when a volcano erupts and collapses. During a volcanic eruption, magma present in the magma chamber underneath the volcano is expelled, often forcefully. When the magma chamber empties, the support that the magma had provided inside the chamber disappears. As a result, the sides and top of the volcano collapse inward. Calderas vary in size from one to 100 kilometers in diameter.',
        'A pyroclastic cone (or cinder cone) is a steep conical hill of loose pyroclastic fragments, such as volcanic clinkers, volcanic ash, or scoria that has been built around a volcanic vent. The pyroclastic fragments are formed by explosive eruptions or lava fountains from a single, typically cylindrical, vent. As the gas-charged lava is blown violently into the air, it breaks into small fragments that solidify and fall as either cinder around the vent to form a cone.',
      ],
      imgList: [
        ['https://i.postimg.cc/zGZkGFQ7/1-2.png', 'https://i.postimg.cc/Nj6k9rqc/1-2.png'],
        ['https://i.postimg.cc/j5FH0HNz/2-2.png', 'https://i.postimg.cc/hjjL5yJD/2-2.png'],
        ['https://i.postimg.cc/2jtwPDFP/3-2.png', 'https://i.postimg.cc/pdkQkbLc/3-2.png'],
        ['https://i.postimg.cc/VLbRwVK5/4-2.png', 'https://i.postimg.cc/fbMjxTD0/4-2.png'],
      ],
      countries: [
        [Indonesia, Japan, US, Chile, Russia],
        [US, Russia, Kenya, Ecuador, Japan],
        [Japan, Indonesia, Russia, NZ, US],
        [Mexico, Russia, Chile, China, US],
      ],
      showChart: false,
      volcanoImgList: [Strato, Shield, Caldera, Cone],
      activedCard: 0,
      isMobile: this.$store.state.isMobile,
      elevationList: ['CompareElevationStra', 'CompareElevationShield', 'CompareElevationCaldera', 'CompareElevationCone'],
    };
  },
  methods: {
    setActiveCard(index) {
      // if (this.activedCard !== index) {
      //   document.getElementsByClassName('card')[this.activedCard].classList.remove('is-active');
      //   document.getElementsByClassName('card')[index].classList.add('is-active');
      // }
      this.activedCard = index;
    },
  },
  watch: {
    activedCard(index) {
      if (index === 1) {
        this.showChart = true;
      } else {
        this.showChart = false;
      }
    },
  },
};
</script>

<style scoped lang="scss">
.category {
  display: grid;
  width: calc(100vw - wCalc(244) - hCalc(176) - 9px);
  height: calc(100vh - hCalc(300));
  grid-template-columns: repeat(3, 1fr);
  overflow: scroll;
  .card {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: calc(100% - 1px);
    height: calc(100% - 5px);
    color: white;
    border-right: 1px solid rgb(151, 151, 151);
    border-top: 5px solid transparent;
    cursor: pointer;
    &:nth-child(-1) {
      border-right: unset;
    }
    .card__content {
      width: 100%;
      display: none;
    }
    &.is-active {
      border-top-color: rgb(191, 95, 64);
      .card__content {
        display: block;
      }
    }
  }

  .title {
    margin-top: hCalc(37);
    width: hCalc(438);
    height: hCalc(112);
    font-family: Roboto-Black;
    font-size: fSizeCalc(35);
    text-align: center;

    &.countries {
      padding-left: wCalc(40);
      text-align: left;
    }
  }

  .features {
    padding: 0 wCalc(40);
    font-family: union_regular;
    font-size: fSizeCalc(16);
    line-height: fSizeCalc(31);
    text-align: start;
  }

  .countries-box {
    display: flex;
    flex-wrap: wrap;
    padding: 0 wCalc(40);
    column-gap: hCalc(66);
    row-gap: hCalc(10);
    .icon-country {
      width: hCalc(59);
      height: hCalc(59);
    }
  }

  .dynamic-chart {
    position: absolute;
    bottom: 0;
    left: 0;
    height: hCalc(658);
    pointer-events: visible;
    z-index: 100;
  }

  .chart-container-2 {
    width: 100%;
    height: hCalc(458);
  }
}

.cPhoto-box {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: hCalc(658);
  pointer-events: none;
  .cPhoto {
    width: 100%;
    height: 100%;
    object-fit: scale-down;
    object-position: 50% 100%;
  }
  .cPhoto__chart {
    width: 100%;
    height: 100%;
    object-fit: scale-down;
    object-position: 50% 100%;
    z-index: 100;
  }
}

@media screen and (max-width: 414px) {
  .category {
    width: 100%;
    height:  calc(100vh - hCalc(412));
    grid-template-columns: repeat(1, 1fr);
    overflow-y: scroll;
    .card {
      width: 100%;
      border-right: unset;
      border-bottom: 1px solid rgb(151, 151, 151);
      &:nth-child(-1) {
        border-right: unset;
      }
      &.is-active {
        border-top-color: transparent;
      }
    }
    .title {
      width: 100%;
      height: hCalcM(60);
      font-size: fSizeCalc(20);
    }
    .card__content {
      width: 100%;
      display: block !important;
    }
    .features {
      font-size: fSizeCalc(12);
    }
    .dynamic-chart {
      position: static;
      //width: calc(100vw - wCalc(244));
      pointer-events: visible;
      z-index: 100;
    }
    .chart-container-2 {
      margin-bottom: hCalcM(50);
    }
  }
}
</style>
