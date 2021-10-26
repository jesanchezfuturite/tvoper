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
          <div id="row">
            <div class='col-md-10'> 
              <div class='form-group'>   
               <v-date-picker v-model="range" is-range>
                <template v-slot="{ inputValue, inputEvents }">
                  <div class="flex justify-center items-center input-group input-daterange" data-date-format='yyyy-mm-dd'>
                    <span class='input-group-addon'>De</span>
                    <input :value="inputValue.start" v-on="inputEvents.start" 
                      class="form-control  rounded focus:outline-none focus:border-indigo-300 border rounded"
                    /><span class='input-group-addon'>A</span>
                    <input :value="inputValue.end" v-on="inputEvents.end"
                      class="form-control  rounded focus:outline-none focus:border-indigo-300 border rounded green"
                    />
                  </div>
                </template>
              </v-date-picker>
              </div>
            </div>
            <div class="col-md-2"> <button class="btn green" v-on:click="findReg()"> Buscar</button> </div>
          </div>
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
import LineChart from './BarHorizontalChart.vue'
import VCalendar from 'v-calendar'

export default {
  name: 'ChartRenderBar',
  components: { LineChart },
  data(){return{ 
     dot: 'red',
    range: {
      start: new Date(),
      end: new Date(),       
    },     
    message: null,
    loaded: true,
    chartdatas: [],
    }
  },
  methods:{
    obtenerR(){
      axios.get("/reporte-tramites-c")
      .then((response)=>{
        this.loaded = true
        this.chartdatas=response.data        
      })
    },
    findReg(){
      console.log(new Date(this.range.start).toISOString().slice(0,10));
      console.log(new Date(this.range.end).toISOString().slice(0,10))
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