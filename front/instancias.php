<?php
include('parciales/cabecera.php');
include('parciales/menu.php');
include('parciales/titulo.php');
?>


    <!-- Main content -->
    <section class="content" id="app" v-cloak>

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de Instancias</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <!-- 
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>-->
          </div>
        </div>
        <div class="card-body">
          <div class="card-body p-0">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Logo</th>
                      <th>Nombre</th>
                      <th>Servidor</th>
                      <th style="width: 40px">Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="instancia of listado_instancias">
                      <td>{{instancia.instancia_id}}</td>
                      <td>
                        <div v-if="instancia.instancia_estado == 1">
                          <a :href="instancia.instancia_url" target="_blank">
                            <img class="attachment-img" style="width: 50px;" :src="instancia.instancia_img">
                          </a>
                        </div>
                        <div v-else>
                          <img class="attachment-img" style="width: 50px; filter: grayscale(1);" src="https://entrenamiento.autoshop-easy.com/particular/logo-agencia.png">
                        </div>
                      </td>
                      <td>
                        <div v-if="instancia.instancia_estado == 1">
                          <a :href="instancia.instancia_url" target="_blank">{{instancia.instancia_nombre}}</a>
                        </div>
                        <div v-else>{{instancia.instancia_nombre}}</div>
                        </td>
                      <td>{{instancia.instancia_servidor}}</td>
                      <td>{{instancia.instancia_estado}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
        </div>
        <!--/.card-body -->
        <div class="card-footer">
          Autoshop-Easy
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript">
  Vue.use('vue-moment');
  var now = moment();
  moment.locale('es');
  var app = new Vue({ 
    el: "#app",
    data: {
      date: "",
      errorMessage: "",
      successMessage: "",
      listado_instancias: [],
    },

    mounted: function () {
      console.log("Vue.js esta corriendo...");
      console.log(moment().format('LLLL'));
      this.cargarInstancias();
    },

    methods: {
      moment: function () {
      return moment();
      },      
      
      cargarInstancias: function () {
        axios.get('<?= $axios_url ?>api/instancias_api.php?accion=listado')
        .then(function (response) {
          console.log(response);

          if (response.data.error) {
            app.errorMessage = response.data.message;
            //console.log(response.data.message);
          } else {
            app.listado_instancias = response.data.listado_instancias;
            //console.log(response.data.listado_instancias);
          }
        })
      }

    }
  });
</script>
  
<?php
include('parciales/pie.php');
 ?>
