
<script>
  import { HorizontalBar } from 'vue-chartjs'
  var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    var a = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + "" + a + ")";
 };
 var ict_unit = [];
         var efficiency = [];
         var coloR = [];
 for (var i in this.chartdatas.data) {
    coloR.push(dynamicColors());
 }
export default {
  name:"BarHorizontalChart",
  props:{
    chartdatas:[]

  },
  extends: HorizontalBar,
  data(){
      return{
        chartdata: {
        
        labels: this.chartdatas.data_label,
        datasets: [
          {
            label: this.chartdatas.mes,
            borderWidth: 1,
            backgroundColor: coloR,
            borderColor: coloR,
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
    
  }
}
</script>