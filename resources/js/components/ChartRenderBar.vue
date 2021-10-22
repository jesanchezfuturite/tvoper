<template>
  <div class="container col-md-12">
    <line-chart
      v-if="loaded"
      :chartdata="chartdata"/>
  </div>
</template>

<script>
import LineChart from './BarChart.vue'

export default {
  name: 'LineChartContainer',
  components: { LineChart },
  data: () => ({
    loaded: false,
    chartdata: null
  }),
  async mounted () {
    this.loaded = false
    try {
      const { userlist } = await fetch('/reporte-mes')
      this.chartdata = userlist
      this.loaded = true
    } catch (e) {
      console.error(e)
    }
  }
}
</script>