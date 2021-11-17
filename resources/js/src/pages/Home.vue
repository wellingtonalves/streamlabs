<template>
  <div>
    <v-row>
      <v-col md="10" offset="1">
        <h1 class="text-center">Streams</h1>
        <p class="text-center">Median of viewer {{median}}</p>
      </v-col>
      <v-col>
        <v-tabs
            fixed-tabs
            prominent
            v-model="tab"
        >
          <v-tab>
            Total per game
          </v-tab>
          <v-tab>
            Highest
          </v-tab>
          <v-tab>
            ODD
          </v-tab>
          <v-tab>
            EVEN
          </v-tab>
          <v-tab>
            Same amount
          </v-tab>
          <v-tab>
            Top 100
          </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item>
            <amount-component ref="amount_comp"/>
          </v-tab-item>
          <v-tab-item>
            <highest-component ref="highest_comp"/>
          </v-tab-item>
          <v-tab-item>
            <odd-component ref="odd_comp"/>
          </v-tab-item>
          <v-tab-item>
            <even-component ref="even_comp"/>
          </v-tab-item>
          <v-tab-item>
            <same-component ref="same_comp"/>
          </v-tab-item>
          <v-tab-item>
            <top-component ref="top_comp"/>
          </v-tab-item>
        </v-tabs-items>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import AmountComponent from "../components/AmountComponent";
import HighestComponent from "../components/HighestComponent";
import OddComponent from "../components/OddComponent";
import EvenComponent from "../components/EvenComponent";
import TopComponent from "../components/TopComponent";
import SameComponent from "../components/SameComponent";

export default {
  name: "Home",
  components: {SameComponent, TopComponent, EvenComponent, OddComponent, HighestComponent, AmountComponent},
  data() {
    return {
      tab: 0,
      median: 0
    }
  },
  mounted() {
    const vm = this;
    this.medianService()
    this.$observer('public', 'App\\Events\\StreamsUpdate', function () {
      console.log('updating...')
      vm.init()
    });
  },
  methods: {
    ...mapActions('stream', ['getMedian']),
    medianService(type = 'database'){
      this.getMedian(type).then(response => {
        this.median = Number(response.data.media).toFixed(2)
      })
    },
    init() {
      this.medianService()
      this.$refs.amount_comp.streamService()
      this.$refs.highest_comp.streamService()
      this.$refs.odd_comp.streamService()
      this.$refs.even_comp.streamService()
      this.$refs.same_comp.streamService()
      this.$refs.top_comp.streamService()
    }
  }
}
</script>

<style scoped>

</style>