<template>
  <div class="container col-md-12">
    <div class="portlet light">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-bar-chart-o"></i>
          <span class="caption-subject bold uppercase"> Charts</span>
          <div class='col-md-4'>
            <span class='help-block'>&nbsp;</span> 
            <div class='form-group'>   
              <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                <span class='input-group-addon'>De</span>
                <input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'>
                <span class='input-group-addon'>A</span>
                <input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
              </div>
            </div>
          </div>
        </div>
        <div class="actions">
          <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;">
          </a>
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
      axios.get("/reporte-mes")
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