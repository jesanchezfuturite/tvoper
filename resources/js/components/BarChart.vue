
<script>
  import { Bar } from 'vue-chartjs'

export default {
  name:"BarChart",
  props:{
    chartdatas:[]

  },
  extends: Bar,
  data(){
      return{
        chartdata: {
        
        labels: this.chartdatas.data_label,
        datasets: [
          {
            label: this.chartdatas.mes,borderWidth: 1,
            backgroundColor: [],
            borderColor: [],
            data: this.chartdatas.data
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        
      }
    }
  },

  mounted () {
    this.renderChart(this.chartdata, this.options)
    
  },
  methods:{
    dynamicColors(){
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      var a = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + "," + a + ")";
    },
    colorsd(){
      for (var i in this.chartdatas.data) {
          this.chartdata.datasets[0].backgroundColor.push(this.dynamicColors());          
      }
      this.chartdata.datasets[0].borderColor=this.chartdata.datasets[0].backgroundColor;
    }
  }
}
</script>