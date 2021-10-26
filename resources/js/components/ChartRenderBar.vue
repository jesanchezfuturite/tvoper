<template>
  <div class="container col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;">
          </a>
        </div>
        <div class="caption">
          <span class="caption-subject bold uppercase"> <i class="fa fa-bar-chart-o"></i> Charts</span>
              <span class="help-block">&nbsp;</span>          
         
        </div>
        
      </div>
      <div class="portlet-body">
        <div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">          
          <line-chart v-if="loaded" :chartdatas="chartdatas"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import LineChart from './BarChart.vue'

export default {
  name: 'ChartRenderBar',
  components: { LineChart },
  data(){ 
    return{
    loaded: false,
    chartdatas: [],
    }
  },
  methods:{
    obtenerR(){
      axios.get("/reporte-mes-c")
      .then((response)=>{
        console.log(response.data) 
        this.loaded = true
        this.chartdatas=response.data 
       
      })
    }
  },
  mounted() {
    this.loaded = false
    try {
      this.obtenerR()     
     
    } catch (e) {
      console.error(e)
    }
  }

}
</script>